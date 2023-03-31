<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendors\Payments\StoreBillPaymentRequest;
use App\Models\BillPayments;
use App\Models\Bills;
use App\Models\PaymentReferences;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillPaymentController extends Controller
{
    public function searchAjax($query = null)
    {
        $payments = PaymentReferences::select([
            'payment_references.id',
            'payment_references.date',
            'payment_references.status',
            'vendors.name',
            // 'payment_references.is_void',
            'bill_payments.amount_paid',
        ])
        ->leftJoin('bill_payments', 'bill_payments.payment_reference_id', 'payment_references.id')
        ->leftJoin('vendors', 'vendors.id', 'payment_references.vendor_id')
        ->where('payment_references.accounting_system_id', session('accounting_system_id'))
        ->where('payment_references.type', 'bill_payment')
        ->where(function($q) use ($query) {
            $q->where('payment_references.id', 'like', "%{$query}%")
            ->orWhere('payment_references.date', 'like', "%{$query}%")
            ->orWhere('payment_references.status', 'like', "%{$query}%")
            ->orWhere('vendors.name', 'like', "%{$query}%");
        });

        return response()->json([
            'bill_payments' => $payments->paginate(10),
        ]);
    }

    public function store(StoreBillPaymentRequest $request)
    {
        // return $request;

        // Get bill where payment reference id = selected bill value
        $bill = Bills::where('payment_reference_id', $request->bill->value)->first();
        $bill->paymentReference;

        // return $bill;
        // return $bill->paymentReference->status;

        // check bill status then update
        $bill->amount_received += $request->amount_paid;

        if($bill->amount_received >= $bill->grand_total) {
            $bill->paymentReference->status = 'paid';
        }
        else if($bill->paymentReference->status == 'unpaid' && $bill->amount_received > 0)
        {
            $bill->paymentReference->status == 'partially_paid';
        }

        $bill->push();

        // create journal entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Create Payment Reference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'bill_payment',
            'is_void' => 'no',
            'status' => 'paid', // is always paid
            'journal_entry_id' => $je->id,
        ]);

        // Create child database entry
        $billPayment = BillPayments::create([
            'payment_reference_id' => $reference->id,
            'chart_of_account_id' => $request->chart_of_account_id,
            'cheque_number' => $request->cheque_number, // recheck if exist
            'amount_paid' => floatval($request->amount_paid),
            'discount_account_number' => $request->discount_account_number, // recheck if exist
        ]);

        // create credit postings
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
        $credit_amount[] = $request->amount_paid;

        // create debit postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_account_payable);
        $debit_amount[] = $request->amount_paid;

        // push journal postings
        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    public function ajaxGetEntriesToPay(Vendors $vendor)
    {
        return PaymentReferences::select(
            'payment_references.id as value',
            'bills.due_date',
            DB::raw('bills.grand_total - bills.amount_received as balance'),
        )
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->where('payment_references.type', '=', 'bill')
            ->where('payment_references.vendor_id', '=', $vendor->id)
            ->where('payment_references.status', '!=', 'paid')->get();
    }
}

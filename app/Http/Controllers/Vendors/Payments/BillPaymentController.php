<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\Payments\StoreBillPaymentRequest;
use App\Models\Bills;
use App\Models\PaymentReferences;
use App\Models\BillPayments;

class BillPaymentController extends Controller
{
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
}

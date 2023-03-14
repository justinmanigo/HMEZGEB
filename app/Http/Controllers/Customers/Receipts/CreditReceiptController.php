<?php

namespace App\Http\Controllers\Customers\Receipts;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Actions\Customer\Receipt\UpdateReceiptStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Receipt\StoreCreditReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreProformaRequest;
use App\Mail\Customers\MailCustomerProforma;
use App\Models\CreditReceipts;
use App\Models\Customers;
use App\Models\Proformas;
use App\Models\ReceiptCashTransactions;
use App\Models\ReceiptItem;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customers\MailCustomerCreditReceipt;
use App\Models\BankAccounts;
use App\Models\DepositItems;
use App\Models\Deposits;
use Exception;
use Illuminate\Support\Facades\DB;

class CreditReceiptController extends Controller
{
    public function searchAjax($query = null)
    {
        $credit_receipts = ReceiptReferences::select(
            'receipt_references.id',
            'receipt_cash_transactions.for_receipt_reference_id',
            'credit_receipts.id as credit_receipt_id',
            'receipt_references.date',
            'customers.name as customer_name',
            'credit_receipts.total_amount_received as grand_total',
            'receipt_cash_transactions.total_amount_received',
            'receipt_references.is_void',
        )
        ->leftJoin('credit_receipts', 'credit_receipts.receipt_reference_id', 'receipt_references.id')
        ->leftJoin('customers', 'customers.id', 'receipt_references.customer_id')
        // left join sub to get sum of receipt_cash_transactions
        // this will determine the status of the receipt (paid, partially_paid, unpaid)
        ->leftJoinSub(
            ReceiptCashTransactions::select(
                'receipt_cash_transactions.receipt_reference_id',
                'receipt_cash_transactions.for_receipt_reference_id',
                DB::raw('SUM(receipt_cash_transactions.amount_received) as total_amount_received')
            )
            ->groupBy('receipt_cash_transactions.receipt_reference_id', 'receipt_cash_transactions.for_receipt_reference_id'),
            'receipt_cash_transactions',
            'receipt_cash_transactions.receipt_reference_id',
            'receipt_references.id'
        )
        ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
        ->where(function($q) use ($query){
            $q->where('receipt_references.id', 'like', "%{$query}%")
            ->orWhere('customers.name', 'like', "%{$query}%")
            ->orWhere('receipt_references.date', 'like', "%{$query}%")
            ->orWhere('receipt_references.status', 'like', "%{$query}%");
        })
        ->where('receipt_references.type', 'credit_receipt');


        return response()->json([
            'credit_receipts' => $credit_receipts->paginate(10),
        ]);

    }

    public function store(StoreCreditReceiptRequest $request)
    {
        $reference = CreateReceiptReference::run($request->customer_id, $request->date, 'credit_receipt', 'paid', session('accounting_system_id'));

        $receipt = Receipts::where('receipt_reference_id', $request->receipt->value)->first();
        $receipt->total_amount_received += $request->amount_paid;

        if($receipt->total_amount_received >= $receipt->grand_total) {
            UpdateReceiptStatus::run($request->receipt->value, 'paid');
        }
        else if($receipt->receiptReference->status == 'unpaid' && $receipt->total_amount_received > 0) {
            UpdateReceiptStatus::run($request->receipt->value, 'partially_paid');
        }
        $receipt->save();

        $rct = ReceiptCashTransactions::create([
            'accounting_system_id' => session('accounting_system_id'),
            'receipt_reference_id' => $reference->id,
            'for_receipt_reference_id' => $request->receipt->value,
            'amount_received' => $request->amount_paid,
            'chart_of_account_id' => $request->credit_receipt_cash_on_hand,
        ]);

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));
        $reference->journal_entry_id = $je->id;
        $reference->save();

        // Create Debit Postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
        $debit_amount[] = $request->amount_paid;

        // Create Credit Postings
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->credit_receipt_account_receivable);
        $credit_amount[] = $request->amount_paid;

        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        $bank_account = BankAccounts::where('chart_of_account_id',      $request->cash_account->value)->first();
        $deposit = null;

        if($bank_account) {
            $deposit = Deposits::create([
                'accounting_system_id' => session('accounting_system_id'),
                'chart_of_account_id' => $request->cash_account->value,
                'deposit_ticket_date' => date('Y-m-d'),
                'remark' => $request->remark,
                'reference_number' => $request->reference_number,
                'is_direct_deposit' => true,
            ]);

            $deposit_item = DepositItems::create([
                'deposit_id' => $deposit->id,
                'receipt_cash_transaction_id' => $rct->id,
                'journal_entry_id' => $je->id,
            ]);
        }

        CreditReceipts::create([
            'receipt_reference_id' => $reference->id,
            'total_amount_received' => $request->amount_paid,
            'description' => $request->description,
            'remark' => $request->remark,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    public function show(CreditReceipts $cr)
    {
        return view('customer.receipt.credit_receipt.edit',[
            'credit_receipt' => $cr,
        ]);
    }

    public function voidAjax(ReceiptReferences $rr)
    {
        $rr->journalEntry;
        $rr->receiptCashTransactions[0]->depositItem;

        // If a deposit of this credit receipt is already made, void the deposit first before voiding the credit receipt.
        if($rr->receiptCashTransactions[0]->depositItem) {
            $rr->receiptCashTransactions[0]->depositItem->journalEntry->is_void = true;
            $rr->receiptCashTransactions[0]->depositItem->journalEntry->save();

            $rr->receiptCashTransactions[0]->depositItem->is_void = true;
            $rr->receiptCashTransactions[0]->depositItem->save();
        }

        // Get Receipt Cash Transaction & Source Receipt
        $rct = ReceiptCashTransactions::where('receipt_reference_id', $rr->id)->first();
        $rct->forReceiptReference->receipt;

        // Deduct Source Receipt's Total Amount Received
        $rct->forReceiptReference->receipt->total_amount_received -= $rct->amount_received;

        // Check Status
        if($rct->forReceiptReference->receipt->total_amount_received >= $rct->forReceiptReference->receipt->grand_total) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'paid');
        }
        else if($rct->forReceiptReference->status == 'unpaid' &&
            $rct->forReceiptReference->receipt->total_amount_received > 0) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'partially_paid');
        }
        else if($rct->forReceiptReference->receipt->total_amount_received <= 0) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'unpaid');
        }
        $rct->push();

        $rr->is_void = true;
        $rr->journalEntry->is_void = true;
        $rr->push();

        return response()->json([
            'success' => true,
        ]);
        // return redirect()->back()->with('success', "Successfully voided credit receipt.");
    }

    public function reactivateAjax(ReceiptReferences $rr)
    {
        // Get Receipt Cash Transaction & Source Receipt
        $rct = ReceiptCashTransactions::where('receipt_reference_id', $rr->id)->first();
        $rct->forReceiptReference->receipt;

        // Check if source receipt is voided, then return error.
        if($rct->forReceiptReference->is_void == true) {
            throw new Exception("Can't reinstate credit receipt. Source receipt # {$rct->forReceiptReference->id} is currently voided.");
            // return redirect()->back()->with('danger', "Can't reinstate credit receipt. Source receipt # {$rct->forReceiptReference->id} is currently voided.");
        }

        // If the receipt is a direct deposit, reactivate the deposit item entry
        try {
            $rr->receiptCashTransactions[0]->depositItem->deposit;

            if($rr->receiptCashTransactions[0]->depositItem->deposit->is_direct_deposit == true) {
                $rr->receiptCashTransactions[0]->depositItem->is_void = false;
                $rr->receiptCashTransactions[0]->depositItem->save();

                $rr->receiptCashTransactions[0]->depositItem->journalEntry->is_void = false;
                $rr->receiptCashTransactions[0]->depositItem->journalEntry->save();
            }
        } catch(\Exception $e) {
            // Do nothing
        }

        // Add Source Receipt's Total Amount Received
        $rct->forReceiptReference->receipt->total_amount_received += $rct->amount_received;

        // Check Status
        if($rct->forReceiptReference->receipt->total_amount_received >= $rct->forReceiptReference->receipt->grand_total) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'paid');
        }
        else if($rct->forReceiptReference->status == 'unpaid' &&
            $rct->forReceiptReference->receipt->total_amount_received > 0) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'partially_paid');
        }
        else if($rct->forReceiptReference->receipt->total_amount_received <= 0) {
            UpdateReceiptStatus::run($rct->forReceiptReference->id, 'unpaid');
        }
        $rct->push();

        // If source receipt is not voided, then proceed
        $rr->is_void = false;
        $rr->journalEntry->is_void = false;
        $rr->push();

        return response()->json([
            'success' => true,
        ]);
        // return redirect()->back()->with('success', "Successfully voided credit receipt.");
    }

    public function mailAjax(CreditReceipts $cr)
    {
        // Mail
        $emailAddress = $cr->receiptReference->customer->email;

        Mail::to($emailAddress)->queue(new MailCustomerCreditReceipt($cr));

        return response()->json([
            'success' => true,
        ]);

        // return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    public function print(CreditReceipts $cr)
    {
        $pdf = \PDF::loadView('customer.receipt.credit_receipt.print', [
            'credit_receipt' => $cr,
        ]);

        return $pdf->stream('credit_receipt_'.$cr->id.'_'.date('Y-m-d').'.pdf');
    }
}

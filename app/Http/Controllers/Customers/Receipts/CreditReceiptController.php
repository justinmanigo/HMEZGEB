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
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customers\MailCustomerCreditReceipt;


class CreditReceiptController extends Controller
{
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

        ReceiptCashTransactions::create([
            'accounting_system_id' => session('accounting_system_id'),
            'receipt_reference_id' => $reference->id,
            'for_receipt_reference_id' => $request->receipt->value,
            'amount_received' => $request->amount_paid,
        ]);        

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));
        $reference->journal_entry_id = $je->id;
        $reference->save();

        // Create Debit Postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->credit_receipt_cash_on_hand);
        $debit_amount[] = $request->amount_paid;

        // Create Credit Postings
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->credit_receipt_account_receivable);
        $credit_amount[] = $request->amount_paid;

        CreateJournalPostings::run($je, 
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

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

    public function void(ReceiptReferences $rr)
    {
        $rr->journalEntry;
        
        // TODO: Iterate through all receipt cash transactions and check if it is already deposited.
        // If it is already deposited, void the deposit first before voiding the receipt.

        // if($rr->is_deposited == "yes")
        //     return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");
        
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

        $rr->is_void = "yes";
        $rr->journalEntry->is_void = true;
        $rr->push();

        return redirect()->back()->with('success', "Successfully voided credit receipt.");
    }

    public function reactivate(ReceiptReferences $rr)
    {
        $rr->journalEntry;

        // Get Receipt Cash Transaction & Source Receipt
        $rct = ReceiptCashTransactions::where('receipt_reference_id', $rr->id)->first();
        $rct->forReceiptReference->receipt;

        // Check if source receipt is voided, then return error.
        if($rct->forReceiptReference->is_void == 'yes') {
            return redirect()->back()->with('danger', "Can't reinstate credit receipt. Source receipt # {$rct->forReceiptReference->id} is currently voided.");
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
        $rr->is_void = "no";
        $rr->journalEntry->is_void = false;
        $rr->push();

        return redirect()->back()->with('success', "Successfully voided credit receipt.");
    }  

    public function send(CreditReceipts $cr)
    {
        // Mail
        $emailAddress = $cr->receiptReference->customer->email; 
        
        Mail::to($emailAddress)->queue(new MailCustomerCreditReceipt($cr));
        
        return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    public function print(CreditReceipts $cr)
    {
        $pdf = PDF::loadView('customer.receipt.credit_receipt.print', compact('credit_receipt'));

        return $pdf->stream('credit_receipt_'.$cr->id.'_'.date('Y-m-d').'.pdf');
    }
}
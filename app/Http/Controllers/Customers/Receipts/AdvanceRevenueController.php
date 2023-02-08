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
use App\Models\AdvanceRevenues;
use App\Models\Receipts;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customers\MailCustomerCreditReceipt;
use App\Http\Requests\Customer\Receipt\StoreAdvanceRevenueRequest;
use App\Mail\Customers\MailCustomerAdvanceRevenue;


class AdvanceRevenueController extends Controller
{
    public function store(StoreAdvanceRevenueRequest $request)
    {
        $accounting_system_id = session('accounting_system_id');
        $reference = CreateReceiptReference::run($request->customer_id, $request->date, 'advance_receipt', 'paid', $accounting_system_id);

        // Create child database entry
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'advance-revenues', $fileAttachment);
        }

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, $accounting_system_id);
        $reference->journal_entry_id = $je->id;
        $reference->save();

        // Create Debit Postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->advance_receipt_cash_on_hand);
        $debit_amount[] = $request->amount_received;

        // Create Credit Postings
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->advance_receipt_advance_payment);
        $credit_amount[] = $request->amount_received;

        CreateJournalPostings::run($je, 
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            $accounting_system_id);

        AdvanceRevenues::create([
            'receipt_reference_id' => $reference->id,
            'total_amount_received' => $request->amount_received,
            'reason' => $request->reason,
            'remark' => $request->remark,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    public function show(AdvanceRevenues $ar)
    {   
        return view('customer.receipt.advance_revenue.edit',[
            'advance_revenue' => $ar,
        ]);
    }
    
    public function void(ReceiptReferences $rr)
    {
        $rr->journalEntry;

        // TODO: Since advance revenue is added before the receipt is created, so we have
        // to check whether the receipt is created or not. If the receipt is created,
        // then it shall check for the deposit status of the receipt through receipt cash transactions model.

        // if($rr->is_deposited == "yes")
        //     return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        $rr->is_void = "yes";
        $rr->journalEntry->is_void = true;
        $rr->push();

        return redirect()->back()->with('success', "Successfully voided advance revenue.");
    }   

    public function reactivate(ReceiptReferences $rr)
    {
        $rr->journalEntry;

        $rr->is_void = "no";
        $rr->journalEntry->is_void = false;
        $rr->push();

        return redirect()->back()->with('success', "Successfully reactivated advance revenue.");
    }

    public function mail(AdvanceRevenues $ar)
    {
        // Mail
        $emailAddress = $ar->receiptReference->customer->email; 
        
        Mail::to($emailAddress)->queue(new MailCustomerAdvanceRevenue($ar));
        
        return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    public function print(AdvanceRevenues $ar)
    {
        $pdf = PDF::loadView('customer.receipt.advance_revenue.print', compact('advance_revenue'));

        return $pdf->stream('advance_revenue_'.$ar->id.'_'.date('Y-m-d').'.pdf');
    }
}
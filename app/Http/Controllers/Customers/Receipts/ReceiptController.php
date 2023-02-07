<?php

namespace App\Http\Controllers\Customers\Receipts;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DeterminePaymentMethod;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Actions\Customer\Receipt\UpdateReceiptStatus;
use App\Actions\UpdateInventoryItemQuantity;
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
use App\Http\Requests\Customer\Receipt\StoreReceiptRequest;
use App\Mail\Customers\MailCustomerAdvanceRevenue;
use App\Mail\Customers\MailCustomerReceipt;
use App\Models\BankAccounts;
use App\Models\Deposits;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\Transactions;

class ReceiptController extends Controller
{
    public function store(StoreReceiptRequest $request)
    {
        $accounting_system_id = session('accounting_system_id');

        // If this transaction is linked to Proforma
        if(isset($request->proforma)) UpdateReceiptStatus::run($request->proforma->value, 'paid');

        // Determine Receipt Status
        $status = DetermineReceiptStatus::run($request->grand_total, $request->total_amount_received);

        // Create Receipt Reference
        $reference = CreateReceiptReference::run($request->customer->value, $request->date, 'receipt', $status, $accounting_system_id);

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }

        // Store Receipt Items
        StoreReceiptItems::run($request->item, $request->quantity, $reference->id);
        UpdateInventoryItemQuantity::run($request->item, $request->quantity, 'decrease');

        for ($i=0; $i < count($request->item); $i++) {
            $inventory = Inventory::where('id', $request->item[$i]->value)->first();
            // Create notification if inventory quantity has reached 0
            if($inventory->quantity == 0 && $inventory->notify_critical_quantity == 'Yes'){
                Notification::create([
                    'accounting_system_id' => $accounting_system_id,
                    'reference_id' => $inventory->id,
                    'source' => 'inventory',    
                    'message' => 'Inventory item '.$inventory->item_name.' has zero stocks. Please reorder.',
                    'title' => 'Inventory Zero Stocks',
                    'type' => 'danger',
                    'link' => 'vendors/bills',
                ]);
            }
            // Create notification if inventory quantity is less than or equal to critical level
            else if($inventory->quantity <= $inventory->critical_quantity && $inventory->notify_critical_quantity == 'Yes'){
                Notification::create([
                    'accounting_system_id' => $accounting_system_id,
                    'reference_id' => $inventory->id,
                    'source' => 'inventory',
                    'message' => 'Inventory item '.$inventory->item_name.' is less than or equal to '.$inventory->critical_quantity.'. Please reorder.',
                    'title' => 'Inventory Critical Level',
                    'type' => 'warning',
                    'link' => 'vendors/bills',
                ]);
            }
        }

        // Create Receipt Cash Transaction
        if($request->total_amount_received > 0) {
            // Check if cash_account->value is a bank account
            $bank_account = BankAccounts::where('chart_of_account_id', $request->cash_account->value)->first();
            $deposit = null;

            if($bank_account) {
                $deposit = Deposits::create([
                    'accounting_system_id' => session()->get('accounting_system_id'),
                    'chart_of_account_id' => $request->cash_account->value,
                    'status' => 'Deposited',
                    'deposit_ticket_date' => date('Y-m-d'),
                    'total_amount' => $request->total_amount_received,
                    'remark' => $request->remark,
                    'reference_number' => $request->reference_number,
                ]);
        
                // create transaction
                Transactions::create([
                    'accounting_system_id' => session()->get('accounting_system_id'),
                    'chart_of_account_id' => $request->cash_account->value,
                    'type' => 'Deposit',
                    'description' => $request->remark,
                    'amount' => $request->total_amount_received,
                ]);
            }
            
            $rct = ReceiptCashTransactions::create([
                'accounting_system_id' => $accounting_system_id,
                'receipt_reference_id' => $reference->id,
                'for_receipt_reference_id' => $reference->id,
                'amount_received' => $request->total_amount_received,
                'deposit_id' => $deposit ? $deposit->id : null,
            ]);

            
        }

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, $accounting_system_id);
        $reference->journal_entry_id = $je->id;
        $reference->save();

        $cash_on_hand = $request->total_amount_received;
        $account_receivable = $request->grand_total - $request->total_amount_received;

        // Check if there is withholding
        if($request->withholding_check != null) {
            $cash_on_hand -= $request->withholding;

            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_withholding);
            $debit_amount[] = $request->withholding;

            if($cash_on_hand < 0) {
                $account_receivable += $cash_on_hand;
            }
        }

        // Create Debit Postings
        // This determines which is which to include in debit postings
        if($status == 'paid' || $status == 'partially_paid') {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $debit_amount[] = $cash_on_hand;
        }
        if($status == 'partially_paid' || $status == 'unpaid') {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_account_receivable);
            $debit_amount[] = $account_receivable;
        }

        // Create Credit Postings
        // This checks whether to add credit tax posting
        if($request->tax_total > 0) {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_vat_payable);
            $credit_amount[] = $request->tax_total;
        }
        // Add credit sales posting
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_sales);
        $credit_amount[] = $request->sub_total;

        CreateJournalPostings::run($je, 
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            $accounting_system_id);
        
        //  image upload and save to database 
        // if($request->hasFile('attachment'))
        // {
        //     $file = $request->file('attachment');
        //     $filename = $file->getClientOriginalName();
        //     $file->move(public_path('images'), $filename);
        //     $receipt->attachment = $filename;
        //     $receipt->save();
        // }

        // // TODO: Refactor Attachment Upload
        
        Receipts::create([
            'receipt_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'discount' => $request->discount,
            'grand_total' => $request->grand_total,
            'remark' => $request->remark,           
            'attachment' => isset($fileAttachment) ? $fileAttachment : null, // file upload and save to database
            'discount' => '0.00', // Temporary discount
            'withholding' => isset($request->withholding_check) ? $request->withholding : '0.00',
            'tax' => $request->tax_total,
            'proforma_id' => isset($request->proforma) ? $request->proforma->value : null, // Test
            'payment_method' => DeterminePaymentMethod::run($request->grand_total, $request->total_amount_received),
            'total_amount_received' => $request->total_amount_received,
            'chart_of_account_id' => $request->receipt_cash_on_hand,
        ]);

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    /**
     * TODO: To implement
     */
    public function show()
    {
        //
    }

    public function void(ReceiptReferences $rr)
    {
        $rr->journalEntry;
        $rr->receipt;

        if($rr->is_deposited == "yes")
            return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        // Voiding a source receipt will also affect the credit receipts that are linked to it.
        $rct_list = ReceiptCashTransactions::where('for_receipt_reference_id', '=', $rr->id)
            ->where('receipt_reference_id', '!=', $rr->id)
            ->get();

        if(!empty($rct_list))
        {
            foreach($rct_list as $rrl)
            {
                if($rrl->receiptReference->is_void != "yes") {
                    $rr->receipt->total_amount_received -= $rrl->amount_received;
    
                    $rrl->receiptReference->is_void = "yes";
                    $rrl->receiptReference->journalEntry->is_void = true;
                    $rrl->push();
                }
            }

            if($rr->receipt->total_amount_received >= $rr->receipt->grand_total) {
                UpdateReceiptStatus::run($rr->id, 'paid');
            }
            else if($rr->receipt->total_amount_received > 0) {
                UpdateReceiptStatus::run($rr->id, 'partially_paid');
            }
            else if($rr->receipt->total_amount_received <= 0) {
                UpdateReceiptStatus::run($rr->id, 'unpaid');
            }
        }

        $rr->is_void = "yes";
        $rr->journalEntry->is_void = true;
        $rr->push();
            
        return redirect()->back()->with('success', "Successfully voided receipt.");
    }

    public function reactivate(ReceiptReferences $rr)
    {
        $rr->journalEntry;

        $rr->is_void = "no";
        $rr->journalEntry->is_void = false;
        $rr->push();

        return redirect()->back()->with('success', "Successfully reactivated receipt.");
    }    

    public function mail(Receipts $r)
    {
        $receipt_items = ReceiptItem::where('receipt_reference_id' , $r->receipt_reference_id)->get();
        $emailAddress = $r->receiptReference->customer->email;
        
        Mail::to($emailAddress)->queue(new MailCustomerReceipt($receipt_items));
        
        return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    public function print(Receipts $r)
    {
        $receipt_items = ReceiptItem::where('receipt_reference_id' , $r->receipt_reference_id)->get();

        $pdf = PDF::loadView('customer.receipt.print', compact('receipt_items'));

        return $pdf->stream('receipt_'.$r->id.'_'.date('Y-m-d').'.pdf');
    }
}
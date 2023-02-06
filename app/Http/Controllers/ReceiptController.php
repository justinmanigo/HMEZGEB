<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\UpdateReceiptStatus;
use App\Actions\Customer\Receipt\DeterminePaymentMethod;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Actions\Customer\CalculateBalanceCustomer;
use App\Models\Proformas;
use App\Models\CreditReceipts;
use App\Models\AdvanceRevenues;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use App\Models\ReceiptItem;
use App\Models\Customers;
use App\Models\Transactions;
use App\Models\Deposits;
use App\Models\Inventory;
use App\Models\BankAccounts;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\Receipt\StoreReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreAdvanceRevenueRequest;
use App\Http\Requests\Customer\Receipt\StoreCreditReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreProformaRequest;
use App\Models\ReceiptCashTransactions;
use Illuminate\Support\Facades\Log;
use App\Mail\Customers\MailCustomerReceipt;
use App\Mail\Customers\MailCustomerAdvanceRevenue;
use App\Mail\Customers\MailCustomerCreditReceipt;
use App\Mail\Customers\MailCustomerProforma;
use Illuminate\Support\Facades\Mail;
use PDF;


class ReceiptController extends Controller
{
    /**
     * Show the receipts page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        $transactions = ReceiptReferences::leftJoin('customers', 'customers.id', '=', 'receipt_references.customer_id')
            ->leftJoin('receipts', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
            ->leftJoin('advance_revenues', 'receipt_references.id', '=', 'advance_revenues.receipt_reference_id')
            ->leftJoin('credit_receipts', 'receipt_references.id', '=', 'credit_receipts.receipt_reference_id')
            ->leftJoin('sales', 'receipt_references.id', '=', 'sales.receipt_reference_id')
            ->select(
                'customers.name',
                'receipt_references.id',
                'receipt_references.customer_id',
                'receipt_references.date',
                'receipt_references.type',
                'receipt_references.status',
                'receipt_references.is_void',
                'receipts.total_amount_received as receipt_amount',
                'advance_revenues.total_amount_received as advance_revenue_amount',
                'credit_receipts.total_amount_received as credit_receipt_amount',
                'sales.amount_received as sales_amount'
            )
            ->where('receipt_references.accounting_system_id', $accounting_system_id)
            ->where('receipt_references.type', '!=', 'proforma')
            ->get();

        $proformas = ReceiptReferences::leftJoin('customers', 'customers.id', '=', 'receipt_references.customer_id')
            ->leftJoin('proformas', 'receipt_references.id', '=', 'proformas.receipt_reference_id')
            ->select(
                'customers.name',
                'receipt_references.id',
                'receipt_references.customer_id',
                'receipt_references.date',
                'receipt_references.type',
                'receipt_references.status',
                'receipt_references.is_void',
                'proformas.amount as proforma_amount',
            )
            ->where('receipt_references.accounting_system_id', $accounting_system_id)
            ->where('receipt_references.type', 'proforma')
            ->get();

        // count advance revenues
        $customers = Customers::where('accounting_system_id', $accounting_system_id)->get();

        $total_balance = 0;
        $total_balance_overdue = 0;
        $count = 0;
        $count_overdue = 0;

        foreach($customers as $customer){
            $total_balance += CalculateBalanceCustomer::run($customer->id)['total_balance'];
            $total_balance_overdue += CalculateBalanceCustomer::run($customer->id)['total_balance_overdue'];
            $count += CalculateBalanceCustomer::run($customer->id)['count'];
            $count_overdue += CalculateBalanceCustomer::run($customer->id)['count_overdue'];
        }

        return view('customer.receipt.index', [
            'transactions' => $transactions,
            'proformas' => $proformas,
            'total_balance' => $total_balance,
            'total_balance_overdue' => $total_balance_overdue,
            'count' => $count,
            'count_overdue' => $count_overdue,
        ]);
    }

    /** === STORE RECEIPTS === */

    public function storeReceipt(StoreReceiptRequest $request)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

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
     * TODO: Need to refactor this
     */
    public function edit($id)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $receipts = Receipts::find($id);

        if(!$receipts) abort(404);
        if($receipts->accounting_system_id != $accounting_system_id)
        return redirect('/customers/receipts')->with('danger', "You are not authorized to edit this receipt.");;

        return view('customer.receipt.edit',compact('receipts'));
    }

    /**
     * TODO: Need to refactor this
     */
    public function update(Request $request, $id)
    { 
        $receipts = Receipts::find($id);

        $receipts->receipt_reference_id =  $request->input('receipt_reference_id');
        $receipts->due_date =  $request->input('due_date');
        $receipts->sub_total =  $request->input('sub_total');
        $receipts->discount =  $request->input('discount');
        $receipts->grand_total =  $request->input('grand_total');
        $receipts->remark = $request->input('remark');
        $receipts->discount = $request->input('discount');
        $receipts->withholding = $request->input('withholding');
        $receipts->tax = $request->input('tax');
        $receipts->proforma_id = $request->input('proforma_id');
        $receipts->payment_method = $request->input('payment_method');
        $receipts->total_amount_received = $request->input('total_amount_received');
        $receipts->is_active ='Yes';
        $receipts->update();

        return redirect('receipt/')->with('success', "Successfully edited receipt.");

    }
    // SHOW
    public function show(Receipts $receipt)
    {   
        return view('customer.receipt.edit',compact('receipt'));
    }

    
    /**
     * TODO: Need to refactor this
     */
    public function destroy($id)
    {
        $receipt = ReceiptReferences::find($id);

        // If receipt
        if($receipt->type == 'receipt')
        {
            // Get receipt id
            $r = $receipt->receipt()->first();

            // Delete receipt items
            ReceiptItem::where('receipt_id', '=', $r->id);

            // Delete receipt
            $r->delete();
        }
        else if($receipt->type == 'advance_receipt')
        {
            // TODO: Other deletions later
            $receipt->advanceRevenue()->delete();
        }
        else if($receipt->type == 'credit_receipt')
        {
            // TODO: Other deletions later
            $receipt->creditReceipt()->delete();
        }
        else if($receipt->type == 'proforma')
        {
            // TODO: Other deletions later
            // // Get receipt id
            // $p = $receipt->proforma()->first();

            // // Delete receipt items
            // ReceiptItem::where('receipt_id', '=', $p->id);

            // // Delete receipt
            // $r->delete();

            // $receipt->proforma()->receiptItems()->delete();
            $receipt->proforma()->delete();
        }
        $receipt->delete();
  
        return redirect('receipt/')->with('success', "Successfully deleted customer");
    }

    // VOID
    public function voidReceipt($id)
    {
        $rr = ReceiptReferences::find($id);
        $rr->journalEntry;
        $rr->receipt;

        if($rr->is_deposited == "yes")
            return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        // Voiding a source receipt will also affect the credit receipts that are linked to it.
        $rct_list = ReceiptCashTransactions::where('for_receipt_reference_id', '=', $id)
            ->where('receipt_reference_id', '!=', $id)
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

     

    // REACTIVATE VOID
    public function reactivateReceipt($id)
    {
        $rr = ReceiptReferences::find($id);
        $rr->journalEntry;

        $rr->is_void = "no";
        $rr->journalEntry->is_void = false;
        $rr->push();

        return redirect()->back()->with('success', "Successfully reactivated receipt.");
    }    

    // Mail
    public function sendMailReceipt($id)
    {
        $receipt = Receipts::find($id);
        $receipt_items = ReceiptItem::where('receipt_reference_id' , $receipt->receipt_reference_id)->get();
        $emailAddress = $receipt->receiptReference->customer->email;
        
        Mail::to($emailAddress)->queue(new MailCustomerReceipt($receipt_items));
        
        return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    // Print
    public function printReceipt($id)
    {
        $receipt = Receipts::find($id);
        $receipt_items = ReceiptItem::where('receipt_reference_id' , $receipt->receipt_reference_id)->get();

        $pdf = PDF::loadView('customer.receipt.print', compact('receipt_items'));

        return $pdf->stream('receipt_'.$id.'_'.date('Y-m-d').'.pdf');
    }

    // export
    public function exportReceipts()
    {
        // convert receipts, proforma, credit_receipts,advance_revenue into one csv
        $receipts = Receipts::all();
        $proforma = Proformas::all();
        $credit_receipts = CreditReceipts::all();
        $advance_revenue = AdvanceRevenues::all();
        // open file
        $file = fopen('receipts.csv', 'w');
        // write header
        fputcsv($file, array('Receipts'));
        fputcsv($file, array('id','receipt_reference_id','proforma_id','chart_of_account_id','discount','due_date','sub_total','discount','tax','grand_total','total_amount_received','withholding','remark','created_at','attachment','payment_method','created_at','updated_by'));
        // loop through the array
        foreach ($receipts as $receipt) {
            // add the data to the file
            $receipt = $receipt->toArray();
            fputcsv($file, $receipt);
        }
        
        // write header
        fputcsv($file, array('Proforma'));
        fputcsv($file, array('id','receipt_reference_id','due_date','amount','tax','terms_and_condition','attachment','created_at','updated_by'));
        
        foreach ($proforma as $proforma) {
            // add the data to the file
            $proforma = $proforma->toArray();
            fputcsv($file, $proforma);
        }

        // write header
        fputcsv($file, array('Credit Receipts'));
        fputcsv($file, array('id','receipt_reference_id','credit_receipt_number','total_amount_received','description','remark','attachment','created_at','updated_by'));
        
        foreach ($credit_receipts as $credit_receipt) {
            // add the data to the file
            $credit_receipt = $credit_receipt->toArray();
            fputcsv($file, $credit_receipt);
        }

        // write header
        fputcsv($file, array('Advance Revenue'));
        fputcsv($file, array('id','receipt_reference_id','advance_revenue_number','total_amount_received','reason','remark','attachment','created_at','updated_by'));
        foreach ($advance_revenue as $advance_revenue) {
            // add the data to the file
            $advance_revenue = $advance_revenue->toArray();
            fputcsv($file, $advance_revenue);
        }
        // close the file
        fclose($file);
        // redirect to the file
        return response()->download('receipts.csv');
    }


    /*********** AJAX *************/

    /**
     * Deprecated function.
     */
    public function ajaxGetPaidReceipt()
    {
        $receipts = ReceiptReferences::select(
                'receipt_references.id as value',
                'receipt_references.date',
                'receipts.total_amount_received',
                'receipts.payment_method',
                'customers.name as customer_name',
            )
            ->leftJoin('receipts', 'receipts.receipt_reference_id', '=', 'receipt_references.id')
            ->leftJoin('customers', 'customers.id', '=', 'receipt_references.customer_id')
            ->where('receipt_references.status', 'paid')
            ->where('receipt_references.type', 'receipt')
            ->where('receipt_references.is_deposited', 'no')
            ->get();
        return $receipts;
    }
}

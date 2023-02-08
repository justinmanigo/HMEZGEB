<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
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


class ReceiptsController extends Controller
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
}

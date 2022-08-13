<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Vendor\Bill\StoreBillItems;
use App\Actions\Vendor\Bill\UpdateBillStatus;
use App\Http\Requests\Vendor\Bill\StoreBillRequest;
use App\Http\Requests\Vendor\Bill\StorePurchaseOrderRequest;
use App\Models\Bills;
use App\Models\Vendors;
use App\Models\PaymentReferences;
use App\Models\BillItem;
use App\Models\PurchaseOrders;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Mail\MailVendorBill;
use Illuminate\Support\Facades\Mail;
use PDF;


class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = PaymentReferences::leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
            // where subquery
            ->where(function ($query) {
                $query->where('payment_references.type', '=', 'bill')
                    ->orWhere('payment_references.type', '=', 'purchase_order');
            })
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                // 'payment_references.is_void',
                'bills.grand_total as bill_amount',
                'purchase_orders.grand_total as purchase_order_amount',
            )
            ->get();

        return view('vendors.bills.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    /** === STORE BILLS === */

    public function storeBill(StoreBillRequest $request)
    {
        // return $request;

        // If this transaction is linked to Proforma
        if(isset($request->purchase_order)) UpdateBillStatus::run($request->purchase_order->value, 'paid');

        // Determine bill status.
        if($request->grand_total == $request->total_amount_received)
            $status = 'paid';
        else if($request->total_amount_received == 0)
            $status = 'unpaid';
        else
            $status = 'partially_paid';

        // Create BillReference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'bill',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => $status
        ]);

        // If request has attachment, store it to file storage.
        // if($request->attachment) {
        //     $fileAttachment = time().'.'.$request->attachment->extension();  
        //     $request->attachment->storeAs('public/bill-attachment'/'bill', $fileAttachment);
        // }
        
        // Create child database entry
        if($request->grand_total == $request->total_amount_received)
            $payment_method = 'cash';
        else
            $payment_method = 'credit';
        
        UpdateInventoryItemQuantity::run($request->item, $request->quantity, 'increase');
        StoreBillitems::run($request->item, $request->quantity, $reference->id);

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Create Debit Postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_items_for_sale);
        $debit_amount[] = $request->sub_total;

        // Create Credit Postings
        // This determines which is which to include in debit postings
        if($status == 'paid' || $status == 'partially_paid') {
            $cash_on_hand = $request->total_amount_received;
            
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_cash_on_hand);
            $credit_amount[] = $cash_on_hand;
        }
        if($status == 'partially_paid' || $status == 'unpaid') {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_account_payable);
            $credit_amount[] = $request->grand_total - $request->total_amount_received;
        }

        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));
            
        Bills::create([
            'payment_reference_id' => $reference->id,
            // 'withholding_payment_id' => '0', // temporary
            'purchase_order_id' => isset($request->purchase_order) ? $request->purchase_order->value : null,
            'due_date' => $request->due_date,
            'chart_of_account_id' => $request->chart_of_account_id,
            'sub_total' => $request->sub_total,
            'discount' => '0', // temporary
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            'withholding' => '0', // temporary
            'withholding_status' => 'paid', // temporary
            'payment_method' => $payment_method,
            'amount_received' => $request->total_amount_received,
        ]);
        
        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    public function storePurchaseOrder(StorePurchaseOrderRequest $request)
    {
        // Create Payment Reference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'purchase_order',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => 'unpaid',
        ]);

        // Create Purchase Order Record
        //  if($request->attachment) {
        //      $fileAttachment = time().'.'.$request->attachment->extension();  
        //      $request->attachment->storeAs('public/bill-attachment', $fileAttachment);
        //  }

        StoreBillitems::run($request->item, $request->quantity, $reference->id);

        return PurchaseOrders::create([
            'payment_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            // image upload
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    // send Email
    public function sendMailBill($id)
    {
        $bills = Bills::find($id);
        $emailAddress = $bills->paymentReference->vendor->email;

        Mail::to($emailAddress)->queue(new MailVendorBill ($bills));
        
        return redirect()->route('bills.bills.index')->with('success', 'Email has been sent!');
    }

    // Print
    public function printBill($id)
    {
        $bills = Bills::find($id);

        $pdf = PDF::loadView('vendors.bills.print', compact('bills'));
        return $pdf->download('bill_'.date('Y-m-d').'.pdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function show(Bills $bills)
    {
        return view('vendors.bills.individualBill');
    }

    public function showPurchaseOrder(PurchaseOrders $purchaseOrders)
    {
        return view('vendors.bills.purchaseOrder');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function edit(Bills $bills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills $bills)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bills $bills)
    {
        //
    }

    
}

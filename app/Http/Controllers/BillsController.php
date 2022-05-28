<?php

namespace App\Http\Controllers;

use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Vendor\Bill\StoreBillItems;
use App\Http\Requests\Vendor\Bill\StoreBillRequest;
use App\Http\Requests\Vendor\Bill\StorePurchaseOrderRequest;
use App\Models\Bills;
use App\Models\Vendors;
use App\Models\PaymentReferences;
use App\Models\BillItem;
use App\Models\PurchaseOrders;
use App\Models\Inventory;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get vendors table join
          $bill = Vendors::join('payment_references', 'payment_references.vendor_id', '=', 'vendors.id')
            ->join('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->select('payment_references.*', 'vendors.name', 'bills.grand_total');

        $bill_and_purchase_order = Vendors::join('payment_references', 'payment_references.vendor_id', '=', 'vendors.id')
            ->join('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
            ->select('payment_references.*', 'vendors.name', 'purchase_orders.grand_total')
            ->union($bill)
            ->get();        
       
        return view('vendors.bills.index',compact('bill_and_purchase_order'));
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

        // TODO: Link with Purchase Order (if applicable)

        // Determine bill status.
        if($request->grand_total == $request->total_amount_received)
            $status = 'paid';
        else if($request->total_amount_received == 0)
            $status = 'unpaid';
        else
            $status = 'partially_paid';

        // Create BillReference Record
        $reference = PaymentReferences::create([
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
            
        return Bills::create([
            'payment_reference_id' => $reference->id,
            // 'withholding_payment_id' => '0', // temporary
            'purchase_order_id' => $request->purchase_order_id,
            'due_date' => $request->due_date,
            'chart_of_account_id' => $request->chart_of_account_id,
            'sub_total' => $request->sub_total,
            'discount' => '0', // temporary
            'tax' => '0', // temporary
            'grand_total' => $request->grand_total,
            'withholding' => '0', // temporary
            'withholding_status' => 'paid', // temporary
            'payment_method' => $payment_method,
            'amount_received' => $request->total_amount_received,
        ]);
        
    }

    public function storePurchaseOrder(StorePurchaseOrderRequest $request)
    {
        // Create Payment Reference Record
        $reference = PaymentReferences::create([
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
            'grand_total' => $request->grand_total,
            // image upload
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
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

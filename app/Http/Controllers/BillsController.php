<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Vendors;
use App\Models\PaymentReferences;
use App\Models\BillItem;
use App\Models\PurchaseOrders;
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
        
        // join vendors table with bills table and select all the fields from vendors table and bills table. 
        $bills = Vendors::join(
            'bills',
            'vendors.id',
            '=',
            'bills.vendor_id'
        )->select(
            // get vendors name
            'vendors.name as vendor_name',
        );
        
        return view('vendors.bills.index',compact('bills'));
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

    public function storeBill(Request $request)
    {
        // Decode json of item tagify fields.
        for($i = 0; $i < count($request->item); $i++)
        {
            $item = json_decode($request->item[$i]);

            // Resulting json_decode will turn into an array of
            // object, thus it has to be merged.
            $items[$i] = $item[0];
        }

        // // Decode Proforma field
        // $p = json_decode($request->proforma);
        // $proforma = isset($p) ? $p[0] : null;

        // // If this transaction is linked to Proforma
        // if(isset($proforma))
        // {
        //     BillReferences::where('id', $proforma->value)
        //         ->update([
        //             'status' => 'paid'
        //         ]);
        // }

        // Determine bill status.
        if($request->grand_total == $request->total_amount_received)
            $status = 'paid';
        else if($request->total_amount_received == 0)
            $status = 'unpaid';
        else
            $status = 'partially_paid';

        // Create BillReference Record
        $reference = PaymentReferences::create([
            'vendor_id' => $request->vendor_id,
            'date' => $request->date,
            'type' => 'bill',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
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
        
        // Create Bill Record
        $bills = Bills::create([
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
            'payment_method' => $payment_method,
            'amount_received' => $request->total_amount_received,
        ]);
        // Create Bill Item Records
        for($i = 0; $i < count($items); $i++)
        {
            BillItem::create([
                'inventory_id' => $items[$i]->value,
                'bill_id' => $bills->id,
                'quantity' => $request->quantity[$i],
                'price' => $items[$i]->sale_price,
                'total_price' => $request->quantity[$i] * $items[$i]->sale_price,
            ]);
        }

        //  image upload and save to database 
        // if($request->hasFile('attachment'))
        // {
        //     $file = $request->file('attachment');
        //     $filename = $file->getClientOriginalName();
        //     $file->move(public_path('images'), $filename);
        //     $bill->attachment = $filename;
        //     $bill->save();
        // }

        return redirect()->back()->with('success', 'Bill has been created successfully.');
        
    }

    public function storePurchaseOrder(Request $request)
    {
         // Decode json of item tagify fields.
         for($i = 0; $i < count($request->item); $i++)
         {
             $item = json_decode($request->item[$i]);
 
             // Resulting json_decode will turn into an array of
             // object, thus it has to be merged.
             $items[$i] = $item[0];
         }
         
         // Temporary status
         $status = 'unpaid';
 
         // payment References
         $reference = PaymentReferences::create([
            'vendor_id' => $request->vendor_id,
            'date' => $request->date,
            'type' => 'bill',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
        ]);
 
         // Create child database entry
         if($reference)        
         {
            //  if($request->attachment) {
            //      $fileAttachment = time().'.'.$request->attachment->extension();  
            //      $request->attachment->storeAs('public/bill-attachment', $fileAttachment);
            //  }
             $purchase_orders = PurchaseOrders::create([
                 'payment_reference_id' => $reference->id,
                 'due_date' => $request->due_date,
                 'sub_total' => $request->sub_total,
                 'grand_total' => $request->grand_total,
                 // image upload
                 'attachment' => isset($fileAttachment) ? $fileAttachment : null,
             ]);
         }
 
         // TODO: Merge with billItems (use billReference instead of billId for bills)
         // Create bill Item Records
         for($i = 0; $i < count($items); $i++)
         {
            BillItem::create([
                'inventory_id' => $items[$i]->value,
                'bill_id' => $purchase_orders->id,
                'quantity' => $request->quantity[$i],
                'price' => $items[$i]->sale_price,
                'total_price' => $request->quantity[$i] * $items[$i]->sale_price,
            ]);
         }
         
         return redirect()->back()->with('success', 'Proforma has been added successfully');
 
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

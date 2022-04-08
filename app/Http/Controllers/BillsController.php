<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Vendors;
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
    public function storeBill(Request $request)
    {
        // // Decode json of item tagify fields.
        // for($i = 0; $i < count($request->item); $i++)
        // {
        //     $item = json_decode($request->item[$i]);

        //     // Resulting json_decode will turn into an array of
        //     // object, thus it has to be merged.
        //     $items[$i] = $item[0];
        // }

        // // Determine receipt status.
        // if($request->grand_total == $request->total_amount_received)
        //     $status = 'paid';
        // else if($request->total_amount_received == 0)
        //     $status = 'unpaid';
        // else
        //     $status = 'partially_paid';

        // // Create ReceiptReference Record
        // $reference = Bills::create([
        //     'customer_id' => $request->customer_id,
        //     'reference_number' => $request->reference_number,
        //     'date' => $request->date,
        //     'type' => 'receipt',
        //     'is_void' => 'no',
        //     'status' => $status
        // ]);

        // // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }
        
        // // Create child database entry
        if($request->grand_total==$request->total_amount_received)
            $cash_from = 'cash';
        else
            $cash_from = 'credit';
        // // return $request;
        // // Create Receipt Record
        $receipt = Bills::create([
            'vendor_id' => $request->vendor_id,
            'date' => $request->date,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'bill_number' => $request->bill_number,
            'order_number' => $request->order_number,
            'grand_total' => $request->grand_total,
            'note' => $request->note,           
            'attachment' => isset($fileAttachment) ? $fileAttachment : null, // file upload and save to database
            'discount' => '0.00', // Temporary discount
            'withholding' => '0.00', // Temporary Withholding
            'tax' => '0.00', // Temporary Tax value
            'cash_from' => $cash_from,
            'total_amount_received' => $request->total_amount_received
        ]);

        // // // Create Receipt Item Records
        // for($i = 0; $i < count($items); $i++)
        // {
        //     Bills::create([
        //         'inventory_id' => $items[$i]->value,
        //         'bill_id' => $receipt->id,
        //         'quantity' => $request->quantity[$i],
        //         'price' => $items[$i]->sale_price,
        //         'total_price' => $request->quantity[$i] * $items[$i]->sale_price,
        //     ]);
        // }

        return redirect()->route('bills.bill.index')->with('success', 'Receipt has been added successfully');
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

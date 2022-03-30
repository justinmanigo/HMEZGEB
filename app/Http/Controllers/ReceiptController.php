<?php

namespace App\Http\Controllers;
use App\Models\AdvanceRevenues;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use App\Models\Customers;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Show the receipts page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customers = Customers::all();
        return view('customer.receipt.index',compact('customers'));
    }
    
    public function storeReceipt(Request $request)
    {

        // if(// insert logic)
        //     {
                $status = 'unpaid';
            // }
    
            $reference = ReceiptReferences::create([
                'customer_id' => $request->customer_id,
                'reference_number' => $request->reference_number,
                'date' => $request->date,
                'type' => 'receipt',
                'is_void' => 'no',
                'status' => $status
            ]);

                   // Create child database entry
            if($reference)        
            {
                if($request->grand_total==$request->total_amount_received)
                {
                    $payment_method = 'cash';
                }
                else
                {
                    $payment_method = 'credit';
                }
                $reference->id;
                $receipt = Receipts::create([
                    'receipt_reference_id' => $reference->id,
                    'due_date' => $request->due_date,
                    'sub_total' => $request->sub_total,
                    'discount' => $request->discount,
                    // 'tax' => $request->tax,
                    'grand_total' => $request->grand_total,
                    // 'withholding' => $request->withholding,
                    'remark' => $request->remark,

                    // image upload
                    // 'attachment' => $request->attachment,

                    // Temporary discount
                    'discount' => '0.00',
                    // Temporary Withholding
                    'withholding' => '0.00',
                    // Temporary Tax value
                    'tax' => '0.00',
                    // Temporary reference number
                    'receipt_number' => $request->proforma_number,
                    // Temporary proforma id
                    'proforma_id' => null,

                    'payment_method' => $payment_method,
                    'total_amount_received' => $request->total_amount_received
                    
                ]);
                return redirect()->route('receipts.receipt.index')->with('success', 'Receipt has been added successfully');
            }
     

    }
    public function storeAdvanceRevenue(Request $request){

        $advanceRevenue = new AdvanceRevenue();
        // $advanceRevenue -> receipt_reference_id = $request -> receipt_reference_id;
        $advanceRevenue->advance_revenue_number = $request->advance_revenue_number;
        $advanceRevenue->total_amount_received = $request->amount_received;
        $advanceRevenue->reason = $request->reason;
        $advanceRevenue->remark = $request->remark;
        $advanceRevenue->save();
        $advanceRevenue->customer_id = $request->customer_id;
        return view('customer.receipt.index',compact('customers'));
    }

}

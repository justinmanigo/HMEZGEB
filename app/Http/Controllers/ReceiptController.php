<?php

namespace App\Http\Controllers;
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
    
    public function selectCustomer(Request $request){
       
        $customers = Customers::where('id',$request->customer_id)->first();
    
       return response()->json([
            'customers' => $customers,
        ]);
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

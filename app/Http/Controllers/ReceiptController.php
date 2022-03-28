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

}

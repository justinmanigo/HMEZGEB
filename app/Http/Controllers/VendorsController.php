<?php

namespace App\Http\Controllers;

use App\Models\Vendors;
use App\Imports\ImportVendorsVendor;
use App\Exports\ExportVendorsVendor;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\PaymentReferences;
use Illuminate\Support\Facades\Log;
use App\Mail\Vendors\MailVendorStatement;
use Illuminate\Support\Facades\Mail;
use App\Actions\Vendor\CalculateBalanceVendor;
use Illuminate\Support\Facades\DB;
use PDF;



class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::where('accounting_system_id', $accounting_system_id)->get();

        $total_balance = 0;
        $total_balance_overdue = 0;
        $count = 0;
        $count_overdue = 0;
        foreach($vendors as $vendor){
            $vendor->balance = CalculateBalanceVendor::run($vendor->id);
            $total_balance += $vendor->balance['total_balance'];
            $count += $vendor->balance['count'];
            $total_balance_overdue += $vendor->balance['total_balance_overdue'];
            $count_overdue += $vendor->balance['count_overdue'];
        }
        
        return view('vendors.vendors.index',compact('vendors', 'total_balance', 'count', 'total_balance_overdue', 'count_overdue'));
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
    public function store(Request $request)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        $vendor = new Vendors();

        if($request->image)
        {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->storeAs('public/vendors/vendor', $imageName);
        }
        $vendor->accounting_system_id = $accounting_system_id;
        $vendor->name =  $request->name;
        $vendor->tin_number =  $request->tin_number;
        $vendor->address =  $request->address;
        $vendor->city =  $request->city;
        $vendor->country =  $request->country;
        $vendor->mobile_number =  $request->mobile_number;
        $vendor->telephone_one =  $request->telephone_one;
        $vendor->telephone_two =  $request->telephone_two;
        $vendor->fax =  $request->fax;
        $vendor->website =  $request->website;
        $vendor->email =  $request->email;
        $vendor->contact_person =  $request->contact_person;
        $vendor->label =  $request->label;
        $vendor->image = isset($imageName) ? $imageName : null;
        $vendor->is_active =  $request->is_active;

        $vendor->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function show(Vendors $vendors)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::where('accounting_system_id', $accounting_system_id)->get();

        return view('vendors.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        //view edit vendor info
        $vendor = Vendors::where('id',$id)->first();
        if(!$vendor) return abort(404);
        if($vendor->accounting_system_id != $accounting_system_id) {
            return redirect()->route('vendors.vendors.index')->with('danger', "You are not authorized to edit this vendor.");
        }
        
        return view('vendors.vendors.individualVendor', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update the form
      
        $vendor = Vendors::where('id',$id)->first();
        // if not null then update the image
        if($request->image)
        {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->storeAs('public/vendors/vendor', $imageName);
            $vendor->image = $imageName;
        }

        $vendor->name =  $request->name;
        $vendor->tin_number =  $request->tin_number;
        $vendor->address =  $request->address;
        $vendor->city =  $request->city;
        $vendor->country =  $request->country;
        $vendor->mobile_number =  $request->mobile_number;
        $vendor->telephone_one =  $request->telephone_one;
        $vendor->telephone_two =  $request->telephone_two;
        $vendor->fax =  $request->fax;
        $vendor->website =  $request->website;
        $vendor->email =  $request->email;
        $vendor->contact_person =  $request->contact_person;
        $vendor->label =  $request->label;
        $vendor->is_active =  $request->is_active;

        $vendor->save();
        return back()->withSuccess('Successfully Updated');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendors  $vendors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        $vendor = Vendors::where('id',$id)->first();
        $vendor->delete();
        }
        catch(\Exception $e)
        {
            return back()->with('error', 'Make sure there are no related transactions with vendor.');
        }
        return redirect('/vendors')->withSuccess('Successfully Deleted');;
    
    }

    // Mail Statetment
    public function mailVendorStatement($id)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::where('accounting_system_id', $accounting_system_id)
        ->where('id', $id)
        ->whereHas('PaymentReferences', function($query) {
            $query->where('type', 'bill')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                  ->orWhere('status', 'partially_paid');
              });})->first();

        if(!$vendors)
            return redirect()->back()->with('error', "No pending statements found.");
        
        $payment_reference = PaymentReferences::where('vendor_id', $vendors->id)
        ->where('type', 'bill')
        ->where(function ($query) {
            $query->where('status', 'unpaid')
              ->orWhere('status', 'partially_paid');
          })->get(); 

        $bills = [];
        
        foreach($payment_reference as $payment)
        {
            $bills[] = $payment->toArray() + $payment->bills->toArray();
        }

        Mail::to($vendors->email)->queue(new MailVendorStatement ($vendors, $bills));


        return redirect()->back()->with('success', "Successfully sent vendor statement.");     
    }

    // Print Statement
    public function printVendorStatement($id)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::where('accounting_system_id', $accounting_system_id)
        ->where('id', $id)
        ->whereHas('PaymentReferences', function($query) {
            $query->where('type', 'bill')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                  ->orWhere('status', 'partially_paid');
              });})->first();


        if(!$vendors)
            return redirect()->back()->with('error', "No pending statements found.");
        
        $payment_references = PaymentReferences::where('vendor_id', $vendors->id)
        ->where('type', 'bill')
        ->where(function ($query) {
            $query->where('status', 'unpaid')
              ->orWhere('status', 'partially_paid');
          })->get(); 

        $total_balance = 0;
        foreach($payment_references as $payment_reference) {
            $total_balance += $payment_reference->bills->grand_total - $payment_reference->bills->amount_received;
        }

        $pdf = PDF::loadView('vendors.vendors.print', compact('payment_references','total_balance'));
        return $pdf->stream('vendor_statement_'.$id.'_'.date('Y-m-d').'.pdf');
    }

    // Import Export
    public function import(Request $request)
    {
        if (!$request->file('file'))
        {
            return back()->with('error', 'Please select a file');
        }
        try {
            Excel::import(new ImportVendorsVendor, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing bank account');
        }  
        return redirect()->back()->with('success', 'Successfully imported vendor records.');

    }

    public function export(Request $request)
    {

        if($request->type=="csv")
        return Excel::download(new ExportVendorsVendor, 'vendorsVendor_'.date('Y_m_d').'.csv');
        else
        $vendors = Vendors::all();
        $pdf = \PDF::loadView('vendors.vendors.pdf', compact('vendors'));
        return $pdf->download('vendorsVendor_'.date('Y_m_d').'.pdf');
 
    }

    public function queryVendors($query)
    {   
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::select('id as value', 'name', 'address', 'contact_person','telephone_one', 'tin_number', 'mobile_number')
            ->where('accounting_system_id', $accounting_system_id)
            ->where('name', 'LIKE', '%' . $query . '%')->get();
        return $vendors;
    }

    public function ajaxGetBillPaymentsToPay(Vendors $vendor)
    {
        return PaymentReferences::select(
            'payment_references.id as value',
            'bills.due_date',
            DB::raw('bills.grand_total - bills.amount_received as balance'),
        )
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->where('payment_references.type', '=', 'bill')
            ->where('payment_references.vendor_id', '=', $vendor->id)
            ->where('payment_references.status', '!=', 'paid')->get();
    }

    public function ajaxGetWithholdingToPay(Vendors $vendor)
    {

        return PaymentReferences::select('*')
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->where('payment_references.type', '=', 'bill')
            ->where('payment_references.vendor_id', '=', $vendor->id)
            ->where('bills.withholding', '>', '0')->get();

    }

    public function ajaxSearchVendorPurchaseOrder(Vendors $vendor, $value)
    {
        $purchase_orders = PaymentReferences::select(
            'payment_references.id as value',
            'payment_references.date',
            'purchase_orders.grand_total as amount',
            'purchase_orders.due_date',
        )
        ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
        ->where('vendor_id', $vendor->id)
        ->where('type', 'purchase_order')
        ->where('status', 'unpaid')
        ->get();

        return $purchase_orders;
    }

    public function ajaxGetPurchaseOrder(PaymentReferences $purchaseOrder)
    {
        // Load relationships.
        $purchaseOrder->purchaseOrders;
        $purchaseOrder->billItems;
        for($i = 0; $i < count($purchaseOrder->billItems); $i++){
            $purchaseOrder->billItems[$i]->inventory;
            $purchaseOrder->billItems[$i]->inventory->tax;
        }

        // Return response
        return $purchaseOrder;
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Vendors;
use Illuminate\Http\Request;
use App\Models\PaymentReferences;
use Illuminate\Support\Facades\Log;


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
        
        return view('vendors.vendors.vendor',compact('vendors'));
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
        
        return view('vendors.vendors.vendor',compact('vendors'));
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
        //view edit customer info
        $vendor = Vendors::where('id',$id)->first();
        if(!$vendor) return abort(404);
        if($vendor->accounting_system_id != $accounting_system_id) {
            return redirect('/vendors/vendors')->with('danger', "You are not authorized to edit this vendor.");
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
        $imageName = time().'.'.$request->image->extension();  
        $request->image->storeAs('public/vendors/vendor', $imageName);

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
        $vendor->image = $imageName;
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
        $vendor = Vendors::where('id',$id)->first();
        $vendor->delete();
        return redirect('/vendors')->withSuccess('Successfully Deleted');;
    
    }

    public function toCSV()
    {
        
        Log::info("Exporting Vendors");
        // create a csv file
        $vendors = Vendors::all();
        // open file
        $file = fopen('vendors.csv', 'w');
        // add column name
        fputcsv($file, array('ID','Account_ID', 'Name', 'TIN Number', 'Address', 'City', 'Country', 'Mobile Number', 'Telephone_one', 'Telephone_Two', 'Fax', 'Website', 'Email', 'Contact_person', 'Label', 'Image', 'is_active', 'Created_at', 'Updated_at'));

        // loop through the array
        foreach ($vendors as $vendor) {
            // add the data to the file
            $vendor = $vendor->toArray();
            fputcsv($file, $vendor);
        }
        // close the file
        fclose($file);
        // redirect to the file
        return response()->download('vendors.csv');
 
    }

    public function queryVendors($query)
    {   
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $vendors = Vendors::select('id as value', 'name', 'address', 'contact_person','telephone_one')
            ->where('accounting_system_id', $accounting_system_id)
            ->where('name', 'LIKE', '%' . $query . '%')->get();
        return $vendors;
    }

    public function ajaxGetPaymentsToPay(Vendors $vendor)
    {
        return PaymentReferences::select('*')
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


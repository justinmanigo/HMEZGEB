<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use App\Models\ReceiptReferences;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the customers page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $customers = Customers::where('accounting_system_id', $accounting_system_id)->get();

        return view('customer.customer.index',compact('customers'));
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

        if($request->image) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->storeAs('customers', $imageName);
        }
        
        $customers = new Customers();
        $customers->accounting_system_id = $accounting_system_id;
        $customers->name =  $request->name;
        $customers->tin_number =  $request->tin_number;
        $customers->address =  $request->address;
        $customers->city =  $request->city;
        $customers->country =  $request->country;
        $customers->mobile_number = $request->mobile_number;
        $customers->telephone_one = $request->telephone_one;
        $customers->telephone_two = $request->telephone_two;
        $customers->fax = $request->fax;
        $customers->website = $request->website;
        $customers->email = $request->email;
        $customers->contact_person = $request->contact_person;
        $customers->label = $request->label;
        $customers->image =  isset($imageName) ? $imageName : null;
        $customers->is_active ='Yes';
        $customers->save();
        return redirect('/customers/customers')->with('success', "Successfully added new customer.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $customers = Customers::where('accounting_system_id', $accounting_system_id)->get();

        return view('customer.customer.index',compact('customers'));
    }
    public function edit($id)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $customers = Customers::find($id);
        if($customers->accounting_system_id != $accounting_system_id)
            return redirect('/customers/customers')->with('danger', "You are not authorized to edit this customer.");

        return view('customer.customer.edit', compact('customers'));
    }

    public function update(Request $request, $id)
    { 
        $customers = Customers::find($id);

        $customers->name =  $request->input('name');
        $customers->tin_number =  $request->input('tin_number');
        $customers->address =  $request->input('address');
        $customers->city =  $request->input('city');
        $customers->country =  $request->input('country');
        $customers->mobile_number = $request->input('mobile_number');
        $customers->telephone_one = $request->input('telephone_one');
        $customers->telephone_two = $request->input('telephone_two');
        $customers->fax = $request->input('fax');
        $customers->website = $request->input('website');
        $customers->email = $request->input('email');
        $customers->contact_person = $request->input('contact_person');
        $customers->label = $request->input('label');
        $customers->is_active ='Yes';
        $customers->update();

        return redirect('/customers/customers')->with('success', "Successfully edited customer.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        
        $customers = Customers::find($id);
        $customers->delete();
        
        return redirect('/customers/customers')->with('danger', "Successfully deleted customer");

    }

    public function toCSV()
    {
        // create a csv file
        $customers = Customers::all();
        // open file
        $file = fopen('customers.csv', 'w');
        // write header
        fputcsv($file, array('id', 'accounting_system_id','name', 'tin_number', 'address', 'city', 'country', 'mobile_number', 'telephone_one', 'telephone_two', 'fax', 'website', 'email', 'contact_person', 'image','label', 'is_active','created_at','updated_at','updated_by'));
        // loop through the array
        foreach ($customers as $customer) {
            // add the data to the file
            $customer = $customer->toArray();
            fputcsv($file, $customer);
        }
        // close the file
        fclose($file);
        // redirect to the file
        return response()->download('customers.csv');

    }

    /*=================================*/

    public function queryCustomers($query)
    {   
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        $customers = Customers::select('id as value', 'name', 'tin_number', 'contact_person','mobile_number')
            ->where('accounting_system_id', $accounting_system_id)
            ->where('name', 'LIKE', '%' . $query . '%')->get();
            
        return $customers;
    }

    public function ajaxGetReceiptsToPay(Customers $customer)
    {
        return ReceiptReferences::select('*')
            ->leftJoin('receipts', 'receipts.receipt_reference_id', '=', 'receipt_references.id')
            ->where('receipt_references.type', '=', 'receipt')
            ->where('receipt_references.customer_id', '=', $customer->id)
            ->where('receipt_references.status', '!=', 'paid')->get();
    }
}

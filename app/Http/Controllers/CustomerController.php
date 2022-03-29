<?php

namespace App\Http\Controllers;
use App\Models\Customers;

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
        $customers = Customers::all();

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
        if($request->image) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->storeAs('customers', $imageName);
        }
        
        $customers = new Customers();
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
        return redirect('customer/')->with('success', "Successfully added new customer.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        $customers = Customers::all();

        // Compute for each inventory value and total value.
         

        return view('customer.customer.index',compact('customers'));
    }
    public function edit($id)
    {
        $customers = Customers::find($id);
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

        return redirect('customer/')->with('success', "Successfully edited customer.");

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
        
        return redirect('customer/')->with('danger', "Successfully deleted customer");

    }

    /*=================================*/

    public function queryCustomers($query)
    {   
        $customers = Customers::select('id as value', 'name', 'tin_number', 'contact_person','mobile_number')
            ->where('name', 'LIKE', '%' . $query . '%')->get();
        return $customers;
    }
}

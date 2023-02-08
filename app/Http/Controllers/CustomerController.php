<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use App\Imports\ImportCustomersCustomer;
use App\Exports\ExportCustomersCustomer;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use Illuminate\Http\Request;
use App\Mail\Customers\MailCustomerStatement;
use Illuminate\Support\Facades\Mail;
use App\Exceptions;
use App\Actions\Customer\CalculateBalanceCustomer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Show the customers page of customers menu.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customers = Customers::where('accounting_system_id', session('accounting_system_id'))->get();
        
        $total_balance = 0;
        $total_balance_overdue = 0;
        $count = 0;
        $count_overdue = 0;
        foreach($customers as $customer){
            $customer->balance = CalculateBalanceCustomer::run($customer->id);
            $total_balance += $customer->balance['total_balance'];
            $count += $customer->balance['count'];
            $total_balance_overdue += $customer->balance['total_balance_overdue'];
            $count_overdue += $customer->balance['count_overdue'];
        }
        
        return view('customer.customer.index',compact('customers', 'total_balance', 'count', 'total_balance_overdue', 'count_overdue'));
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
        $customers->accounting_system_id = session('accounting_system_id');
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
        $customers->is_active = $request->is_active ? true : false;
        $customers->save();
        return redirect()->back()->with('success', "Successfully added new customer.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        $customers = Customers::where('accounting_system_id', session('accounting_system_id'))->get();

        return view('customer.customer.index',compact('customers'));
    }
    public function edit($id)
    {
        $customers = Customers::find($id);
        if($customers->accounting_system_id != session('accounting_system_id'))
            return redirect()->route('cutomer.cutomer.index')->with('danger', "You are not authorized to edit this customer.");

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
        $customers->is_active = $request->is_active ? true : false;
        $customers->update();

        return redirect()->back()->with('success', "Successfully edited customer.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try{
        $customers = Customers::find($id);
        $customers->delete();
        }
        catch(\Exception $e){
            return redirect()->back()->with('danger', "You are not authorized to delete this customer.");
        }
        return redirect()->route('customers.customers.index')->with('success', "Successfully deleted customer");

    }
    // Mail
    // public function mailCustomerStatements()
    // {
    //     $accounting_system_id = $this->request->session()->get('accounting_system_id');
    //     $customers = Customers::where('accounting_system_id', $accounting_system_id)
    //     ->whereHas('receiptReference', function($query) {
    //         $query->Where('status', 'unpaid')
    //         ->orWhere('status', 'partially_paid')
    //         ->where('type', 'receipt');
    //     })->get();

    //     if($customers->isEmpty())
    //         return redirect()->back()->with('danger', "No pending statements found.");
    //     foreach($customers as $customer) {
    //         $data = $customer->toArray();
    //         // add receipt reference in data
    //         $receipts = $customer->receiptReference->toArray();
    //         $receipts += $customer->receiptReference->receipt->toArray();

    //         Mail::to($customer->email)->queue(new MailCustomerStatement ($data, $receipts));
    //     }

    //     return redirect()->back()->with('success', "Successfully sent customer statements.");     
    // }

    // Specific customer mail
    public function mailCustomerStatement($id)
    {
        $customer = Customers::where('accounting_system_id', session('accounting_system_id'))
        ->where('id', $id)
        ->whereHas('receiptReference', function($query) {
            $query->where('type', 'receipt')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                  ->orWhere('status', 'partially_paid');
              });})->first();
            
        if(!$customer)
            return redirect()->back()->with('danger', "No pending statements found.");

        $receipt_references = ReceiptReferences::where('customer_id', $id)
        ->where('type', 'receipt')
        ->where(function ($query) {
            $query->where('status', 'unpaid')
              ->orWhere('status', 'partially_paid');
          })->get(); 

        $receipts = [];
        foreach($receipt_references as $receipt) {
            $receipts[] = $receipt->toArray() + $receipt->receipt->toArray();  
        }

        Mail::to($customer->email)->queue(new MailCustomerStatement ($customer, $receipts));

        return redirect()->back()->with('success', "Successfully sent customer statement.");     
    }

    
    // Import Export
    public function import(Request $request)
    {
        if (!$request->file('file'))
        {
            return back()->with('error', 'Please select a file');
        }
        try {
            Excel::import(new ImportCustomersCustomer, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');
        }    
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing customer records.');
        }  
        return redirect()->back()->with('success', 'Successfully imported customer records.');

    }

    public function export(Request $request)
    {
        if($request->file_type=="csv")
        return Excel::download(new ExportCustomersCustomer, 'customersCustomer_'.date('Y_m_d').'.csv');
        else
        $customers = Customers::all();
        $pdf = \PDF::loadView('customer.customer.pdf', compact('customers'));
        return $pdf->download('customersCustomer_'.date('Y_m_d').'.pdf');
    }

    // print
    public function print($id)
    {
        $customer = Customers::where('accounting_system_id', session('accounting_system_id'))
            ->where('id', $id)
            ->whereHas('receiptReference', function($query) {
                $query->where('type', 'receipt')
                ->where(function ($query) {
                    $query->where('status', 'unpaid')
                    ->orWhere('status', 'partially_paid');
                });})->first();

        if(!$customer)
            return redirect()->back()->with('danger', "No pending statements found.");

        $receipt_references = ReceiptReferences::where('customer_id', $id)
            ->where('type', 'receipt')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                ->orWhere('status', 'partially_paid');
            })->get(); 
        
        $total_balance = 0;
        foreach($receipt_references as $receipt_reference) {
            $total_balance += $receipt_reference->receipt->grand_total - $receipt_reference->receipt->total_amount_received;
        }
        $pdf = \PDF::loadView('customer.customer.print', compact('receipt_references', 'total_balance'));
        return $pdf->stream('customer_statement_'.date('Y_m_d').'.pdf');
    }

    /*=================================*/

    public function queryCustomers($query)
    {   
        $customers = Customers::select('id as value', 'name', 'tin_number', 'contact_person','mobile_number')
            ->where('accounting_system_id', session('accounting_system_id'))
            ->where('name', 'LIKE', '%' . $query . '%')->get();
            
        return $customers;
    }

    public function ajaxGetReceiptsToPay(Customers $customer)
    {
        return ReceiptReferences::select(
                'receipt_references.id as value',
                'receipt_references.date',
                'receipts.due_date',
                DB::raw('receipts.grand_total - receipts.total_amount_received as amount_to_pay')    
            )
            ->leftJoin('receipts', 'receipts.receipt_reference_id', '=', 'receipt_references.id')
            ->where('receipt_references.type', '=', 'receipt')
            ->where('receipt_references.customer_id', '=', $customer->id)
            ->where('receipt_references.status', '!=', 'paid')->get();
    }
}

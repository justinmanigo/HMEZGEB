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
        
        $transactions = Customers::join(
            'receipt_references',
            'receipt_references.customer_id',
            '=',
            'customers.id'
        )->join(
            'receipts',
            'receipts.receipt_reference_id',
            '=',
            'receipt_references.id'
        )->select(
            'customers.name',
        //    'customers.tin_number',
        //      'customers.address',
        //     'customers.city',
        //     'customers.country',
        //     'customers.mobile_number',
        //     'customers.telephone_one',
        //     'customers.telephone_two',
        //     'customers.fax',
        //     'customers.website',
        //     'customers.email',
        //     'customers.contact_person',
        //     'customers.image',
        //     'customers.label',
        //     'customers.is_active',
            'receipt_references.reference_number',
            'receipt_references.date',
            'receipt_references.type',
            'receipt_references.status',
            // 'receipt_references.is_void',
            // 'receipt_references.customer_id',
            'receipts.id as receipt_id',
            'receipts.receipt_number',
            'receipts.due_date',
            'receipts.sub_total',
            'receipts.discount',
            'receipts.tax',
            'receipts.grand_total',
            'receipts.withholding',
            'receipts.remark',
            'receipts.attachment',
            'receipts.payment_method',
            'receipts.total_amount_received'
        )->get();

        return view('customer.receipt.index',compact('transactions'));
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
            if($request->attachment) {
                $fileAttachment = time().'.'.$request->attachment->extension();  
                $request->attachment->storeAs('public/receipt-attachment', $fileAttachment);
            }
            
          
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

                    // file upload and save to database
                    
                    'attachment' => isset($fileAttachment) ? $fileAttachment : null,
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
                //  image upload and save to database 
                // if($request->hasFile('attachment'))
                // {
                //     $file = $request->file('attachment');
                //     $filename = $file->getClientOriginalName();
                //     $file->move(public_path('images'), $filename);
                //     $receipt->attachment = $filename;
                //     $receipt->save();
                // }
                
                return redirect()->route('receipts.receipt.index')->with('success', 'Receipt has been added successfully');
            }
    

    }
    public function edit($id)
    {
        $receipts = Receipts::find($id);

        return view('customer.receipt.edit',compact('receipts'));
    }

    public function update(Request $request, $id)
    { 
        $receipts = Receipts::find($id);

        $receipts->receipt_reference_id =  $request->input('receipt_reference_id');
        $receipts->due_date =  $request->input('due_date');
        $receipts->sub_total =  $request->input('sub_total');
        $receipts->discount =  $request->input('discount');
        $receipts->grand_total =  $request->input('grand_total');
        $receipts->remark = $request->input('remark');
        $receipts->discount = $request->input('discount');
        $receipts->withholding = $request->input('withholding');
        $receipts->tax = $request->input('tax');
        $receipts->receipt_number = $request->input('receipt_number');
        $receipts->proforma_id = $request->input('proforma_id');
        $receipts->payment_method = $request->input('payment_method');
        $receipts->total_amount_received = $request->input('total_amount_received');
        $receipts->is_active ='Yes';
        $receipts->update();

        return redirect('receipt/')->with('success', "Successfully edited customer.");

    }
    public function show(Receipts $receipt)
    {   
        $receipt = Receipts::all();
        return view('customer.receipt.index',compact('receipt'));
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
    public function destroy($id)
    {
        
        $receipts = Receipts::find($id);
        $receipts->delete();
        
        
        return redirect('receipt/')->with('danger', "Successfully deleted customer");

    }

}

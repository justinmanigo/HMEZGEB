<?php

namespace App\Http\Controllers;
use App\Models\Proformas;
use App\Models\CreditReceipts;
use App\Models\AdvanceRevenues;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use App\Models\ReceiptItem;
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
        // Views Transactions 
        $receipt = Customers::join(
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
            'receipt_references.id',
            'receipt_references.reference_number',
            'receipt_references.date',
            'receipt_references.type',
            'receipt_references.status',
            'receipts.total_amount_received'
        );

        $advance = Customers::join(
            'receipt_references',
            'receipt_references.customer_id',
            '=',
            'customers.id'
        )->join(
            'advance_revenues',
            'advance_revenues.receipt_reference_id',
            '=',
            'receipt_references.id'
        )->select(
            'customers.name',
            'receipt_references.id',
            'receipt_references.reference_number',
            'receipt_references.date',
            'receipt_references.type',
            'receipt_references.status',
            'advance_revenues.total_amount_received'
        )->union($receipt);

        $transactions = Customers::join(
            'receipt_references',
            'receipt_references.customer_id',
            '=',
            'customers.id'
        )->join(
            'credit_receipts',
            'credit_receipts.receipt_reference_id',
            '=',
            'receipt_references.id'
        )->select(
            'customers.name',
            'receipt_references.id',
            'receipt_references.reference_number',
            'receipt_references.date',
            'receipt_references.type',
            'receipt_references.status',
            'credit_receipts.total_amount_received'
        )->union($advance)->get();
        
        // Views proforma
        $proformas = Customers::join(
            'receipt_references',
            'receipt_references.customer_id',
            '=',
            'customers.id'
        )->join(
            'proformas',
            'proformas.receipt_reference_id',
            '=',
            'receipt_references.id'
        )->select(
            'customers.name',
            'receipt_references.id',
            'receipt_references.reference_number',
            'receipt_references.date',
            'receipt_references.type',
            'proformas.amount'
        )->get();

     
         

        return view('customer.receipt.index',compact('transactions','proformas'));
    }

    /** === STORE RECEIPTS === */

    public function storeReceipt(Request $request)
    {
        // Decode json of item tagify fields.
        for($i = 0; $i < count($request->item); $i++)
        {
            $item = json_decode($request->item[$i]);

            // Resulting json_decode will turn into an array of
            // object, thus it has to be merged.
            $items[$i] = $item[0];
        }

        // Determine receipt status.
        if($request->grand_total == $request->total_amount_received)
            $status = 'paid';
        else if($request->total_amount_received == 0)
            $status = 'unpaid';
        else
            $status = 'partially_paid';

        // Create ReceiptReference Record
        $reference = ReceiptReferences::create([
            'customer_id' => $request->customer_id,
            'reference_number' => $request->reference_number,
            'date' => $request->date,
            'type' => 'receipt',
            'is_void' => 'no',
            'status' => $status
        ]);

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }
        
        // Create child database entry
        if($request->grand_total==$request->total_amount_received)
            $payment_method = 'cash';
        else
            $payment_method = 'credit';
        
        // Create Receipt Record
        $receipt = Receipts::create([
            'receipt_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'discount' => $request->discount,
            'grand_total' => $request->grand_total,
            'remark' => $request->remark,           
            'attachment' => isset($fileAttachment) ? $fileAttachment : null, // file upload and save to database
            'discount' => '0.00', // Temporary discount
            'withholding' => '0.00', // Temporary Withholding
            'tax' => '0.00', // Temporary Tax value
            'receipt_number' => $request->proforma_number, // Temporary reference number
            'proforma_id' => null, // Temporary proforma id
            'payment_method' => $payment_method,
            'total_amount_received' => $request->total_amount_received
        ]);

        // Create Receipt Item Records
        for($i = 0; $i < count($items); $i++)
        {
            ReceiptItem::create([
                'inventory_id' => $items[$i]->value,
                'receipt_reference_id' => $reference->id,
                'quantity' => $request->quantity[$i],
                'price' => $items[$i]->sale_price,
                'total_price' => $request->quantity[$i] * $items[$i]->sale_price,
            ]);
        }

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

    public function storeAdvanceRevenue(Request $request)
    {
        // Create ReceiptReference Record
        $reference = ReceiptReferences::create([
            'customer_id' => $request->customer_id,
            'reference_number' => $request->reference_number,
            'date' => $request->date,
            'type' => 'advance_receipt',
            'status' => 'paid' // Advance Revenue's status is always paid.
        ]);

        // Create child database entry
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'advance-revenues', $fileAttachment);
        }

        $reference->id;
        $advanceRevenue = AdvanceRevenues::create([
            'receipt_reference_id' => $reference->id,
            'advance_revenue_number' => $request->reference_number,
            'total_amount_received' => $request->amount_received,
            'reason' => $request->reason,
            'remark' => $request->remark,
            // image upload
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
        
        return redirect()->route('receipts.receipt.index')->with('success', 'Proforma has been added successfully');
    }

    public function storeCreditReceipt(Request $request)
    {
        // return $request;

        // Update Receipts to Pay
        $c = 0;
        if(isset($request->is_paid))
        {
            for($i = 0; $i < count($request->receipt_reference_id); $i++)
            {
                // If to pay wasn't checked for certain id, skip.
                if(!in_array($request->receipt_reference_id[$i], $request->is_paid))
                    continue;
    
                // Get receipt
                $receipt = Receipts::leftJoin('receipt_references', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
                    ->where('receipts.receipt_reference_id', '=', $request->receipt_reference_id[$i])->first();
    
                // return $receipt;

                // If amount paid wasn't even set, skip.
                if($request->amount_paid[$i] <= 0) continue;
    
                $receipt->total_amount_received += $request->amount_paid[$i];
                if($receipt->total_amount_received >= $receipt->grand_total)
                {
                    ReceiptReferences::where('id', '=', $request->receipt_reference_id[$i])
                        ->update(['status' => 'paid']);
                }
                else if($receipt->status == 'unpaid' && $receipt->total_amount_received > 0)
                {
                    ReceiptReferences::where('id', '=', $request->receipt_reference_id[$i])
                        ->update(['status' => 'partially_paid']);
                }
                else if($receipt->status == 'paid')
                {
                    continue;
                }
    
                $receipt->save();
                $c++;
            }
        }

        if($c > 0) {
            // Create ReceiptReference Record
            $reference = ReceiptReferences::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'type' => 'credit_receipt',
                'is_void' => 'no',
                'status' => 'paid', // Credit Receipt's status is always paid.
            ]);
    
            // Create child database entry
            if($request->attachment) {
                $fileAttachment = time().'.'.$request->attachment->extension();  
                $request->attachment->storeAs('public/receipt-attachment/credit-receipts', $fileAttachment);
            }
    
            $creditReceipts = CreditReceipts::create([
                'receipt_reference_id' => $reference->id,
                'credit_receipt_number' => $request->credit_receipt_number,
                'total_amount_received' => floatval($request->total_received),
                'description' => $request->description,
                'remark' => $request->remark,
                // image upload
                'attachment' => isset($fileAttachment) ? $fileAttachment : null,
            ]);
            
            $messageContent = 'Credit Receipt has been added successfully.';
        }
        else {
            $messageContent = 'There are no receipts to pay.';
        }
        
        return redirect()->route('receipts.receipt.index')->with('success', $messageContent);

    }

    public function storeProforma(Request $request)
    {
        // if($request->grand_total==$request->total_amount_received)
        // {
        //     $status = 'paid';
        // }
        // if($request->grand_total>$request->total_amount_received)
        // {
        //     $status = 'partially_paid';
        // }
        // else
        // {
            // Temporary status
            $status = 'unpaid';
        // }

            // Receipt References
            $reference = ReceiptReferences::create([
                'customer_id' => $request->customer_id,
                // Temporary Proforma
                'reference_number' => $request->proforma_number,
                'date' => $request->date,
                'type' => 'proforma',
                'is_void' => 'no',
                'status' => $status
            ]);

            // Create child database entry
            if($reference)        
            {
                if($request->attachment) {
                    $fileAttachment = time().'.'.$request->attachment->extension();  
                    $request->attachment->storeAs('public/receipt-attachment', $fileAttachment);
                }

                $reference->id;
                $proformas = Proformas::create([
                    'receipt_reference_id' => $reference->id,
                    'proforma_number' => $request->proforma_number,
                    'due_date' => $request->due_date,
                    'amount' => $request->grand_total,
                    'terms_and_conditions' => $request->terms_and_conditions,
                    // image upload
                    'attachment' => isset($fileAttachment) ? $fileAttachment : null,
                ]);
                return redirect()->route('receipts.receipt.index')->with('success', 'Proforma has been added successfully');
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

    public function destroy($id)
    {
        $receipt = ReceiptReferences::find($id);

        // If receipt
        if($receipt->type == 'receipt')
        {
            // Get receipt id
            $r = $receipt->receipt()->first();

            // Delete receipt items
            ReceiptItem::where('receipt_id', '=', $r->id);

            // Delete receipt
            $r->delete();
        }
        else if($receipt->type == 'advance_receipt')
        {
            // TODO: Other deletions later
            $receipt->advanceRevenue()->delete();
        }
        else if($receipt->type == 'credit_receipt')
        {
            // TODO: Other deletions later
            $receipt->creditReceipt()->delete();
        }
        else if($receipt->type == 'proforma')
        {
            // TODO: Other deletions later
            // // Get receipt id
            // $p = $receipt->proforma()->first();

            // // Delete receipt items
            // ReceiptItem::where('receipt_id', '=', $p->id);

            // // Delete receipt
            // $r->delete();

            // $receipt->proforma()->receiptItems()->delete();
            $receipt->proforma()->delete();
        }
        $receipt->delete();
  
        return redirect('receipt/')->with('danger', "Successfully deleted customer");
    }
}

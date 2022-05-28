<?php

namespace App\Http\Controllers;

use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\UpdateReceiptStatus;
use App\Actions\Customer\Receipt\DeterminePaymentMethod;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Models\Proformas;
use App\Models\CreditReceipts;
use App\Models\AdvanceRevenues;
use App\Models\ReceiptReferences;
use App\Models\Receipts;
use App\Models\ReceiptItem;
use App\Models\Customers;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\Receipt\StoreReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreAdvanceRevenueRequest;
use App\Http\Requests\Customer\Receipt\StoreCreditReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreProformaRequest;

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
            'receipt_references.date',
            'receipt_references.type',
            'proformas.amount'
        )->get();

     
         

        return view('customer.receipt.index',compact('transactions','proformas'));
    }

    /** === STORE RECEIPTS === */

    public function storeReceipt(StoreReceiptRequest $request)
    {
        // If this transaction is linked to Proforma
        if(isset($request->proforma)) UpdateReceiptStatus::run($request->proforma->value, 'paid');

        // Determine Receipt Status
        $status = DetermineReceiptStatus::run($request->grand_total, $request->total_amount_received);

        // Create Receipt Reference
        $reference = CreateReceiptReference::run($request->customer->value, $request->date, 'receipt', $status);

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }

        // Store Receipt Items
        StoreReceiptItems::run($request->item, $request->quantity, $reference->id);
        UpdateInventoryItemQuantity::run($request->item, $request->quantity, 'decrease');

        //  image upload and save to database 
        // if($request->hasFile('attachment'))
        // {
        //     $file = $request->file('attachment');
        //     $filename = $file->getClientOriginalName();
        //     $file->move(public_path('images'), $filename);
        //     $receipt->attachment = $filename;
        //     $receipt->save();
        // }

        // TODO: Refactor Attachment Upload
        
        return Receipts::create([
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
            'proforma_id' => isset($request->proforma) ? $request->proforma->value : null, // Test
            'payment_method' => DeterminePaymentMethod::run($request->grand_total, $request->total_amount_received),
            'total_amount_received' => $request->total_amount_received
        ]);;
    }

    public function storeAdvanceRevenue(StoreAdvanceRevenueRequest $request)
    {
        $reference = CreateReceiptReference::run($request->customer_id, $request->date, 'advance_receipt', 'paid');

        // Create child database entry
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'advance-revenues', $fileAttachment);
        }

        return AdvanceRevenues::create([
            'receipt_reference_id' => $reference->id,
            'total_amount_received' => $request->amount_received,
            'reason' => $request->reason,
            'remark' => $request->remark,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    public function storeCreditReceipt(StoreCreditReceiptRequest $request)
    {
        for($i = 0; $i < count($request->is_paid); $i++)
        {
            if(!in_array($request->receipt_reference_id[$i], $request->is_paid) || $request->amount_paid[$i] <= 0) continue;

            $receipt = Receipts::where('receipt_reference_id', $request->receipt_reference_id[$i])->first();
            $receipt->total_amount_received += $request->amount_paid[$i];
            $receipt->save();

            if($receipt->total_amount_received >= $receipt->grand_total) {
                UpdateReceiptStatus::run($request->receipt_reference_id[$i], 'paid');
            }
            else if($receipt->status == 'unpaid' && $receipt->total_amount_received > 0) {
                UpdateReceiptStatus::run($request->receipt_reference_id[$i], 'partially_paid');
            }
        }

        $reference = CreateReceiptReference::run($request->customer_id, $request->date, 'credit_receipt', 'paid');

        return CreditReceipts::create([
            'receipt_reference_id' => $reference->id,
            'total_amount_received' => floatval($request->total_received),
            'description' => $request->description,
            'remark' => $request->remark,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);;

    }

    public function storeProforma(StoreProformaRequest $request)
    {        
        $reference = CreateReceiptReference::run($request->customer->value, $request->date, 'proforma', 'unpaid');

        // if($reference)        
        // {
        //     if($request->attachment) {
        //         $fileAttachment = time().'.'.$request->attachment->extension();  
        //         $request->attachment->storeAs('public/receipt-attachment', $fileAttachment);
        //     }
        // }

        StoreReceiptItems::run($request->item, $request->quantity, $reference->id);
        
        return Proformas::create([
            'receipt_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'amount' => $request->grand_total,
            'terms_and_conditions' => $request->terms_and_conditions,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);

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

    /*********** AJAX *************/

    public function ajaxSearchCustomerProforma(Customers $customer, $value)
    {
        $proformas = ReceiptReferences::select(
                'receipt_references.id as value',
                'receipt_references.date',
                'proformas.amount',
                'proformas.due_date',
            )
            ->leftJoin('proformas', 'proformas.receipt_reference_id', '=', 'receipt_references.id')
            ->where('customer_id', $customer->id)
            ->where('type', 'proforma')
            ->where('status', 'unpaid')
            ->get();

        return $proformas;
    }

    public function ajaxGetProforma(ReceiptReferences $proforma)
    {
        // Load relationships.
        $proforma->proforma;
        $proforma->receiptItems;
        for($i = 0; $i < count($proforma->receiptItems); $i++)
            $proforma->receiptItems[$i]->inventory;

        // Return response
        return $proforma;
    }
}

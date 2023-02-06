<?php

namespace App\Http\Controllers\Customers\Receipts;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Receipt\StoreProformaRequest;
use App\Mail\Customers\MailCustomerProforma;
use App\Models\Customers;
use App\Models\Proformas;
use App\Models\ReceiptCashTransactions;
use App\Models\ReceiptItem;
use App\Models\ReceiptReferences;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProformaController extends Controller
{
    public function store(StoreProformaRequest $request)
    {
        $accounting_system_id = session('accounting_system_id');
        $reference = CreateReceiptReference::run($request->customer->value, $request->date, 'proforma', 'unpaid', $accounting_system_id);

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
            'reference_number' => $request->reference_number,
            'due_date' => $request->due_date,
            'amount' => $request->grand_total,
            'tax' => $request->tax_total,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->grand_total,
            'terms_and_conditions' => $request->terms_and_conditions,
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    public function show(Proformas $proforma)
    {
        return view('customer.receipt.proforma.edit',compact('proforma'));
    }

    public function void(Proformas $proforma)
    {
        if($proforma->receiptReference->is_deposited == "yes")
        return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        $proforma->receiptReference->is_void = "yes";
        $proforma->receiptReference->save();

        return redirect()->back()->with('success', "Successfully voided proforma.");
    }

    public function reactivate(Proformas $proforma)
    {
        $proforma->receiptReference->is_void = "no";
        $proforma->receiptReference->save();

        return redirect()->back()->with('success', "Successfully reactivated proforma.");
    }

    public function mail(Proformas $proforma)
    {
        $proforma_items = ReceiptItem::where('receipt_reference_id' , $proforma->receipt_reference_id)->get();
        $emailAddress = $proforma->receiptReference->customer->email;
         
        Mail::to($emailAddress)->queue(new MailCustomerProforma($proforma_items , $proforma));
        
        return redirect()->back()->with('success', "Successfully sent email to customer.");
    }

    public function print(Proformas $proforma)
    {
        $proforma_items = ReceiptItem::where('receipt_reference_id' , $proforma->receipt_reference_id)->get();

        $pdf = PDF::loadView('customer.receipt.proforma.print', compact('proforma_items','proforma'));

        return $pdf->stream('proforma_'.$proforma->id.'_'.date('Y-m-d').'.pdf');
    }

    /************************ AJAX ************************/

    public function ajaxSearchCustomer(Customers $customer, $value)
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

    public function ajaxGet(ReceiptReferences $proforma)
    {
        // Load relationships.
        $proforma->proforma;
        $proforma->receiptItems;
        for($i = 0; $i < count($proforma->receiptItems); $i++){
            $proforma->receiptItems[$i]->inventory;
            $proforma->receiptItems[$i]->inventory->tax;
        }

        // Return response
        return $proforma;
    }

}
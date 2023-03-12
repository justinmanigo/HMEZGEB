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
use App\Models\Receipts;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProformaController extends Controller
{
    public function searchAjax($query = null)
    {
        $proformas = ReceiptReferences::select(
            'receipt_references.id',
            'receipt_references.date',
            'customers.name as customer_name',
            'proformas.grand_total',
            'proformas.due_date',
        )
        ->leftJoin('proformas', 'proformas.receipt_reference_id', 'receipt_references.id')
        ->leftJoin('customers', 'customers.id', 'receipt_references.customer_id')
        // left join sub to get sum of receipt_cash_transactions
        // this will determine the status of the receipt (paid, partially_paid, unpaid)
        ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
        ->where(function($q) use ($query){
            $q->where('receipt_references.id', 'like', "%{$query}%")
            ->orWhere('customers.name', 'like', "%{$query}%")
            ->orWhere('receipt_references.date', 'like', "%{$query}%")
            ->orWhere('receipt_references.status', 'like', "%{$query}%");
        })
        ->where('receipt_references.type', 'proforma');


        return response()->json([
            'proformas' => $proformas->paginate(10),
        ]);

    }

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
        // If the proforma is already linked to a receipt, return an error since it can no longer be voided.
        if(Receipts::where('proforma_id', $proforma->receiptReference->id)->count()) {
            return redirect()->back()->with('danger', "Can't void this proforma since it is already linked to a receipt.");
        }

        $proforma->receiptReference->is_void = true;
        $proforma->receiptReference->save();

        return redirect()->back()->with('success', "Successfully marked proforma as void.");
    }

    public function reactivate(Proformas $proforma)
    {
        $proforma->receiptReference->is_void = false;
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
            ->where('receipt_references.customer_id', $customer->id)
            ->where('receipt_references.type', 'proforma')
            ->where('receipt_references.status', 'unpaid')
            ->where('receipt_references.is_void', false)
            ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
            ->where('proformas.due_date', '>=', date('Y-m-d'))
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

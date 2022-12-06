<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Actions\Vendor\Bill\StoreBillItems;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendors\Bills\StorePurchaseOrderRequest;
use App\Mail\Vendors\MailVendorPurchaseOrder;
use App\Models\PaymentReferences;
use App\Models\PurchaseOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;


class PurchaseOrderController extends Controller
{

    /** MAIN FUNCTIONS */

    /**
     * Stores a new entry.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        // Create Payment Reference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'purchase_order',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => 'unpaid',
        ]);

        // Create Purchase Order Record
        //  if($request->attachment) {
        //      $fileAttachment = time().'.'.$request->attachment->extension();
        //      $request->attachment->storeAs('public/bill-attachment', $fileAttachment);
        //  }

        StoreBillitems::run($request->item, $request->quantity, $reference->id);

        return PurchaseOrders::create([
            'payment_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            // image upload
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    /**
     * Shows a specific entry.
     */
    public function show($id)
    {
        $purchaseOrders = PurchaseOrders::find($id);
        return view('vendors.bills.purchase_order.show', compact('purchaseOrders'));
    }

    /**
     * Marks an entry as void.
     */
    public function void($id)
    {
        $purchaseOrder = PurchaseOrders::find($id);
        // if($purchaseOrder->paymentReference->is_deposited == "yes")
        // return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");
        $purchaseOrder->paymentReference->is_void = "yes";
        $purchaseOrder->paymentReference->save();

        return redirect()->back()->with('success', "Successfully voided purchase order.");
    }

    /**
     * Reverses a voided entry.
     */
    public function revalidate($id)
    {
        $purchase_order = PurchaseOrders::find($id);
        $purchase_order->paymentReference->is_void = "no";
        $purchase_order->paymentReference->save();

        return redirect()->back()->with('success', "Successfully revalidated purchase order.");
    }

    /**
     * Sends an email of the entry.
     */
    public function mail($id)
    {
        $purchaseOrder = PurchaseOrders::find($id);
        $emailAddress = $purchaseOrder->paymentReference->vendor->email;

        Mail::to($emailAddress)->queue(new MailVendorPurchaseOrder ($purchaseOrder));

        return redirect()->route('bills.bills.index')->with('success', 'Email has been sent!');
    }

    /**
     * Prints the entry.
     */
    public function print($id)
    {
        $purchase_order = PurchaseOrders::find($id);

        $pdf = PDF::loadView('vendors.bills.purchase_order.print', compact('purchase_order'));
        return $pdf->stream('purchase_order_'.date('Y-m-d').'.pdf');
    }

    /** AJAX CALLS */

    /**
     * Returns JSON of the purchase order.
     */
    public function ajaxGet(PaymentReferences $purchaseOrder)
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

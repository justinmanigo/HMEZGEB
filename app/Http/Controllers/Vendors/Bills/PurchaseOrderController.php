<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\Bills\StorePurchaseOrderRequest;
use App\Models\PaymentReferences;
use App\Models\PurchaseOrders;
use App\Actions\Vendor\Bill\StoreBillItems;

class PurchaseOrderController extends Controller
{
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
}

<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentReferences;
use App\Models\PensionPayments;



class PensionPaymentController extends Controller
{

    /**
     * TODO: to implement
     * * Custom Request Class
     * * Custom Validation
     * * Store Process
     * * Integration with COA
     *
     * Stores a new entry.
     */
    public function store(Request $request)
    {
        $status = 'paid';

        // Store payment reference
        $reference = PaymentReferences::create([
            'accounting_system_id' => $this->request->session()->get('accounting_system_id'),
            'vendor_id' => $request->vendor_id,
            'date' => $request->date,
            'type' => 'pension_payment',
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
            'remark' => $request->remark,
            'status' => $status
        ]);

        // store pension payment
        $pensionPayment = PensionPayments::create([
            'payment_reference_id' => $reference->id,
            'accounting_period_id' => $request->accounting_period_id,
            'chart_of_account_id' => $request->chart_of_account_id,
            'cheque_number' => $request->cheque_number,
            'amount_received' => $request->amount_received,
        ]);

        return redirect()->back()->with('success', 'Pension Payment has been added successfully.');
    }
}

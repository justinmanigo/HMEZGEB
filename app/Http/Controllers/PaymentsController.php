<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentReferences;
use App\Models\AccountingPeriods;
use App\Models\ChartOfAccounts;
use App\Models\IncomeTaxPayments;
use App\Models\PensionPayments;
use App\Models\BillPayments;
use App\Models\Bills;
use App\Models\WithholdingPayments;




class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendors.payments.payment');
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
        //
    }

    public function storeBillPayment(Request $request)
    {
        // Update Bills to Pay
        $b = 0;
        if(isset($request->is_paid))
        {
            
            for($i = 0; $i < count($request->payment_reference_id); $i++)
            {
                // If to pay wasn't checked for certain id, skip.
                if(!in_array($request->payment_reference_id[$i], $request->is_paid))
                    continue;

                // Get bill
                $bill = Bills::leftJoin('payment_references', 'payment_references.id', '=', 'bills.payment_reference_id')
                    ->where('bills.payment_reference_id', '=', $request->payment_reference_id[$i])->first();
                
                // If amount paid wasn't even set, skip.
                if($request->amount_paid[$i] <= 0) continue;
                
                $bill->amount_received += $request->amount_paid[$i];
                if($bill->amount_received >= $bill->grand_total)
                {
                    PaymentReferences::where('id', '=', $request->payment_reference_id[$i])
                        ->update(['status' => 'paid']);
                }
                else if($bill->status == 'unpaid' && $bill->amount_received > 0)
                {
                    PaymentReferences::where('id', '=', $request->payment_reference_id[$i])
                        ->update(['status' => 'partially_paid']);
                }
                else if($bill->status == 'paid')
                {
                    continue;
                }

                Bills::where('payment_reference_id', $request->payment_reference_id[$i])
                    ->update([
                        'amount_received' => $bill->amount_received
                    ]);

                $b++;
            }
        }

        if($b > 0) {
            // Create PaymentReference Record
            $reference = PaymentReferences::create([
                'vendor_id' => $request->vendor_id,
                'date' => $request->date,
                'type' => 'bill_payment',
                'is_void' => 'no',
                'status' => 'paid', // Bill Payment status is always paid.
            ]);
    
            // Create child database entry
            // if($request->attachment) {
            //     $fileAttachment = time().'.'.$request->attachment->extension();  
            //     $request->attachment->storeAs('public/bill-attachment/credit-bills', $fileAttachment);
            // }

            $billPayment = BillPayments::create([
                'payment_reference_id' => $reference->id,
                'chart_of_account_id' => $request->chart_of_account_id,
                'cheque_number' => $request->cheque_number,
                'amount_paid' => floatval($request->total_received),
                'discount_account_number' => $request->discount_account_number,        
            ]);

            $messageType = 'success';
            $messageContent = 'Bill Payment has been added successfully.';
        }
        else {
            $messageType = 'warning';
            $messageContent = 'There are no bills to pay.';
        }
  
        return redirect()->back()->with($messageType, $messageContent);

    }
    public function storeIncomeTaxPayment(Request $request)
    {
        $status = 'paid';

        // Store payment reference
        $reference = PaymentReferences::create([
            'vendor_id' => $request->vendor_id,
            'date' => $request->date,
            'type' => 'income_tax_payment',
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
            'remark' => $request->remark,
            'status' => $status
        ]);
        
        // store income tax payment
        $incomeTaxPayment = IncomeTaxPayments::create([
            'payment_reference_id' => $reference->id,
            'accounting_period_id' => $request->accounting_period_id,
            'chart_of_account_id' => $request->chart_of_account_id,
            'cheque_number' => $request->cheque_number,
            'amount_received' => $request->amount_received,
        ]);
        
        return redirect()->back()->with('success', 'Income Tax Payment has been added successfully.');
    }

    // Store pension
    public function storePensionPayment(Request $request)
    {
        $status = 'paid';

        // Store payment reference
        $reference = PaymentReferences::create([
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
    // Store withholding
    public function storeWithholdingPayment(Request $request)
    {
        // return $request;

        // Update Withholding to Pay
        $w = 0;
        if(isset($request->is_paid))
        {
            
            for($i = 0; $i < count($request->payment_reference_id); $i++)
            {
                
                // If to pay wasn't checked for certain id, skip.
                if(!in_array($request->payment_reference_id[$i], $request->is_paid))
                    continue;

                // Get bill
                $bill = Bills::leftJoin('payment_references', 'payment_references.id', '=', 'bills.payment_reference_id')
                    ->where('bills.payment_reference_id', '=', $request->payment_reference_id[$i])->first();
    
                // return $bill;
                
                // If amount paid wasn't even set, skip.
                if($request->amount_paid[$i] <= 0) continue;
                
                $bill->withholding -= $request->amount_paid[$i];
                if($bill->withholding < 0)
                {
                    $bill->withholding = 0;
                }
                
                if($bill->withholding <= 0)
                {
                    $withholding_status = 'paid';
                }
                else if($bill->status == 'unpaid' && $bill->amount_received > 0)
                {
                    $withholding_status = 'partially_paid';
                }
                else if($bill->status == 'paid')
                {
                    continue;
                }
    
                Bills::where('payment_reference_id', $request->payment_reference_id[$i])
                    ->update([
                        'withholding' => $bill->withholding,
                        'withholding_status' => $withholding_status,
                    ]);
                $w++;
            }
        }

        if($w > 0) {
            // Create PaymentReference Record
            $reference = PaymentReferences::create([
                'vendor_id' => $request->vendor_id,
                'date' => $request->date,
                'type' => 'withholding_payment',
                'is_void' => 'no',
                'status' => 'paid', // Withholding Payment status is always paid.
            ]);
    
            // Create child database entry
            if($request->attachment) {
                $fileAttachment = time().'.'.$request->attachment->extension();  
                $request->attachment->storeAs('public/bill-attachment/credit-bills', $fileAttachment);
            }
            
            $withholdingPayment = WithholdingPayments::create([
                'payment_reference_id' => $reference->id,
                'accounting_period_id' => $request->accounting_period_id,
                'chart_of_account_id' => $request->chart_of_account_id,
                'amount_paid' => floatval($request->total_amount_received),       
            ]);

            $messageType = 'success';
            $messageContent = 'Withholding Payment has been added successfully.';
        }
        else {
            $messageType = 'warning';
            $messageContent = 'There are no withholdings to pay.';
        }
  
        return redirect()->back()->with($messageType, $messageContent);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payments)
    {
        //
    }
}

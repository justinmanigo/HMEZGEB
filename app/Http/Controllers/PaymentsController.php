<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

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
        // return $request;

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
    
                // return $bill;

                // If amount paid wasn't even set, skip.
                if($request->amount_paid[$i] <= 0) continue;
    
                $bill->total_amount_received += $request->amount_paid[$i];
                if($bill->total_amount_received >= $bill->grand_total)
                {
                    PaymentReferences::where('id', '=', $request->payment_reference_id[$i])
                        ->update(['status' => 'paid']);
                }
                else if($bill->status == 'unpaid' && $bill->total_amount_received > 0)
                {
                    PaymentReferences::where('id', '=', $request->payment_reference_id[$i])
                        ->update(['status' => 'partially_paid']);
                }
                else if($bill->status == 'paid')
                {
                    continue;
                }
    
                $bill->save();
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
                'status' => 'paid', // Credit Receipt's status is always paid.
            ]);
    
            // Create child database entry
            if($request->attachment) {
                $fileAttachment = time().'.'.$request->attachment->extension();  
                $request->attachment->storeAs('public/bill-attachment/credit-bills', $fileAttachment);
            }
    
            $billPayment = BillPayments::create([
                'payment_reference_id' => $reference->id,
                'bill_payment_number' => $request->bill_payment_number,
                'total_amount_received' => floatval($request->total_received),
                'description' => $request->description,
                'remark' => $request->remark,
                // image upload
                'attachment' => isset($fileAttachment) ? $fileAttachment : null,
            ]);
            
            $messageType = 'success';
            $messageContent = 'Credit Receipt has been added successfully.';
        }
        else {
            $messageType = 'warning';
            $messageContent = 'There are no bills to pay.';
        }
        
        return redirect()->route('bills.bill.index')->with($messageType, $messageContent);

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

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
use App\Mail\Vendors\MailVendorPayment;
use Illuminate\Support\Facades\Mail;



class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billPayments = PaymentReferences::select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.date',
                'payment_references.status',
                // 'payment_references.is_void', // TODO: to implement
                'bill_payments.amount_paid',
            )
            ->leftJoin('vendors', 'payment_references.vendor_id', '=', 'vendors.id')
            ->leftJoin('bill_payments', 'payment_references.id', '=', 'bill_payments.payment_reference_id')
            ->where('type', 'bill_payment')
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->get();

        // return $billPayments;

        $otherPayments = PaymentReferences::select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                // 'payment_references.is_void', // TODO: to implement
                'vat_payments.current_receivable as vat_amount',
                'pension_payments.amount_received as pension_amount',
                'income_tax_payments.total_paid as income_tax_amount',
                'withholding_payments.amount_paid as withholding_amount',
                'payroll_payments.total_paid as payroll_amount',
                'accounting_periods.period_number',
                'accounting_periods.date_from',
                'accounting_periods.date_to',
                // TODO: implement commission
            )
            ->leftJoin('vendors', 'payment_references.vendor_id', '=', 'vendors.id')
            ->leftJoin('vat_payments', 'payment_references.id', '=', 'vat_payments.payment_reference_id')
            ->leftJoin('pension_payments', 'payment_references.id', '=', 'pension_payments.payment_reference_id')
            ->leftJoin('income_tax_payments', 'payment_references.id', '=', 'income_tax_payments.payment_reference_id')
            ->leftJoin('withholding_payments', 'payment_references.id', '=', 'withholding_payments.payment_reference_id')
            ->leftJoin('payroll_payments', 'payment_references.id', '=', 'payroll_payments.payment_reference_id')
            ->leftJoin('payroll_periods', 'payroll_payments.payroll_period_id', '=', 'payroll_periods.id')
            ->leftJoin('accounting_periods', 'payroll_periods.period_id', '=', 'accounting_periods.id')
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->where('payment_references.type', '!=', 'bill_payment')
            ->where('payment_references.type', '!=', 'bill')
            ->where('payment_references.type', '!=', 'purchase_order')
            ->get();

        // return $otherPayments;

        return view('vendors.payments.payment', [
            'billPayments' => $billPayments,
            'otherPayments' => $otherPayments,
        ]);
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

    public function storeIncomeTaxPayment(Request $request)
    {
        $status = 'paid';

        // Store payment reference
        $reference = PaymentReferences::create([
            'accounting_system_id' => $this->request->session()->get('accounting_system_id'),
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
                'accounting_system_id' => session('accounting_system_id'),
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
}

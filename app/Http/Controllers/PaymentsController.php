<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentReferences;

class PaymentsController extends Controller
{
    public function searchOtherPaymentsAjax($query = null)
    {
        $otherPayments = PaymentReferences::select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                // 'payment_references.is_void', // TODO: to implement

                // Vat Payments
                'vat_payments.current_receivable as vat_amount',

                // Pension Payments
                'pension_payments.amount_received as pension_amount',

                // Withholding Payments
                'withholding_payments.total_paid as withholding_amount',
                'wp_accounting_periods.period_number as wp_period_number',
                'wp_accounting_periods.date_from as wp_date_from',
                'wp_accounting_periods.date_to as wp_date_to',

                // Payroll Payments
                'payroll_payments.total_paid as payroll_amount',
                'pp_accounting_periods.period_number as pp_period_number',
                'pp_accounting_periods.date_from as pp_date_from',
                'pp_accounting_periods.date_to as pp_date_to',

                // Income Tax Payments
                'income_tax_payments.total_paid as income_tax_amount',
                'itp_accounting_periods.period_number as itp_period_number',
                'itp_accounting_periods.date_from as itp_date_from',
                'itp_accounting_periods.date_to as itp_date_to',

                // TODO: implement commission
            )
            ->leftJoin('vendors', 'payment_references.vendor_id', '=', 'vendors.id')

            // VAT Payments
            ->leftJoin('vat_payments', 'payment_references.id', '=', 'vat_payments.payment_reference_id')

            // Pension Payments
            ->leftJoin('pension_payments', 'payment_references.id', '=', 'pension_payments.payment_reference_id')

            // Withholding Payments
            ->leftJoin('withholding_payments', 'payment_references.id', '=', 'withholding_payments.payment_reference_id')
            ->leftJoin('accounting_periods as wp_accounting_periods', 'withholding_payments.accounting_period_id', '=', 'wp_accounting_periods.id')

            // Payroll Payments
            ->leftJoin('payroll_payments', 'payment_references.id', '=', 'payroll_payments.payment_reference_id')
            ->leftJoin('payroll_periods as pp_payroll_periods', 'payroll_payments.payroll_period_id', '=', 'pp_payroll_periods.id')
            ->leftJoin('accounting_periods as pp_accounting_periods', 'pp_payroll_periods.period_id', '=', 'pp_accounting_periods.id')

            // Income Tax Payments
            ->leftJoin('income_tax_payments', 'payment_references.id', '=', 'income_tax_payments.payment_reference_id')
            ->leftJoin('payroll_periods as itp_payroll_periods', 'income_tax_payments.payroll_period_id', '=', 'itp_payroll_periods.id')
            ->leftJoin('accounting_periods as itp_accounting_periods', 'itp_payroll_periods.period_id', '=', 'itp_accounting_periods.id')


            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->where('payment_references.type', '!=', 'bill_payment')
            ->where('payment_references.type', '!=', 'bill')
            ->where('payment_references.type', '!=', 'purchase_order')
            ->where('payment_references.type', '!=', 'cogs')
            ->where('payment_references.type', '!=', 'expense')
            ->where(function($q) use ($query) {
                $q->where('vendors.name', 'like', "%{$query}%")
                    ->orWhere('payment_references.id', 'like', "%{$query}%")
                    ->orWhere('payment_references.type', 'like', "%{$query}%")
                    ->orWhere('payment_references.date', 'like', "%{$query}%")
                    ->orWhere('payment_references.status', 'like', "%{$query}%");
            });

        return response()->json([
            'other_payments' => $otherPayments->paginate(10),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendors.payments.payment');
    }
}

<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeTaxPaymentController extends Controller
{
    public function ajaxGetUnpaid()
    {
        $journal_postings = DB::table('journal_postings')
            ->select('journal_postings.*')
            ->leftJoin('journal_entries', 'journal_entries.id', 'journal_postings.journal_entry_id')
            ->leftJoin('chart_of_accounts', 'chart_of_accounts.id', 'journal_postings.chart_of_account_id')
            ->where('chart_of_accounts.chart_of_account_no', '2102')
            ->where('journal_postings.type', 'credit');

        $payroll_periods = DB::table('payroll_periods')
            ->select(
                'payroll_periods.id as value',
                DB::raw('CONCAT("#", accounting_periods.period_number, ": ", DATE_FORMAT(accounting_periods.date_from, "%Y-%m-%d"), " - ", DATE_FORMAT(accounting_periods.date_to, "%Y-%m-%d")) as label'),
                'accounting_periods.period_number',
                'accounting_periods.date_from',
                'accounting_periods.date_to',
                'journal_postings.amount as balance'
            )
            ->leftJoin('accounting_periods', 'accounting_periods.id', 'payroll_periods.period_id')
            ->leftJoin('journal_entries', 'journal_entries.id', 'payroll_periods.journal_entry_id')
            ->leftJoinSub($journal_postings, 'journal_postings', function ($join) {
                $join->on('journal_postings.journal_entry_id', 'journal_entries.id');
            })
            ->leftJoin('income_tax_payments', 'income_tax_payments.payroll_period_id', 'payroll_periods.id')
            ->where('payroll_periods.accounting_system_id', session('accounting_system_id'))
            ->whereNull('income_tax_payments.id')
            ->get();

        return response()->json($payroll_periods);
    }
}

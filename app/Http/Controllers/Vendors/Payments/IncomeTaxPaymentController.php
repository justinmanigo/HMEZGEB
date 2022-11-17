<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Vendors\Payments\StoreIncomeTaxPaymentRequest;
use App\Models\PaymentReferences;
use App\Models\PayrollPayments;
use App\Models\PayrollPeriod;
use App\Models\IncomeTaxPayments;

class IncomeTaxPaymentController extends Controller
{
    public function store(StoreIncomeTaxPaymentRequest $request)
    {
        // return $request;

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Store Payment Reference
        $reference = new PaymentReferences();
        $reference->accounting_system_id = session('accounting_system_id');
        $reference->type = 'income_tax_payment';
        $reference->status = 'paid';
        $reference->date = $request->date;
        $reference->remark = $request->remark;
        $reference->journal_entry_id = $je->id;
        // $reference->attachment = isset($fileAttachment) ? $fileAttachment : null;
        $reference->save();

        // Store Income Tax Payment
        $payment = new IncomeTaxPayments();
        $payment->payment_reference_id = $reference->id;
        $payment->payroll_period_id = $request->payroll_period->value;
        $payment->cheque_number = $request->cheque_number;
        $payment->total_paid = $request->payroll_period->balance;
        $payment->save();

        // Debit 2102 - Income Tax Payable
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->income_tax_payable->id);
        $debit_amount[] = $request->payroll_period->balance;

        // Credit Selected Cash Account
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
        $credit_amount[] = $request->payroll_period->balance;

        // Create Journal Postings
        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        return [
            'success' => true,
            'message' => 'Income Tax Payment has been successfully recorded.',
        ];
    }

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

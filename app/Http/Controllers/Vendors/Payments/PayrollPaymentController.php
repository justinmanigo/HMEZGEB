<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendors\Payments\StorePayrollPaymentRequest;
use App\Models\PaymentReferences;
use App\Models\PayrollPayments;
use Illuminate\Http\Request;

class PayrollPaymentController extends Controller
{
    public function store(StorePayrollPaymentRequest $request)
    {
        // return $request;

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Store Payment Reference
        $reference = new PaymentReferences();
        $reference->accounting_system_id = session('accounting_system_id');
        $reference->type = 'payroll_payment';
        $reference->status = 'paid';
        $reference->date = $request->date;
        $reference->remark = $request->remark;
        $reference->journal_entry_id = $je->id;
        // $reference->attachment = isset($fileAttachment) ? $fileAttachment : null;
        $reference->save();

        // Store Payroll Payment
        $payment = new PayrollPayments();
        $payment->payment_reference_id = $reference->id;
        $payment->payroll_period_id = $request->payroll_period->value;
        $payment->cheque_number = $request->cheque_number;
        $payment->total_paid = $request->payroll_period->balance;
        $payment->save();

        // Debit 2101 - Salary Payable
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->salary_payable->id);
        $debit_amount[] = $request->payroll_period->balance;

        // Credit Selected Cash Account
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
        $credit_amount[] = $request->payroll_period->balance;

        // Create Journal Postings
        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        return redirect('/vendors/payments')
            ->with('success', 'Payroll Payment has been made successfully.');
    }
}

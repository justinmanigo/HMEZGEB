<?php

namespace App\Http\Controllers\Vendors\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\Payments\StoreWithholdingPaymentRequest;
use App\Actions\Vendors\Payments\GetAllWithholdingPeriods;
use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Models\WithholdingPayments;
use App\Models\PaymentReferences;

class WithholdingPaymentController extends Controller
{
    public function store(StoreWithholdingPaymentRequest $request)
    {
        // Create Payment Reference for each period selected
        for($i = 0; $i < count($request->accounting_period_ids); $i++)
        {
            // Reinitialize every loop
            $debit_accounts = [];
            $debit_amount = [];
            $credit_accounts = [];
            $credit_amount = [];

            // Select current period
            $current_period = $request->withholding_periods[$request->accounting_period_ids[$i]];

            // Create Journal Entry
            $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

            // Store Payment Reference
            $reference = new PaymentReferences();
            $reference->accounting_system_id = session('accounting_system_id');
            $reference->type = 'withholding_payment';
            $reference->status = 'paid';
            $reference->date = $request->date;
            $reference->remark = $request->remark;
            $reference->journal_entry_id = $je->id;
            $reference->save();

            // Store Withholding Payment
            $payment = new WithholdingPayments();
            $payment->payment_reference_id = $reference->id;
            $payment->accounting_period_id = $current_period->id;
            $payment->cheque_number = $request->cheque_number;
            $payment->total_paid = $current_period->total_withholdings;
            $payment->save();

            // Debit 2105 - Withholding Tax Payable
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->withholding_tax_payable->id);
            $debit_amount[] = $current_period->total_withholdings;

            // Credit Selected Cash Account
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $credit_amount[] = $current_period->total_withholdings;

            // Create Journal Postings
            CreateJournalPostings::run($je,
                $debit_accounts, $debit_amount,
                $credit_accounts, $credit_amount,
                session('accounting_system_id'));
        }

        return [
            'success' => true,
            'message' => 'Withholding Payments been successfully recorded.',
        ];
    }

    public function ajaxGetAll()
    {
        $withholding_periods = GetAllWithholdingPeriods::run();
        $withholding_periods_unpaid = GetAllWithholdingPeriods::run(true);
        $total = 0;

        // get array sum of withholding_periods_unpaid
        for($i = 0; $i < count($withholding_periods_unpaid); $i++) {
            $total += $withholding_periods_unpaid[$i]->total_withholdings;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'withholding_periods' => $withholding_periods,
                'total_selectable_withholding' => $total,
            ]
        ]);
    }
}

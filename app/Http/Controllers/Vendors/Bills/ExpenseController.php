<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendors\Bills\StoreExpenseRequest;
use App\Models\PaymentReferences;
use App\Models\Vendors\Bills\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(StoreExpenseRequest $request)
    {
        // return $request;

        // Determine bill status
        $status = DetermineReceiptStatus::run($request->grand_total, $request->total_amount_received);

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Create Bill Reference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'date' => $request->date,
            'type' => 'expense',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => $status
        ]);

        if($request->grand_total == $request->total_amount_received)
            $payment_method = 'cash';
        else
            $payment_method = 'credit';

        $expense = Expense::create([
            // Foreign
            'payment_reference_id' => $reference->id,

            // Field
            'reference_number' => $request->reference_number,
            'total_amount_received' => $request->total_amount_received,

            // Auto-generated
            'sub_total' => $request->sub_total,
            'discount' => 0.00, // Temporary
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            'withholding' => $request->withholding,
            'payment_method' => $payment_method,
        ]);

        // Store Expense Items
        $ctr = 0;
        foreach($request->item as $item) {
            $expenses[] = [
                'expense_id' => $expense->id,
                'chart_of_account_id' => $item->value,
                'price_amount' => $request->price[$ctr++],
            ];
        }

        DB::table('expense_items')->insert($expenses);

        // Transaction Proper
        $cash = $request->total_amount_received;
        $account_payable = $request->grand_total - $request->total_amount_received;

        // Create Debit Postings for each expense
        for($i = 0; $i < count($request->item); $i++) {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->item[$i]->value);
            $debit_amount[] = $request->price[$i];
        }

        // This chekcs whether to add debit_amount tax posting
        if($request->tax_total > 0) {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_vat_receivable);
            $debit_amount[] = $request->tax_total;
        }

        // Create Credit Postings

        // Check if there is withholding tax
        if($request->withholding_check != null)
        {
            $cash -= $request->withholding;

            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_withholding);
            $credit_amount[] = $request->withholding;

            if($cash < 0) {
                $account_payable += $cash;
            }
        }

        // This determines which is which to include in credit postings
        if($status == 'paid' || $status == 'partially_paid') {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $credit_amount[] = $cash;
        }
        if($status == 'partially_paid' || $status == 'unpaid') {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_account_payable);
            $credit_amount[] = $account_payable;
        }

        if($request->discount_amount > 0) {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_sales_discount);
            $credit_amount[] = $request->discount_amount;
        }

        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount
        ];
    }
}

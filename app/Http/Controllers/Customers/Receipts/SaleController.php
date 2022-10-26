<?php

namespace App\Http\Controllers\Customers\Receipts;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\Receipts\StoreSaleRequest;
use App\Models\ReceiptCashTransactions;
use App\Models\Customers\Receipts\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(StoreSaleRequest $request)
    {
        // return $request;

        // Determine Receipt Status
        $status = DetermineReceiptStatus::run($request->grand_total, $request->total_amount_received);        

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();  
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Create Receipt Reference
        $reference = CreateReceiptReference::run(null, $request->date, 'sale', $status, session('accounting_system_id'));
        $reference->journal_entry_id = $je->id;
        $reference->save();

        // Create Receipt Cash Transaction
        if($request->total_amount_received > 0) {
            ReceiptCashTransactions::create([
                'accounting_system_id' => session('accounting_system_id'),
                'receipt_reference_id' => $reference->id,
                'for_receipt_reference_id' => $reference->id,
                'amount_received' => $request->total_amount_received,
            ]);
        }

        $cash = $request->total_amount_received;
        $account_receivable = $request->grand_total - $request->total_amount_received;

        // Check if there is withholding
        if($request->withholding_check != null) {
            $cash -= $request->withholding;

            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_withholding);
            $debit_amount[] = $request->withholding;

            if($cash < 0) {
                $account_receivable += $cash;
            }
        }

        // Create Debit Postings
        // This determines which is which to include in debit postings
        if($status == 'paid' || $status == 'partially_paid') {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $debit_amount[] = $cash;
        }
        if($status == 'partially_paid' || $status == 'unpaid') {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_account_receivable);
            $debit_amount[] = $account_receivable;
        }

        // Create Credit Postings
        // This checks whether to add credit tax posting
        if($request->tax_amount > 0) {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_vat_payable);
            $credit_amount[] = $request->tax_amount;
        }
        // Add credit sales posting
        $credit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_sales);
        $credit_amount[] = $request->price_amount;

        CreateJournalPostings::run($je, 
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        $sale = Sale::create([
            'receipt_reference_id' => $reference->id,
            'reference_number' => $request->reference_number,
            'price' => $request->price_amount,
            'tax' => $request->tax_amount,
            'withholding' => isset($request->withholding) ? $request->withholding : 0,
            'grand_total' => $request->grand_total,
            'amount_received' => $request->total_amount_received,
            'terms_and_conditions' => $request->remarks,
            'attachment' => $request->attachment,
        ]);

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
            'sale' => $sale,
        ];
    }
}

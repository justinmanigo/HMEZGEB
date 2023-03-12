<?php

namespace App\Http\Controllers\Customers\Receipts;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\Receipts\StoreSaleRequest;
use App\Models\BankAccounts;
use App\Models\ReceiptCashTransactions;
use App\Models\Customers\Receipts\Sale;
use App\Models\DepositItems;
use App\Models\Deposits;
use App\Models\ReceiptReferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function searchAjax($query = null)
    {
        $sales = ReceiptReferences::select(
            'receipt_references.id',
            'receipt_references.date',
            'sales.grand_total',
            'receipt_cash_transactions.total_amount_received'
        )
        ->leftJoin('sales', 'sales.receipt_reference_id', 'receipt_references.id')
        // left join sub to get sum of receipt_cash_transactions
        // this will determine the status of the receipt (paid, partially_paid, unpaid)
        ->leftJoinSub(
            ReceiptCashTransactions::select(
                'receipt_cash_transactions.for_receipt_reference_id',
                DB::raw('SUM(receipt_cash_transactions.amount_received) as total_amount_received')
            )
            ->groupBy('receipt_cash_transactions.for_receipt_reference_id'),
            'receipt_cash_transactions',
            'receipt_cash_transactions.for_receipt_reference_id',
            'receipt_references.id'
        )
        ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
        ->where(function($q) use ($query){
            $q->where('receipt_references.id', 'like', "%{$query}%")
            ->orWhere('receipt_references.date', 'like', "%{$query}%")
            ->orWhere('receipt_references.status', 'like', "%{$query}%");
        })
        ->where('receipt_references.type', 'sale');


        return response()->json([
            'sales' => $sales->paginate(10),
        ]);

    }

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
            $bank_account = BankAccounts::where('chart_of_account_id', $request->cash_account->value)->first();
            $deposit = null;

            $rct = ReceiptCashTransactions::create([
                'accounting_system_id' => session('accounting_system_id'),
                'chart_of_account_id' => $request->cash_account->value,
                'receipt_reference_id' => $reference->id,
                'for_receipt_reference_id' => $reference->id,
                'amount_received' => $request->total_amount_received,
            ]);

            if($bank_account) {
                $deposit = Deposits::create([
                    'accounting_system_id' => session('accounting_system_id'),
                    'chart_of_account_id' => $request->cash_account->value,
                    'deposit_ticket_date' => date('Y-m-d'),
                    'remark' => $request->remark,
                    'reference_number' => $request->reference_number,
                    'is_direct_deposit' => true,
                ]);

                $deposit_item = DepositItems::create([
                    'deposit_id' => $deposit->id,
                    'receipt_cash_transaction_id' => $rct->id,
                    'journal_entry_id' => $je->id,
                ]);
            }
        }

        $cash = $request->total_amount_received;
        $account_receivable = $request->grand_total - $request->total_amount_received;

        // Check if there is withholding
        if($request->withholding_check != null) {
            $cash -= $request->withholding_amount;

            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_withholding);
            $debit_amount[] = $request->withholding_amount;

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

        if($request->discount_amount > 0) {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->receipt_sales_discount);
            $debit_amount[] = $request->discount_amount;
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
            'withholding' => isset($request->withholding_amount) ? $request->withholding_amount : 0,
            'discount' => $request->discount_amount,
            'sub_total' => $request->sub_total,
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

    /**
     * TODO: To implement
     */
    public function show()
    {
        //
    }

    public function void(ReceiptReferences $rr)
    {
        $rr->journalEntry;
        $rr->sale;

        // Source Receipt Cash Transaction
        $rr->receiptCashTransactions[0]->depositItem;

        // If the source receipt is already deposited, void the deposit item entry
        if($rr->receiptCashTransactions[0]->depositItem) {
            $rr->receiptCashTransactions[0]->depositItem->is_void = true;
            $rr->receiptCashTransactions[0]->depositItem->save();

            $rr->receiptCashTransactions[0]->depositItem->journalEntry->is_void = true;
            $rr->receiptCashTransactions[0]->depositItem->journalEntry->save();
        }

        // TODO: Voiding a source receipt will also affect the credit sales that are linked to it.

        $rr->is_void = true;
        $rr->journalEntry->is_void = true;
        $rr->push();

        return redirect()->back()->with('success', "Successfully voided sale.");
    }

    public function reactivate(ReceiptReferences $rr)
    {
        $rr->journalEntry;

        $rr->is_void = false;
        $rr->journalEntry->is_void = false;
        $rr->push();

        return redirect()->back()->with('success', "Successfully reactivated sale.");
    }
}

<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\Bills\StoreCostOfGoodsSoldRequest;
use App\Models\PaymentReferences;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CostOfGoodsSoldController extends Controller
{
    public function store(StoreCostOfGoodsSoldRequest $request)
    {
        // return $request;

        // Determine COGS Status
        $status = DetermineReceiptStatus::run($request->grand_total, $request->total_amount_received);

        // If request has attachment, store it to file storage.
        if($request->attachment) {
            $fileAttachment = time().'.'.$request->attachment->extension();
            $request->attachment->storeAs('public/receipt-attachment'/'receipt', $fileAttachment);
        }

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));

        // Create BillReference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => null,
            'date' => $request->date,
            'type' => 'cogs',
            'attachment' => null, // TEMPORARY
            'remark' => $request->remark,
            'status' => $status
        ]);

        $cash = $request->total_amount_received;
        $account_payable = $request->grand_total - $request->total_amount_received;
        $sales = $request->sub_total - $request->tax_amount;

        // Create debit postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_cost_of_goods_sold->id);
        $debit_amount[] = $sales;

        // This checks whether to add debit_amount tax posting
        if($request->tax_amount > 0) {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_vat_receivable);
            $debit_amount[] = $request->tax_amount;
        }

        // Create Credit Postings

        // Check if there is withholding
        if($request->withholding_check != null) {
            $cash -= $request->withholding_amount;

            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_withholding);
            $credit_amount[] = $request->withholding_amount;

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

        $cogs = DB::table('cost_of_goods_sold')->insert([
            'payment_reference_id' => $reference->id,
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
            'credit_amount' => $credit_amount
        ];
    }
}

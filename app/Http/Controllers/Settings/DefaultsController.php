<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Defaults\UpdateAdvanceReceiptDefaultsRequest;
use App\Http\Requests\Settings\Defaults\UpdateBillDefaultsRequest;
use App\Http\Requests\Settings\Defaults\UpdateCreditReceiptDefaultsRequest;
use App\Http\Requests\Settings\Defaults\UpdatePaymentDefaultsRequest;
use App\Http\Requests\Settings\Defaults\UpdateReceiptDefaultsRequest;
use App\Models\AccountingSystem;

class DefaultsController extends Controller
{
    public function index()
    {
        return view('settings.defaults.index');
    }

    public function updateReceipts(UpdateReceiptDefaultsRequest $request)
    {
        return AccountingSystem::find($request->accounting_system_id)->update([
            'receipt_cash_on_hand' => $request->receipt_cash_on_hand,
            'receipt_vat_payable' => $request->receipt_vat_payable,
            'receipt_sales' => $request->receipt_sales,
            'receipt_account_receivable' => $request->receipt_account_receivable,
            'receipt_sales_discount' => $request->receipt_sales_discount,
            'receipt_withholding' => $request->receipt_withholding,
        ]);
    }

    public function updateAdvanceReceipts(UpdateAdvanceReceiptDefaultsRequest $request)
    {
        return AccountingSystem::find($request->accounting_system_id)->update([
            'advance_receipt_cash_on_hand' => $request->advance_receipt_cash_on_hand,
            'advance_receipt_advance_payment' => $request->advance_receipt_advance_payment,
        ]);
    }

    public function updateCreditReceipts(UpdateCreditReceiptDefaultsRequest $request)
    {
        return AccountingSystem::find($request->accounting_system_id)->update([
            'credit_receipt_cash_on_hand' => $request->credit_receipt_cash_on_hand,
            'credit_receipt_credit_payment' => $request->credit_receipt_credit_payment,
        ]);
    }

    public function updateBills(UpdateBillDefaultsRequest $request)
    {
        return AccountingSystem::find($request->accounting_system_id)->update([
            'bill_cash_on_hand' => $request->bill_cash_on_hand,
            'bill_items_for_sale' => $request->bill_items_for_sale,
            'bill_freight_charge_expense' => $request->bill_freight_charge_expense,
            'bill_vat_receivable' => $request->bill_vat_receivable,
            'bill_account_payable' => $request->bill_account_payable,
            'bill_withholding' => $request->bill_withholding,
        ]);
    }

    public function updatePayments(UpdatePaymentDefaultsRequest $request)
    {
        return AccountingSystem::find($request->accounting_system_id)->update([
            'payment_cash_on_hand' => $request->payment_cash_on_hand,
            'payment_vat_receivable' => $request->payment_vat_receivable,
            'payment_account_payable' => $request->payment_account_payable,
            'payment_withholding' => $request->payment_withholding,
            'payment_salary_payable' => $request->payment_salary_payable,
            'payment_commission_payment' => $request->payment_commission_payment,
        ]);
    }
}

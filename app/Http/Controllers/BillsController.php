<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Vendor\Bill\StoreBillItems;
use App\Actions\Vendor\Bill\UpdateBillStatus;
use App\Actions\Vendor\CalculateBalanceVendor;
use App\Http\Requests\Vendors\Bills\StoreBillRequest;
use App\Http\Requests\Vendor\Bill\StorePurchaseOrderRequest;
use App\Models\Bills;
use App\Models\Vendors;
use App\Models\PaymentReferences;
use App\Models\BillItem;
use App\Models\PurchaseOrders;
use App\Models\Inventory;
use Illuminate\Http\Request;


class BillsController extends Controller
{
    public function searchAjax($query = null)
    {
        $transactions = PaymentReferences::select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                'payment_references.is_void',
                'bills.amount_received as bill_amount',
                'purchase_orders.grand_total as purchase_order_amount',
                'cost_of_goods_sold.amount_received as cost_of_goods_sold_amount',
                'expenses.total_amount_received as expenses_amount'
            )
            ->leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('cost_of_goods_sold', 'cost_of_goods_sold.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('expenses', 'expenses.payment_reference_id', '=', 'payment_references.id')
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            // where subquery
            ->where(function ($query) {
                $query->where('payment_references.type', '=', 'bill')
                    ->orWhere('payment_references.type', '=', 'purchase_order')
                    ->orWhere('payment_references.type', '=', 'cogs')
                    ->orWhere('payment_references.type', '=', 'expense');
            })
            ->where(function($q) use ($query) {
                $q->where('vendors.name', 'like', '%'.$query.'%')
                    ->orWhere('payment_references.id', 'like', '%'.$query.'%')
                    ->orWhere('payment_references.type', 'like', '%'.$query.'%')
                    ->orWhere('payment_references.date', 'like', '%'.$query.'%')
                    ->orWhere('payment_references.status', 'like', '%'.$query.'%');
            });

        return response()->json([
            'bills' => $transactions->paginate(10),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = PaymentReferences::leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('cost_of_goods_sold', 'cost_of_goods_sold.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('expenses', 'expenses.payment_reference_id', '=', 'payment_references.id')
            // where subquery
            ->where(function ($query) {
                $query->where('payment_references.type', '=', 'bill')
                    ->orWhere('payment_references.type', '=', 'purchase_order')
                    ->orWhere('payment_references.type', '=', 'cogs')
                    ->orWhere('payment_references.type', '=', 'expense');
            })
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                'payment_references.is_void',
                'bills.amount_received as bill_amount',
                'purchase_orders.grand_total as purchase_order_amount',
                'cost_of_goods_sold.amount_received as cost_of_goods_sold_amount',
                'expenses.total_amount_received as expenses_amount'
            )
            ->get();

        // count advance revenues
        $vendors = Vendors::where('accounting_system_id', session('accounting_system_id'))->get();

        $total_balance = 0;
        $total_balance_overdue = 0;
        $count = 0;
        $count_overdue = 0;

        foreach($vendors as $vendor){
            $total_balance += CalculateBalanceVendor::run($vendor->id)['total_balance'];
            $total_balance_overdue += CalculateBalanceVendor::run($vendor->id)['total_balance_overdue'];
            $count += CalculateBalanceVendor::run($vendor->id)['count'];
            $count_overdue += CalculateBalanceVendor::run($vendor->id)['count_overdue'];
        }

        return view('vendors.bills.index', [
            'transactions' => $transactions,
            'total_balance' => $total_balance,
            'total_balance_overdue' => $total_balance_overdue,
            'count' => $count,
            'count_overdue' => $count_overdue,
        ]);
    }
}

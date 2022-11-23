<?php

namespace App\Actions\Vendors\Payments;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;

class GetAllWithholdingPeriods
{
    use AsAction;

    public function handle($onlyUnpaid = false)
    {
        $ap = DB::table('accounting_periods')
            ->select(
                'id',
                'date_from',
                'date_to',
            )
        ->where('accounting_system_id', session('accounting_system_id'));

        $cogs = DB::table('cost_of_goods_sold')
            ->select(
                'accounting_periods.id as accounting_period_id',
                DB::raw('SUM(cost_of_goods_sold.withholding) as total_withholding'),
            )
            ->leftJoin('payment_references', 'cost_of_goods_sold.payment_reference_id', '=', 'payment_references.id')
            ->leftJoinSub(
                $ap, 'accounting_periods',
                function ($join) {
                    $join->on('payment_references.date', '>=', 'accounting_periods.date_from')
                        ->on('payment_references.date', '<=', 'accounting_periods.date_to');
                }
            )
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->groupBy('accounting_periods.id');

        $expenses = DB::table('expenses')
            ->select(
                'accounting_periods.id as accounting_period_id',
                DB::raw('SUM(expenses.withholding) as total_withholding'),
            )
            ->leftJoin('payment_references', 'expenses.payment_reference_id', '=', 'payment_references.id')
            ->leftJoinSub(
                $ap, 'accounting_periods',
                function ($join) {
                    $join->on('payment_references.date', '>=', 'accounting_periods.date_from')
                        ->on('payment_references.date', '<=', 'accounting_periods.date_to');
                }
            )
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->groupBy('accounting_periods.id');

        $bills = DB::table('bills')
            ->select(
                'accounting_periods.id as accounting_period_id',
                DB::raw('SUM(bills.withholding) as total_withholding'),
            )
            ->leftJoin('payment_references', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->leftJoinSub(
                $ap, 'accounting_periods',
                function ($join) {
                    $join->on('payment_references.date', '>=', 'accounting_periods.date_from')
                        ->on('payment_references.date', '<=', 'accounting_periods.date_to');
                }
            )
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->groupBy('accounting_periods.id');

        $periods = DB::table('accounting_periods')
            ->select(
                'accounting_periods.id',
                'accounting_periods.period_number',
                'accounting_periods.date_from',
                'accounting_periods.date_to',
                'withholding_payments.id as withholding_payment_id',
                DB::raw('IFNULL(expenses.total_withholding, 0) + IFNULL(cogs.total_withholding, 0) + IFNULL(bills.total_withholding, 0) as total_withholdings'),
            )
            // left join sub expenses variable
            ->leftJoinSub($cogs, 'cogs', function ($join) {
                $join->on('cogs.accounting_period_id', 'accounting_periods.id');
            })
            ->leftJoinSub($expenses, 'expenses', function ($join) {
                $join->on('expenses.accounting_period_id', 'accounting_periods.id');
            })
            ->leftJoinSub($bills, 'bills', function ($join) {
                $join->on('bills.accounting_period_id', 'accounting_periods.id');
            })
            // TODO: left join with withholding payments to indicate
            // if the withholding payment is already made for period
            ->leftJoin('withholding_payments', 'accounting_periods.id', 'withholding_payments.accounting_period_id')
            ->where('accounting_periods.accounting_system_id', session('accounting_system_id'));

        if($onlyUnpaid) {
            $periods->where('withholding_payments.id', '=', null);
        }
        return $periods->get();
    }
}

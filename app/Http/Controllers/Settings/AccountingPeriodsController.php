<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\AccountingPeriods\UpdateAccountingPeriodsRequest;
use App\Models\Settings\ChartOfAccounts\AccountingPeriods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingPeriodsController extends Controller
{
    public function index()
    {
        $accounting_periods = AccountingPeriods::select(
                'accounting_periods.period_number as number',
                'accounting_periods.date_from',
                'accounting_periods.date_to',
                'accounting_periods.updated_at',
                DB::raw('CONCAT(users.firstName, " ", users.lastName) as last_edited_by'),
            )
            ->leftJoin('accounting_system_users', 'accounting_system_users.id', '=', 'accounting_periods.accounting_system_user_id')
            ->leftJoin('subscription_users', 'subscription_users.id', '=', 'accounting_system_users.subscription_user_id')
            ->leftJoin('users', 'users.id', '=', 'subscription_users.user_id')
            ->where('accounting_periods.accounting_system_id', session('accounting_system_id'))
            ->orderBy('accounting_periods.period_number', 'asc')
            ->get();

        // return $accounting_periods;

        return view('settings.accounting_periods.index', [
            'accounting_periods' => $accounting_periods,
        ]);
    }

    public function updateAjax(UpdateAccountingPeriodsRequest $request)
    {
        for($i = 0; $i < 12; $i++)
        {
            $accounting_period = AccountingPeriods::where('accounting_system_id', session('accounting_system_id'))
                ->where('period_number', $i+1)
                ->first();
            $accounting_period->date_from = $request->date_from[$i];
            $accounting_period->date_to = $request->date_to[$i];
            
            if($accounting_period->isDirty())
            {
                $accounting_period->accounting_system_user_id = session('accounting_system_user_id');
                $accounting_period->save();
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }
}

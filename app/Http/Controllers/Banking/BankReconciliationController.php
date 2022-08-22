<?php

namespace App\Http\Controllers\Banking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankReconciliationController extends Controller
{
    public function index()
    {
        $bankAccounts = \App\Models\BankAccounts::select(
                'bank_accounts.id as value',
                'bank_accounts.bank_branch',   
                'bank_accounts.bank_account_number',
                'chart_of_accounts.account_name',
            )
            ->leftJoin('chart_of_accounts', 'chart_of_accounts.id', 'bank_accounts.chart_of_account_id')
            ->where('accounting_system_id', session('accounting_system_id'))
            ->get();

        return view('banking.reconciliation.index', [
            'bankAccounts' => $bankAccounts,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BankAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Http\Request;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bank_accounts = BankAccounts::all();
        $coa_number = 1030;
        // $coa_last_record = BankAccounts::orderBy('created_at', 'desc')->first();
        // if (empty($coa_last_record)) {
        //     $coa_number = 1030;
        // } else {
        //     $coa_number = $coa_last_record->chartOfAccount->chart_of_account_no + 1;
        // }
        return view('banking.accounts.index', compact('bank_accounts','coa_number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //coa
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        $coa = new ChartOfAccounts();
        $coa->accounting_system_id = $accounting_system_id;
        $coa->chart_of_account_category_id = '1';
        $coa->chart_of_account_no = $request->coa_number;
        $coa->account_name = $request->account_name;
        $coa->current_balance = 0.00;
        $coa->save();

        $account = new BankAccounts();
        $account->chart_of_account_id = $coa->id;
        $account->bank_branch = $request->bank_branch;
        $account->bank_account_number = $request->bank_account_number;
        $account->bank_account_type = $request->bank_account_type;
        $account->save();

        return redirect()->back()->with('success', 'Bank Account Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function show(Accounts $accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounts $accounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accounts $accounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounts $accounts)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BankAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $bank_accounts = BankAccounts::leftJoin('chart_of_accounts', 'bank_accounts.chart_of_account_id', '=', 'chart_of_accounts.id')
            ->where('chart_of_accounts.accounting_system_id', $this->request->session()->get('accounting_system_id'))->get();
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
    public function edit($id)
    {
        //
        $accounts = BankAccounts::find($id);
        return view('banking.accounts.edit', compact('accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $accounts = BankAccounts::find($id);
        $accounts->bank_branch = $request->bank_branch;
        $accounts->bank_account_number = $request->bank_account_number;
        $accounts->bank_account_type = $request->bank_account_type;
        $coa = ChartOfAccounts::find($accounts->id);
        $coa->account_name = $request->account_name;
        $coa->chart_of_account_no = $request->coa_number;
        $coa->save();
        $accounts->save();

        return redirect()->back()->with('success', 'Bank Account Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{

            $accounts = BankAccounts::find($id);
            $coa = ChartOfAccounts::find($accounts->chart_of_account_id);       
            $accounts->delete();
            $coa->delete();
        }
        catch(\Exception $e){
            return redirect('/banking/accounts')->with('error', 'Error deleting bank account');
        }
        return redirect('/banking/accounts')->with('success', 'Bank Account Deleted Successfully');
    }
}

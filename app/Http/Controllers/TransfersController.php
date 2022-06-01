<?php

namespace App\Http\Controllers;

use App\Models\Transfers;
use Illuminate\Http\Request;
use App\Models\BankAccounts;
use App\Models\ChartOfAccounts;
use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\DecodeTagifyField;
use Illuminate\Support\Facades\Log;

class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transfers = Transfers::all();
        return view('banking.transfers.index', compact('transfers'));
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
        // deduct and add in coa balances 
        $fromAccount = BankAccounts::find($request->from_account_id);
        $toAccount = BankAccounts::find($request->to_account_id);

        // check if account is the same
        if($fromAccount->id == $toAccount->id){
            return redirect()->back()->with('error', 'Cannot transfer to the same account');
        }
        // check if the amount is greater than the balance
        if($request->amount > $fromAccount->chartOfAccount->current_balance){
            return redirect()->back()->with('error', 'Cannot transfer more than the balance');
        }

        $fromAccount->chartOfAccount->current_balance -= $request->amount;
        $toAccount->chartOfAccount->current_balance += $request->amount;
        $fromAccount->chartOfAccount->save();
        $toAccount->chartOfAccount->save();

        $debit_accounts[] = CreateJournalPostings::encodeAccount($toAccount->chartOfAccount->id);
        $credit_accounts[] = CreateJournalPostings::encodeAccount($fromAccount->chartOfAccount->id);
        
        $je = CreateJournalEntry::run(now()->format('Y-m-d'), $request->reason, $this->request->session()->get('accounting_system_id'));

        CreateJournalPostings::run($je, 
            $debit_accounts, [$request->amount], 
            $credit_accounts, [$request->amount], 
            $this->request->session()->get('accounting_system_id')
        );

        Transfers::create($request->all());

        return redirect()->back()->with('success', 'Transfer has been made successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function show(Transfers $transfers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfers $transfers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfers $transfers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfers $transfers)
    {
        //
    }

    public function queryBank($query)
    {   
        $bankAccounts = BankAccounts::select(
                'bank_accounts.id as value',
                'bank_accounts.bank_branch',
                'bank_accounts.bank_account_number',
                'chart_of_accounts.chart_of_account_no',
                'chart_of_accounts.account_name',
            )
            ->leftJoin('chart_of_accounts', 'bank_accounts.chart_of_account_id', '=', 'chart_of_accounts.id')
            ->where('bank_branch', 'LIKE', '%'.$query.'%')
            ->orWhere('bank_account_number', 'LIKE', '%'.$query.'%')
            ->get();
            
        return $bankAccounts;
    }
}

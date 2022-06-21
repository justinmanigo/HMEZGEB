<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Requests\Customer\Deposit\StoreDepositRequest;
use App\Models\Deposits;
use App\Models\DepositItems;
use App\Models\ReceiptCashTransactions;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\ReceiptReferences;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DepositsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get deposits where accounting system id
        $deposits = Deposits::where('accounting_system_id', session()->get('accounting_system_id'))->get();
        return view('customer.deposit.index',compact('deposits'));
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
    public function store(StoreDepositRequest $request)
    {
        $coa = ChartOfAccounts::find($request->bank_account->value);
        $deposits = Deposits::create([
            'accounting_system_id' => session()->get('accounting_system_id'),
            'chart_of_account_id' => $coa->id,
            'status' => 'Deposited',
            'deposit_ticket_date' => $request->deposit_ticket_date,
            'total_amount' => $request->total_amount,
            'remark' => $request->remark,
        ]);

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->deposit_ticket_date, $request->remark, session('accounting_system_id'));

        // Initialize the COAs and Amount from different cash on hand
        $credit_accounts = [];
        $credit_amount = [];

        // Stores the COA of Bank
        $debit_accounts[] = CreateJournalPostings::encodeAccount($coa->id);
        $debit_amount[] = $request->total_amount;

        $coa = [];

        for($i = 0; $i < count($request->is_deposited); $i++)
        {
            $cash_transaction = ReceiptCashTransactions::find($request->is_deposited[$i]);

            $cash_transaction->receiptReference->receipt;
            
            $cash_transaction->is_deposited = 'yes';
            $cash_transaction->save();
            
            $deposit_item = DepositItems::create([
                'deposit_id' => $deposits->id,
                'receipt_cash_transaction_id' => $request->is_deposited[$i],
            ]);

            // Deduct balance from COA for transfer
            $coa_id = $cash_transaction->receiptReference->receipt->chart_of_account_id;
            $amount_received = $cash_transaction->amount_received;
            
            $idx = -1;
            for($j = 0; $j < count($credit_accounts); $j++)
            {
                if($credit_accounts[$j] == $coa_id) {
                    $credit_amount[$j] += $cash_transaction->amount_received;
                    $idx = $j;
                }
            }
            if($idx == -1) {
                $credit_accounts[] = $coa_id;
                $credit_amount[] = $cash_transaction->amount_received;
            }
        }

        for($i = 0; $i < count($credit_accounts); $i++)
            $credit_accounts[$i] = CreateJournalPostings::encodeAccount($credit_accounts[$i]);

        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function show(Deposits $deposits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposits $deposits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposits $deposits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposits $deposits)
    {
        //
    }

     /******* AJAX ***********/

     public function ajaxSearchBank($query)
     {
         return ChartOfAccounts::select(
                 'chart_of_accounts.id as value',
                 'chart_of_accounts.chart_of_account_category_id',
                 'chart_of_accounts.chart_of_account_no',
                 'chart_of_accounts.account_name',
                 'bank_accounts.bank_branch',
                 'bank_accounts.bank_account_number',
                 'bank_accounts.bank_account_type',
                 'chart_of_account_categories.category',
                 'chart_of_account_categories.normal_balance',
             )
             ->leftJoin('chart_of_account_categories', 'chart_of_accounts.chart_of_account_category_id', '=', 'chart_of_account_categories.id')
             ->leftJoin('bank_accounts', 'chart_of_accounts.id', '=', 'bank_accounts.chart_of_account_id')
             ->where('chart_of_account_categories.category' , '=', 'Cash')
             ->where('bank_accounts.bank_account_number' , '!=', NULL)
             ->where(function($sql) use ($query) {
                 $sql->where('chart_of_accounts.account_name', 'LIKE', "%{$query}%")
                     ->orWhere('chart_of_accounts.chart_of_account_no', 'LIKE', "%{$query}%")
                     ->orWhere('bank_accounts.bank_account_number', 'LIKE', "%{$query}%")
                     ->orWhere('bank_accounts.bank_branch', 'LIKE', "%{$query}%");
             })
             ->get();
     }
}
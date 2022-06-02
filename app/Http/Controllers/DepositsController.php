<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use App\Models\DepositItems;
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
        $deposits = Deposits::all();
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
    public function store(Request $request)
    {
        $data = json_decode($request->bank_account);
        $id = $data[0]->value;
        $coa = ChartOfAccounts::find($id);
        $deposits = Deposits::create([
            'chart_of_account_id' => $coa->id,
            'status' => 'Deposited',
            'deposit_ticket_date' => $request->deposit_ticket_date,
            'total_amount' => $request->total_amount,
            'remark' => $request->remark,
        ]);
        for($i = 0; $i < count($request->is_deposited); $i++)
        {
            // find the receipt reference using is_deposited value (receipt_reference_id)
            $receipts = ReceiptReferences::find($request->is_deposited[$i]);
            // add to coa balance
            $coa->current_balance += $receipts->receipt->total_amount_received;
            $coa->save();
            // update receipt reference is_deposited
            $receipts->is_deposited = "yes";
            $receipts->save();
            // add to deposit items
            $depositItems = DepositItems::create([
                'receipt_reference_id' => $request->is_deposited[$i],
                'deposit_id' => $deposits->id,
            ]); 
        }
        return $coa;
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
<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccounts;
use App\Models\ChartOfAccountCategory;
use App\Models\PeriodOfAccounts;
use Illuminate\Http\Request;

class SettingChartOfAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart_of_accounts = ChartOfAccounts::select(
                'chart_of_accounts.id',
                'chart_of_accounts.chart_of_account_no',
                'chart_of_accounts.name',
                'chart_of_account_categories.type',
                'chart_of_account_categories.category',
                'chart_of_accounts.current_balance',
                'chart_of_accounts.status',
            )
            ->leftJoin('chart_of_account_categories', 'chart_of_account_category_id', '=', 'chart_of_account_categories.id')
            ->get();

        return view('settings.chart_of_account.index', compact('chart_of_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;

        $coa_category = json_decode($request->coa_category, true);
        
        // To get the category_id of coa, use
        // $coa[0]['value'];
        // other related info such as type, category name,
        // can be seen by changing `value` to its corresponding
        // column name.

        // Validation
        // TODO: Check if specific COA number already exists.

        // Create Chart of Account Entry
        $coa = new ChartOfAccounts();
        $coa->chart_of_account_category_id = $coa_category[0]['value'];
        $coa->chart_of_account_no = $request->coa_number;
        $coa->name = $request->coa_name;
        $coa->current_balance = $request->coa_beginning_balance;

        // If COA is Cash (id:1) and checkbox is checked.
        if(isset($request->coa_is_bank) && $coa_category[0]['value'] == 1)
        {
            $coa->bank_account_number = $request->bank_account_number;
            $coa->bank_branch = $request->bank_branch;
            $coa->bank_account_type = $request->bank_account_type;
        }

        $coa->save();

        // Create Period of Account Entry for $coa
        // TODO: Integrate with Accounting Period later. At the moment, 
        // temporary value will be null.
        $poa = PeriodOfAccounts::create([
            'chart_of_account_id' => $coa->id,
            'beginning_balance' => $request->coa_beginning_balance,
        ]);

        return back()->with('success', 'Successfully stored new Chart of Account.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChartOfAccounts  $chartOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function show(ChartOfAccounts $chartOfAccounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChartOfAccounts  $chartOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit(ChartOfAccounts $chartOfAccounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChartOfAccounts  $chartOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChartOfAccounts $chartOfAccounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChartOfAccounts  $chartOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChartOfAccounts $chartOfAccounts)
    {
        //
    }

    /**====================== */

    function ajaxSearchCOA($query)
    {
        return ChartOfAccounts::select(
                'chart_of_accounts.id as value',
                'chart_of_accounts.chart_of_account_no',
                // 'chart_of_account_categories.id',
                'chart_of_account_categories.category',
                'chart_of_account_categories.type',
                'chart_of_account_categories.normal_balance',
            )
            ->leftJoin('chart_of_account_categories', 'chart_of_account_categories.id', '=', 'chart_of_accounts.chart_of_account_category_id')
            ->where('chart_of_accounts.chart_of_account_no', 'LIKE', '%' . $query . '%')
            ->orWhere('chart_of_account_categories.category', 'LIKE', '%' . $query . '%')
            ->orWhere('chart_of_account_categories.type', 'LIKE', '%' . $query . '%')
            ->get();
    }

    public function ajaxSearchCategories($query = null)
    {
        $categories = ChartOfAccountCategory::select(
            'id as value', 
            'category',
            'type',
            'normal_balance');
            
        if(isset($query))
            $categories->where('category', 'LIKE', '%' . $query . '%');
    
        return $categories->get();
    }
}
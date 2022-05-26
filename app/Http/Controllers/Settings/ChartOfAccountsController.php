<?php

namespace App\Http\Controllers\Settings;

use App\Actions\GetLatestAccountingPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeginningBalanceRequest;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccountCategory;
use App\Models\Settings\ChartOfAccounts\PeriodOfAccounts;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use Illuminate\Support\Facades\DB;

class ChartOfAccountsController extends Controller
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
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
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
        $coa->accounting_system_id = $accounting_system_id;
        $coa->chart_of_account_category_id = $coa_category[0]['value'];
        $coa->chart_of_account_no = $request->coa_number;
        $coa->name = $request->coa_name;
        $coa->current_balance = 0.00;

        // If COA is Cash (id:1) and checkbox is checked.
        if(isset($request->coa_is_bank) && $coa_category[0]['value'] == 1)
        {
            $coa->bank_account_number = $request->bank_account_number;
            $coa->bank_branch = $request->bank_branch;
            $coa->bank_account_type = $request->bank_account_type;
        }

        $coa->save();

        // Get Beginning Balance Journal Entry
        $je = JournalEntries::where('accounting_system_id', $accounting_system_id)
        ->first();
        
        // Create Journal Posting linked to the Beginning Balance
        JournalPostings::create([
            'accounting_system_id' => $accounting_system_id,
            'journal_entry_id' => $je->id,
            'chart_of_account_id' => $coa->id,
            'type' => $coa_category[0]['normal_balance'] == 'Debit' ? 'debit' : 'credit',
            'amount' => 0.00,
        ]);

        return back()->with('success', 'Successfully stored new Chart of Account.');
    }

    /**
     * A method to store beginning balances using AJAX.
     * 
     * @param \App\Http\Requests\StoreBeginningBalanceRequest $request
     * @return string
     */
    public function storeBeginningBalance(StoreBeginningBalanceRequest $request)
    {
        $validated = $request->validated();
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        // Delete past beginning balances.
        JournalPostings::where('accounting_system_id', $accounting_system_id)->delete();

        // Get Beginning Balance Journal Entry.
        $je = JournalEntries::where('accounting_system_id', $accounting_system_id)
            ->first();

        // Create insert rows for Debit.
        for($i = 0; $i < count($validated['debit_coa_id']); $i++)
        {
            $jp[] = [
                'journal_entry_id' => $je->id,
                'accounting_system_id' => $accounting_system_id,
                'chart_of_account_id' => $validated['debit_coa_id'][$i],
                'type' => 'debit',
                'amount' => $validated['debit_amount'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Create insert rows for Credit.
        for($i = 0; $i < count($validated['credit_coa_id']); $i++)
        {
            $jp[] = [
                'journal_entry_id' => $je->id,
                'accounting_system_id' => $accounting_system_id,
                'chart_of_account_id' => $validated['credit_coa_id'][$i],
                'type' => 'credit',
                'amount' => $validated['credit_amount'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert rows to the database.
        DB::table('journal_postings')->insert($jp);

        return "Successfully saved accounting system's beginning balance.";
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

    function ajaxGetCOAForBeginningBalance()
    {
        // return $this->request->session()->get('accounting_period_id');

        $debits = ChartOfAccounts::select(
            'chart_of_accounts.id',
            'chart_of_accounts.chart_of_account_no',
            'chart_of_accounts.name',
            'chart_of_account_categories.category',
        )
        ->leftJoin('chart_of_account_categories', 'chart_of_accounts.chart_of_account_category_id', 'chart_of_account_categories.id');

        $credits = clone $debits;

        $accountingPeriod = GetLatestAccountingPeriod::run($this->request->session()->get('accounting_system_id'));

        return [
            'accounting_period' => $accountingPeriod,
            'debits' => $debits->where('chart_of_account_categories.normal_balance', 'Debit')->get(),
            'credits' => $credits->where('chart_of_account_categories.normal_balance', 'Credit')->get(),
        ];
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
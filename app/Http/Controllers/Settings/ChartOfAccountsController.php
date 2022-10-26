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
use App\Imports\ImportSettingChartOfAccount;
use App\Exports\ExportSettingChartOfAccount;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BankAccounts;
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
        $sum_debits = DB::table('journal_postings')
            ->select(
                'journal_postings.chart_of_account_id',
                DB::raw('SUM(journal_postings.amount) as total_debit'),
            )
            ->leftJoin('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.is_void', false)
            ->where('type', 'debit')
            ->groupBy('chart_of_account_id');

        $sum_credits = DB::table('journal_postings')
            ->select(
                'journal_postings.chart_of_account_id',
                DB::raw('SUM(journal_postings.amount) as total_credit'),
            )
            ->leftJoin('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.is_void', false)
            ->where('type', 'credit')
            ->groupBy('chart_of_account_id');

        $chart_of_accounts = ChartOfAccounts::select(
                'chart_of_accounts.id',
                'chart_of_accounts.chart_of_account_no',
                'chart_of_accounts.account_name',
                'chart_of_account_categories.type',
                'chart_of_account_categories.category',
                'chart_of_account_categories.normal_balance',
                'chart_of_accounts.status',
                DB::raw('IFNULL(sum_debits.total_debit, 0) as total_debit'),
                DB::raw('IFNULL(sum_credits.total_credit, 0) as total_credit'),
                DB::raw('IFNULL(sum_debits.total_debit, 0) - IFNULL(sum_credits.total_credit, 0) as balance_if_debit'),
                DB::raw('IFNULL(sum_credits.total_credit, 0) - IFNULL(sum_debits.total_debit, 0) as balance_if_credit'),
            )
            ->leftJoin('chart_of_account_categories', 'chart_of_account_category_id', '=', 'chart_of_account_categories.id')
            ->leftJoinSub($sum_debits, 'sum_debits', 'chart_of_accounts.id', '=', 'sum_debits.chart_of_account_id')
            ->leftJoinSub($sum_credits, 'sum_credits', 'chart_of_accounts.id', '=', 'sum_credits.chart_of_account_id')
            ->where('chart_of_accounts.accounting_system_id', session('accounting_system_id'))
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
        
        // return $request->coa_category;
        // To get the category_id of coa, use
        // $coa[0]['value'];
        // other related info such as type, category name,
        // can be seen by changing `value` to its corresponding
        // column name.

        // Search category by value
        $category = ChartOfAccountCategory::where('category', $coa_category[0]['value'])->first();
        
        // Validation
        // TODO: Check if specific COA number already exists.

        // Create Chart of Account Entry
        $coa = new ChartOfAccounts();
        $coa->accounting_system_id = $accounting_system_id;
        $coa->chart_of_account_category_id = $category['id'];
        $coa->chart_of_account_no = $request->coa_number;
        $coa->account_name = $request->account_name;
        $coa->current_balance = 0.00;
        $coa->save();
        
        // If COA is Cash (id:1) and checkbox is checked.
        if(isset($request->coa_is_bank) && $category['id'] == 1)
        {
            $accounts = new BankAccounts();
            $accounts->chart_of_account_id = $coa->id;
            $accounts->bank_branch = $request->bank_branch;
            $accounts->bank_account_number = $request->bank_account_number;
            $accounts->bank_account_type = $request->bank_account_type;
            $accounts->save();
        }
       
        // Get Beginning Balance Journal Entry
        $je = JournalEntries::where('accounting_system_id', $accounting_system_id)
        ->first();
        
        // Create Journal Posting linked to the Beginning Balance
        JournalPostings::create([
            'accounting_system_id' => $accounting_system_id,
            'journal_entry_id' => $je->id,
            'chart_of_account_id' => $coa->id,
            'type' => $category['normal_balance'] == 'Debit' ? 'debit' : 'credit',
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

        $je = JournalEntries::where('accounting_system_id', $accounting_system_id)
            ->first();

        // Delete past beginning balances.
        JournalPostings::where('accounting_system_id', $accounting_system_id)
            ->where('journal_entry_id', $je->id)
            ->delete();

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
    
        // Import Export
    /**====================== */
    public function import(Request $request)
    {
        try {
            Excel::import(new ImportSettingChartOfAccount, $request->file('file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: Cannot import chartOfAccount records. Make sure you have the correct format.');
        }        
        return redirect()->back()->with('success', 'Successfully imported Chart Of Accounts record.');
    }

    // Export
    public function export(Request $request)
    {
       if($request->type=="csv")
            return Excel::download(new ExportSettingChartOfAccount, 'settingChartOfAccount_'.date('Y_m_d').'.csv');
        else
        $coas = ChartOfAccounts::all();
        $pdf = \PDF::loadView('settings.chart_of_account.pdf', compact('coas'));

        return $pdf->download('settingChartOfAccount_'.date('Y_m_d').'.pdf');

    }

    /**====================== */



    function ajaxSearchCOA($query = null)
    {
        $coa = ChartOfAccounts::select(
                'chart_of_accounts.id as value',
                'chart_of_accounts.chart_of_account_no',
                DB::raw('CONCAT(chart_of_accounts.chart_of_account_no, " - ", chart_of_accounts.account_name) as label'),
                'chart_of_accounts.account_name',
                // 'chart_of_account_categories.id',
                'chart_of_account_categories.category',
                'chart_of_account_categories.type',
                'chart_of_account_categories.normal_balance',
            )
            ->leftJoin('chart_of_account_categories', 'chart_of_account_categories.id', '=', 'chart_of_accounts.chart_of_account_category_id')
            ->where('chart_of_accounts.accounting_system_id', session('accounting_system_id'));

        if($query) {
            // nested where
            $coa->where(function($q) use ($query) {
                $q->where('chart_of_accounts.chart_of_account_no', 'LIKE', '%' . $query . '%')
                    ->orWhere('chart_of_account_categories.category', 'LIKE', '%' . $query . '%')
                    ->orWhere('chart_of_account_categories.type', 'LIKE', '%' . $query . '%');
            });
        }

        return $coa->get();
    }

    function ajaxSearchCashCOA($query = null)
    {
        $sum_debits = DB::table('journal_postings')
            ->select(
                'journal_postings.chart_of_account_id',
                DB::raw('SUM(journal_postings.amount) as total_debit'),
            )
            ->leftJoin('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.is_void', false)
            ->where('type', 'debit')
            ->groupBy('chart_of_account_id');

        $sum_credits = DB::table('journal_postings')
            ->select(
                'journal_postings.chart_of_account_id',
                DB::raw('SUM(journal_postings.amount) as total_credit'),
            )
            ->leftJoin('journal_entries', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.is_void', false)
            ->where('type', 'credit')
            ->groupBy('chart_of_account_id');

        $coa = ChartOfAccounts::select(
                'chart_of_accounts.id as value',
                'chart_of_accounts.chart_of_account_no',
                DB::raw('CONCAT(chart_of_accounts.chart_of_account_no, " - ", chart_of_accounts.account_name) as label'),
                'chart_of_accounts.account_name',
                // 'chart_of_account_categories.id',
                'chart_of_account_categories.category',
                'chart_of_account_categories.type',
                'chart_of_account_categories.normal_balance',
                DB::raw('IFNULL(sum_debits.total_debit, 0) as total_debit'),
                DB::raw('IFNULL(sum_credits.total_credit, 0) as total_credit'),
                DB::raw('IFNULL(sum_debits.total_debit, 0) - IFNULL(sum_credits.total_credit, 0) as balance_if_debit'),
                DB::raw('IFNULL(sum_credits.total_credit, 0) - IFNULL(sum_debits.total_debit, 0) as balance_if_credit'),
            )
            ->leftJoin('chart_of_account_categories', 'chart_of_account_categories.id', '=', 'chart_of_accounts.chart_of_account_category_id')
            ->leftJoinSub($sum_debits, 'sum_debits', 'chart_of_accounts.id', '=', 'sum_debits.chart_of_account_id')
            ->leftJoinSub($sum_credits, 'sum_credits', 'chart_of_accounts.id', '=', 'sum_credits.chart_of_account_id')
            ->where('chart_of_account_categories.category', 'Cash')
            ->where('chart_of_accounts.accounting_system_id', session('accounting_system_id'));

        if($query) {
            $coa->where(function($q) use($query) {
                $q->where('chart_of_accounts.chart_of_account_no', 'LIKE', '%' . $query . '%')
                    ->orWhere('chart_of_accounts.account_name', 'LIKE', '%' . $query . '%');
            });
        }

        return $coa->get();
    }

    function ajaxGetCOAForBeginningBalance()
    {
        // return $this->request->session()->get('accounting_period_id');

        // Get the Beginning Balance Journal Entry
        $je = JournalEntries::where('accounting_system_id', session('accounting_system_id'))
            ->first();

        $jp = JournalPostings::select(
                'chart_of_account_id',
                'journal_entry_id',
                'amount',
                'type',
            )
            ->where('journal_entry_id', $je->id);

        $debits = ChartOfAccounts::select(
            'chart_of_accounts.id',
            'chart_of_accounts.chart_of_account_no',
            'chart_of_accounts.account_name',
            'chart_of_account_categories.category',
            DB::raw('IFNULL(journal_postings.amount, 0) as amount'),
        )
        ->leftJoin('chart_of_account_categories', 'chart_of_accounts.chart_of_account_category_id', 'chart_of_account_categories.id')
        ->leftJoinSub($jp, 'journal_postings', 'chart_of_accounts.id', 'journal_postings.chart_of_account_id')
        ->where('chart_of_accounts.accounting_system_id', session('accounting_system_id'));

        $credits = clone $debits;

        return [
            'debits' => $debits->where('chart_of_account_categories.normal_balance', 'Debit')->get(),
            'credits' => $credits->where('chart_of_account_categories.normal_balance', 'Credit')->get(),
        ];
    }

    public function ajaxSearchCategories($query = null)
    {
        $categories = ChartOfAccountCategory::select(
            'category as value',
            'type', 
            'normal_balance',
        );

        if(isset($query))
            $categories->where('category', 'LIKE', '%' . $query . '%');
    
        return $categories->get();
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\JournalVouchers;
use App\Models\JournalEntries;
use App\Models\JournalPostings;
use App\Models\ChartOfAccounts;
use Illuminate\Http\Request;

class JournalVouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journalVouchers = JournalVouchers::get();
        
        for($i = 0; $i < count($journalVouchers); $i++)
        {
            $journalVouchers[$i]->journalEntry->journalPostings;
            $totalAmount[$i] = $journalVouchers[$i]->journalEntry->journalPostings->where('type', '=', 'debit')->sum('amount');
        }
        // return $journalVouchers;



        return view('journals.index', [
            'journalVouchers' => $journalVouchers,
            'totalAmount' => $totalAmount,
        ]);
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
        // Create a Journal Entry
        $journal_entry = JournalEntries::create([
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        // Create a Journal Voucher Entry
        $journal_voucher = JournalVouchers::create([
            'journal_entry_id' => $journal_entry->id,
            'reference_number' => $request->reference_number,
        ]);

        // Add Journal Postings and Update the COA Balance accordingly.
        // Decode json of item tagify fields.
        // Resulting json_decode will turn into an array of
        // object, thus it has to be merged.

        // Debits
        for($i = 0; $i < count($request->debit_accounts); $i++)
        {
            $item = json_decode($request->debit_accounts[$i]);
            $debit_accounts[$i] = $item[0];

            $coa = ChartOfAccounts::find($debit_accounts[$i]->value);

            // Update Balance
            if($debit_accounts[$i]->normal_balance == 'Debit')
                $updated_balance = $coa->current_balance + $request->debit_amount[$i];
            else
                $updated_balance = $coa->current_balance - $request->debit_amount[$i];

            $coa->update([
                'current_balance' => $updated_balance,
            ]);

            JournalPostings::create([
                'journal_entry_id' => $journal_entry->id,
                'chart_of_account_id' => $debit_accounts[$i]->value,
                'accounting_period_id' => 1, // TODO: temporarily 1 for now
                'type' => 'debit',
                'amount' => $request->debit_amount[$i],
                'updated_balance' => $updated_balance,
            ]);
        }

        // Credits
        for($i = 0; $i < count($request->credit_accounts); $i++)
        {
            $item = json_decode($request->credit_accounts[$i]);
            $credit_accounts[$i] = $item[0];

            $coa = ChartOfAccounts::find($credit_accounts[$i]->value);

            // Update Balance
            if($credit_accounts[$i]->normal_balance == 'Credit')
                $updated_balance = $coa->current_balance + $request->credit_amount[$i];
            else
                $updated_balance = $coa->current_balance - $request->credit_amount[$i];

            $coa->update([
                'current_balance' => $updated_balance,
            ]);

            JournalPostings::create([
                'journal_entry_id' => $journal_entry->id,
                'chart_of_account_id' => $credit_accounts[$i]->value,
                'accounting_period_id' => 1, // TODO: temporarily 1 for now
                'type' => 'credit',
                'amount' => $request->credit_amount[$i],
                'updated_balance' => $updated_balance,
            ]);
        }

        return redirect()->route('journals.index')->with('success', 'Successfully created a journal voucher.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JournalVouchers  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(JournalVouchers $journalVoucher)
    {
        // Call relationships.
        $journalVoucher->journalEntry->journalPostings;

        // Initialize total values.
        $totalDebit = 0;
        $totalCredit = 0;

        for($i = 0; $i < count($journalVoucher->journalEntry->journalPostings); $i++)
        {
            // Call inner relationships each.
            $journalVoucher->journalEntry->journalPostings[$i]->chartOfAccount;

            // Accumulate total
            if($journalVoucher->journalEntry->journalPostings[$i]->type == 'debit')
                $totalDebit += $journalVoucher->journalEntry->journalPostings[$i]->amount;
            else if($journalVoucher->journalEntry->journalPostings[$i]->type == 'credit')
                $totalCredit += $journalVoucher->journalEntry->journalPostings[$i]->amount;
        }
        
        return view('journals.show', [
            'journalVoucher' => $journalVoucher,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JournalVouchers  $journalVouchers
     * @return \Illuminate\Http\Response
     */
    public function edit(JournalVouchers $journalVouchers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JournalVouchers  $journalVouchers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JournalVouchers $journalVouchers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JournalVouchers  $journalVouchers
     * @return \Illuminate\Http\Response
     */
    public function destroy(JournalVouchers $journalVouchers)
    {
        //
    }
}

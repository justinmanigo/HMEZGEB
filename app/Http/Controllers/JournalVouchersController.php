<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalVoucherRequest;
use App\Models\JournalVouchers;
use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\CreateJournalVoucher;
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
        $journalVouchers = JournalVouchers::where('accounting_system_id', session('accounting_system_id'))
            ->get();
        
        for($i = 0; $i < count($journalVouchers); $i++)
        {
            $journalVouchers[$i]->journalEntry->journalPostings;
            $totalAmount[$i] = $journalVouchers[$i]->journalEntry->journalPostings->where('type', '=', 'debit')->sum('amount');
        }

        return view('journals.index', [
            'journalVouchers' => $journalVouchers,
            'totalAmount' => isset($totalAmount) ? $totalAmount : [],
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
    public function store(StoreJournalVoucherRequest $request)
    {     
        $journal_entry = CreateJournalEntry::run($request->date, $request->notes, session('accounting_system_id'));
        $journal_voucher = CreateJournalVoucher::run($journal_entry->id);

        CreateJournalPostings::run($journal_entry, $request->debit_accounts, $request->debit_amount, $request->credit_accounts, $request->credit_amount, session('accounting_system_id'), $request->debit_description, $request->credit_description);

        return $journal_voucher;
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

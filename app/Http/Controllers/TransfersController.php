<?php

namespace App\Http\Controllers;

use App\Models\Transfers;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\BankAccounts;
use App\Models\ChartOfAccounts;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\DecodeTagifyField;
use Illuminate\Support\Facades\Log;
use App\Mail\MailBankTransfer;
use Illuminate\Support\Facades\Mail;
use App\Imports\ImportBankTransfer;
use App\Exports\ExportBankTransfer;
use Maatwebsite\Excel\Facades\Excel;


class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');
        // TODO: Change to use the accounting system id
        $transfers = Transfers::where('accounting_system_id', $accounting_system_id)->get();
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
        // if($request->amount > $fromAccount->chartOfAccount->current_balance){
        //     return redirect()->back()->with('error', 'Cannot transfer more than the balance');
        // }

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
  
        $transactions = Transactions::create([
            'accounting_system_id' => $this->request->session()->get('accounting_system_id'),
            'chart_of_account_id' => $request->from_account_id,
            'type' => 'Transfer',
            'description' => $request->reason,
            'amount' => $request->amount,
        ]);

        Transfers::create([
            'accounting_system_id' => $this->request->session()->get('accounting_system_id'),
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'status' => 'completed',
            'journal_entry_id' => $je->id,
            'transaction_id' =>  $transactions->id,
        ]);


        // create transaction
        Transactions::create([
            'accounting_system_id' => $this->request->session()->get('accounting_system_id'),
            'chart_of_account_id' => $request->from_account_id,
            'type' => 'Transfer',
            'description' => $request->reason,
            'amount' => $request->amount,
        ]);

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
    public function edit($id)
    {
        //Open the form for editing the transfer
          $accounting_system_id = $this->request->session()->get('accounting_system_id');
        
          $transfers = Transfers::where('accounting_system_id', $accounting_system_id)
          ->find($id);
  
          return view('banking.transfers.edit', compact('transfers'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $transfers = Transfers::where('id', $id)->first();
        // Find connected relationships with transfers
        $transactions = Transactions::where('id', $transfers->transaction_id)->first();
        $je = JournalEntries::where('id', $transfers->journal_entry_id)->first();
        
        // Update the transfer/transaction/journal entry description
        $transfers->reason = $request->reason;
        $transactions->description = $request->reason;
        $je->notes = $request->reason;

        $transfers->save();
        $transactions->save();
        $je->save();

        return redirect()->route('transfers.transfer.index')->with('success', 'Transfer has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfers  $transfers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $transfers = Transfers::where('id', $id)->first();
        $transfers->delete();

        return redirect()->route('transfers.transfer.index')->with('success', 'Transfer has been deleted successfully');
    }

    public function void($id)
    {
        $transfers = Transfers::where('id', $id)->first();

        // Find connected relationships with transfers
        $transactions = Transactions::where('id', $transfers->transaction_id)->first();
        $je = JournalEntries::where('id', $transfers->journal_entry_id)->first();

        // deduct and add in coa balances 
        $fromAccount = BankAccounts::find($transfers->from_account_id);
        $toAccount = BankAccounts::find($transfers->to_account_id);

        $fromAccount->chartOfAccount->current_balance += $transfers->amount;
        $toAccount->chartOfAccount->current_balance -= $transfers->amount;
        $fromAccount->chartOfAccount->save();
        $toAccount->chartOfAccount->save();

        $transfers->status = 'void';
        $transfers->journal_entry_id= null;
        $transfers->transaction_id= null;
        $transfers->save();
        $transactions->delete();
        $je->delete();

        return redirect()->route('transfers.transfer.index')->with('success', 'Transfer has been voided successfully');
    }

    // Mail
    public function mail($id)
    {
        $transfers = Transfers::where('id', $id)->first();
        // TODO: Add mail to user;
        $email = "transfer@email.com";
        Mail::to($email)->queue(new MailBankTransfer($transfers));

        return redirect()->back()->with('success', 'Successfully sent email!');
    }

     // Import Export

     public function import(Request $request)
     {
         if (!$request->file('file'))
         {
             return back()->with('error', 'Please select a file');
         }
         try {
           Excel::import(new ImportBankTransfer, $request->file('file'));
           return redirect()->back()->with('success', 'Successfully imported bank transfer records.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');        
        }   
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing bank account');
        }  
 
     }
 
     public function export(Request $request)
     {
         if($request->file_type=="csv")
         return Excel::download(new ExportBankTransfer, 'bankTransfer_'.date('Y_m_d').'.csv');
         else
         $transfers = Transfers::all();
         $pdf = \PDF::loadView('banking.transfers.pdf', compact('transfers'));
         return $pdf->download('bankTransfer_'.date('Y_m_d').'.pdf');
  
     }

    public function queryBank($query)
    {   
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        $bankAccounts = BankAccounts::select(
                'bank_accounts.id as value',
                'bank_accounts.bank_branch',
                'bank_accounts.bank_account_number',
                'chart_of_accounts.chart_of_account_no',
                'chart_of_accounts.account_name',
            )
            ->leftJoin('chart_of_accounts', 'bank_accounts.chart_of_account_id', '=', 'chart_of_accounts.id')
            ->where(function($q) use ($query) {
                $q->where('bank_accounts.bank_branch', 'LIKE', '%'.$query.'%')
                    ->orWhere('bank_accounts.bank_account_number', 'LIKE', '%'.$query.'%')
                    ->orWhere('chart_of_accounts.chart_of_account_no', 'LIKE', '%'.$query.'%')
                    ->orWhere('chart_of_accounts.account_name', 'LIKE', '%'.$query.'%');
            })
            ->where('chart_of_accounts.accounting_system_id', $accounting_system_id)
            ->get();
            
        return $bankAccounts;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BankAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Imports\ImportBankAccount;
use App\Exports\ExportBankAccount;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\Banking\MailBankAccount;
use Illuminate\Support\Facades\Mail;
use PDF;

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
        $bank_accounts = BankAccounts::Join('chart_of_accounts', 'bank_accounts.chart_of_account_id', '=', 'chart_of_accounts.id')
            ->where('chart_of_accounts.accounting_system_id', $this->request->session()->get('accounting_system_id'))
            ->select('bank_accounts.*', 'chart_of_accounts.account_name')->get();


        // $coa_last_record = BankAccounts::orderBy('created_at', 'desc')->first();
        // if (empty($coa_last_record)) {
        //     $coa_number = 1030;
        // } else {
        //     $coa_number = $coa_last_record->chartOfAccount->chart_of_account_no + 1;
        // }
        return view('banking.accounts.index', compact('bank_accounts'));
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
    public function show(BankAccounts $accounts)
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
        try{
            $accounts = BankAccounts::find($id);
            $coa = ChartOfAccounts::find($accounts->chart_of_account_id);       
            $accounts->delete();
            $coa->delete();
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Error deleting bank account. Make sure no related transactions exist.');
        }
        return redirect()->route('accounts.accounts.index')->with('success', 'Bank Account Deleted Successfully');
    }

    // Mail
    public function mail($id)
    {
        $bank_account = BankAccounts::where('id', $id)->first();
        // TODO: Add email to user
        $email = "bank@email.com";
        Mail::to($email)->queue(new MailBankAccount($bank_account));

        return redirect()->back()->with('success', 'Email Sent Successfully!');
    }

    // Print
    public function print($id)
    {
        $account = BankAccounts::find($id);
        
        $pdf = PDF::loadView('banking.accounts.print', compact('account'));
        return $pdf->stream('accounts'.date('Y-m-d').'.pdf');
    }

    // Import Export
    public function import(Request $request)
    {
        try {
            Excel::import(new ImportBankAccount, $request->file('file'));
        } 
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');
        }     
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing bank account');
        }   
        return redirect()->back()->with('success', 'Successfully imported accounts records.');
    }

    // Export
    public function export(Request $request)
    {
       if($request->file_type=="pdf"){
           $accounts = BankAccounts::all();
           $pdf = \PDF::loadView('banking.accounts.pdf', compact('accounts'));
           return $pdf->download('BankAccount_'.date('Y_m_d').'.pdf');
        }
       else
       return Excel::download(new ExportBankAccount, 'settingBankAccount_'.date('Y_m_d').'.csv');
    }

}

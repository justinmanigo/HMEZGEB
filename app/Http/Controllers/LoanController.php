<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Hr\IsAccountingPeriodLocked;
use App\Models\Loan;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Http\Requests\HumanResource\StoreLoanRequest;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loans = Employee::join(
            'loans',
            'loans.employee_id',
            '=',
            'employees.id'
        )->select(
            'loans.id',
            'loans.date',
            'loans.loan',
            'loans.paid_in',
            'employees.first_name',
            'employees.type',
        )->where('loans.accounting_system_id', session('accounting_system_id'))
        ->get();
        return view('hr.loan.index' , compact('loans'));
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
    public function store(StoreLoanRequest $request)
    {       
        for($i = 0; $i < count($request->employee); $i++)
        {
            $debit_accounts = [];
            $debit_amount = [];
            $credit_accounts = [];
            $credit_amount = [];

            // Store
            $loan = new Loan;
            $loan->accounting_system_id = session('accounting_system_id');
            $loan->employee_id = $request->employee[$i]->value;
            $loan->date = $request->date;
            $loan->loan = $request->loan[$i];
            $loan->paid_in = $request->paid_in[$i];
            $loan->description = $request->description;
            $loan->save();

            // Create Journal Entry and Link to Loan
            $je = CreateJournalEntry::run($request->date, $request->description, session('accounting_system_id'));
            $loan->journal_entry_id = $je->id;
            $loan->save();
            
            // Debit 1120 - Employees Advance
            // TODO: Make this feature dynamic (allow changing of accounts, or set default)      
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->employees_advance);
            $debit_amount[] = $request->loan[$i];

            // Credit to Selected Cash Account
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $credit_amount[] = $request->loan[$i];

            // Create Journal Postings
            CreateJournalPostings::run($je, 
                $debit_accounts, $debit_amount, 
                $credit_accounts, $credit_amount,
                session('accounting_system_id'));
        }
        return redirect()->back()->with('success', 'Loan has been successfully added.');
    }

    public function update(Request $request, Loan $loan)
    {
        // Disable create if payroll is generated for current accounting period.
        if(IsAccountingPeriodLocked::run($loan->date))
            return redirect()->back()->with('danger', 'Payroll already created! Unable to update loan in current accounting period.');
          
        // TODO: Implement update loan.
    }

    public function destroy(Loan $loan)
    {
        // Disable create if payroll is generated for current accounting period.
        if(IsAccountingPeriodLocked::run($loan->date))
            return redirect()->back()->with('danger', 'Payroll already created! Unable to delete loan in current accounting period.');
          
        if(isset($loan->payroll_id))
        {
            return redirect()->back()->with('danger', 'Loan already pending in payroll.');
        }
        else
        {
            $loan->delete();
            $loan->journalEntry->delete();
            return redirect()->back()->with('success', 'Loan has been deleted.');
        }          
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Http\Requests\Customer\Deposit\StoreDepositRequest;
use App\Models\Deposits;
use App\Models\DepositItems;
use App\Models\ReceiptCashTransactions;
use App\Models\Transactions;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\ReceiptReferences;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\Customers\MailCustomerDeposit;
use Illuminate\Support\Facades\Mail;
use PDF;

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
            'reference_number' => $request->reference_number,
        ]);

        // create transaction
        Transactions::create([
            'accounting_system_id' => session()->get('accounting_system_id'),
            'chart_of_account_id' => $coa->id,
            'type' => 'Deposit',
            'description' => $request->remark,
            'amount' => $request->total_amount,
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
            $cash_transaction->receiptReference->is_deposited = 'yes';
            $cash_transaction->receiptReference->save();
            $cash_transaction->deposit_id = $deposits->id;
            $cash_transaction->save();

            // Deduct balance from COA for transfer
            $coa_id = $cash_transaction->forReceiptReference->receipt->chart_of_account_id;
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

    // Mail
    public function mailDeposit($id)
    {
        // Mail
        $deposit = Deposits::find($id);
        $emailAddress = "test@test.com";

        Mail::to($emailAddress)->queue(new MailCustomerDeposit($deposit));
        
        return redirect()->route('deposits.deposits.index')->with('success', "Successfully sent email to customer.");

    }

    // Print
    public function printDeposit($id)
    {
        $deposits = Deposits::find($id);
        $pdf = PDF::loadView('customer.deposit.print', compact('deposits'));

        return $pdf->stream('deposit_'.$id.'_'.date('Y-m-d').'.pdf');
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
            ->where('chart_of_accounts.accounting_system_id', session('accounting_system_id'))
            ->where(function($sql) use ($query) {
                $sql->where('chart_of_accounts.account_name', 'LIKE', "%{$query}%")
                    ->orWhere('chart_of_accounts.chart_of_account_no', 'LIKE', "%{$query}%")
                    ->orWhere('bank_accounts.bank_account_number', 'LIKE', "%{$query}%")
                    ->orWhere('bank_accounts.bank_branch', 'LIKE', "%{$query}%");
            })
            ->get();
    }

    public function ajaxGetUndepositedReceipts()
    {
        return ReceiptCashTransactions::select(
                'receipt_cash_transactions.id as value',
                'receipt_references.date',
                'receipt_cash_transactions.amount_received as total_amount_received',
                'receipts.payment_method',
                'customers.name as customer_name',
            )
            ->where('receipt_cash_transactions.accounting_system_id', session('accounting_system_id'))
            ->leftJoin('receipt_references', 'receipt_cash_transactions.receipt_reference_id', '=', 'receipt_references.id')
            ->leftJoin('receipts', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
            ->leftJoin('customers', 'receipt_references.customer_id', '=', 'customers.id')
            ->where('receipt_cash_transactions.deposit_id', '=', NULL)
            ->get();
    }
}
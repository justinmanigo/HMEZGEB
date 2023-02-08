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
use Illuminate\Support\Facades\DB;
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
        $deposit = Deposits::create([
            'accounting_system_id' => session('accounting_system_id'),
            'chart_of_account_id' => $request->bank_account->value,
            'deposit_ticket_date' => $request->deposit_ticket_date,
            'remark' => $request->remark,
            'reference_number' => $request->reference_number,
        ]);

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->deposit_ticket_date, $request->remark, session('accounting_system_id'));

        // Initialize the COAs and Amount from different cash accounts
        $credit_accounts = [];
        $credit_amount = [];

        $coa = [];
        $total_transferred_amount = 0;

        for($i = 0; $i < count($request->is_deposited); $i++)
        {
            // Get the receipt cash transaction entry and load its receipt reference and linked receipt.
            $cash_transaction = ReceiptCashTransactions::find($request->is_deposited[$i]);
            $cash_transaction->receiptReference->receipt;

            // Create deposit item
            DepositItems::create([
                'deposit_id' => $deposit->id,
                'receipt_cash_transaction_id' => $cash_transaction->id,
            ]);

            // Deduct balance from Source's COA for transfer
            $coa_id = $cash_transaction->chart_of_account_id;
            $total_transferred_amount += $cash_transaction->amount_received;
            
            // Find if the Destination's COA is already in the array, then accumulate the amount to it.
            // If not yet, then add the Destination's COA and its amount to the array.
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

        // Stores the COA of Bank
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bank_account->value);
        $debit_amount[] = $total_transferred_amount;

        // Encode the COA of the Source COAs
        for($i = 0; $i < count($credit_accounts); $i++)
            $credit_accounts[$i] = CreateJournalPostings::encodeAccount($credit_accounts[$i]);

        // Create Journal Postings
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
                'receipt_references.type as receipt_type',
            )
            ->where('receipt_cash_transactions.accounting_system_id', session('accounting_system_id'))
            ->leftJoin('receipt_references', 'receipt_cash_transactions.receipt_reference_id', '=', 'receipt_references.id')
            ->leftJoin('receipts', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
            ->leftJoin('customers', 'receipt_references.customer_id', '=', 'customers.id')
            ->leftJoin('deposit_items', 'receipt_cash_transactions.id', '=', 'deposit_items.receipt_cash_transaction_id')
            ->where('deposit_items.id', '=', NULL)
            ->get();
    }
}
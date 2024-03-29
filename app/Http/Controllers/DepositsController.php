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
    public function searchAjax($query = null)
    {
        $deposits = Deposits::select(
            // 'deposits.*',
            'deposits.id',
            'chart_of_accounts.chart_of_account_no',
            'chart_of_accounts.account_name',
            'deposits.deposit_ticket_date as date',
            'deposits.reference_number',
            'deposits.is_direct_deposit',
            DB::raw('IFNULL(deposit_items.total_amount, 0) as total_amount'),
            DB::raw('IFNULL(deposit_items_void.total_void_amount, 0) as total_void_amount'),
        )
        ->leftJoin('chart_of_accounts', 'chart_of_accounts.id', '=', 'deposits.chart_of_account_id')
        // left join by sum of deposit items' amount received
        ->leftJoin(DB::raw('(SELECT deposit_id, SUM(receipt_cash_transactions.amount_received) as total_amount FROM deposit_items LEFT JOIN receipt_cash_transactions ON receipt_cash_transactions.id = deposit_items.receipt_cash_transaction_id GROUP BY deposit_id) as deposit_items'), 'deposit_items.deposit_id', '=', 'deposits.id')
        // left join by sum of deposit items' amount received that are void
        ->leftJoin(DB::raw('(SELECT deposit_id, SUM(receipt_cash_transactions.amount_received) as total_void_amount FROM deposit_items LEFT JOIN receipt_cash_transactions ON receipt_cash_transactions.id = deposit_items.receipt_cash_transaction_id WHERE deposit_items.is_void = 1 GROUP BY deposit_id) as deposit_items_void'), 'deposit_items_void.deposit_id', '=', 'deposits.id')
        ->where('deposits.accounting_system_id', session('accounting_system_id'))
        ->where(function($q) use ($query){
            $q->where('deposits.deposit_ticket_date', 'like', '%'.$query.'%')
                ->orWhere('deposits.reference_number', 'like', '%'.$query.'%')
                ->orWhere('chart_of_accounts.chart_of_account_no', 'like', '%'.$query.'%')
                ->orWhere('chart_of_accounts.account_name', 'like', '%'.$query.'%');
        });

        return response()->json([
            'deposits' => $deposits->paginate(10),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.deposit.index');
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

        // Deposit Item = Journal Entry. It makes marking deposits as void flexible later on.
        for($i = 0; $i < count($request->is_deposited); $i++)
        {
            // Initialize the COAs and Amount from different cash accounts
            $credit_accounts = [];
            $credit_amount = [];
            $debit_accounts = [];
            $debit_amount = [];

            // Create Journal Entry for specific deposit item
            $je = CreateJournalEntry::run($request->deposit_ticket_date, $request->remark, session('accounting_system_id'));

            // Get the receipt cash transaction entry and load its receipt reference and linked receipt.
            $cash_transaction = ReceiptCashTransactions::find($request->is_deposited[$i]);

            // Create deposit item
            DepositItems::create([
                'deposit_id' => $deposit->id,
                'receipt_cash_transaction_id' => $cash_transaction->id,
                'journal_entry_id' => $je->id,
            ]);

            // Deduct the balance of Source COA
            $credit_accounts[] = CreateJournalPostings::encodeAccount($cash_transaction->chart_of_account_id);
            $credit_amount[] = $cash_transaction->amount_received;

            // Add the balance of Destination COA
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bank_account->value);
            $debit_amount[] = $cash_transaction->amount_received;

            // Create Journal Postings of the deposit item
            CreateJournalPostings::run($je,
                $debit_accounts, $debit_amount,
                $credit_accounts, $credit_amount,
                session('accounting_system_id'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Deposit has been created.',
            'deposit' => $deposit,
        ]);
    }

    /**
     *
     */
    public function show(Deposits $deposit)
    {
        $total_amount = 0;
        $total_void_amount = 0;

        $deposit->depositItems;
        $deposit->chartOfAccount;
        for($i = 0; $i < count($deposit->depositItems); $i++) {
            $deposit->depositItems[$i]->receiptCashTransaction->receiptReference->customer;
            $total_amount += $deposit->depositItems[$i]->receiptCashTransaction->amount_received;

            if($deposit->depositItems[$i]->is_void == true) {
                $total_void_amount += $deposit->depositItems[$i]->receiptCashTransaction->amount_received;
            }
        }

        // return $deposit;
        return view('customer.deposit.show', [
            'deposit' => $deposit,
            'total_amount' => $total_amount,
            'total_void_amount' => $total_void_amount,
        ]);
    }

    // Mail
    public function mail(Deposits $deposit)
    {
        $emailAddress = "test@test.com";

        Mail::to($emailAddress)->queue(new MailCustomerDeposit($deposit));

        // return redirect()->route('deposits.deposits.index')->with('success', "Successfully sent email to customer.");

        return response()->json([
            'success' => true,
            'message' => "Successfully sent email to customer.",
        ]);
    }

    // Print
    public function print(Deposits $deposit)
    {
        $pdf = PDF::loadView('customer.deposit.print', compact('deposit'));

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

<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\JournalVouchers;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportsController extends Controller
{
    // Nav View controller
    public function customers()
    {       
        return view('reports.customers.index');
    }

    public function vendors()
    {
        return view('reports.vendors.index');
    }

    public function sales()
    {
        return view('reports.sales.index');
    }

    public function entries()
    {
        return view('reports.entries.index');
    }

    public function financial_statement()
    {
        return view('reports.financial_statement.index');
    }

    // PDF
    // TODO: Add date today on file name
    // Customers
    public function agedReceivablePDF(Request $request)
    {
        // Subquery
        $r = DB::table('receipt_references')
                ->select(
                    'receipt_references.date',
                    'receipts.due_date',
                    'customers.id as customer_id', // needed for grouping
                    'receipt_references.id as receipt_reference_id',
                    'customers.name as customer_name',
                    DB::raw("CASE WHEN CURRENT_DATE() < receipts.due_date THEN receipts.grand_total - receipts.total_amount_received ELSE 0 END AS 'current'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > receipts.due_date AND CURRENT_DATE() < DATE_ADD(receipts.due_date, INTERVAL 30 DAY) THEN receipts.grand_total - receipts.total_amount_received ELSE 0 END AS 'thirty_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(receipts.due_date, INTERVAL 30 DAY) AND CURRENT_DATE() < DATE_ADD(receipts.due_date, INTERVAL 60 DAY) THEN receipts.grand_total - receipts.total_amount_received ELSE 0 END AS 'sixty_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(receipts.due_date, INTERVAL 60 DAY) AND CURRENT_DATE() < DATE_ADD(receipts.due_date, INTERVAL 90 DAY) THEN receipts.grand_total - receipts.total_amount_received ELSE 0 END AS 'ninety_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(receipts.due_date, INTERVAL 90 DAY) THEN receipts.grand_total - receipts.total_amount_received ELSE 0 END AS 'over_ninety_days'"),
                )
                ->leftJoin('customers', 'customers.id', '=', 'receipt_references.customer_id')
                ->leftJoin('receipts', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
                ->where('is_void', '=', 'no')
                ->where('type', '=', 'receipt')
                ->where('receipt_references.accounting_system_id', '=', session('accounting_system_id'))
                ->where('status', '!=', 'paid')
                ->whereBetween('date', [$request->date_from, $request->date_to]);
                

        if($request->type == 'summary') {
            $results = DB::table('customers')
                ->select(
                    'customers.id as id',
                    'customers.name as name',
                    DB::raw('coalesce(SUM(current), 0) as current'),
                    DB::raw('coalesce(SUM(thirty_days), 0) as thirty_days'),
                    DB::raw('coalesce(SUM(sixty_days), 0) as sixty_days'),
                    DB::raw('coalesce(SUM(ninety_days), 0) as ninety_days'),
                    DB::raw('coalesce(SUM(over_ninety_days), 0) as over_ninety_days'),
                    DB::raw('coalesce(SUM(current), 0) + coalesce(SUM(thirty_days), 0) + coalesce(SUM(sixty_days), 0) + coalesce(SUM(ninety_days), 0) + coalesce(SUM(over_ninety_days), 0) as total'),
                )
                ->leftJoinSub($r, 'r', function($join){
                    $join->on('r.customer_id', '=', 'customers.id');
                })
                ->where('customers.accounting_system_id', '=', session('accounting_system_id'))
                ->groupBy('customers.id', 'customers.name')
                ->orderBy('customers.name', 'asc')
                ->get();

            $pdf = \PDF::loadView('reports.customers.pdf.aged_receivable.summary', compact('request'), compact('results'));
        }
        else if($request->type == 'detailed') {
            $results = $r->orderBy('customers.id', 'asc')->orderBy('receipt_references.id', 'asc')->get();

            $pdf = \PDF::loadView('reports.customers.pdf.aged_receivable.detailed', compact('request'), compact('results'));
        }

        return $pdf->stream('aged_receivable.pdf');
    }
    
    public function cashReceiptsJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.cash_receipts_journal', compact('request'));
        return $pdf->stream('cash_receipts_journal.pdf');
    }

    public function customerLedgersPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.customers_ledgers', compact('request'));
        return $pdf->stream('customer_ledgers.pdf');
    }
    
    // Vendors
    public function agedPayablesPDF(Request $request)
    {
        // Subquery
        $r = DB::table('payment_references')
                ->select(
                    'payment_references.date',
                    'bills.due_date',
                    'vendors.id as vendor_id', // needed for grouping
                    'payment_references.id as payment_reference_id',
                    'vendors.name as vendor_name',
                    DB::raw("CASE WHEN CURRENT_DATE() < bills.due_date THEN bills.grand_total - bills.amount_received ELSE 0 END AS 'current'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > bills.due_date AND CURRENT_DATE() < DATE_ADD(bills.due_date, INTERVAL 30 DAY) THEN bills.grand_total - bills.amount_received ELSE 0 END AS 'thirty_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(bills.due_date, INTERVAL 30 DAY) AND CURRENT_DATE() < DATE_ADD(bills.due_date, INTERVAL 60 DAY) THEN bills.grand_total - bills.amount_received ELSE 0 END AS 'sixty_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(bills.due_date, INTERVAL 60 DAY) AND CURRENT_DATE() < DATE_ADD(bills.due_date, INTERVAL 90 DAY) THEN bills.grand_total - bills.amount_received ELSE 0 END AS 'ninety_days'"),
                    DB::raw("CASE WHEN CURRENT_DATE() > DATE_ADD(bills.due_date, INTERVAL 90 DAY) THEN bills.grand_total - bills.amount_received ELSE 0 END AS 'over_ninety_days'"),
                )
                ->leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
                ->leftJoin('bills', 'payment_references.id', '=', 'bills.payment_reference_id')
                ->where('is_void', '=', 'no')
                ->where('type', '=', 'bill')
                ->where('payment_references.accounting_system_id', '=', session('accounting_system_id'))
                ->where('status', '!=', 'paid')
                ->whereBetween('date', [$request->date_from, $request->date_to]);

        if($request->type == 'summary') {
            $results = DB::table('vendors')
                ->select(
                    'vendors.id as id',
                    'vendors.name as name',
                    DB::raw('coalesce(SUM(current), 0) as current'),
                    DB::raw('coalesce(SUM(thirty_days), 0) as thirty_days'),
                    DB::raw('coalesce(SUM(sixty_days), 0) as sixty_days'),
                    DB::raw('coalesce(SUM(ninety_days), 0) as ninety_days'),
                    DB::raw('coalesce(SUM(over_ninety_days), 0) as over_ninety_days'),
                    DB::raw('coalesce(SUM(current), 0) + coalesce(SUM(thirty_days), 0) + coalesce(SUM(sixty_days), 0) + coalesce(SUM(ninety_days), 0) + coalesce(SUM(over_ninety_days), 0) as total'),
                )
                ->leftJoinSub($r, 'r', function($join){
                    $join->on('r.vendor_id', '=', 'vendors.id');
                })
                ->where('vendors.accounting_system_id', '=', session('accounting_system_id'))
                ->groupBy('vendors.id', 'vendors.name')
                ->orderBy('vendors.name', 'asc')
                ->get();

            $pdf = \PDF::loadView('reports.vendors.pdf.aged_payables.summary', compact('request'), compact('results'));
        }
        else if($request->type == 'detailed') {
            $results = $r->orderBy('vendors.id', 'asc')->orderBy('payment_references.id', 'asc')->get();

            $pdf = \PDF::loadView('reports.vendors.pdf.aged_payables.detailed', compact('request'), compact('results'));
        }

        return $pdf->stream('aged_payables.pdf');
    }

    public function cashDisbursementsJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_disbursements_journal', compact('request'));
        return $pdf->stream('cash_disbursements_journal.pdf');
    }

    public function cashRequirementsPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_requirements', compact('request'));
        return $pdf->stream('cash_requirements.pdf');
    }

    public function vendorLedgersPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.vendor_ledgers', compact('request'));
        return $pdf->stream('vendor_ledgers.pdf');
    }

    // Sales
    public function salesPDF(Request $request)
    {
        if($request->group_by == 'all') 
        {
            $results = DB::table('receipt_items')
                ->select(
                    'receipt_references.date',
                    'receipt_items.inventory_id',
                    'receipt_references.id as reference',
                    'customers.name as customer',
                    'inventories.item_name',
                    // '', // TODO: add commission agent
                    'receipt_items.quantity',
                    'receipt_items.total_price',
                )
                ->leftJoin('receipt_references', 'receipt_references.id', '=', 'receipt_items.receipt_reference_id')
                ->leftJoin('inventories', 'inventories.id', 'receipt_items.inventory_id')
                ->leftJoin('customers', 'customers.id', 'receipt_references.customer_id')
                ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
                ->whereBetween('date', [$request->date_from, $request->date_to])
                ->get();

            $pdf = \PDF::loadView('reports.sales.pdf.all', compact('request', 'results'));
        }
        else if($request->group_by == 'customer') {
            $results = DB::table('receipt_items')
                ->select(
                    'customers.name as customer',
                    DB::raw('SUM(receipt_items.total_price) as total_amount'),
                )
                ->leftJoin('receipt_references', 'receipt_references.id', '=', 'receipt_items.receipt_reference_id')
                ->leftJoin('inventories', 'inventories.id', 'receipt_items.inventory_id')
                ->leftJoin('customers', 'customers.id', 'receipt_references.customer_id')
                ->groupBy('customers.id', 'customers.name')
                ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
                ->whereBetween('date', [$request->date_from, $request->date_to])
                ->get();

            $pdf = \PDF::loadView('reports.sales.pdf.by-customer', compact('request', 'results'));
        }
        else if($request->group_by == 'item') {
            $results = DB::table('receipt_items')
                ->select(
                    'receipt_items.inventory_id',
                    'inventories.item_name',
                    DB::raw('SUM(receipt_items.quantity) as quantity_sold'),
                    DB::raw('SUM(receipt_items.total_price) as total_amount'),
                )
                ->leftJoin('receipt_references', 'receipt_references.id', '=', 'receipt_items.receipt_reference_id')
                ->leftJoin('inventories', 'inventories.id', 'receipt_items.inventory_id')
                ->groupBy('receipt_items.inventory_id', 'inventories.item_name')
                ->where('receipt_references.accounting_system_id', session('accounting_system_id'))
                ->whereBetween('date', [$request->date_from, $request->date_to])
                ->get();

            $pdf = \PDF::loadView('reports.sales.pdf.by-item', compact('request', 'results'));
        }
        else if($request->group_by == 'commission_agent') {
            
        }

        // $pdf = \PDF::loadView('reports.sales.pdf.sales', compact('request'));
        return $pdf->stream('sales.pdf');
    }

    // Entries
    public function generalLedgerPDF(Request $request)
    {
        $r = DB::table('chart_of_accounts')
            ->select(
                'chart_of_accounts.id as coa_id',
                'chart_of_accounts.chart_of_account_no as coa_no',
                'chart_of_accounts.account_name as coa_name',
            )
            // ->whereBetween('date', [$request->date_from, $request->date_to])
            ->where('accounting_system_id', '=', session('accounting_system_id'))
            ->get();

        for($i = 0; $i < count($r); $i++)
        {
            $jp_d[$i] = DB::table('journal_entries')
                ->select(
                    'journal_entries.id as id',
                    'journal_entries.date as date',
                    'journal_postings.amount',
                )
                ->leftJoin('journal_postings', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->leftJoin('chart_of_accounts', 'journal_postings.chart_of_account_id', '=', 'chart_of_accounts.id')
                ->orderBy('journal_entries.date', 'asc')
                ->whereBetween('date', [$request->date_from, $request->date_to])
                ->where('chart_of_accounts.id', '=', $r[$i]->coa_id)
                ->where('journal_postings.type', 'debit')
                ->get();

            $jp_c[$i] = DB::table('journal_entries')
                ->select(
                    'journal_entries.id as id',
                    'journal_entries.date as date',
                    'journal_postings.amount',
                )
                ->leftJoin('journal_postings', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
                ->leftJoin('chart_of_accounts', 'journal_postings.chart_of_account_id', '=', 'chart_of_accounts.id')
                ->orderBy('journal_entries.date', 'asc')
                ->whereBetween('date', [$request->date_from, $request->date_to])
                ->where('chart_of_accounts.id', '=', $r[$i]->coa_id)
                ->where('journal_postings.type', 'credit')
                ->get();
        }

        // return [
        //     $r,
        //     $jp_d,
        //     $jp_c,
        // ];

        $pdf = \PDF::loadView('reports.entries.pdf.general_ledger', compact('request', 'r', 'jp_d', 'jp_c'));
        return $pdf->stream('general_ledger.pdf');
    }

    public function generalJournalPDF(Request $request)
    {
        $results = DB::table('journal_entries')
            ->select(
                'journal_entries.id as id',
                'journal_entries.date as date',
                'chart_of_accounts.chart_of_account_no as account_no',
                'chart_of_accounts.account_name as account_name',
                DB::raw("CASE WHEN journal_postings.type = 'debit' THEN journal_postings.amount ELSE 0 END AS 'debit'"),
                DB::raw("CASE WHEN journal_postings.type = 'credit' THEN journal_postings.amount ELSE 0 END AS 'credit'"),
            )
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->where('journal_entries.accounting_system_id', '=', session('accounting_system_id'))
            ->leftJoin('journal_postings', 'journal_entries.id', '=', 'journal_postings.journal_entry_id')
            ->leftJoin('chart_of_accounts', 'journal_postings.chart_of_account_id', '=', 'chart_of_accounts.id')
            ->orderBy('journal_entries.date', 'asc')
            ->get();

        $pdf = \PDF::loadView('reports.entries.pdf.general_journal', compact('request', 'results'));
        return $pdf->stream('general_journal.pdf');
    }

    public function receiptPDF(Request $request)
    {
        $results = DB::table('receipt_references')
            ->select(
                'receipt_references.date',
                'receipt_references.id',
                'customers.name as customer_name',
                'receipts.remark',
                'receipts.tax',
                'receipts.discount',
                'receipts.withholding',
                'receipts.grand_total',
                'receipts.total_amount_received',
            )
            ->leftJoin('receipts', 'receipt_references.id', '=', 'receipts.receipt_reference_id')
            ->leftJoin('customers', 'receipt_references.customer_id', '=', 'customers.id')
            ->where('receipt_references.type', '=', 'receipt')
            ->where('receipt_references.is_void', '=', 'no')
            ->whereBetween('receipt_references.date', [$request->date_from, $request->date_to])
            ->where('receipt_references.accounting_system_id', '=', session('accounting_system_id'))
            ->get();

        $pdf = \PDF::setPaper('a4', 'landscape')->loadView('reports.entries.pdf.receipt', compact('request', 'results'));
        return $pdf->stream('receipt.pdf');
    }

    public function billPDF(Request $request)
    {
        $results = DB::table('payment_references')
            ->select(
                'payment_references.date',
                'payment_references.id',
                'vendors.name as vendor_name',
                'payment_references.remark',
                'bills.tax',
                'bills.discount',
                'bills.withholding',
                'bills.grand_total',
                'bills.amount_received',
            )
            ->leftJoin('bills', 'payment_references.id', '=', 'bills.payment_reference_id')
            ->leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
            ->where('payment_references.type', '=', 'bill')
            ->where('payment_references.is_void', '=', 'no')
            ->whereBetween('payment_references.date', [$request->date_from, $request->date_to])
            ->where('payment_references.accounting_system_id', '=', session('accounting_system_id'))
            ->get();

        $pdf = \PDF::setPaper('a4', 'landscape')->loadView('reports.entries.pdf.bill', compact('request', 'results'));
        return $pdf->stream('bill.pdf');
    }
    
    public function paymentPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.payment', compact('request'));
        return $pdf->stream('payment.pdf');
    }

    public function journalVoucherPDF(Request $request)
    {
        $results = DB::table('journal_vouchers')
            ->select(
                'journal_entries.date as date',
                'journal_vouchers.id as id',
                'chart_of_accounts.chart_of_account_no as account_no',
                'chart_of_accounts.account_name as account_name',
                'journal_entries.notes as description', // TODO: Fix this.
                DB::raw("CASE WHEN journal_postings.type = 'debit' THEN journal_postings.amount ELSE 0 END AS 'debit'"),
                DB::raw("CASE WHEN journal_postings.type = 'credit' THEN journal_postings.amount ELSE 0 END AS 'credit'"),
            )
            ->leftJoin('journal_entries', 'journal_vouchers.journal_entry_id', '=', 'journal_entries.id')
            ->leftJoin('journal_postings', 'journal_postings.journal_entry_id', '=', 'journal_entries.id')
            ->leftJoin('chart_of_accounts', 'chart_of_accounts.id', '=', 'journal_postings.chart_of_account_id')
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->where('journal_entries.accounting_system_id', session('accounting_system_id'))
            ->orderBy('journal_vouchers.id')
            ->get();

        $pdf = \PDF::loadView('reports.entries.pdf.journal_voucher', compact('request','results'));
        return $pdf->stream('journal_voucher.pdf');
    }
    
    // Financial Statement
    public function balanceSheetPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.balance_sheet', compact('request'));
        return $pdf->stream('balance_sheet.pdf');
    }

    public function balanceSheetZeroAccountPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.balance_sheet_zero_account', compact('request'));
        return $pdf->stream('balance_sheet_zero_account.pdf');
    }
    
    public function incomeStatementSinglePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.income_statement_single', compact('request'));
        return $pdf->stream('income_statement_single.pdf');
    }

    public function incomeStatementMultiplePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.income_statement_multiple', compact('request'));
        return $pdf->stream('income_statement_multiple.pdf');
    }

  
}

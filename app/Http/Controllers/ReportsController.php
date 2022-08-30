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
        $pdf = \PDF::loadView('reports.vendors.pdf.aged_payables', compact('request'));
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
        $pdf = \PDF::loadView('reports.sales.pdf.sales', compact('request'));
        return $pdf->stream('sales.pdf');
    }

    // Entries
    public function generalLedgerPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.general_ledger', compact('request'));
        return $pdf->stream('general_ledger.pdf');
    }

    public function generalJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.general_journal', compact('request'));
        return $pdf->stream('general_journal.pdf');
    }

    public function receiptPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.receipt', compact('request'));
        return $pdf->stream('receipt.pdf');
    }

    public function billPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.bill', compact('request'));
        return $pdf->stream('bill.pdf');
    }
    
    public function paymentPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.payment', compact('request'));
        return $pdf->stream('payment.pdf');
    }

    public function journalVoucherPDF(Request $request)
    {
        $journalVouchers = JournalVouchers::all();
        // sum debit credit amount
        $totalDebit = JournalPostings::where('type', '=', 'debit')->sum('amount');
        $totalCredit = JournalPostings::where('type', '=', 'credit')->sum('amount'); 

        $pdf = \PDF::loadView('reports.entries.pdf.journal_voucher', compact('request','journalVouchers','totalDebit','totalCredit'));
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

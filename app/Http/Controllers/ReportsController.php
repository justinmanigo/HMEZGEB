<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\JournalVouchers;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
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
        $pdf = \PDF::loadView('reports.customers.pdf.aged_receivable', compact('request'));
        return $pdf->download('aged_receivable.pdf');
    }
    
    public function cashReceiptsJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.cash_receipts_journal', compact('request'));
        return $pdf->download('cash_receipts_journal.pdf');
    }

    public function customerLedgersPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.customers_ledgers', compact('request'));
        return $pdf->download('customer_ledgers.pdf');
    }
    
    // Vendors
    public function agedPayablesPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.aged_payables', compact('request'));
        return $pdf->download('aged_payables.pdf');
    }

    public function cashDisbursementsJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_disbursements_journal', compact('request'));
        return $pdf->download('cash_disbursements_journal.pdf');
    }

    public function cashRequirementsPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_requirements', compact('request'));
        return $pdf->download('cash_requirements.pdf');
    }

    public function vendorLedgersPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.vendor_ledgers', compact('request'));
        return $pdf->download('vendor_ledgers.pdf');
    }

    // Sales
    public function salesPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.sales.pdf.sales', compact('request'));
        return $pdf->download('sales.pdf');
    }

    // Entries
    public function generalLedgerPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.general_ledger', compact('request'));
        return $pdf->download('general_ledger.pdf');
    }

    public function generalJournalPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.general_journal', compact('request'));
        return $pdf->download('general_journal.pdf');
    }

    public function receiptPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.receipt', compact('request'));
        return $pdf->download('receipt.pdf');
    }

    public function billPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.bill', compact('request'));
        return $pdf->download('bill.pdf');
    }
    
    public function paymentPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.entries.pdf.payment', compact('request'));
        return $pdf->download('payment.pdf');
    }

    public function journalVoucherPDF(Request $request)
    {
        $journalVouchers = JournalVouchers::all();
        // sum debit credit amount
        $totalDebit = JournalPostings::where('type', '=', 'debit')->sum('amount');
        $totalCredit = JournalPostings::where('type', '=', 'credit')->sum('amount'); 

        $pdf = \PDF::loadView('reports.entries.pdf.journal_voucher', compact('request','journalVouchers','totalDebit','totalCredit'));
        return $pdf->download('journal_voucher.pdf');
    }
    
    // Financial Statement
    public function balanceSheetPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.balance_sheet', compact('request'));
        return $pdf->download('balance_sheet.pdf');
    }

    public function balanceSheetZeroAccountPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.balance_sheet_zero_account', compact('request'));
        return $pdf->download('balance_sheet_zero_account.pdf');
    }
    
    public function incomeStatementSinglePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.income_statement_single', compact('request'));
        return $pdf->download('income_statement_single.pdf');
    }

    public function incomeStatementMultiplePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.income_statement_multiple', compact('request'));
        return $pdf->download('income_statement_multiple.pdf');
    }

  
}

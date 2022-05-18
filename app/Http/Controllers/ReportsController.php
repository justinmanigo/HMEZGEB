<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
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
    // Customers
    public function agedReceivablePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.aged_receivable', compact('request'));
        return $pdf->download('aged_receivable.pdf');
    }
    
    public function cashReceiptsPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_receipts', compact('request'));
        return $pdf->download('cash_receipts.pdf');
    }

    public function customersLedgers(Request $request)
    {
        $pdf = \PDF::loadView('reports.sales.pdf.customers_ledgers', compact('request'));
        return $pdf->download('customers_ledgers.pdf');
    }
    
    // Vendors
    public function agedPayablePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.aged_payable', compact('request'));
        return $pdf->download('aged_payable.pdf');
    }

    public function cashDisbursementsPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.vendors.pdf.cash_disbursements', compact('request'));
        return $pdf->download('cash_disbursements.pdf');
    }

    public function cashRequirementsPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.sales.pdf.cash_requirements', compact('request'));
        return $pdf->download('cash_requirements.pdf');
    }

    public function vendorsLedgersPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.sales.pdf.vendors_ledgers', compact('request'));
        return $pdf->download('vendors_ledgers.pdf');
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
        $pdf = \PDF::loadView('reports.entries.pdf.journal_voucher', compact('request'));
        return $pdf->download('journal_voucher.pdf');
    }
    
    // Financial Statement
    public function balanceSheetPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.balance_sheet', compact('request'));
        return $pdf->download('balance_sheet.pdf');
    }
    
    public function incomeStatementPDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.financial_statement.pdf.income_statement', compact('request'));
        return $pdf->download('income_statement.pdf');
    }

  
}

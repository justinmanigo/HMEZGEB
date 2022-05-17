<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use PDF;

class ReportsController extends Controller
{
    // function for customers view
    public function customers()
    {       
        return view('reports.customers.index');
    }

    // function for vendors view
    public function vendors()
    {
        return view('reports.vendors.index');
    }

    // function for sales
    public function sales()
    {
        return view('reports.sales.index');
    }

    // function for entries
    public function entries()
    {
        return view('reports.entries.index');
    }

    // function for financial statement
    public function financial_statement()
    {
        return view('reports.financial_statement.index');
    }

    // PDF
    public function agedReceivablePDF(Request $request)
    {
        $pdf = \PDF::loadView('reports.customers.pdf.aged_receivable', compact('request'));
        return $pdf->download('aged_receivable.pdf');
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reports.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }
}

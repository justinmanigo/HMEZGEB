<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.taxes.index', [
            'taxes' => Tax::get()
        ]);
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
        // Create Tax
        Tax::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);

        return back()->with('success', 'Successfully created tax record.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        // TODO: Add restriction when already linked to another . . .

        // Update Tax
        Tax::where('id', '=', $tax->id)
            ->update([
                'name' => $request->name,
                'percentage' => $request->percentage,
            ]);

        return back()->with('success', 'Successfully updated tax record.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        // TODO: Add restriction

        // Delete Tax
        Tax::where('id', '=', $tax->id)
            ->delete();

        return back()->with('success', 'Successfully deleted tax reccord.');
    }

    /*===========================*/

    /**
     * Returns the specified resource queried from routes.
     * 
     * @param \App\models\Tax $tax
     * @return \App\models\Tax $tax
     */
    public function ajaxGetTax(Tax $tax)
    {
        return $tax;
    }
}

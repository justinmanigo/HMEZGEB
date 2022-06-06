<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\Withholding\Withholding;

class WithholdingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        return view('settings.withholding.index', [
            'withholdings' => Withholding::where('accounting_system_id', $accounting_system_id)->get()
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
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        // Create Withholding
        Withholding::create([
            'accounting_system_id' => $accounting_system_id,
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);

        return back()->with('success', 'Successfully created withholding record.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withholding  $withholding
     * @return \Illuminate\Http\Response
     */
    public function show(Withholding $withholding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withholding  $withholding
     * @return \Illuminate\Http\Response
     */
    public function edit(Withholding $withholding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withholding  $withholding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withholding $withholding)
    {
        // TODO: Add restriction when already linked to another . . .

        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        // Update Tax
        Withholding::where('id', '=', $withholding->id)
            ->where('accounting_system_id', '=', $accounting_system_id)
            ->update([
                'name' => $request->name,
                'percentage' => $request->percentage,
            ]);

        return back()->with('success', 'Successfully updated withholding record.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withholding  $withholding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withholding $withholding)
    {
        // TODO: Add restriction

        // Delete Tax
        Withholding::where('id', '=', $withholding->id)
            ->delete();

        return back()->with('success', 'Successfully deleted withholding reccord.');
    }

    /*===========================*/

    /**
     * Returns the specified resource queried from routes.
     * 
     * @param \App\models\Withholding $withholding
     * @return \App\models\Withholding $withholding
     */
    public function ajaxGetWithholding(Withholding $withholding)
    {
        return $withholding;
    }
}

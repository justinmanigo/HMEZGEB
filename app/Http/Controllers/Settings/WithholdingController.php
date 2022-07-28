<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\Withholding\Withholding;
use App\Imports\ImportSettingWithholding;
use App\Exports\ExportSettingWithholding;
use Maatwebsite\Excel\Facades\Excel;

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

    // Import

    public function import(Request $request)
    {
        try {
            Excel::import(new ImportSettingWithholding, $request->file('file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: Cannot import withholding records. Make sure you have the correct format.');
        }        
        return redirect()->back()->with('success', 'Successfully imported withholding records.');
    }

    // Export
    public function export(Request $request)
    {
       if($request->type=="excel")
            return Excel::download(new ExportSettingWithholding, 'settingWithholding_'.date('Y_m_d').'.xlsx');
        else
        $withholdings = Withholding::all();
        $pdf = \PDF::loadView('settings.withholding.pdf', compact('withholdings'));

        return $pdf->download('settingWithholding_'.date('Y_m_d').'.pdf');

    }

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

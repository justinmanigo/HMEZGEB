<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\Taxes\Tax;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportSettingTax;
use App\Exports\ExportSettingTax;
use Maatwebsite\Excel\Facades\Excel;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        return view('settings.taxes.index', [
            'taxes' => Tax::where('accounting_system_id', $accounting_system_id)->get()
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

        // Create Tax
        Tax::create([
            'accounting_system_id' => $accounting_system_id,
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

        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        // Update Tax
        Tax::where('id', '=', $tax->id)
            ->where('accounting_system_id', '=', $accounting_system_id)
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

    // Import

    public function import(Request $request)
    {
        try {
            Excel::import(new ImportSettingTax, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $message = $failures[0]->errors();
            return back()->with('error', $message[0].' Please check the file format');
        }  
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing bank account');
        }       
        return redirect()->back()->with('success', 'Successfully imported tax records.');
    }

    // Export
    public function export(Request $request)
    {
       if($request->type=="csv")
            return Excel::download(new ExportSettingTax, 'settingTax_'.date('Y_m_d').'.csv');
        else
        $taxes = Tax::all();
        $pdf = \PDF::loadView('settings.taxes.pdf', compact('taxes'));

        return $pdf->download('settingTax_'.date('Y_m_d').'.pdf');

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

    /**
     * 
     */
    public function ajaxSearchTax($query)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        return Tax::select(
                'id as value',
                DB::raw('CONCAT(name, " (", percentage, "%)") as label'),
                'name',
                'percentage',
            )
            ->where('accounting_system_id', '=', $accounting_system_id)
            ->where('name', 'like', '%' . $query . '%')
            ->get();
    }
}

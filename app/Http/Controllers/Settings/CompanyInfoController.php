<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyInfoRequest;
use App\Models\AccountingSystem;

class CompanyInfoController extends Controller
{
    public function index()
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        return view('settings.company_info.index', [
            'accounting_system' => AccountingSystem::find($accounting_system_id),
        ]);
    }

    public function updateAjax(UpdateCompanyInfoRequest $request)
    {
        $accounting_system_id = $this->request->session()->get('accounting_system_id');

        $accounting_system = AccountingSystem::find($accounting_system_id);

        $accounting_system->update($request->all());

        return 'success';
    }
}

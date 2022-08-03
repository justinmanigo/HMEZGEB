<?php

namespace App\Exports;

use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportSettingChartOfAccount implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $coa = ChartOfAccounts::all();
        $coa->prepend(['id','accounting_system_id','chart_of_account_category_id', 'chart_of_account_no','account_name','current_balance', 'status', 'created_at', 'updated_at']);
        return $coa;
    }
}

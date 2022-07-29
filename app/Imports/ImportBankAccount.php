<?php

namespace App\Imports;

use App\Models\BankAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBankAccount implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $coa = new ChartOfAccounts();
        $coa->accounting_system_id = $row['accounting_system_id'];
        $coa->chart_of_account_category_id = $row['chart_of_account_category_id'];;
        $coa->chart_of_account_no = $row['chart_of_account_no'];;
        $coa->account_name = $row['account_name'];;
        $coa->current_balance = 0.00;
        $coa->save();

        return new BankAccounts([
            //
            'chart_of_account_id' => $coa->id,
            'bank_branch' => $row['bank_branch'],
            'bank_account_number' => $row['bank_account_number'],
            'bank_account_type' => $row['bank_account_type'],
        ]);
    }
}

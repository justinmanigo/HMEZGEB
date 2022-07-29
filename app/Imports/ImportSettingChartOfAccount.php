<?php

namespace App\Imports;

use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccountCategory;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\Settings\ChartOfAccounts\JournalPostings;


class ImportSettingChartOfAccount implements ToModel, WithHeadingRow
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
        $coa->chart_of_account_category_id = $row['chart_of_account_category_id'];
        $coa->chart_of_account_no = $row['chart_of_account_no'];
        $coa->account_name = $row['account_name'];  
        $coa->save();

        $coa_category = ChartOfAccountCategory::find($row['chart_of_account_category_id']);
        // Get Beginning Balance Journal Entry
        $je = JournalEntries::where('accounting_system_id', $row['accounting_system_id'])
        ->first();
          
        // Create Journal Posting linked to the Beginning Balance
        $jp = JournalPostings::create([
              'accounting_system_id' => $row['accounting_system_id'],
              'journal_entry_id' => $je->id,
              'chart_of_account_id' => $coa->id,
              'type' => $coa_category->normal_balance == 'Debit' ? 'debit' : 'credit',
              'amount' => 0.00,
          ]);

          return $jp;
    }
}

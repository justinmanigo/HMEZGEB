<?php

namespace App\Imports;

use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccountCategory;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;


class ImportSettingChartOfAccount implements ToModel, WithHeadingRow, WithValidation
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

    public function rules(): array
    {
        return [
            'accounting_system_id' => 'required|numeric|exists:accounting_systems,id',
            'chart_of_account_category_id' => 'required|numeric|exists:chart_of_accounts,id',
            'chart_of_account_no' => 'required|numeric',
            'account_name' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id is required.',
            'accounting_system_id.numeric' => 'The accounting system id must be numeric.',
            'accounting_system_id.exists' => 'The accounting system id must exist.',
            'chart_of_account_category_id.required' => 'The chart of account id is required.',
            'chart_of_account_category_id.numeric' => 'The chart of account id must be numeric.',
            'chart_of_account_category_id.exists' => 'The chart of account id must exist.',
            'chart_of_account_no.required' => 'The to account id is required.',
            'chart_of_account_no.numeric' => 'The to account id must be numeric.',
            'account_name.required' => 'The account name is required.',
            'account_name.max' => 'The name may not be greater than 255 characters.',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\BankAccounts;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportBankAccount implements ToModel, WithHeadingRow, WithValidation 
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

    public function rules(): array
    {
        return [
            'accounting_system_id' => 'required|integer|exists:accounting_systems,id',
            'chart_of_account_category_id' => 'required|integer|exists:chart_of_account_categories,id',
            'chart_of_account_no' => 'required|integer|max:255',
            'account_name' => 'required|string|max:255',
            'bank_branch' => 'required|string|max:255',
            'bank_account_number' => 'required|integer|max:255|unique:bank_accounts',
            'bank_account_type' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id field is required.',
            'accounting_system_id.integer' => 'The accounting system id must be an integer.',
            'accounting_system_id.exists' => 'The selected accounting system id is invalid.',
            'chart_of_account_category_id.required' => 'The chart of account category id field is required.',
            'chart_of_account_category_id.integer' => 'The chart of account category id must be an integer.',
            'chart_of_account_category_id.exists' => 'The selected chart of account category id is invalid.',
            'chart_of_account_no.required' => 'The chart of account no field is required.',
            'chart_of_account_no.integer' => 'The chart of account no must be an integer.',
            'chart_of_account_no.max' => 'The chart of account no may not be greater than 255 characters.',
            'account_name.required' => 'The account name field is required.',
            'account_name.string' => 'The account name must not be numerical.',
            'account_name.max' => 'The account name may not be greater than 255 characters.',
            'bank_branch.required' => 'The bank branch field is required.',
            'bank_branch.string' => 'The bank branch must not be numerical.',
            'bank_branch.max' => 'The bank branch may not be greater than 255 characters.',
            'bank_account_number.required' => 'The bank account number field is required.',
            'bank_account_number.integer' => 'The bank account number must be an integer.',
            'bank_account_number.max' => 'The bank account number may not be greater than 255 characters.',
            'bank_account_number.unique' => 'The bank account number has already been taken.',
            'bank_account_type.required' => 'The bank account type field is required.',
            'bank_account_type.string' => 'The bank account type must not be numerical.',
            'bank_account_type.max' => 'The bank account type may not be greater than 255 characters.',
        ];
    }


}

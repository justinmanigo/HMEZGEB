<?php

namespace App\Exports;

use App\Models\BankAccounts;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBankAccount implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bankAccount = BankAccounts::all();
        $bankAccount->prepend(['id','chart_of_account_id', 'bank_branch', 'bank_account_number', 'bank_account_type','created_at', 'updated_at']);
        return $bankAccount;
    }
}

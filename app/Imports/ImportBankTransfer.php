<?php

namespace App\Imports;

use App\Models\Transfers;
use App\Models\Transactions;
use App\Models\BankAccounts;
use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportBankTransfer implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $fromAccount = BankAccounts::find($row['from_account_id']);
        $toAccount = BankAccounts::find($row['to_account_id']);
        
        $debit_accounts[] = CreateJournalPostings::encodeAccount($toAccount->chartOfAccount->id);
        $credit_accounts[] = CreateJournalPostings::encodeAccount($fromAccount->chartOfAccount->id);
        
        $je = CreateJournalEntry::run(now()->format('Y-m-d'), $row['reason'] ?? '', $row['accounting_system_id']);

        CreateJournalPostings::run($je, 
            $debit_accounts, [$row['amount']], 
            $credit_accounts, [$row['amount']], 
            $row['accounting_system_id']
        );
  
        $transactions = Transactions::create([
            'accounting_system_id' => $row['accounting_system_id'],
            'chart_of_account_id' => $row['from_account_id'],
            'type' => 'Transfer',
            'description' => $row['reason'] ?? '',
            'amount' => $row['amount'],
        ]);

        $transfers = Transfers::create([
            //
            'accounting_system_id' => $row['accounting_system_id'],
            'from_account_id' => $row['from_account_id'],
            'to_account_id' => $row['to_account_id'],
            'amount' => $row['amount'],
            'reason' => $row['reason'] ?? '',
            'status' => 'completed',
            'journal_entry_id' => $je->id,
            'transaction_id' =>  $transactions->id,
        ]);

        $fromAccount->chartOfAccount->current_balance -= $row['amount'];
        $toAccount->chartOfAccount->current_balance += $row['amount'];
        $fromAccount->chartOfAccount->save();
        $toAccount->chartOfAccount->save();

        return $transfers;
    }

    public function rules(): array
    {
        return [
            'accounting_system_id' => 'required|numeric|exists:accounting_systems,id',
            'from_account_id' => 'required|numeric|exists:bank_accounts,id',
            'to_account_id' => 'required|numeric|exists:bank_accounts,id',
            'amount' => 'required|numeric',
            'reason' => 'nullable |string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'accounting_system_id.required' => 'The accounting system id is required.',
            'accounting_system_id.numeric' => 'The accounting system id must be numeric.',
            'accounting_system_id.exists' => 'The accounting system id must exist.',
            'from_account_id.required' => 'The from account id is required.',
            'from_account_id.numeric' => 'The from account id must be numeric.',
            'from_account_id.exists' => 'The from account id must exist.',
            'to_account_id.required' => 'The to account id is required.',
            'to_account_id.numeric' => 'The to account id must be numeric.',
            'to_account_id.exists' => 'The to account id must exist.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be numeric.',
            'reason.required' => 'The reason is required.',
            'reason.string' => 'The reason must be a string.',
        ];
    }
}


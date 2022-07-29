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

class ImportBankTransfer implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // TODO : ADD VALIDATION FOR THE FIELDS
        $fromAccount = BankAccounts::find($row['from_account_id']);
        $toAccount = BankAccounts::find($row['to_account_id']);

        $debit_accounts[] = CreateJournalPostings::encodeAccount($toAccount->chartOfAccount->id);
        $credit_accounts[] = CreateJournalPostings::encodeAccount($fromAccount->chartOfAccount->id);
        
        $je = CreateJournalEntry::run(now()->format('Y-m-d'), $row['reason'], $row['accounting_system_id']);

        CreateJournalPostings::run($je, 
            $debit_accounts, [$row['amount']], 
            $credit_accounts, [$row['amount']], 
            $row['accounting_system_id']
        );
  
        $transactions = Transactions::create([
            'accounting_system_id' => $row['accounting_system_id'],
            'chart_of_account_id' => $row['from_account_id'],
            'type' => 'Transfer',
            'description' => $row['reason'],
            'amount' => $row['amount'],
        ]);

        $transfers = Transfers::create([
            //
            'accounting_system_id' => $row['accounting_system_id'],
            'from_account_id' => $row['from_account_id'],
            'to_account_id' => $row['to_account_id'],
            'amount' => $row['amount'],
            'reason' => $row['reason'],
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
}


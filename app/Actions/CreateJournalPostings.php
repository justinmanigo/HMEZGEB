<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\ChartOfAccounts;
use App\Models\JournalPostings;

class CreateJournalPostings
{
    use AsAction;

    public function handle($journal_entry, $raw_debit_accts, $debit_amount, $raw_credit_accts, $credit_amount)
    {
        for($i = 0; $i < count($raw_debit_accts); $i++)
        {
            $debit_accounts[$i] = $this->decodeRawAccount($raw_debit_accts[$i]);
            $coa = ChartOfAccounts::find($debit_accounts[$i]->value);

            $updated_balance = $this->computeCOAUpdatedBalance('debit', $debit_accounts[$i], $coa, $debit_amount[$i]);
            $this->updateCOABalance($coa, $updated_balance);
            $this->createJournalPosting('debit', $journal_entry->id, $debit_accounts[$i]->value, $credit_amount[$i], $updated_balance);
        }

        // Credits
        for($i = 0; $i < count($raw_credit_accts); $i++)
        {
            $credit_accounts[$i] = $this->decodeRawAccount($raw_credit_accts[$i]);
            $coa = ChartOfAccounts::find($credit_accounts[$i]->value);

            $updated_balance = $this->computeCOAUpdatedBalance('credit', $credit_accounts[$i], $coa, $credit_amount[$i]);
            $this->updateCOABalance($coa, $updated_balance);
            $this->createJournalPosting('credit', $journal_entry->id, $credit_accounts[$i]->value, $credit_amount[$i], $updated_balance);
        }
    }

    public function decodeRawAccount($acct)
    {
        $item = json_decode($acct);
        return $item[0];
    }

    public function computeCOAUpdatedBalance($type, $acct, $coa, $amount)
    {
        if($type == 'debit')
        {
            if($acct->normal_balance == 'Debit')
                $updated_balance = $coa->current_balance + floatval($amount);
            else
                $updated_balance = $coa->current_balance - floatval($amount);
        }
        else if($type == 'credit')
        {
            if($acct->normal_balance == 'Debit')
                $updated_balance = $coa->current_balance - floatval($amount);
            else
                $updated_balance = $coa->current_balance + floatval($amount);
        }
        
        return $updated_balance;
    }

    public function updateCOABalance($coa, $updated_balance)
    {
        $coa->update([
            'current_balance' => $updated_balance,
        ]);
    }

    public function createJournalPosting($type, $id, $coa_id, $amount, $updated_balance)
    {
        JournalPostings::create([
            'type' => $type,
            'journal_entry_id' => $id,
            'chart_of_account_id' => $coa_id,
            'amount' => $amount,
            'updated_balance' => $updated_balance,
            'accounting_period_id' => 1, // TODO: temporarily 1 for now
        ]);
    }
}
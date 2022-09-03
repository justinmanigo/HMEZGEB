<?php

namespace App\Actions;

use App\Actions\DecodeTagifyField;
use App\Models\Settings\ChartOfAccounts\ChartOfAccounts;
use App\Models\Settings\ChartOfAccounts\JournalPostings;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateJournalPostings
{
    use AsAction;

    public function handle($journal_entry, $debit_accounts, $debit_amount, $credit_accounts, $credit_amount, $accounting_system_id, $debit_description = null, $credit_description = null)
    {
        for($i = 0; $i < count($debit_accounts); $i++)
        {
            // $debit_accounts[$i] = $this->decodeRawAccount($raw_debit_accts[$i]);
            $coa = ChartOfAccounts::find($debit_accounts[$i]->value);

            // $updated_balance = $this->computeCOAUpdatedBalance('debit', $debit_accounts[$i], $coa, $debit_amount[$i]);
            // $this->updateCOABalance($coa, $updated_balance);
            $this->createJournalPosting('debit', $journal_entry->id, $debit_accounts[$i]->value, $debit_amount[$i], (isset($debit_description[$i]) ? $debit_description[$i] : null));
        }

        // Credits
        for($i = 0; $i < count($credit_accounts); $i++)
        {
            // $credit_accounts[$i] = $this->decodeRawAccount($raw_credit_accts[$i]);
            $coa = ChartOfAccounts::find($credit_accounts[$i]->value);

            // $updated_balance = $this->computeCOAUpdatedBalance('credit', $credit_accounts[$i], $coa, $credit_amount[$i]);
            // $this->updateCOABalance($coa, $updated_balance);
            $this->createJournalPosting('credit', $journal_entry->id, $credit_accounts[$i]->value, $credit_amount[$i], (isset($credit_description[$i]) ? $credit_description[$i] : null));
        }
    }

    public static function encodeAccount($id)
    {
        return DecodeTagifyField::run(json_encode([['value' => $id]]));
    }

    /** TODO: This is something to be finalized later :D */
    public static function encodeAccounts(array $ids)
    {
        $accounts = [];
        foreach($ids as $id)
            $accounts[] = self::encodeAccount($id);

        return $accounts;
    }

    /**
     * TODO: Rework later when needed.
     */
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

    /**
     * TODO: Rework later when needed.
     */
    public function updateCOABalance($coa, $updated_balance)
    {
        $coa->update([
            'current_balance' => $updated_balance,
        ]);
    }

    public function createJournalPosting($type, $id, $coa_id, $amount, $description = null)
    {
        JournalPostings::create([
            'accounting_system_id' => session('accounting_system_id'),
            'description' => $description,
            'type' => $type,
            'journal_entry_id' => $id,
            'chart_of_account_id' => $coa_id,
            'amount' => $amount,
            'accounting_period_id' => 1, // TODO: temporarily 1 for now
        ]);
    }
}
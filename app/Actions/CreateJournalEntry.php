<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Settings\ChartOfAccounts\JournalEntries;

class CreateJournalEntry
{
    use AsAction;

    public function handle($date, $notes, $accounting_system_id)
    {
        $journal_entry = JournalEntries::create([
            'date' => $date,
            'accounting_system_id' => $accounting_system_id,
            'notes' => $notes,
        ]);

        return $journal_entry;
    }
}
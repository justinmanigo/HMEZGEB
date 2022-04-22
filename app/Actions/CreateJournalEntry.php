<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\JournalEntries;

class CreateJournalEntry
{
    use AsAction;

    public function handle($date, $notes)
    {
        $journal_entry = JournalEntries::create([
            'date' => $date,
            'notes' => $notes,
        ]);

        return $journal_entry;
    }
}
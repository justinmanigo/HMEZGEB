<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\JournalVouchers;

class CreateJournalVoucher
{
    use AsAction;

    public function handle($id, $reference_number)
    {
        $journal_voucher = JournalVouchers::create([
            'journal_entry_id' => $id,
            'reference_number' => $reference_number,
        ]);

        return $journal_voucher;
    }
}
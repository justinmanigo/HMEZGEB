<?php

namespace App\Exports;

use App\Models\Transfers;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBankTransfer implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $transfers = Transfers::all();
        $transfers->prepend(['id','accounting_system_id', 'from_account_id', 'to_account_id', 'amount', 'reason', 'status', 'journal_entry_id', 'transaction_id','created_at','updated_at']);
        return $transfers;
    }
}

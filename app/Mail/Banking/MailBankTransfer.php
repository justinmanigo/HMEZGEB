<?php

namespace App\Mail\Banking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailBankTransfer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $bank_transfer;
    public function __construct($bank_transfer)
    {
        //
        $this->bank_transfer = $bank_transfer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('banking.transfers.mail')
        ->subject('Bank Transfer Record')
        ->with([
            'bank_transfer' => $this->bank_transfer,
        ]);
    }
}

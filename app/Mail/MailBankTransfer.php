<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailBankTransfer extends Mailable
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
        ->with([
            'bank_transfer' => $this->bank_transfer,
        ]);
    }
}

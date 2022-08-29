<?php

namespace App\Mail\Banking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailBankAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $bank_account;
    public function __construct($bank_account)
    {
        //
        $this->bank_account = $bank_account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('banking.accounts.mail')
        ->subject('Bank Account Record')
        ->with([
            'bank_account' => $this->bank_account,
        ]);
    }
}

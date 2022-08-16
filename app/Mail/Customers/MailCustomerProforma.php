<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCustomerProforma extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $proforma;
    public function __construct($proforma)
    {
        //
        $this->proforma = $proforma;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customer.receipt.proforma.mail')
            ->subject('Proforma Invoice')
            ->with([
                'proforma' => $this->proforma,
            ]);
    }
}

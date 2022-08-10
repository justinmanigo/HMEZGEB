<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVendorStatement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public $vendors;
    public $statement;

    public function __construct($vendors, $statement)
    {
        //
        $this -> vendors = $vendors;
        $this -> statement = $statement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendors.vendors.mail')->with([
            'vendors' => $this->vendors,
            'bills' => $this->statement,
        ]);
    }
}

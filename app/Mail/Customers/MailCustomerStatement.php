<?php

namespace App\Mail\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class MailCustomerStatement extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $customer;
    public $receipts;


    public function __construct($customer, $receipts)
    {
        $this->customer = $customer;
        $this->receipts = $receipts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customer.customer.mail')
        ->subject('Customer Statement Invoice')
        ->with([
            'customer' => $this->customer,
            'receipts' => $this->receipts,
        ]);
    }
}

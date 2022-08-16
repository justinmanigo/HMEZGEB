<?php

namespace App\Mail\Referral;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable 
{
    use Queueable, SerializesModels;

    private $user;
    private $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('referrals.mail.invite-user', [
            'user' => $this->user,
            'code' => $this->code
        ]);
    }
}

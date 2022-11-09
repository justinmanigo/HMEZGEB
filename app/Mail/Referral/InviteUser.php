<?php

namespace App\Mail\Referral;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $user;
    private $code;
    private $reject_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $code)
    {
        // Encrypt code
        $key = config('app.key');
        $method = 'AES-256-CBC';
        $iv = substr(hash('sha256', $key), 0, 16);
        $encrypted = openssl_encrypt($code, $method, $key, 0, $iv);

        // prepare encrypted for url
        $encrypted = str_replace(['+', '/', '='], ['-', '_', ''], $encrypted);

        $this->user = $user;
        $this->code = $code;
        $this->reject_link = url('/reject-invitation/' . $encrypted);
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
            'code' => $this->code,
            'rejectLink' => $this->reject_link,
        ])
        ->subject('Referral Invitation');
    }
}

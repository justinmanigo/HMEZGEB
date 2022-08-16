<?php

namespace App\Mail\Control\SuperAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSuperAdmin extends Mailable 
{
    use Queueable, SerializesModels;

    private $user;
    private $rawPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $rawPassword)
    {
        $this->user = $user;
        $this->rawPassword = $rawPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('control_panel.super_admins.mail.new-super-admin', [
            'user' => $this->user,
            'password' => $this->rawPassword
        ]);
    }
}

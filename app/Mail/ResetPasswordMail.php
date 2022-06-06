<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token,string $email)
    {
        $this->token=$token;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admins.emails.reset_password', [
                                    'url' => config('app.url').'/admins/reset/password/'.$this->token.'/'.$this->email,
                                ]);
    }
}

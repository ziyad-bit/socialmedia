<?php

namespace App\Listeners;

use App\Events\ResetPassword;
use App\Mail\ResetPasswordMail;
use App\Models\Password_reset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ResetPassword $event)
    {
        $token=Str::random(60);

        $email=$event->email;

        Password_reset::create(['token'=>$token,'email'=>$email]);

        Mail::to($email)->send(new ResetPasswordMail($token));
    }
}

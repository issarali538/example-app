<?php

namespace App\Listeners;

use App\Mail\RegisterationMail;
use App\Events\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegisteredListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserRegistered $event): void
    {
        Mail::to($event->user->email)->send(new RegisterationMail($event->user));
    }
}

<?php

namespace App\Listeners;

use App\Mail\PasswordChangeMail;
use App\Events\PasswordChangeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordChangeEventLilstener
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
    public function handle(PasswordChangeEvent $event): void
    {
        Mail::to($event->user->email)->send(new PasswordChangeMail($event->user));
    }
}

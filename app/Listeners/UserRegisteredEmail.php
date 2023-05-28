<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\UserRegisteredMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserRegisteredEmail
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
    public function handle(UserRegistered $event): void
    {
        DB::table('users')->insert([
            'name'=>$event->name,
            'email'=>$event->email,
            'password'=>$event->password
        ]);
    }
}

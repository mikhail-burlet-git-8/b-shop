<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNewUserListener {

    public function handle( $event ) {
        $event->user->notify( new NewUserNotification() );
    }
}

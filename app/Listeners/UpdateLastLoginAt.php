<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    /**
     * Handle the event.
     * Update last_login_at timestamp when user logs in.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        
        $user->update([
            'last_login_at' => now(),
        ]);
    }
}

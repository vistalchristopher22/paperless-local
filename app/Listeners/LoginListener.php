<?php

namespace App\Listeners;

use App\Enums\LoggedStatus;
use App\Models\LoginHistory;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class LoginListener
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
    public function handle(Login $event): void
    {
        DB::transaction(function () use ($event) {
            LoginHistory::create([
                'ip_address' => request()->ip(),
                'user_id' => $event->user->id,
                'type' => LoggedStatus::LOGIN->value,
                'logged_in_at' => now(),
            ]);

            $event->user->is_online = 1;
            $event->user->save();
        });
    }
}

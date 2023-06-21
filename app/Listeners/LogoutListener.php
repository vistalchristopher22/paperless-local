<?php

namespace App\Listeners;

use App\Enums\LoggedStatus;
use App\Models\LoginHistory;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;

class LogoutListener
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
    public function handle(Logout $event): void
    {
        DB::transaction(function () use ($event) {
            LoginHistory::create([
                'ip_address' => request()->ip(),
                'user_id' => $event->user->id,
                'type' => LoggedStatus::LOGOUT->value,
                'logged_in_at' => now(),
            ]);

            $event->user->is_online = 0;
            $event->user->save();
        });
    }
}

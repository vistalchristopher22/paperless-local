<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

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
        //
    }
}

<?php

namespace App\ViewComposers;

use App\Models\Committee;
use App\Models\UserNotification;
use Illuminate\View\View;

final class NotificationViewComposer
{
    /**
     * The categories repository implementation.
     *
     * @var Committee
     */
    protected UserNotification $notifications;

    /**
     * Create a new category composer.
     *
     * @param Category $committees
     * @return void
     */
    public function __construct(UserNotification $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $notifications = $this->notifications->with('sender_information')->where('user', auth()->user()->id)->latest()->get();
        $view->with('notifications', $notifications);
    }
}

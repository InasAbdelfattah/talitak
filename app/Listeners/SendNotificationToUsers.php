<?php

namespace App\Listeners;

use App\Events\NotifyUsers;
use App\Notifications\CommentsNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationToUsers
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
     * @param  NotifyUsers $event
     * @return void
     */
    public function handle(NotifyUsers $event)
    {


        $favoritesUserAll = $event->company->favorites;

        $favoritesUserWithoutOwner = $favoritesUserAll->filter(function ($q) use ($event) {
            return $q->id != $event->user->id;
        })->values();

        \Notification::send($favoritesUserWithoutOwner, new CommentsNotification($event->message, $event->user, $event->company->id, $event->type));

    }
}

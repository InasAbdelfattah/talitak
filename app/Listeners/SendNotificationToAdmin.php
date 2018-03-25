<?php

namespace App\Listeners;

use App\Events\NotifyAdminJoinApp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationToAdmin
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
     * @param  NotifyAdminJoinApp  $event
     * @return void
     */
    public function handle(NotifyAdminJoinApp $event)
    {

    }
}

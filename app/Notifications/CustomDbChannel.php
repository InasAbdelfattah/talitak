<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomDbChannel extends Notification
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            //customize here
            'user_id' => $data['user_id'], //<-- comes from toDatabase() Method below
            'target_id' => $data['target_id'], //<-- comes from toDatabase() Method below
            'notify_type' => $data['notify_type'], //<-- comes from toDatabase() Method below
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }

}

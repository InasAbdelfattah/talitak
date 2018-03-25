<?php

namespace App\Events;

use App\Company;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyUsers
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $company;
    public $message;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Company $company, $message, $type)
    {
        $this->user = $user;
        $this->company = $company;
        $this->message = $message;
        $this->type = $type;

    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $table = "user_invitations";

    public function invitor()
    {
        return $this->belongsTo(User::class ,'invited_by');
    }

    public function invited()
    {
        return $this->belongsTo(User::class ,'user_id');
    }
}

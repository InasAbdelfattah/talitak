<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abuse extends Model
{
    /**
     * @var array
     * @ $fillable array of available varible to display.
     */
    protected $fillable = [
        'abuseable_id', 'abuseable_type', 'abuse',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function abuseable()
    {
        return $this->morphTo();
    }
}

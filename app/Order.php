<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function service()
    {
        return $this->belongsTo(Service::class);

    }

    public function Company()
    {
        return $this->belongsTo(Company::class , 'company_id');

    }

    public function rates()
    {
        return $this->hasMany('App\Rate')->where('rate_from','user');
    }
}

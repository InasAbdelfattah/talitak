<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);

    }

    public function provider()
    {
        return $this->belongsTo(User::class ,'provider_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class ,'district_id' ,'id');
    }
}

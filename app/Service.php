<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Service extends Model
{
    //use  Rateable;
    use Translatable;

    public $translatedAttributes = ['name' , 'description'];

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

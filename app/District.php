<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
//use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
   // use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['name'];
    
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
   // protected $dates = ['deleted_at'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * @var array
     * @ $fillable array of available varible to display.
     */
    protected $fillable = [
        'parent_id', 'imageable_id', 'imageable_type', 'image',
    ];
    public function imageable()
    {
        return $this->morphTo();
    }


    public static function scopeById($query, $id)
    {

        if ($id != '') {
            $query->where('id', $id);
        }
        return $query->first();


    }


}

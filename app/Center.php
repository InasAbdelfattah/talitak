<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $fillable = [
        'category_id'
    ];

    /**
     * @param $query
     * @param $id
     * @return mixed
     */

    public static function scopeById($query, $id)
    {

        if ($id != '') {
            $query->where('id', $id);
        }
        return $query->first();


    }

   

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);

    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */

    // public function favorites()
    // {
    //     return $this->belongsToMany(User::class, 'company_favorite');
    // }


    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function visits()
    // {
    //     return $this->hasMany(Visit::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

//use willvincent\Rateable\Rateable;

class Company extends Model
{

    //use  Rateable;
    use Translatable;

    public $translatedAttributes = ['name' , 'description'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function membership()
    // {
    //     return $this->belongsTo(Membership::class);
    // }

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

    public function provider()
    {
        return $this->belongsTo(User::class ,'provider_id');

    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }

    public function workDays()
    {
        return $this->hasMany('App\CompanyWorkDay');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function rates()
    {
        return $this->hasMany('App\Rate')->where('rate_from','user');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function products()
    {
        return $this->hasMany(Service::class);
    }

    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function city()
    {
        return $this->belongsTo(City::class ,'city_id');
    }

    public function languages()
    {
        return $this->hasMany(CompanyTranslation::class ,'company_id');
    }


}

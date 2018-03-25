<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Support\Facades\Hash;
//use App\Notifications\MyAdminResetPassword as ResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable , HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
       // 'api_token',
        // 'code',
        // 'lat',
        // 'lng',
        // 'address',
       // 'image',
        'is_active',
        'is_suspend',
        'is_online',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     /**
     * @return mixed
     * @@ Check if user have any roles.
     */


    public function hasAnyRoles()
    {
        if (auth()->check()) {
            return auth()->user()->roles->count();
        } else {
            redirect(route('admin.login'));
        }
    }

     /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }


    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * @param $query
     * @param $api_token
     * @return mixed
     */

    public function scopeIsActive($query, $phone)
    {
        if ($phone != '') {
            $query->where('phone', $phone);
        }
        return $query->first();
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }


    public function company()
    {
        //return $this->hasMany(Company::class);
        //return $this->belongsTo(Company::class, 'user_id');
        return $this->hasOne('App\Company', 'user_id');
    }

    

    public static function scopeByToken($query, $token)
    {

        if ($token != '') {
            $query->where('api_token', $token);
        }
        return $query->first();

    }

    public static function scopeById($query, $id)
    {

        if ($id != '') {
            $query->where('id', $id);
        }
        return $query->first();

    }

    public static function userCode($code)
    {

        $rand = User::where('code', $code)->first();
        if ($rand) {
            return $randomCode = rand(1000000000, 9999999999);
        } else {
            return $code;
        }

    }

    public function rates()
    {
        return $this->hasMany('App\Rate')->where('rate_from','provider');

    }

    public static function actionCode($code)
    {

        $rand = User::where('action_code', $code)->first();
        if ($rand) {
            return $randomCode = rand(1000, 9999);
        } else {
            return $code;
        }

    }

}

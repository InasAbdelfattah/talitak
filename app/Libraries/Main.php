<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
use Silber\Bouncer\Database\Role;

class Main
{

    /**
     * @return int|mixed|string
     * Get other language.
     */

    public function otherLang()
    {

        // create variable to save default or current language.
        $lang = config('app.locale');


        // get all languages in app.
        // and loop in it then put other (not current in var $lang)

        foreach (config('translatable.locales') as $key => $val) {

            if ($key != config('app.locale')) {

                $lang = $key;

            }
        }
        return $lang;

    }


    public function getName(Role $role, $name)
    {
        $ability = $role->abilities()->whereName($name)->first();

        if ($ability['title'] != '') {
            return $ability['title'];
        } else {
            if ($ability['name'] == '*') {
                return 'كل الصلاحيات';
            } else {
                return $ability['name'];
            }

        }

    }


    public function getRoleTitleByName(Role $role)
    {
        $role = Role::whereName($role->name)->first();
        return $role->title;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: Hassan Saeed
 * Date: 11/16/2017
 * Time: 9:29 AM
 */

namespace App\Providers;

use App\Category;

use App\Libraries\Main;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $cats = Category::where('parent_id', 0)->get();
            $helper = new \App\Http\Helpers\Images();
            $main_helper = new \App\Http\Helpers\Main();
            $setting = new Setting;
            $main = new Main();

            $view->with(compact('cats', 'helper', 'main', 'setting','main_helper'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}



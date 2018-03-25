<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'administrator'], function () {

    Route::get('/', 'Admin\LoginController@login')->name('admin');
    Route::get('/login', 'Admin\LoginController@login')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@postLogin')->name('admin.postLogin');


    // Password Reset Routes...

    Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('administrator.password.request');
    Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('administrator.password.email');
    Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('administrator.password.reset.token');
    Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset');

});

//Route::get('lang/{language}', ['as' => 'lang.switch', 'uses' => 'Api\V1\LanguageController@switchLang']);

Route::group(['prefix' => 'administrator', 'middleware' => 'admin'], function () {

    Route::get('/', 'Admin\HomeController@index')->name('home');
    Route::get('/home', 'Admin\HomeController@index')->name('admin.home');

    Route::resource('abilities', 'Admin\AbilitiesController');
    Route::post('abilities_mass_destroy', ['uses' => 'Admin\AbilitiesController@massDestroy', 'as' => 'abilities.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::post('provider_activation', ['uses' => 'Admin\UsersController@activation', 'as' => 'provider.activation']);
    Route::get('providers_requests', ['uses' => 'Admin\UsersController@getNewProvidersRequests', 'as' => 'users.providers_requests']);
    Route::get('providers', ['uses' => 'Admin\UsersController@getProviders', 'as' => 'users.app_providers']);
    Route::get('app_users', ['uses' => 'Admin\UsersController@getUsers', 'as' => 'users.app_users']);

    Route::post('role/delete/group', 'Admin\RolesController@groupDelete')->name('roles.group.delete');


    Route::post('user/delete', 'Admin\UsersController@delete')->name('user.delete');
    Route::post('user/delete/group', 'Admin\UsersController@groupDelete')->name('users.group.delete');
    Route::post('user/suspend/group', 'Admin\UsersController@groupSuspend')->name('users.group.suspend');
    Route::post('companies/delete/group', 'Admin\CompaniesController@groupDelete')->name('companies.group.delete');
    Route::post('companies/suspend-comment', 'Admin\CompaniesController@suspendComment')->name('companies.suspendComment');
    Route::post('companies/delete-comment', 'Admin\CompaniesController@deleteComment')->name('companies.deleteComment');

    Route::post('role/delete', 'Admin\RolesController@delete')->name('role.delete');


    /**
     * @@ Manage Categories Routes.
     */
    Route::post('category/delete', 'Admin\CategoriesController@delete')->name('category.delete');
    Route::post('category/delete/group', 'Admin\CategoriesController@groupDelete')->name('categories.group.delete');
    Route::resource('categories', 'Admin\CategoriesController');

    Route::post('categories/filter', 'Admin\CategoriesController@filter')->name('categories.filter');
    Route::post('users/filter', 'Admin\UsersController@filter')->name('users.filter');
    Route::post('membership/filter', 'Admin\MembershipController@filter')->name('membership.filter');
    Route::post('roles/filter', 'Admin\RolesController@filter')->name('roles.filter');


    Route::post('companies/delete', 'Admin\CompaniesController@delete')->name('company.delete');

    Route::post('companies/orders', 'Admin\CompaniesController@activation')->name('company.activation');
    Route::get('companies/orders', 'Admin\CompaniesController@orders')->name('companies.orders');
    Route::resource('companies', 'Admin\CompaniesController');
//    Route::get('companies', 'Admin\CompaniesController@index')->name('companies.index');
//    Route::get('companies/get', 'Admin\CompaniesController@getCompanies')->name('get.companies');

    Route::post('contactus/reply/{id}', 'Admin\SupportsController@reply')->name('support.reply');
    Route::get('contactus', 'Admin\SupportsController@index')->name('support.index');
    Route::get('contactus/{id}', 'Admin\SupportsController@show')->name('support.show');
    Route::post('contactus', 'Admin\SupportsController@delete')->name('support.delete');


    /**
     * Abuse Routes
     */
    Route::post('abuses/delete', 'Admin\AbuseController@delete')->name('abuse.delete');
    Route::post('abuses/delete/group', 'Admin\AbuseController@groupDelete')->name('abuse.group.delete');
    Route::post('abuses/adopt-abuse', 'Admin\AbuseController@adoptAbuse')->name('abuse.adoptAbuse');
    Route::resource('abuses', 'Admin\AbuseController');

    //Products Routes
    Route::post('products/delete', 'Admin\ProductsController@delete')->name('product.delete');
    Route::post('products/update', 'Admin\ProductsController@update')->name('product.update');

    /**
     * Cities Routes
     */

    Route::post('city/delete/group', 'Admin\CitiesController@groupDelete')->name('cities.group.delete');
    Route::post('cities/delete', 'Admin\CitiesController@delete')->name('city.delete');
    Route::resource('cities', 'Admin\CitiesController');
    
    /**
     * Districts Routes
     */

    Route::post('district/delete/group', 'Admin\DistrictsController@groupDelete')->name('districts.group.delete');
    Route::post('districts/delete', 'Admin\DistrictsController@delete')->name('district.delete');
    Route::resource('districts', 'Admin\DistrictsController');
    
    /**
     * @ orders Routes
     */
    Route::post('orders/delete/group', 'Admin\OrdersController@groupDelete')->name('orders.group.delete');
    Route::post('orders/delete', 'Admin\OrdersController@delete')->name('orders.delete');
    Route::post('orders/search', 'Admin\OrdersController@search')->name('orders.search');
    Route::get('orders/financial-reports', 'Admin\OrdersController@getFinancialReports')->name('orders.financial_reports');
    Route::get('orders/financial_accounts', 'Admin\OrdersController@getFinancialAccounts')->name('orders.financial_accounts');
    Route::post('orders/search_financial_reports', 'Admin\OrdersController@searchFinancialReports')->name('orders.search_reports');
    Route::get('orders/search_financial_accounts', 'Admin\OrdersController@searchFinancialAccounts')->name('orders.search_accounts');
    Route::post('orders/delete_financial_account', 'Admin\OrdersController@deleteAccount')->name('orders.delete_accounts');    
    Route::post('orders/confirm-payment', 'Admin\OrdersController@confirmPayment')->name('account.confirmPayment');    
    Route::resource('orders', 'Admin\OrdersController');

    /**
     * @ user_discounts Routes
     */
    Route::post('user_discounts/add_discount', 'Admin\UserDiscountsController@addDiscount')->name('user_discounts.addDiscount');
    Route::get('user_discounts/all', 'Admin\UserDiscountsController@userDiscounts')->name('user_discounts.all');
    Route::post('user_discounts/delete', 'Admin\UserDiscountsController@delete')->name('user_discounts.delete');
    Route::resource('user_discounts', 'Admin\UserDiscountsController');
    
    /**
     * @ Setting Routes
     */

    Route::get('/settings/companies/projects', 'Admin\SettingsController@commentsProjects')->name('administrator.settings.comments');
    Route::post('/settings/companies/projects', 'Admin\SettingsController@commentsProjectsSettings')->name('administrator.settings.projects.comments');
    Route::post('/settings/companies/ratings', 'Admin\SettingsController@ratingProjectsSettings')->name('administrator.settings.projects.ratings');

    Route::get('/settings/commission', 'Admin\SettingsController@commission')->name('settings.commission');
    Route::get('/settings/aboutus', 'Admin\SettingsController@aboutus')->name('settings.aboutus');
    Route::get('/settings/terms', 'Admin\SettingsController@terms')->name('settings.terms');

    Route::get('/settings/socials/links','Admin\SettingsController@socialLinks')->name('settings.socials');
    Route::post('/settings', 'Admin\SettingsController@store')->name('administrator.settings.store');

    // notifications
    Route::group(['prefix' => 'notifications'], function () {

        // show all notifications
        Route::get('/', [
            'uses' => 'Admin\NotificationController@getIndex',
            'as' => 'notifs'
        ]);

        Route::get('/new', [
            'uses' => 'Admin\NotificationController@getNotif',
            'as' => 'new-notif'
        ]);

        Route::post('/send', [
            'uses' => 'Admin\NotificationController@send',
            'as' => 'notif-send'
        ]);

    });

    // groups
    Route::group(['prefix' => 'groups'], function () {

        Route::get('/', [
            'uses' => 'Admin\ManagementLevelController@getIndex',
            'as' => 'levels'
        ]);

        Route::get('level-add', [
            'uses' => 'Admin\ManagementLevelController@getAdd',
            'as' => 'level-add'
        ]);

        Route::post('level-do-add', [
            'uses' => 'Admin\ManagementLevelController@postAdd',
            'as' => 'level-do-add'
        ]);

        Route::get('level-edit/{id}', [
            'uses' => 'Admin\ManagementLevelController@getEdit',
            'as' => 'level-edit'
        ]);

        Route::post('level-do-edit/{id}', [
            'uses' => 'Admin\ManagementLevelController@postEdit',
            'as' => 'level-do-edit'
        ]);

        Route::get('level-delete/{id}', [
            'uses' => 'Admin\ManagementLevelController@getDelete',
            'as' => 'level-delete'
        ]);

        Route::get('level-details/{id}', [
            'uses' => 'Admin\ManagementLevelController@getDetails',
            'as' => 'level-details'
        ]);

        Route::post('/delete-all/{route}', [
            'uses' => 'Admin\ManagementLevelController@deleteAll',
            'as' => 'lv-delete-all'
        ]);

    });

    Route::post('/logout', 'Admin\LoginController@logout')->name('administrator.logout');

});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::get('roles', function () {

    $user = auth()->user();
//    $user->retract('admin');
    $user->assign('owner');
    Bouncer::allow('owner')->everything();

    $user->allow('users_manage');

    //Bouncer::allow('admin')->to('users_manage');
    //Bouncer::allow($user)->toOwnEverything();


});


<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('notification/firebase', function () {

    $push = new \App\Libraries\PushNotification();
    return $push->sendPushNotification();
});


Route::group(['prefix' => 'v1'], function () {


    // Complate Agent information for agent after activation code is successfully.
    Route::post('user/register', 'Api\V1\RegistrationController@store');

    // and can login with phone after send activation code successfully.
    Route::post('user/activation', 'Api\V1\LoginController@postActivationCode');

    // Resend Activation Code
    Route::post('resend/activation/code', 'Api\V1\LoginController@resendActivationCode');

    // Login after activate account
    Route::post('/user/login', 'Api\V1\LoginController@login');

//change phone first change action code 
    // Change password first enter phone number and will check if is correct.
    Route::post('password/forgot', 'Api\V1\ForgotPasswordController@getResetTokens');
//change phone after entering action code
    Route::post('activation/code', 'Api\V1\ResetPasswordController@checkCode');

    // After arrive reset code send to check is true.
    Route::post('password/check', 'Api\V1\ResetPasswordController@check');

    // After arrive reset code send to other again and reset password.
    Route::post('password/reset', 'Api\V1\ResetPasswordController@reset');

    // Resent Reset Code
    Route::post('password/forgot/resend', 'Api\V1\ForgotPasswordController@resendResetPasswordCode');

    // Get list of cities
    Route::get('cities', 'Api\V1\CitiesController@index');

    // Social Login
    //Route::post('social/login', 'Api\V1\UsersController@socialLogin');

    //serviceTypes
    Route::get('categories', 'Api\V1\CategoriesController@index');

    Route::get('general/info', 'Api\V1\SettingsController@generalInfo');

    Route::get('/user/{id}', 'Api\V1\UsersController@getUserById');

    Route::post('report', 'Api\V1\CommentsController@abuseComment');

    Route::post('contactus', 'Api\V1\ContactusController@postMessage');

    //Route::get('parent/categories', 'Api\V1\CategoriesController@getParentCategory');

    //centers
    Route::get('centers/list', 'Api\V1\CompaniesController@companiesList');
    Route::get('center/details', 'Api\V1\CompaniesController@details');

    //center services 
    Route::post('center/services/create', 'Api\V1\ProductsController@saveProduct');
    Route::post('center/service/delete', 'Api\V1\ProductsController@delete');
    Route::post('center/service/update', 'Api\V1\ProductsController@update');
    Route::get('center/services/list', 'Api\V1\ProductsController@productsList');

    //center work days 
    Route::post('center/workDays/create', 'Api\V1\CenterWorkDaysController@saveWorkDay');
    Route::post('center/workDays/delete', 'Api\V1\CenterWorkDaysController@delete');
    Route::post('center/workDays/update', 'Api\V1\CenterWorkDaysController@update');
    Route::get('center/workDays/list', 'Api\V1\CenterWorkDaysController@list');

});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {

    Route::post('/rating', 'Api\V1\RatesController@postRating');

    Route::get('profile', 'Api\V1\UsersController@profile');

    Route::post('profile/update', 'Api\V1\UsersController@profileUpdate');

    Route::post('password/change', 'Api\V1\UsersController@changePassword');

    /*DONE*/
    Route::post('companies/complete', 'Api\V1\RegistrationController@companyCompleteData');
    Route::post('comment/create', 'Api\V1\CommentsController@saveComment');
    Route::post('comment/update', 'Api\V1\CommentsController@updateComment');
    Route::post('comment/delete', 'Api\V1\CommentsController@deleteComment');
    Route::get('comments/list', 'Api\V1\CommentsController@commentList');

    /**
     * Favorite Company
     */

    // add and remove user favourite depending on type request
    Route::post('center/favorite', 'Api\V1\FavoritesController@favoriteCompany');
    Route::post('upload/image', 'Api\V1\ImagesController@postImage');

    /**
     * @@ Favorites
     */

    Route::get('favorites/user', 'Api\V1\FavoritesController@getFavoriteListForUser');

    /**
     * Supports Controllers Routes
     */

    Route::post('support/post/message', 'Api\V1\SupportsController@postMessage');
    Route::post('user/logout', 'Api\V1\UsersController@logout');


    /**
     * @ User Notifications
     */

    Route::get('notifications', 'Api\V1\NotificationsController@getUserNotifications');
    Route::post('notification/delete', 'Api\V1\NotificationsController@delete');

//    Route::get('favorites/category', 'Api\V1\CategoriesController@categoriesFavoriteList');


});

Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'data' => [
            'username' => 'hassan',
            'password' => 'password'
        ]
    ]);
});

Route::get('/data', function () {
    // API access key from Google API's Console
    define('FIREBASE_API_KEY', 'AAAAhz3rV6A:APA91bGeeaEjjN9h2jxj6BKJUvitNFatmZimkDW7cN6OoyY3FB89nifskY9BX9K0pQy4SF6jbci2QAUSkqVAitPi_lUufzZ8uNHezu4nLlp0SIQcEDlvs3wCPIq6_panG4lP2cr9vppK');


    $registrationIds = array($_GET['id']);
// prep the bundle
    $msg = array
    (
        'message' => 'here is a message. message',
        'title' => 'This is a title. title',
        'subtitle' => 'This is a subtitle. subtitle',
        'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
        'vibrate' => 1,
        'sound' => 1,
        'largeIcon' => 'large_icon',
        'smallIcon' => 'small_icon'
    );
    $fields = array
    (
        'registration_ids' => $registrationIds,
        'data' => $msg
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
});



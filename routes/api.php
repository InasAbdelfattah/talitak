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


//// API access key from Google API's Console
//    define( 'API_ACCESS_KEY', 'AAAARjiKmhE:APA91bEK_5sSQjZe86ELZSlk3bFIqw7QzSf3nHYx-xT2wmSDbl9ojpwAajobZhbSLu_QG4DQT4Uh5cmC8H7YlScGqAo_BP4Bj78zYUb0IxJ4gy6s6Ojtyi3OpHmnMnZORx7m5TDi4ete' );
//    $registrationIds = array( 'dVRONID1al8:APA91bHdUFINArcXeD50YoxwBKK2spUqw7h_-s0nSsdy_HQDeUqVWWg-02XKyXt4ia3VQ0F_Ij77CawiYq_wZu4WfDVDvHHf52s2Ub_Bg6CZ67Hnc1VTMnoWkEWBYklmsWygRs5MgyLe' );
//// prep the bundle
//    $msg = array
//    (
//        'message' 	=> 'here is a message. message',
//        'title'		=> 'This is a title. title',
//        'subtitle'	=> 'This is a subtitle. subtitle',
//        'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
//        'vibrate'	=> 1,
//        'sound'		=> 1,
//        'largeIcon'	=> 'large_icon',
//        'smallIcon'	=> 'small_icon'
//    );
//    $fields = array
//    (
//        'registration_ids' 	=> $registrationIds,
//        'data'			=> $msg
//    );
//
//    $headers = array
//    (
//        'Authorization: key=' . API_ACCESS_KEY,
//        'Content-Type: application/json'
//    );
//
//    $ch = curl_init();
//    curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
//    curl_setopt( $ch,CURLOPT_POST, true );
//    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
//    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
//    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
//    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
//    $result = curl_exec($ch );
//    curl_close( $ch );
//    echo $result;


    $push = new \App\Libraries\PushNotification();
    return $push->sendPushNotification();
});
Route::group(['prefix' => 'v1'], function () {


    // Complate Agent information for agent after activation code is successfully.
    Route::post('user/register', 'Api\V1\RegistrationController@store');

    // and can login with phone after send activation code successfully.
    Route::post('activation', 'Api\V1\LoginController@postActivationCode');

    // Resend Activation Code
    Route::post('resend/activation/code', 'Api\V1\LoginController@resendActivationCode');

    // Login after activate account
    Route::post('/user/login', 'Api\V1\LoginController@login');

    // Change password first enter phone number and will check if is correct.
    Route::post('password/forgot', 'Api\V1\ForgotPasswordController@getResetTokens');


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
    Route::post('social/login', 'Api\V1\UsersController@socialLogin');


    Route::get('categories', 'Api\V1\CategoriesController@index');
    Route::get('sub/categories/{id}', 'Api\V1\CategoriesController@getSubCategories');


    Route::get('daily/offers', 'Api\V1\OffersController@dailyOvers');


    Route::get('general/info', 'Api\V1\SettingsController@generalInfo');

    Route::get('/user/{id}', 'Api\V1\UsersController@getUserById');


    Route::post('report', 'Api\V1\AbusesController@store');

    Route::post('contactus', 'Api\V1\ContactusController@postMessage');


    Route::post('advertisement/category/sub', 'Api\V1\AdvertisementsController@getSubCategories');
    Route::get('brands', 'Api\V1\AdvertisementsController@getBrandsWithTypes');
    Route::post('advertisement/category/list', 'Api\V1\AdvertisementsController@getAdvertisements');
    Route::get('advertisement/details', 'Api\V1\AdvertisementsController@getAdvDetails');
    Route::post('advertisement/image', 'Api\V1\AdvertisementsController@addImage');


    Route::post('advertisement/search', 'Api\V1\AdvertisementsController@getCarsAdvertisements');
    Route::post('advertisement/basic/search', 'Api\V1\AdvertisementsController@search');
    Route::get('parent/categories', 'Api\V1\CategoriesController@getParentCategory');


    Route::post('advertisement/comment', 'Api\V1\AdvertisementsController@getCommentTo');
    Route::post('advertisement/delete', 'Api\V1\AdvertisementsController@deleteAdv');
    Route::post('advertisement/status', 'Api\V1\AdvertisementsController@changeAdvStatus');
    Route::post('advertisement/update', 'Api\V1\AdvertisementsController@updateAdvertisement');
    Route::post('advertisement/update/image', 'Api\V1\AdvertisementsController@addAdvertisementImage');
    Route::get('myadvs', 'Api\V1\AdvertisementsController@getMyAdvs');
    Route::get('similar', 'Api\V1\AdvertisementsController@similarAdvs');
    Route::get('advertisements/latest', 'Api\V1\AdvertisementsController@getLastAdvs');


    Route::get('companies/list', 'Api\V1\CompaniesController@companiesList');
    Route::get('company/details', 'Api\V1\CompaniesController@details');


    Route::post('company/products/create', 'Api\V1\ProductsController@saveProduct');
    Route::post('company/product/delete', 'Api\V1\ProductsController@delete');
    Route::post('company/product/update', 'Api\V1\ProductsController@update');

    Route::post('company/offer/update', 'Api\V1\OffersController@update');
    Route::post('company/offers/create', 'Api\V1\OffersController@saveOffer');
    Route::post('company/offer/delete', 'Api\V1\OffersController@delete');

    Route::get('company/products/list', 'Api\V1\ProductsController@productsList');


});


Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {

    /**
     * Categories Routing
     *  1- Get all categories.
     *  2- Get Category By ID
     */

//    Route::get('categories/{id?}', 'Api\V1\CategoriesController@index');


    ## Done
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

    Route::post('company/favorite', 'Api\V1\FavoritesController@favoriteCompany');
    Route::post('company/like', 'Api\V1\likesController@likeCompany');
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


//    Route::post('ad/follow', 'Api\V1\AdvertisementsController@following');
//    Route::post('ad/unfollow', 'Api\V1\AdvertisementsController@unfollowing');
//    Route::get('ad/following', 'Api\V1\AdvertisementsController@followsList');


//    Route::get('favorites/category', 'Api\V1\CategoriesController@categoriesFavoriteList');


//    Route::post('ad/favorite', 'Api\V1\AdvertisementsController@favorite');
//    Route::post('ad/unfavorite', 'Api\V1\AdvertisementsController@unfavorite');
//    Route::get('ad/favorites', 'Api\V1\AdvertisementsController@favoritesList');


    Route::post('conversations', 'Api\V1\ConversationsController@sendMessage');

    /**
     * Comment Follow
     */

    Route::get('counts/list', 'Api\V1\SettingsController@countList');

    Route::post('comment/follow', 'Api\V1\AdvertisementsController@followComment');
    Route::post('comment/unfollow', 'Api\V1\AdvertisementsController@unfollowComment');
    Route::get('comment/follow/list', 'Api\V1\AdvertisementsController@followCommentList');
    Route::get('conversations/messages', 'Api\V1\AdvertisementsController@messages');
    Route::get('conversations/list', 'Api\V1\ConversationsController@getListOfConversations');


    Route::post('conversations/asread', 'Api\V1\ConversationsController@markConversationAsRead');
    Route::get('conversations/messages/list', 'Api\V1\ConversationsController@getAllMessages');
    Route::post('conversation/offline', 'Api\V1\ConversationsController@makeUserConversationOffline');

    Route::post('conversation/delete', 'Api\V1\ConversationsController@deleteConversation');
    Route::post('devices/delete', 'Api\V1\ConversationsController@deleteUserDevices');


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



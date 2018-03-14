<?php


use GuzzleHttp\Client;
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

/**
 * User login
 **/

use App\User;


Route::group(['prefix' => 'v1'], function () {


    // Complate Agent information for agent after activation code is successfully.
    Route::post('register', 'Api\V1\UsersController@register');

    // and can login with phone after send activation code successfully.
    Route::post('activation', 'Api\V1\UsersController@postActivationCode');

    // Resend Activation Code
    Route::post('activation/resend', 'Api\V1\UsersController@resendActivationCode');

    // Login after activate account
    Route::post('/login', 'Api\V1\UsersController@login');

    // Change password first enter phone number and will check if is correct.
    Route::post('password/forgot', 'Api\V1\ForgotPasswordController@getResetTokens');

    // After arrive reset code send to check is true.
    Route::post('password/check', 'Api\V1\ResetPasswordController@check');


    // After arrive reset code send to other again and reset password.
    Route::post('password/reset', 'Api\V1\ResetPasswordController@reset');


    // Resent Reset Code
    Route::post('password/forgot/resend', 'Api\V1\ForgotPasswordController@resendResetPasswordCode');


    Route::get('general/info', 'Api\V1\SettingsController@generalInfo');


});


Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {

    /**
     * Categories Routing
     *  1- Get all categories.
     *  2- Get Category By ID
     */

    Route::get('main/projects', function (Request $request) {
        $projects = App\Project::with('images')->where('parent_id', 0)->paginate($request->pageSize);

        return response()->json([
            'status' => true,
            'data' => $projects
        ]);
    });


    Route::get('projects/parent/{id}', function (Request $request, $id) {
        $subProjects = App\Project::with('images')->where('parent_id', $id)->paginate($request->pageSize);
        return response()->json([
            'status' => true,
            'data' => $subProjects
        ]);

    });


    Route::get('projects/units/{id}', function (Request $request, $id) {
        $mainUnits = App\Unit::with('reservations', 'images')->where(['project_id' => $id, 'parent_id' => 0])->paginate($request->pageSize);
        return response()->json([
            'status' => true,
            'data' => $mainUnits
        ]);
    });


    Route::get('projects/units/sub/{id}', function ($id) {

        $units = App\Unit::with('reservations', 'images')->where('parent_id', $id)->paginate(15);
        return response()->json([
            'status' => true,
            'data' => $units
        ]);
    });


    Route::post('search', function (Request $request) {


        if ($request->unitId == null && $request->space == null && $request->floor == null && $request->direction == null && $request->type == null) {
            $query = \App\Unit::with('reservations', 'images')->select();
            $query->where(['project_id' => $request->SubProjectId]);
            $units = $query->paginate($request->pageSize);
            return response()->json([
                'status' => true,
                'message' => 'Sub units',
                'data' => $units
            ]);

        } else {

            if ($request->unitId != null) {
                $query = \App\Unit::with('reservations', 'images')->select();
                $query->where('parent_id', '!=', 0);
                $query->where('parent_id', $request->unitId);
                if ($request->price != null) {
                    $query->where('price', '<=', $request->price);
                }
                if ($request->space != null) {
                    $query->where('space', 'LIKE', "%$request->space%");
                }


                if ($request->floor != null) {
                    $query->where('floor_id', '=', $request->floor);
                }

                if ($request->direction != null) {
                    $query->where('direction_id', '=', $request->direction);
                }


//            if ($request->type != null) {
//                $query->where('type', '=', $request->type);
//            }


                $units = $query->paginate($request->pageSize);

                $units->map(function ($q) {
                    $q->directions = \App\Direction::whereId($q->direction_id)->first();

                    return $q;
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Sub units',
                    'data' => $units
                ]);


            } else {

                $units = \App\Unit::where('project_id', $request->SubProjectId)->get();


                $arrayIds = [];


                foreach ($units as $unit) {
                    $arrayIds[] = $unit->id;
                }


                $query = \App\Unit::select();


                $query->whereIn('parent_id', $arrayIds);

                if ($request->space != null) {
                    $query->where('space', 'LIKE', "%$request->space%");
                }


                if ($request->floor != null) {
                    $query->where('floor_id', '=', $request->floor);
                }

                if ($request->direction != null) {
                    $query->where('direction_id', '=', $request->direction);
                }


                $subUnits = $query->paginate($request->pageSize);


                return response()->json([
                    'status' => true,
                    'message' => 'Sub units',
                    'data' => $subUnits
                ]);



            }


        }


//        if ($request->space || $request->floor || $request->direction || $request->type) {
//            if ($request->unitId) {
//                $query = \App\Unit::with('reservations', 'images')->select();
//                $query->where(['project_id' => $request->SubProjectId]);
//                $query->where('parent_id', '!=', 0);
//                $query->where('parent_id', $request->unitId);
//                if ($request->price != null) {
//                    $query->where('price', '<=', $request->price);
//                }
//
//                $units = $query->paginate($request->pageSize);
//
//                $units->map(function ($q) {
//                    $q->directions = \App\Direction::whereId($q->direction_id)->first();
//
//                    return $q;
//                });
//
//                return response()->json([
//                    'status' => true,
//                    'message' => 'Sub units',
//                    'data' => $units
//                ]);
//
//            } elseif ($request->SubProjectId) {
//
//                $query = \App\Unit::with('reservations', 'images')->select();
//
//                $query->where(['project_id' => $request->SubProjectId, 'parent_id' => 0]);
//                if ($request->price != null) {
//                    $query->where('price', '<=', $request->price);
//                }
//
//                $units = $query->paginate($request->pageSize);
//
//
//                $units->map(function ($q) {
//                    $q->directions = \App\Direction::whereId($q->direction_id)->first();
//
//                    return $q;
//                });
//
//
//                return response()->json([
//                    'status' => true,
//                    'message' => 'Main units',
//                    'data' => $units
//                ]);
//
//            } elseif ($request->MainProjectId) {
//                $query = \App\Project::with('reservations', 'images')->select();
//
//                $query->where('parent_id', $request->MainProjectId);
//                if ($request->price != null) {
//                    $query->where('price', '<=', $request->price);
//                }
//
//                $projects = $query->paginate($request->pageSize);
//
//                return response()->json([
//                    'status' => true,
//                    'message' => 'Sub Projects',
//                    'data' => $projects
//                ]);
//
//            }
//        }else{
//
//
//
//            $unites = \App\Unit::with('reservations', 'images')->where('project_id', $request->SubProjectId)->get();
//
//            return $unites;
//
//
//        }


    });

    Route::post('reservations', function (Request $request) {


        $user = \App\User::whereApiToken($request->api_token)->first();

        if (isset($request->unitId)) {
            $unitId = $request->unitId;
            $item = \App\Unit::whereId($unitId)->first();


        } elseif (isset($request->projectId)) {
            $projectId = $request->projectId;
            $item = \App\Project::whereId($projectId)->first();
        }

        if ($item->reservations()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Reseved Before'
            ]);
        }
        $reservation = new \App\Reservation;
        $reservation->username = $request->username;
        $reservation->paid = $request->paid;
        $reservation->change = $request->change;
        $reservation->description = $request->description;
        $reservation->type = $request->type;
        $reservation->user_id = $user->id;
        if ($item->reservations()->save($reservation)) {

            return response()->json([
                'status' => true,
                'message' => 'Reservation Done',
                'data' => $reservation
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Reservation Can\'t Done',
                'data' => $reservation
            ]);
        }


    });

    Route::get('statistics', function () {

        $mainWithReservation = \App\Unit::whereHas('reservations')->where('parent_id', 0)->get()->count();
        $mainWithOutReservation = \App\Unit::doesntHave('reservations')->where('parent_id', 0)->get()->count();

        $subWithReservation = \App\Unit::whereHas('reservations')->where('parent_id', '!=', 0)->get()->count();
        $subWithOutReservation = \App\Unit::doesntHave('reservations')->where('parent_id', '!=', 0)->get()->count();

        return response()->json([
            'status' => true,
            'message' => 'all Units Statistics',
            'data' => [
                'mainWithReservation' => $mainWithReservation,
                'mainWithOutReservation' => $mainWithOutReservation,
                'subWithReservation' => $subWithReservation,
                'subWithOutReservation' => $subWithOutReservation,

            ]
        ]);
    });

    Route::get('project/details/{id}', function ($id) {
        $project = \App\Project::with('reservations', 'images')->whereId($id)->first();

        return response()->json([
            'status' => true,
            'data' => $project
        ]);

    });

    Route::get('unit/details/{id}', function ($id) {
        $unit = \App\Unit::with('reservations', 'images')->whereId($id)->first();
        $unit->directions = \App\Direction::whereId($unit->direction_id)->first();
        return response()->json([
            'status' => true,
            'data' => $unit
        ]);
    });


    Route::get('directions', function () {
        $directions = \App\Direction::get();
        return response()->json([
            'status' => true,
            'data' => $directions
        ]);
    });


    Route::get('floors', function () {
        $floors = \App\Floor::get();
        return response()->json([
            'status' => true,
            'data' => $floors
        ]);
    });


    Route::post('mainandsubunit', function (Request $request) {

        $type = $request->type;
        if ($type == 0) {
            $query = \App\Unit::whereHas('reservations')->with('reservations', 'images')->select();
            $query->where(['parent_id' => 0]);
            $units = $query->paginate($request->pageSize);
        } elseif ($type == 1) {
            $query = \App\Unit::with('images')->doesntHave('reservations')->select();
            $query->where(['parent_id' => 0]);
            $units = $query->paginate($request->pageSize);

        } elseif ($type == 2) {
            $query = \App\Unit::where('parent_id', '!=', 0)->whereHas('reservations')->with('reservations', 'images')->select();
            $units = $query->paginate($request->pageSize);
        } else {
            $query = \App\Unit::with('images')->where('parent_id', '!=', 0)->doesntHave('reservations')->select();
            $units = $query->paginate($request->pageSize);
        }

        return response()->json([
            'status' => true,
            'data' => $units
        ]);


    });


});




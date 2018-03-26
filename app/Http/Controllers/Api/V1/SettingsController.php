<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use DB;

class SettingsController extends Controller
{


    public function index()
    {
        return response()->json([
            'status' => 'true',
            'data' => [
                'about_title' => Setting::getBody('about_app_title_' . config('app.locale')),
                'about_desc' => Setting::getBody('about_app_desc_' . config('app.locale')),
                'about_image' => Setting::getBody('about_app_image_' . config('app.locale')),
            ]
        ]);
    }


    public function generalInfo(Request $request)
    {
        app()->setLocale($request->lang);

        return response()->json([
            'status' => 'true',
            'data' => [
                'terms' => Setting::getBody('terms'),
                'about_app_desc' => Setting::getBody('about_app_desc'),
                // 'facebook' => Setting::getBody('facebook'),
                // 'twitter' => Setting::getBody('twitter'),
                // 'instagram' => Setting::getBody('instagram')
            ]
        ]);
    }


    public function countList()
    {
        $user = auth()->user();

        $countMessage = DB::table('conversation_user')->where(['user_id' => $user->id, 'read_at' => null, 'deleted_at' => null])->get()->count();

        $countNotify = $user->unreadNotifications()->where('n_type', 0)->get()->count();

        return response()->json([
            'status' => true,
            'messageCount' => $countMessage,
            'notifyCount' => $countNotify
        ]);


    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Device;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class NotificationController extends Controller {

    public function getIndex(){
        // if (auth()->check()) {

        //     $allowRoute = levels(auth()->user()->group_id);

        //     $route = \Request::route()->getName();

        //     if (!in_array($route, $allowRoute)) {
        //         abort('403');
        //     }
        // }

        $data = Device::join('users','devices.user_id','users.id')->select('devices.*','users.id as user_id', 'users.name as username')->get();
        return view('admin.notifs.all', compact('data'));
    }

    public function getNotif() {

        // if (auth()->check()) {

        //     $allowRoute = levels(auth()->user()->group_id);

        //     $route = \Request::route()->getName();

        //     if (!in_array($route, $allowRoute)) {
        //         abort('403');
        //     }
        // }

        $data = Device::join('users','devices.user_id','users.id')->select('devices.*','users.id as user_id', 'users.name as username')->get();

        $users = Device::all();

        return view('admin.notifs.index', compact('data' , 'users'));
    }

    public function send(Request $request) {


        $rules = [
            'msg' => 'required',
            'device_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('new-notif')->withErrors($validator)->withInput();
        }

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('طلتك');
        $notificationBuilder->setBody($request->msg)
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        //$token = "a_registration_from_your_database";

        
        if($request->device_id != 'all'){
            //case:push notif to one device
            $token = $request->device_id;
            $type = 'single';
            
        }else{
            //case:you push notif to all user
            $token = Device::where('device','!=','')->pluck('device')->toArray();
            if(count($token) == 0){
                $token = '';
            }
            $type = 'all';
            //dd($token);
        }
        if($token != ''){
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();

            //return Array - you must remove all this tokens in your database
            $downstreamResponse->tokensToDelete();

            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $downstreamResponse->tokensToModify();

            //return Array - you should try to resend the message to the tokens in the array
            $downstreamResponse->tokensToRetry();

            // return Array (key:token, value:errror) - in production you should remove from your database the tokens

            $notif = new Notification();
            $notif->msg = $request->msg;
            $tokens = [];
            if($type == 'all'){
                foreach($token as $user_token){
                    $user_id = Device::where('device',$user_token)->first();
                    if($user_id){
                        $user = User::find($user_id->user_id);
                        if($user){
                            array_push($tokens,$user->id);
                        }  
                    }
                }
                $notif->to_user = json_encode($tokens);
            }else{
                //$user = User::where('device_id',$token)->first();
                $user_id = Device::where('device',$user_token)->first();
                $notif->to_user = $user_id->user_id;
            }
            $notif->type = $type;
            $notif->save();
            return redirect()->route('new-notif')->with('mOk', 'تم الارسال بنجاح');
        }else{
            return redirect()->route('new-notif')->with('mNo', 'لم يتم الارسال');
        }
    }

}
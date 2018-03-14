<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Transformers\Json;
use App\User;
use Illuminate\Http\Request;
use Sms;

use Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function getResetTokens(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required'
        ]);

        if ($validator->fails()):
            return response()->json([
                'status' => false,
                'message' => 'thisfieldrequired',
                'data' => $validator->errors()
            ], 400);
        endif;

        $user = User::wherePhone($request->phone)->first();
        

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'phoneincorrect',
                'data' => null
            ], 400);
        }

        $reset_code = rand(1000, 9999);
        $user->action_code = $user->actionCode($reset_code);
        $user->save();
        
       // Sms::sendActivationCode('Reset code:' . $user->action_code, $request->phone);

        return response()->json([
                'status' => true,
                'message' => 'resetcodesent',
                 'data' => [
                    'reset_code' => $user->action_code
                ]
                
            ]
        );

    }


    public function resendResetPasswordCode(Request $request)
    {
        return $this->getResetTokens($request);
    }


}

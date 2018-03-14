<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Validator;
use UploadImage;

class UsersController extends Controller
{

    public $public_path;
    public $public_path_user;

    public function __construct()
    {
        $this->public_path = 'files/companies/';
        $this->public_path_user = 'files/users/';
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {

        $user = User::with('companies.city')->whereApiToken($request->api_token)->first();
        return response()->json([
            'status' => true,
            'data' => $user
        ]);

    }


    public function profileUpdate(Request $request)
    {
        $user = User::whereApiToken($request->api_token)->first();


        // Get Input
        $postData = $this->postData($request);

        // Declare Validation Rules.
        $valRules = $this->valRules($user->id);

        // Declare Validation Messages
        $valMessages = $this->valMessages();

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {


            $user->username = $request->name;
            $user->email = $request->email;
            $user->phone = $request->mobile;

            if ($request->hasFile('userImage')):
                $user->image = $request->root() . '/' . $this->public_path_user . UploadImage::uploadImage($request, 'userImage', $this->public_path_user);
            endif;

            if ($user->save() && $user->is_user == 1) {
                $company = $user->companies->first();
                $company->name = $request->name;
                $company->address = $request->address;
                $company->description = $request->description;
                $company->lat = $request->lat;
                $company->lng = $request->lng;
                $company->category_id = $request->category;
                $company->city_id = $request->city;
                $company->facebook = $request->facebook;
                $company->twitter = $request->twitter;
                $company->google = $request->google;

                if ($request->hasFile('image')):
                    $company->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
                endif;

                if ($company->save()) {
                    return response()->json([
                        'status' => true,
                        'data' => $user,
                        'code' => $user->action_code
                    ]);
                }
            } else {
                return response()->json([
                    'status' => true,
                    'data' => $user,
                    'code' => $user->action_code
                ]);
            }


        } else {
            // Grab Messages From Validator
            $valErrors = $valResult->messages();
            return response()->json([
                'status' => true,
                'data' => $valErrors,

            ], 400);
        }

    }

    public function changePassword(Request $request)
    {

        $user = User::whereApiToken($request->api_token)->first();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'newpassword' => 'required',
            'confirm_newpassword' => 'required|same:newpassword',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors(),
            ]);
        }
        $hashedPassword = $user->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->newpassword)
            ])->save();
            return response()->json([
                'status' => true,
                'message' => 'لقد تم تعديل كلمة المرور بنجاح',
                'data' => null
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'كلمة المرور القديمة غير صحيحة',
                'data' => null
            ]);
        }
    }


    public function logout(Request $request)
    {
        // Get User By Api Token
        $user = User::where('api_token', $request->api_token)->first();

        // Check if user exist and have devices

        //@@ then delete device Received from Resquest (PLAYESID)
        if ($user && $user->devices):
            $user->devices()->where('device', $request->playerId)->delete();
            return response()->json([
                'status' => true,
            ]);

        else :

            return response()->json([
                'status' => false,

            ]);

        endif;
    }


    /**
     * @param $request
     * @return array
     */
    private function postData($request)
    {
        return [
            'username' => $request->name,
            'mobile' => $request->mobile,
        ];
    }

    /**
     * @return array
     */
    private function valRules($id)
    {
        return [
            'username' => 'required|unique:users,username,' . $id,
            'mobile' => 'required|unique:users,phone,' . $id,
        ];
    }

    /**
     * @return array
     */
    private function valMessages()
    {
        return [
            'mobile.required' => trans('global.field_required'),
            'mobile.unique' => trans('global.unique_phone'),
            'password.required' => trans('global.field_required'),
            'password_confirmation.required' => trans('global.field_required'),
            'password_confirmation.same' => trans('global.password_not_confirmed'),
        ];
    }


}

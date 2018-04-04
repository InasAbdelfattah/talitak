<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Validator;
use UploadImage;
use Sms;
use App\Company;

class UsersController extends Controller
{

    public $public_path;
    public $public_path_user;

    public function __construct()
    {
        $this->public_path = 'files/companies/';
        $this->public_path_user = 'files/users/';
        $this->public_path_docs = 'files/docs/';
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {

        $user = User::with('company.city')->whereApiToken($request->api_token)->first();
        $user->company->name_en = $user->company->{'name:en'};
        $user->company->name_ar = $user->company->{'name:ar'};
        $user->company->description_en = $user->company->{'description:en'};
        $user->company->description_ar = $user->company->{'description:ar'};
        $user->company->city->name_ar = $user->company->city->{'name:ar'};
        $user->company->city->name_en = $user->company->city->{'name:en'};
        return response()->json([
            'status' => true,
            'data' => $user
        ]);

    }


    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        //$user = User::whereApiToken($request->api_token)->first();

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

            if($request->has('username') && $request->username != ''):
                $user->name = $request->username;
            endif;

            if($request->has('user_email') && $request->user_email != ''):
                $user->email = $request->user_email;
            endif;

            if($request->has('user_phone') && $request->user_phone != ''):
                $user->phone = $request->user_phone;
                $reset_code = rand(1000, 9999);
                $user->action_code = $user->actionCode($reset_code);
                Sms::sendActivationCode('activation code:'.$user->action_code , $user->phone);
            endif;

            if ($request->hasFile('userImage')):
                $user->image = UploadImage::uploadImage($request, 'userImage', $this->public_path_user);
            endif;

            if ($user->save() && $user->is_provider == 1) {
                $company = Company::where('user_id',$user->id)->first();
               if($company){

                    if($request->has('name_ar') && $request->name_ar != ''):
                        $company->{'name:ar'} = $request->name_ar;
                        $company->nameAr = $request->name_ar;
                    endif;
    
                    if($request->has('name_en') && $request->name_en != ''):
                        $company->{'name:en'} = $request->name_en;
                    endif;
    
                    if($request->has('description_ar') && $request->description_ar != ''):
                        $company->{'description:ar'} = $request->description_ar;
                    endif;
    
                    if($request->has('description_en') && $request->description_en != ''):
                        $company->{'description:en'} = $request->description_en;
                    endif;
    
                    if($request->has('city') && $request->city != ''):
                        $company->city_id = $request->city;
                    endif;
                    
                    if($request->has('district') && $request->district != ''):
                        $company->district_id = $request->district;
                    endif;
    
                    if($request->has('providerType') && $request->providerType != ''):
                        $company->type = $request->providerType;
                    endif;
    
                    if ($request->hasFile('document_photo')):
                    //if ($request->has('document_photo')):
                        $company->document_photo = uploadImage($request, 'document_photo', $this->public_path_docs, 1280, 583);
                        //$company->document_photo = save64Img($request->document_photo , $this->public_path_docs);
                    endif;
    
                    if($request->has('address') && $request->address != ''):
                        $company->address = $request->address;
                    endif;
    
                    if($request->has('lat') && $request->lat != ''):
                        $company->lat = $request->lat;
                    endif;
    
                    if($request->has('lng') && $request->lng != ''):
                        $company->lng = $request->lng;
                    endif;
    
                    if($request->has('category') && $request->category != ''):
                        $company->category_id = $request->category;
                    endif;
    
                    if ($request->hasFile('image')):
                        $company->image = UploadImage::uploadImage($request,'image', $this->public_path);
                    endif;
    
                    if ($company->save()) {
                        $user->company->name_en = $company->{'name:en'};
                        $user->company->name_ar = $company->{'name:ar'};
                        $user->company->description_en = $company->{'description:en'};
                        $user->company->description_ar = $company->{'description:ar'};
                        return response()->json([
                            'status' => true,
                            'data' => $user,
                            'code' => $user->action_code
                        ]);
                    }
                
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

    public function getUserById($id){
        $user = User::where('id',$id)->select('id','name','phone','gender','image')->first();
        if(! $user){
            return response()->json([
                'status' => false,
                'message' => 'مستخدم غير موجود',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'تم',
            'data' => $user
        ]);
    }


    public function logout(Request $request)
    {
        
        // Get User By Api Token
        //$user = auth()->user();

        $user = User::where('api_token', $request->api_token)->first();
        if(!$user){
            return response()->json([
                'status' => false,
            ]);
        }

        // Check if user exist and have devices

        //@@ then delete device Received from Resquest (PLAYERID)
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
            'username' => $request->username,
            'phone' => $request->user_phone,
            'email' => $request->user_email,
        ];
    }

    /**
     * @return array
     */
    private function valRules($id)
    {
        return [
            //'username' => 'required',
            'phone' => 'regex:/(05)[0-9]{8}/|unique:users,phone,' . $id,
            'password' =>'confirmed'
        ];
    }

    /**
     * @return array
     */
    private function valMessages()
    {
        return [
            'phone.required' => trans('global.field_required'),
            'phone.unique' => trans('global.unique_phone'),
            'password.required' => trans('global.field_required'),
            'password_confirmation.required' => trans('global.field_required'),
            'password_confirmation.same' => trans('global.password_not_confirmed'),
        ];
    }
}

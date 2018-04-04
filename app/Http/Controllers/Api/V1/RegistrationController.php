<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\NotifyAdminJoinApp;
use App\Events\NotifyUsers;
use App\Company;
use App\UserInvitation;
use App\Image;
use App\Notifications\NotifyAdminForJoinCompanies;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use UploadImage;
use Sms;
use Auth;
 

class RegistrationController extends Controller
{

    public $public_path;
    public $public_path_docs ;

    public function __construct()
    {
        $this->public_path = 'files/companies/';
        $this->public_path_docs = 'files/docs/';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/(05)[0-9]{8}/|unique:users,phone',
            'password' => 'required|confirmed|min:3|max:255',
            //'document_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

            $user = new User();

            $user->gender = $request->gender;
            $user->is_invited = $request->is_invited ;
            $user->name = $request->name;
            $user->email = $request->email ? $request->email : '';
            $user->phone = trim($request->phone);
            $user->password = bcrypt(trim($request->password));
            $user->api_token = str_random(60);
            $code = rand(1000, 9999);
            $code = $user->userCode($code);
            $user->code = $code;
            $user->is_user = 1;
            $user->is_provider = $request->userType;
            $actionCode = rand(1000, 9999);
            $actionCode = $user->actionCode($actionCode);
            $user->action_code = $actionCode;
            $user->address = $request->address ? $request->address : '';
            $user->lat = $request->lat ? $request->lat : '';
            $user->lng = $request->lng ? $request->lng : '';
            $user->save();

            $access_token = $user->createToken($request->name)->accessToken;

            if($user->id && $request->userType != 1){
                    //send sms to user with activation code
                Sms::sendActivationCode('activation code:'.$user->action_code , $user->phone);
            }

            if ($request->is_invited == 1) {

                $invitor = User::where('phone',$request->invitor_phone)->first();
                //dd($invitor);

                if($invitor){
                    $newModel = new UserInvitation();
                    $newModel->invited_by = $invitor->id;
                    $newModel->user_id = $user->id ;
                    $newModel->save();
                }

                // else{
                //     return response()->json([
                //         'status' => true,
                //         'data' => 'رقم هاتف المستخدم المدعو من خلاله المستخدم غير موجود',
                //     ]);
                // }    
            }

            if ($request->userType == 1) {
                $company = new Company;
                $company->user_id = $user->id;
                $company->name = $request->name_ar;
                $company->nameAr = $request->name_ar;
                $company->{'name:ar'} = $request->name_ar;
                $company->{'name:en'} = $request->name_en;
                $company->{'description:ar'} = $request->description_ar;
                $company->{'description:en'} = $request->description_en;
                $company->city_id = $request->city;
                $company->district_id = $request->district;
                $company->type = $request->providerType;

                if ($request->hasFile('document_photo')):
                //if ($request->has('document_photo')):
                    //$company->document_photo = uploadImage($request, 'document_photo', $this->public_path_docs, 1280, 583);
                    $company->document_photo = UploadImage::uploadImage($request, 'document_photo', $this->public_path_docs);
                    //$company->document_photo = save64Img($request->document_photo , $this->public_path_docs);
                endif;

                $company->description = $request->description_ar;
                $company->category_id = $request->category;
                $company->is_comment = 1;
                $company->is_rate = 1;
                $company->phone = '';
                $company->place = '';
                $company->facebook = '';
                $company->twitter = '';
                $company->google = '';
                $company->is_agree = 0;
                $company->is_active = 0;

                $company->address = $request->address ? $request->address : '';
                $company->lat = $request->lat ? $request->lat : '';
                $company->lng = $request->lng ? $request->lng : '';
                

                //if ($request->hasFile('image')):
                if ($request->has('image')):
                    //$company->image = save64Img($request->image , $this->public_path);
                    $company->image = UploadImage::uploadImage($request, 'image', $this->public_path);
                    // $company->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
                endif;

                if ($company->save()) {

                    $message = "لديك طلب إلتحاق مركز جديد للتطبيق ($company->{'name:ar'})";
                    $users = User::whereHas('roles', function ($q) {
                        $q->where('name', 'owner');
                    })->get();

//                    event(new NotifyUsers($users, $company, $message, 0));

                    foreach ($users as $user) {
                        event(new NotifyAdminJoinApp($user->id, $company->id, $message, 0));
                        $user->notify(new NotifyAdminForJoinCompanies($user->id, $company->id, $message, 0));
                    }



                    return response()->json([
                        'status' => true,
                        'data' => $user,
                        'code' => $user->action_code ,
                        'token' => $access_token
                    ]);
                }
            } else {
                return response()->json([
                    'status' => true,
                    'data' => $user,
                    'code' => $user->action_code,
                    'token' => $access_token

                ]);
            }

    }


    public function companyCompleteData(Request $request)
    {

        $user = User::byToken($request->api_token);

        /**
         * Count of company 0 mean that this user haven't companies.
         */
//        if ($user->companies->count() == 0) {

        if (isset($request->companyId)) {
            $company = Company::byId($request->id);
        } elseif ($user->companies->count() == 0) {
            $company = new Company;
        } else {
            return response()->json([
                'status' => true,
                'message' => [
                    'developer' => 'Please, specify Company you want edit.'
                ]
            ]);
        }
        $company->facebook = $request->facebook;
        $company->twitter = $request->twitter;
        $company->google = $request->google;

        if ($request->hasFile('image')):
            $company->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;


        if ($user->companies()->save($company)) {

            $idsArr = "1,2,3,4";
            $data = explode(',', $idsArr);

            foreach ($data as $key => $value) {
                $advImage = Image::whereId($value)->first();
                $advImage->company_id = $company->id;
                $advImage->imageable_id = $company->id;
                $advImage->imageable_type = 'App\Company';
                $advImage->save();
            }


            $data = $user->load('companies.membership');
            return response()->json([
                'status' => true,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => [],
            ], 400);
        }


    }

}

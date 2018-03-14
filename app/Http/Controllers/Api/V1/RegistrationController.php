<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\NotifyAdminJoinApp;
use App\Events\NotifyUsers;
use App\Company;
use App\Image;
use App\Notifications\NotifyAdminForJoinCompanies;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use UploadImage;

class RegistrationController extends Controller
{

    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/companies/';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {


        // Get Input
        $postData = $this->postData($request);

        // Declare Validation Rules.
        $valRules = $this->valRules();

        // Declare Validation Messages
        $valMessages = $this->valMessages();

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {

            $user = new User();
            $user->username = $request->name;
            $user->email = $request->email;
            $user->phone = $request->mobile;
            $user->password = $request->password;

            $user->api_token = str_random(60);
            $code = rand(10000000, 99999999);
            $code = $user->userCode($code);
            $user->code = $code;

            $user->is_user = $request->userType;

            $actionCode = rand(1000, 9999);
            $actionCode = $user->actionCode($actionCode);
            $user->action_code = $actionCode;

            if ($user->save() && $request->userType == 1) {
                $company = new Company;
                $company->user_id = $user->id;
                $company->name = $request->name;
                $company->address = $request->address;
                $company->description = $request->description;
                $company->lat = $request->lat;
                $company->lng = $request->lng;
                $company->category_id = $request->category;
                $company->city_id = $request->city;

                if ($request->hasFile('image')):
                    $company->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
                endif;

                if ($company->save()) {


                    $message = "لديك طلب إلتحاق منشأة جديدة للطبيق ($company->name)";
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


    /**
     * @param $request
     * @return array
     */
    private function postData($request)
    {
        return [
            'username' => $request->name,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ];
    }

    /**
     * @return array
     */
    private function valRules()
    {
        return [
            'username' => 'required|unique:users,username',
            'mobile' => 'required|unique:users,phone',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];
    }

    /**
     * @return array
     */
    private function valMessages()
    {
        return [
            'username.required' => trans('global.field_required'),
            'username.unique' => trans('global.unique_username'),
            'mobile.required' => trans('global.field_required'),
            'mobile.unique' => trans('global.unique_phone'),
            'password.required' => trans('global.field_required'),
            'password_confirmation.required' => trans('global.field_required'),
            'password_confirmation.same' => trans('global.password_not_confirmed'),
        ];
    }


}

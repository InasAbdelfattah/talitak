<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use \App\Device;
use App\Http\Helpers\Main;

class LoginController extends Controller
{

    public $main;

    public function __construct(Main $main)
    {

        $this->main = $main;


    }


    public function login(Request $request)
    {

        // Get Input
        $postData = $this->postData($request);

        // Declare Validation Rules.
        $valRules = $this->valRules();

        // Declare Validation Messages
        $valMessages = $this->valMessages();

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        if ($valResult->passes()) {


            $user = User::wherePhone($request->phone)->first();

            if ($user) {
                if (!$user->is_active)
                    return response()->json([
                        'status' => false,
                        'message' => 'accountnotactivated.',
                        'data' => $user
                    ], 401);
            } else {
                return response()->json([
                    'status' => false,
                    'data' => "عفواً, الرقم غير الذى ادخلته غير صحيح"
                ], 404);
            }


            if ($user = Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'is_active' => 1])) {

                if (!auth()->user()->api_token) {
                    auth()->user()->api_token = str_random(60);
                    auth()->user()->save();
                }


                $this->manageDevices($request, auth()->user());
                $this->makeUserOnline(auth()->user());

                $user = auth()->user();

                if ($user->is_user == 1) {
                    $user->companies = $user->companies()->with('city')->first();
                    $user->categories = $this->getCategoryForCompany((int)$user->companies->category_id);
                }
                // $user->companies['parent'] = $user->companies->category;
                return response()->json([
                    'status' => true,
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'phoneorpasswordisincorrect',
                    'data' => null
                ], 400);
            }
        } else {
            // Grab Messages From Validator
            return response()->json([
                'status' => true,
                'data' => $valResult->messages(),

            ] );
        }


    }


    private function getCategoryForCompany($id)
    {
        $category = Category::with('parent')->whereId($id)->first();

        return $category;
    }


    public function postActivationCode(Request $request)
    {


        // Get Input
        $postData = array(
            'phone' => $request->phone,
            'activation_code' => $request->activation_code,
        );

        // Declare Validation Rules.
        $valRules = array(
            'phone' => 'required',
            'activation_code' => 'required',
        );

        // Declare Validation Messages
        $valMessages = array(
            'phone.required' => trans('global.field_required'),
            'activation_code.required' => trans('global.field_required'),
        );

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);


        if ($valResult->passes()) {

            $user = User::where(['phone' => $request->phone,
                'action_code' => $request->activation_code])
                ->first();

            if ($user && $user->is_active == 0) {
                $user->is_active = 1;
                $user->update();

                $this->manageDevices($request, $user);
                $this->makeUserOnline($user);

                return response()->json([
                    'status' => true,
                    'message' => 'activationcodecodecorrect',
                    'data' => $user
                ]);


            } elseif ($user && $user->is_active == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'activatedbefore',
                    'data' => $user
                ], 400);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'activationcodeisincorrect',
                    'data' => $user
                ]);
            }


        } else {
            // Grab Messages From Validator
            return response()->json([
                'status' => true,
                'data' => $valResult->messages(),

            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @@ Resend Activation Code.
     */

    public function resendActivationCode(Request $request)
    {


        // Get Input
        $postData = array(
            'phone' => $request->phone,
        );

        // Declare Validation Rules.
        $valRules = array(
            'phone' => 'required',
        );

        // Declare Validation Messages
        $valMessages = array(
            'phone.required' => trans('global.field_required'),
        );

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);


        if ($valResult->passes()) {

            $user = User::wherePhone($request->phone)->first();
            if (isset($user)) {
                $code = rand(100000, 999999);
                $activation_code = $user->actionCode($code);
                $user->action_code = $activation_code;
                if ($user->save()) {

                    return response()->json([
                        'status' => true,
                        'message' => 'the activation code has been sent successfully.',
                        'code' => $user->action_code
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'accountnotfound'
                ], 400);
            }


        } else {
            // Grab Messages From Validator
            return response()->json([
                'status' => true,
                'data' => $valResult->messages(),

            ], 400);
        }
    }


    /**
     * @param $user
     * @return mixed
     * @make User online Over All Application.
     */


    private function makeUserOnline($user)
    {
        $user->is_online = 1;
        return $user->save();
    }


    /**
     * @param $request
     * @@ User Device Management
     */
    private function manageDevices($request, $user = null)
    {

        if ($request->playerId) {
            $devices = Device::pluck('device')->toArray();
            $data = in_array($request->playerId, $devices);
            if ($data) {
                $device = Device::whereDevice($request->playerId)->first();
                $device->user_id = $user->id;
                $device->save();
            } else {
                $device = new Device;
                $device->device = $request->playerId;
                $user->devices()->save($device);
            }
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function postData($request)
    {
        return [
            'phone' => $request->phone,
            'password' => $request->password,
        ];
    }

    /**
     * @return array
     */
    private function valRules()
    {
        return [
            'phone' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * @return array
     */
    private function valMessages()
    {
        return [
            'phone.required' => trans('global.field_required'),
            'password.required' => trans('global.field_required'),
        ];
    }

}

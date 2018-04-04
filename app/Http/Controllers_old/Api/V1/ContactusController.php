<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support;
use Validator;

class ContactusController extends Controller
{
    //user_id`, `email`, `phone`, `name`, `parent_id`, `type`, `reply_type`, `message`, `is_read`,
    public function postMessage(Request $request){

    	$rules = [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/(05)[0-9]{8}/',
            'type' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
            //return response()->json(['status'=>false,'data' => $validator->errors()->all()]);
        }

        $newModel = new Support();
        $newModel->name = $request->name;
        $newModel->phone = $request->phone;
        //type == 1 => complain , type == 2 => suggest , type == 3 => other
        $newModel->type = $request->type;
        $newModel->message = $request->message;

        if($request->has('user_id') && $request->user_id != ''){
        	$newModel->user_id = $request->user_id ;
        }else{
        	$newModel->user_id = 0;
        }

        $newModel->parent_id = 0 ;
        $newModel->reply_type = 0 ;
        $newModel->is_read = 0 ;
        $newModel->email = '';
        $newModel->save();

        return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'تم الإرسال'
            ]);

    }
}

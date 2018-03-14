<?php

namespace App\Http\Controllers\Api\V1;

use App\Support;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @@ POST MESSAGE...
     */
    public function postMessage(Request $request)
    {

        $user = User::whereApiToken($request->api_token)->first();

        $support = new Support;
        $support->message = $request->message;
        $support->type = $request->type;
        $support->email = $request->email;
        $support->parent_id = 0;
        if ($user->support()->save($support)) {
            return response()->json([
                'status' => true,

            ], 200);
        } else {
            return response()->json([
                'status' => false,

            ]);
        }
    }
}

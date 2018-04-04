<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\User;
use App\Rate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use willvincent\Rateable\Rating;

class RatesController extends Controller
{
    public function postRating(Request $request)
    {
        $user = User::byToken($request->api_token);

        $validator = Validator::make($request->all(), [
            'centerId' => 'required',
            'orderId' => 'required',
            //'userId' => 'required',
            'rateValue' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ]);
        }

        if ($request->api_token) {

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                    'data' => []
                ]);
            }

            $company = Company::where('id',$request->centerId)->first();
            if(!$company){
                return response()->json([
                    'status' => false,
                    'message' => 'center not found',
                    'data' => []
                ]);
            }
            
            $userRatingBefore = Rate::where('company_id', $request->centerId)->where('user_id', $user->id)->where('order_id', $request->orderId)->first();

            if ($userRatingBefore) {
                $userRatingBefore->rate = $request->rateValue;
                $userRatingBefore->price = $request->price;
                $userRatingBefore->save();

                return response()->json([
                    'status' => true,
                    'message' => 'the user ' . $user->name . ' updated the rate.',
                    'data' => $request->rateValue,
                    'rating' => $company->rates()->avg('rate')
                ]);
            }

            $rating = new Rate;
            $rating->rate = $request->rateValue;
            $rating->price = $request->price;
            $rating->order_id = $request->orderId;
            $rating->company_id = $request->centerId;
            $rating->user_id = $user->id;
            if($user->is_provider == 1 && $user->id == $company->user_id){
                $rating->rate_from = 'provider';
            }else{
                $rating->rate_from = 'user' ;
            }

            $rating->save();

            // $userCurrent = User::whereId($request->user_id)->whereIsActive(1)->first();
            // $userCurrent->notify(new \App\Notifications\AddRateForAgentNotification($user->averageRating));
            return response()->json([
                'status' => true,
                'message' => 'you rated successfully.',
                'data' => $request->rateValue,
                'rating' => $company->rates()->avg('rate')
            ]);

        }
    }

}

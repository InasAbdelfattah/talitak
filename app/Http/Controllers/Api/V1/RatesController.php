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
        // `user_id`, `company_id`, `order_id`, `rate`, `rate_from`, `price`
        $user = User::byToken($request->api_token);

        $validator = Validator::make($request->all(), [
            'centerId' => 'required',
            'orderId' => 'required',
            'userId' => 'required',
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
            $company = Company::find($request->centerId);

            $rating = new Rate;
            $userRatingBefore = $rating->where('company_id', $request->centerId)->where('user_id', auth()->id())->first();

            if ($userRatingBefore) {
                $userRatingBefore->rating = $request->rateValue;
                $company->ratings()->save($userRatingBefore);

                return response()->json([
                    'status' => true,
                    'message' => 'the user ' . auth()->user()->name . ' updated the rate.',
                    'data' => $request->rateValue,
                    'rating' => $company->averageRating
                ]);
            }

            $rating->rating = $request->rateValue;
            $rating->user_id = $user->id;

            $company->ratings()->save($rating);

            if ($company->ratings) {
                // $userCurrent = User::whereId($request->user_id)->whereIsActive(1)->first();
                // $userCurrent->notify(new \App\Notifications\AddRateForAgentNotification($user->averageRating));
                return response()->json([
                    'status' => true,
                    'message' => 'you rated successfully.',
                    'data' => $request->rateValue,
                    'rating' => $company->averageRating
                ]);
            }
        }
    }

}

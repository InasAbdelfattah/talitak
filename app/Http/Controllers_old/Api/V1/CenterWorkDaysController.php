<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\CompanyWorkDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CenterWorkDaysController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function saveWorkDay(Request $request)
    {

        $rules = [
           //'from' => array('regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]|60)$/'),
            'centerId' => 'integer|required',
            'day'      => 'string|required|min:6|max:9',
            //'day'      => 'date_format:"D"|required',
            'from'     => 'date_format:"H:i"|required|before:to',
            'to'       => 'date_format:"H:i"|required|after:from',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }
        /**
         * @ GET company...
         */
        $company = Company::whereId($request->centerId)->first();

        if (!$company)
            return response()->json(['status' => false, 'message' => 'Company Not Found in System']);

//`day`, `from`, `to`, `company_id`
        $model = new CompanyWorkDay;
        $model->day = $request->day;
        $model->from = $request->from;
        $model->to = $request->to;


        if ($company->workDays()->save($model)) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function update(Request $request)
    {
        $model = CompanyWorkDay::whereId($request->workDayId)->first();

        if($request->has('day') && $request->day != ''):
            $model->day = $request->day;
        endif;

        if($request->has('from') && $request->from != ''):
            $model->from = $request->from;
        endif;

        if($request->has('to') && $request->to != ''):
            $model->to = $request->to;
        endif;

        if ($model->save()) {
            return response()->json([
                'status' => true,
                'data' => $model
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Delete
     */

    public function delete(Request $request)
    {
        $model = CompanyWorkDay::whereId($request->workDayId)->first();

        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'هذا اليوم غير موجود'
             ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف اليوم بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لقد حدث خطأ, من فضلك حاول مرة آخرى'
            ]);
        }
    }

    public function list(Request $request , $locale)
    {
        
        $workDays = CompanyWorkDay::where('company_id', $request->centerId)
            ->select('id','day','from','to','company_id as centerId')->get();

        // $workDays->map(function ($q)  {

        //     $q->day_ar = day($q->day);
        //     //$q->day_en = $q->day;
        // });

        if($workDays->count() > 0){
            if($locale == 'ar'){
                $workDays->map(function ($q) {
                    $q->name = day($q->day);
                });
            }else{
                $workDays->map(function ($q) {
                    $q->name = $q->day;
                });
            }
        }

        return response()->json([
            'status' => true,
            'data' => $workDays
        ]);

    }

}

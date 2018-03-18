<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserDiscount;
use App\UserInvitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Auth;


class UserDiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        
        return view('admin.discounts.index' , compact('users'));
    }

    public function show($id){
        $discount = UserDiscount::where('user_id',$id)->get();
    }

    public function addDiscount(Request $request){
        
        $user = User::find($request->userId);

        // $rules = [
        //     'discount' => 'required',
        //     'from_date' => 'required',
        //     'to_date' => 'required',
        //     'maxOrders' => 'required',
        // ];

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {

        //     $error_arr = validateRules($validator->errors(), $rules);
        //     return response()->json(['status'=>false,'message' => $validator->errors()->all()]);
        
        // }

        if ($request->discount == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة الخصم',
            ]);
        }

        if ($request->maxOrders == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كابة اقصى عدد للطلبات المتاح للمستخدم الاستفادة منها للخصم',
            ]);
        }

        if ($request->from_date == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة تاريخ بداية الاستفادة من الخصم',
            ]);
        }

        if ($request->to_date == '') {
            return response()->json([
                'status' => false,
                'message' => 'يرجى كتابة تاريخ نهاية الاستفادة من الخصم',
            ]);
        }

        if ($user) {

            $model = new UserDiscount();

            $model->user_id = $request->userId ;
            $model->created_by = Auth::user()->id;
            $model->registered_users_no = $request->invitedCounts ;
            $model->discount = $request->discount ;
            $model->max_orders = $request->maxOrders ;
            $model->from_date = $request->from_date ;
            $model->to_date = $request->to_date ;

            if ($model->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'تم الحفظ',
                    'id' => $model->id
                ]);
            }
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }

    public function userDiscounts(){

        $discounts = UserDiscount::join('users','user_discounts.user_id','users.id')->select('user_discounts.*' , 'users.id as user_id' , 'users.name as username' , 'users.phone as user_phone')->groupBy('user_discounts.user_id')->get();

        return view('admin.discounts.discounts' , compact('discounts'));
    }
}

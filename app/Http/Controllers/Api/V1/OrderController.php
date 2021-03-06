<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;
use App\Setting;
use Validator;
use App\FinancialAccount;
use UploadImage;
use App\CompanyWorkDay;
use App\Service;
use App\UserDiscount;

class OrderController extends Controller
{
    
    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/pays/';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */

    public function getUserOrders(){

        $user = auth()->user();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'user not found',
                'data' => []
            ]);
        }

        $orders = Order::where('user_id', $user->id)->select('id','place','order_date','order_time','lat','lng','address','price','discount_accept','user_id','service_id','company_id as centerId' , 'provider_id' , 'status' , 'refuse_reasons','user_is_finished')->get();

        $ordersCount = $orders->count();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => ['ordersCount' => $ordersCount , 'orders' => $orders ]
        ]);
    }

    public function changeOrderStatus(Request $request){
        $provider = auth()->user();
        if(!$provider){
            return response()->json([
                'status' => false,
                'message' => 'user not found',
                'data' => []
            ]);
        }

        $order = Order::find($request->orderId);

        if(!$order){
            return response()->json([
                'status' => false,
                'message' => 'order not found',
                'data' => []
            ]);
        }

        if($order->provider_id != $provider->id){
            return response()->json([
                'status' => false,
                'message' => 'user is not the provider of this service',
                'data' => []
            ]);
        }

        $order->status = $request->status;
        if($request->status == 2){
            $rules = [
                'refuse_reason' => 'required|string|min:2',
            ];

            // $msgs = [
            //     'refuse_reasons.required' => 'لا بد مم ذكر سبب الرفض',
            // ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                //$errors = $validator->messages();
                $errors = validateRules($validator->errors(), $rules);
                return response()->json(['status'=>false,'message' => $errors]);
            }

            $order->refuse_reasons = $request->refuse_reason;
        }

        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => ['order' => $order ]
        ]);

    }

    public function providerNewOrders(){

        $provider = auth()->user();
        $center = Company::where('user_id',$provider->id)->first();

        if(!$center){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }

        $orders = Order::where('company_id', $center->id)->where('status',0)->select('id','place','order_date','order_time','lat','lng','address','price','discount_accept','discount','user_id','service_id','company_id as centerId' , 'provider_id' , 'status')->get();

        $ordersCount = $orders->count();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => ['ordersCount' => $ordersCount , 'orders' => $orders ]
        ]);
    }

    public function providerFinishedOrders(){

        $provider = auth()->user();
        $center = Company::where('user_id',$provider->id)->first();

        if(!$center){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }

        $totalOrders = Order::where('company_id', $center->id)->where('status',3)->get();

        $totalProfit = 0 ;
        
        if(count($totalOrders) > 0){
        
            foreach($totalOrders as $order){

                $totalProfit += $order->price;
            };
        
        }
        $totalAppRatio = Setting::getBody('commission') * $totalProfit /100;


        $orders = Order::where('company_id', $center->id)->where('status',3)->where('is_considered',0)->get();

        $profit = 0 ;
        
        if(count($orders) > 0){

            foreach($orders as $order){

                $profit += $order->price;
            };
        }

        $appRatio = Setting::getBody('commission') * $profit /100;

        $ordersCount = $orders->count();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => ['ordersCount' => $ordersCount , 'totlalProfit' => $profit , 'totalAppRatio' => $totalAppRatio ,'appRatio' => $appRatio]
        ]);
    }

    public function payAppRatio(Request $request){
        $provider = auth()->user();
        $center = Company::where('user_id',$provider->id)->first();

        if(!$center){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }

        $rules = [
            'transfered_money' => 'required',
            'ordersCount' => 'required|integer|min:1',
            'appRatio' => 'required',
            'pay_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);

            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $orders = Order::where('company_id',$center->id)->get();

        if(count($orders) > 0){

            foreach($orders as $order){

                $order->is_considered = 1 ;

                $order->save();

            }
        }
        
        $model = FinancialAccount::where('company_id',$center->id)->first();
        if(!$model){
            $newModel = new FinancialAccount();
            $newModel->company_id = $center->id;
            $newModel->orders_count = $request->ordersCount;
            $newModel->net_app_ratio = $request->appRatio;
            $newModel->transfered_money = $request->transfered_money;
            $newModel->pay_status = 1;
            if ($request->hasFile('pay_photo')):
                $newModel->pay_doc = UploadImage::uploadImage($request,'pay_photo', $this->public_path);
            else:
                $newModel->pay_doc = '';
            endif; 

            $newModel->paid = 0;
            $newModel->remain = 0;
            $newModel->is_confirmed = 0;
            $newModel->save();

            return response()->json([
                'status' => true,
                'message' => 'done',
                'data' => []
            ]);
        }

        $model->orders_count = $request->ordersCount;
        $model->net_app_ratio = $request->appRatio;
        $model->transfered_money = $request->transfered_money;
        $model->pay_status = 1;

        if ($request->hasFile('pay_photo')):
            $model->pay_doc = UploadImage::uploadImage($request,'pay_photo', $this->public_path);
        endif; 

        $model->is_confirmed = 0;
        $model->save();

        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => []
        ]);
    }

    public function saveOrder(Request $request){
        
        $user = auth()->user();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'user not found',
                'data' => []
            ]);
        }

        $rules = [
            'place' => 'required',
            'centerId' => 'required',
            'serviceId' => 'required',
            'order_date' => 'date_format:"Y-m-d"|required',
            'order_time' => 'date_format:"H:i:s"|required',
        ];

        $discounts = UserDiscount::where('user_id',$user->id)->where('to_date','>=',date('Y-m-d'))->where('is_used',0)->get();

        if($discounts->count() > 0){
            $rules['discount_accept'] = 'required';
        }

        if($request->discount_accept == 1){
            $rules['discountId'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);

            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $company = Company::find($request->centerId);
        $service = Service::find($request->serviceId);
        if(!$company){
            return response()->json([
                'status' => false,
                'message' => 'center not found',
                'data' => []
            ]);
        }

        if(!$service){
            return response()->json([
                'status' => false,
                'message' => 'service not found',
                'data' => []
            ]);
        }

        $workDays = CompanyWorkDay::where('company_id',$company->id)->get();
        $days = $workDays->pluck('day')->toArray();
        $day = date('D', strtotime($request->order_date));

        if(!in_array($day, $days)){

            return response()->json([
            'status' => false,
            'message' => 'day out of work days',
            'data' => $day
        ]);
        }

        $time_range = $workDays->where('day',$day)->first();

        if(!( $request->order_time >= $time_range->from && $request->order_time <= $time_range->to )){

            return response()->json([
                'status' => false,
                'message' => 'time out of work day time',
                'data' => $day
            ]);
        }

        //`gender`, `place`, `order_date`, `order_time`, `notes`, `lat`, `lng`, `address`, `price`, `discount_accept`, `user_id`, `service_id`, `company_id`, `provider_id`, `status`, `user_is_finished`, `is_considered`, `refuse_reasons`

        $newModel = new Order();
        $newModel->user_id = $user->id;
        $newModel->gender = 'male';
        $newModel->place = $request->place;
        if($request->place == 'home'){

            $rules = [
                'lat' => 'required',
                'lng' => 'required',
                'address' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = validateRules($validator->errors(), $rules);
                return response()->json(['status'=>false,'message' => $errors]);
            }

            $newModel->lat = $request->lat ;
            $newModel->lng = $request->lng ;
            $newModel->address = $request->address;
        }else{

            $newModel->lat = '' ;
            $newModel->lng = '' ;
            $newModel->address = '';
        }
        $newModel->notes = '';
        $newModel->order_date = $request->order_date;
        $newModel->order_time = $request->order_time;
        $newModel->price = $service->price;
        $newModel->discount_accept = $request->discount_accept;
        $newModel->company_id = $request->centerId;
        $newModel->service_id = $request->serviceId;
        $newModel->provider_id = $company->user_id;
        $newModel->status = 0;
        $newModel->user_is_finished = 0;
        $newModel->is_considered = 0;
        $newModel->refuse_reasons = '';
        

        if($request->discount_accept == 1){
            //send order with user discount to provider
            $discount = UserDiscount::where('id',$request->discountId)->first();

            if($discount){

                $discount->is_used = 1 ;
                $discount->save();
                $newModel->discount = $discount->discount;
            }

        }else{
            //send order only to provider
            $newModel->discount = 0;
        }

        $newModel->save();

        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => []
        ]);
    }

    public function checkUserDiscounts(){
        $user = auth()->user();
        if(!$user){
            return response()->json([
                'status' => false ,
                'message' => 'user not found' ,
                'data' => []
            ]);
        }

        $discounts = UserDiscount::where('user_id',$user->id)->where('to_date','>=',date('Y-m-d'))->where('is_used',0)->get();

        if($discounts->count() > 0){
            return response()->json([
                'status' => true ,
                'message' => '' ,
                'data' => $discounts
            ]);
        }else{
            return response()->json([
                'status' => false ,
                'message' => 'no discounts' ,
                'data' => []
            ]);
        }

    }

}

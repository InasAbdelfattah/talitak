<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Order;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.category_id as serviceType' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc')->get();

        return view('admin.orders.index' , compact('orders'));
    }

    public function search(Request $request)
    {
        $orders = [] ;
        if ($request->service_type != '' && $request->service_provider == '') {
            
            $serviceType = Category::where('name_ar','like','%'.$request->service_type.'%')->first();
            if($serviceType){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('companies.category_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.category_id as serviceType' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc')->get(); 
            }

        }elseif ($request->service_type == '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like','%'.$request->service_provider.'%')->first();
            
            if($serviceProvider){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('companies.user_id',$serviceProvider->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.category_id as serviceType' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc')->get(); 
            }

        }elseif ($request->service_type != '' && $request->service_provider != '') {
            
            $serviceProvider = User::where('name','like',$request->service_provider)->first();
            $serviceType = Category::where('name_ar','like',$request->service_type)->first();
            if($serviceType && $serviceProvider){
                $orders = Order::join('companies','orders.company_id','companies.id')->join('users','orders.user_id','users.id')->join('services','orders.service_id','services.id')->where('companies.user_id',$serviceProvider->id)->where('companies.category_id',$serviceType->id)->select('orders.*','companies.id as company_id' , 'companies.name as company_name' , 'companies.category_id as serviceType' ,'companies.place as company_place' , 'companies.user_id as provider_id','companies.city_id as city_id','users.id as user_id' , 'users.name as username' , 'services.id as service_id' , 'services.name as service_name', 'services.description as service_desc')->get(); 
            }
        }else{

            return back()->with(compact('orders'))->with('fail','من فضلك يرجى كتابة اسم مزود الخدمة أو اختيار نوع الخدمة');

        }
        return view('admin.orders.index' , compact('orders'));

    }

    public function getFinancialAccounts()
    {
        $orders = [];
        return view('admin.orders.accounts' , compact('orders'));
    }

    public function getFinancialReports()
    {
        $orders = [];
        return view('admin.orders.reports' , compact('orders'));
    }

}

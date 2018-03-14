<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Company;
use App\Service;
use App\ServiceType;
use App\Order;
use App\User;
use App\Rate;
use App\Support;
use App\Abuse;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use willvincent\Rateable\Rating;

class HomeController extends Controller
{

    public function index()
    {
        $data['centersCount'] = Company::count();
        $data['usersCount'] = User::whereDoesntHave('roles')->where('is_provider',0)->get()->count();
        $data['providersCount'] = User::whereDoesntHave('roles')->where('is_provider',1)->get()->count();
        $data['serviceTypes_app'] = ServiceType::get()->count();
        $data['services_app'] = Service::get()->count();
        $data['orders'] = Order::get()->count();
        $data['read_contacts'] = Support::where('is_read',1)->get()->count();
        $data['notread_contacts'] = Support::where('is_read',0)->get()->count();
        $data['notadoptedreports'] = Abuse::where('is_adopt',0)->get()->count();
        $data['mens_count'] = User::where('is_user',1)->where('gender','male')->get()->count();
        $data['womens_count'] = User::where('is_user',1)->where('gender','female')->get()->count();
        $data['categoriesCount'] = Category::all()->count();
        return view('admin.home.index')->with(compact('data'));
    }
}

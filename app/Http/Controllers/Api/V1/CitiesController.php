<?php

namespace App\Http\Controllers\Api\V1;

use App\City;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    public function index($locale)
    {
       $cities =  City::select('id')->get();

        $cities->map(function ($q) use($locale)  {
            $q->name = $q->{'name:'.$locale};
        });

        $districts =  District::select('id' , 'city_id')->get();

        $districts->map(function ($q) use($locale)  {
            $q->name = $q->{'name:'.$locale};
        });

        $districts->map(function ($q)  {

        });

        return response()->json([
            'status' => true,
            'data' => ['citites' => $cities , 'districts' => $districts]
        ]);
    }
}

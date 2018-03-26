<?php

namespace App\Http\Controllers\Api\V1;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    public function index()
    {
       $cities =  City::select('id')->get();
       $cities->map(function ($q)  {
            $q->name_ar = $q->{'name:ar'};
            $q->name_en = $q->{'name:en'};
            

        });
        return response()->json([
            'status' => true,
            'data' => $cities
        ]);
    }
}

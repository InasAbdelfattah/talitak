<?php

namespace App\Http\Controllers\Api\V1;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    public function index()
    {
       $cities =  City::get();
        return response()->json([
            'status' => true,
            'data' => $cities
        ]);
    }
}

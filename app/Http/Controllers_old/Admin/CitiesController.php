<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Auth;


class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        $cities = City::get();

        return view('admin.cities.index')->with(compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        return view('admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        // Get Input
        $postData = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ];

        // Declare Validation Rules.
        $valRules = [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];

        // Declare Validation Messages
        $valMessages = [
            'name_ar.required' => 'اسم المدينة عربى مطلوب',
            'name_en.required' => 'اسم المدينة انجليزى مطلوب',
        ];

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {

            $city = new City;
            $city->{'name:ar'} = $request->name_ar;
            $city->{'name:en'} = $request->name_en;

            $city->created_by = Auth::user()->id;

            $city->save();

            session()->flash('success', 'لقد تم إضافة المدينة بنجاح.');
            return redirect()->route('cities.index');


        } else {
            // Grab Messages From Validator
            $valErrors = $valResult->messages();
            // Error, Redirect To User Edit
            return redirect()->back()->withInput()
                ->withErrors($valErrors);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        $city = City::findOrFail($id);

        return view('admin.cities.edit')->with(compact('city'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        $city = City::findOrFail($id);

        // Get Input
        $postData = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ];

        // Declare Validation Rules.
        $valRules = [
            'name_en' => 'required',
            'name_ar' => 'required',
        ];

        // Declare Validation Messages
        $valMessages = [
            'name_ar.required' => 'اسم المدينة عربى مطلوب',
            'name_en.required' => 'اسم المدينة انجليزى مطلوب',
        ];

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {


            $city->{'name:ar'} = $request->name_ar;
            $city->{'name:en'} = $request->name_en;

            $city->created_by = Auth::user()->id;

            $city->save();

            session()->flash('success', 'لقد تم تعديل المدينة بنجاح.');
            return redirect()->route('cities.index');


        } else {
            // Grab Messages From Validator
            $valErrors = $valResult->messages();
            // Error, Redirect To User Edit
            return redirect()->back()->withInput()
                ->withErrors($valErrors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function groupDelete(Request $request)
    {

        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }

        $ids = $request->ids;

        $arrsCannotDelete = [];
        foreach ($ids as $id) {
            $model = City::findOrFail($id);

            if ($model->centers->count() > 0) {
                $arrsCannotDelete[] = $model->name;
            } else {
                $model->delete();
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ],
            'message' => $arrsCannotDelete
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (!Gate::allows('cities_manage')) {
            return abort(401);
        }
        
        $model = City::findOrFail($request->id);

        if ($model->centers->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => "عفواً, لا يمكنك حذف المدينة لوجود مراكز بها"
            ]);
        }

        if ($model->districts->count() > 0) {
            foreach($model->districts as $district){
                $district->delete();
            }
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\City;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Auth;

class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::get();

        return view('admin.districts.index')->with(compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.districts.create' , compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        // Get Input
        $postData = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'city_id' => $request->city_id,
        ];

        // Declare Validation Rules.
        $valRules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'city_id' => 'required',
        ];

        // Declare Validation Messages
        $valMessages = [
            'name_ar.required' => 'اسم الحى عربى مطلوب',
            'name_en.required' => 'اسم الحى انجليزى مطلوب',
            'city_id.required' => 'المدينة مطلوب',
        ];

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {

            $district = new District;
            $district->{'name:ar'} = $request->name_ar;
            $district->{'name:en'} = $request->name_en;
            $district->city_id = $request->city_id;
            $district->created_by = Auth::user()->id;

            $district->save();

            session()->flash('success', 'لقد تم إضافة الحى بنجاح.');
            return redirect()->route('districts.index');


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
        $district = District::findOrFail($id);
        $cities = City::all();

        return view('admin.districts.edit')->with(compact('district' , 'cities'));

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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $district = District::findOrFail($id);

        // Get Input
        $postData = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'city_id' => $request->city_id,
        ];

        // Declare Validation Rules.
        $valRules = [
            'name_en' => 'required',
            'name_ar' => 'required',
            'city_id' => 'required',
        ];

        // Declare Validation Messages
        $valMessages = [
            'name_ar.required' => 'اسم المدينة عربى مطلوب',
            'name_en.required' => 'اسم المدينة انجليزى مطلوب',
            'city_id.required' => 'المدينة مطلوبة',
        ];

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {


            $district->{'name:ar'} = $request->name_ar;
            $district->{'name:en'} = $request->name_en;
            $district->city_id = $request->city_id;

            $district->created_by = Auth::user()->id;

            $district->save();

            session()->flash('success', 'لقد تم تعديل الحى بنجاح.');
            return redirect()->route('districts.index');


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

        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $ids = $request->ids;

        $arrsCannotDelete = [];
        foreach ($ids as $id) {
            $model = District::findOrFail($id);

            // if ($model->services->count() > 0) {
            //     $arrsCannotDelete[] = $model->name;
            // } else {
            //     $model->delete();
            // }
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
        $model = District::findOrFail($request->id);

        // if ($model->centers->count() > 0) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => "عفواً, لا يمكنك حذف المدينة لوجود مراكز بها"
        //     ]);
        // }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }

}

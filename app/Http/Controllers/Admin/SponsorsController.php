<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use Validator;
use UploadImage;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sponsor;

class SponsorsController extends Controller
{

    /**
     * @var Category
     */


    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/sponsors/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsor::get();

        return view('admin.sponsors.index')->with(compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $companies = Company::where('is_active', 1)->get();

        return view('admin.sponsors.create')->with(compact('companies'));
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


        $sponsor = new Sponsor;

        if ($request->type == 0):
            $sponsor->url = $request->url;
        else:
            $sponsor->company_id = $request->company;
        endif;

        $sponsor->type = $request->type;


        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):
            $sponsor->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;


        $sponsor->save();

        session()->flash('success', 'لقد تم إضافة الإعلان بنجاح.');
        return redirect()->route('sponsors.index');


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
        /**
         * @@ Get Password For Sponsor
         */
        $sponsor = Sponsor::findOrFail($id);
        $companies = Company::where('is_active', 1)->get();
        return view('admin.sponsors.edit')->with(compact('sponsor', 'companies'));


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

        $sponsor = Sponsor::findOrFail($id);


        if ($request->type == 0):

            $sponsor->url = $request->url;
            $sponsor->company_id = NULL;

        else:
            
            $sponsor->company_id = $request->company;
            $sponsor->url = NULL;

        endif;

        $sponsor->type = $request->type;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):
            $sponsor->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;


        $sponsor->save();

        session()->flash('success', 'لقد تم تعديل بيانات الإعلان.');
        return redirect()->route('sponsors.index');


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
        foreach ($ids as $id) {
            $model = Sponsor::findOrFail($id);
            $model->delete();
        }


        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
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
        $model = Sponsor::findOrFail($request->id);

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $model->id
            ]);
        }
    }
}

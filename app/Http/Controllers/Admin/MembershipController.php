<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use Validator;
use UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Membership;


class MembershipController extends Controller
{

    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/memberships/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //  if (! Gate::allows('users_manage')) {
//        return abort(401);
//    }
//
//        $users = User::with('roles')->get();
//
//        return view('admin.users.index', compact('users'));

//        $page = request('pageSize');
//        $name = request('name');
//
//        ## GET ALL CATEGORIES PARENTS
//        $query = Membership::select();
//        // $categories = Category::paginate($pageSize);
//
//
//        if ($name != '') {
//            $query->where('name', 'like', "%$name%");
//        }
//
//        $query->orderBy('created_at', 'DESC');
//        $memberships = $query->paginate(($page) ?: 10);
//
//
//        if ($name != '') {
//            $memberships->setPath('membership?name=' . $name);
//        } else {
//            $memberships->setPath('membership');
//        }
//
//
//        if ($request->ajax()) {
//            return view('admin.membership.load', ['memberships' => $memberships])->render();
//        }
        $query = Membership::select();
        $query->orderBy('created_at', 'DESC');
        $memberships = $query->get();

        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.membership.index', compact('memberships'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.membership.create');
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
        $postData = $this->postData($request);

        // Declare Validation Rules.
        $valRules = $this->valRules();

        // Declare Validation Messages
        $valMessages = $this->valMessages();

        // Validate Input
        $valResult = Validator::make($postData, $valRules, $valMessages);

        // Check Validate
        if ($valResult->passes()) {


            $membership = new Membership;
            $membership->name = $request->name;
            $membership->images = $request->images;
            $membership->offers = $request->offers;
            $membership->offer_time = $request->offer_time;
            $membership->color = $request->color;

            if ($request->allow_video) {

                $membership->allow_video = $request->allow_video;
            }

            $membership->price = $request->price;


            /**
             * @ Store Image With Image Intervention.
             */

            if ($request->hasFile('image')):
                $membership->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path, 1280, 583);
            endif;


            $membership->save();


            session()->flash('success', 'لقد تم إضافة العضوية بنجاح.');

            return redirect()->route('membership.index');


        } else {
            // Grab Messages From Validator
            $valErrors = $valResult->messages();

            // Error, Redirect To User Edit
            return redirect()->back()->withInput()
                ->withErrors($valErrors);

//            return response()->json([
//                'status' => false,
//                'data' => $valErrors,
//
//            ]);
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
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $membership = Membership::findOrFail($id);

        return view('admin.membership.edit', compact('membership'));
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


        $membership = Membership::findOrFail($id);


        $membership->name = $request->name;
        $membership->images = $request->images;
        $membership->offers = $request->offers;
        $membership->color = $request->color;

        if ($request->allow_video) {

            $membership->allow_video = 1;
        } else {
            $membership->allow_video = 0;
        }

        $membership->price = $request->price;


        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):

            $membership->image = $request->root() . '/' . $this->public_path . UploadImage::uploadImage($request, 'image', $this->public_path, 1280, 583);

            if (isset($request->oldImage) && $request->oldImage != '') {
                $regularPath = str_replace($request->root() . '/', '', $request->oldImage);

                if (\File::exists(public_path($regularPath))):
                    \File::delete(public_path($regularPath));
                endif;

            }
        endif;


        $membership->save();


        return redirect()->route('membership.index');
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
    public function delete(Request $request)
    {


        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $model = Membership::findOrFail($request->id);


        if ($model->companies->count() > 0) {

            return response()->json([
                'status' => false,
                'data' => [
                    'id' => $request->id
                ]
            ]);

        } else {

            $model->delete();
            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $request->id
                ]
            ]);


        }


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
            $user = Membership::findOrFail($id);
            $user->delete();
        }


        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);
    }


    /**
     * @param $request
     * @return array
     */
    private function postData($request)
    {
        return [
            'name' => $request->name,
            'images' => $request->images,
            'offers' => $request->offers,
        ];
    }

    /**
     * @return array
     */
    private function valRules()
    {
        return [
            'name' => 'required|unique:memberships,name',
            'images' => 'numeric|required',
            'offers' => 'numeric|required',
        ];
    }

    /**
     * @return array
     */
    private function valMessages()
    {
        return [
            'name.required' => trans('global.field_required'),
            'name.unique' => trans('global.unique_username'),

            'images.required' => trans('global.field_required'),
            'images.numeric' => trans('global.must_number'),

            'offers.required' => trans('global.field_required'),
            'offers.numeric' => trans('global.must_number'),
        ];
    }


    function filter(Request $request)
    {

        $name = $request->keyName;

        $page = $request->pageSize;

        ## GET ALL CATEGORIES PARENTS
        $query = Membership::select();
        // $categories = Category::paginate($pageSize);


        if ($name != '') {
            $query->where('name', 'like', "%$name%");
        }

        $query->orderBy('created_at', 'DESC');
        $memberships = $query->paginate(($page) ?: 10);

        if ($name != '') {
            $memberships->setPath('membership?name=' . $name);
        } else {
            $memberships->setPath('membership');
        }


        if ($request->ajax()) {
            return view('admin.membership.load', ['memberships' => $memberships])->render();
        }
        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.membership.index')
            ->with(compact('memberships'));
    }


}

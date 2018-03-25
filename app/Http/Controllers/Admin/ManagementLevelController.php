<?php

namespace App\Http\Controllers\Admin;




use App\ManagementLevel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ManagementLevelController extends Controller
{

    public function getIndex() {

        if(auth()->check()) {

            $allowRoute = levels(auth()->user()->group_id);

            $route = \Request::route()->getName();

            if(! in_array($route, $allowRoute)) {
                abort('403');
            }

        }

        $data = ManagementLevel::join('users','management_levels.created_by','users.id')->select('management_levels.*','users.id as user_id' ,'users.name as username')->orderBy('id')->get();

        $menu = menu();

        return view('admin.groups.showAll', ['data' => $data, 'menu' => $menu]);
    }

    public function getAdd() {

        if(auth()->check()) {

            $allowRoute = levels(auth()->user()->group_id);

            $route = \Request::route()->getName();

            if(! in_array($route, $allowRoute)) {
                abort('403');
            }

        }

        $data = menu();

        return view('admin.groups.add', ['data' => $data]);

    }


    public function postAdd(Request $request) {

        $rules = [
            'name' => 'required|min:3|max:255',
//            'items' => 'required|min:3|max:255',
        ];



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('level-add')->withErrors($validator)->withInput();

        }

        $newGroup = new ManagementLevel();

        $newGroup->name = $request->name;
        $newGroup->status = $request->status;
        $newGroup->items = json_encode($request->items);
        $newGroup->created_by = Auth::user()->id;

        return $newGroup->save() ?  redirect()->route('levels')->with('mOk', trans('messages.addOK')) :
                                    redirect()->route('levels')->with('mNo', trans('messages.addNo'))->withInput();

    }



    public function getEdit($id) {

        $data = ManagementLevel::where('id', $id)->firstOrFail();


        $groups = ManagementLevel::where('status', 1)->orderBy('id', 'DESC')->select('id', 'name')->get();

        return view('admin.groups.edit', ['data' => $data, 'groups' => $groups]);

    }



    public function postEdit(Request $request, $id) {


        $rules = [
            'name' => 'required|min:3|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('level-edit', ['id' => $id])->withErrors($validator)->withInput();

        }


        $data = ManagementLevel::where('id', $id)->first();


        $data->name = $request->name;
        $data->status = $request->status;
        $data->items = json_encode($request->items);


        return $data->save() ?  redirect()->route('level-edit', ['id' => $id])->with('mOk', trans('admin.editOK')) :
                                redirect()->route('level-edit', ['id' => $id])->with('mNo', trans('admin.editNo'))->withInput();


    }


    public function getDetails($id) {

        $data = ManagementLevel::join('users','management_levels.created_by','users.id')->select('management_levels.*','users.name as username')->where('id', $id)->firstOrFail();
        $menu = menu();
        return view('admin.groups.details', ['data' => $data, 'menu' => $menu]);

    }


    public function getDelete($id) {

        return ManagementLevel::destroy($id) ? redirect()->route('levels')->with('mOk', trans('admin.deleteOK')) :
                                      redirect()->route('levels')->with('mNo', trans('admin.deleteNo'))->withInput();


    }




}

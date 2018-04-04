<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
//use UploadImage;
use Image;
use Validator;

class UsersController extends Controller
{

    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/users/';
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->where('is_user',0)->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $roles = Role::get();

        $roles = $roles->reject(function ($q) {
            return $q->name == 'owner';
        });

//        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  StoreUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

            $user = new User;
           
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->api_token = str_random(60);
            $user->remember_token = csrf_token();
            $user->password = bcrypt(trim($request->password));

            $user->gender = 'male';
            $user->is_invited = 0;
            $user->is_active = $request->is_active ? $request->is_active : 0;
            $user->is_suspend = 0;
            $user->is_online = 0;
            $user->is_user = 0;
            $user->address = $request->address;


            /**
             * @ Store Image With Image Intervention.
             */

            if ($request->hasFile('image')):
                $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            endif;


            $code = rand(10000000, 99999999);
            $code = $user->userCode($code);
            $user->code = $code;
            $user->action_code = '';

            $user->save();

            if($request->has('roles') && count($request->roles) > 0 ){
                foreach ($request->input('roles') as $role) {
                    $user->assign($role);
                }
            }


          //  session()->flash('success', 'لقد تم إضافة المستخدم بنجاح.');

            return redirect()->route('users.index')->with('success', 'لقد تم إضافة المستخدم بنجاح.');

    }

    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'roles'));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
//      $roles = Role::get()->pluck('name', 'name');
        $roles = Role::get();
        $roles = $roles->reject(function ($q) {
            return $q->name == 'owner';
        });
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUsersRequest $request, $id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }

        $user = User::findOrFail($id);

        //$user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->is_active = $request->is_active;
        $user->is_suspend = $request->is_suspend;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // $user->lat = $request->lat;
        // $user->lng = $request->lng;
        $user->address = $request->address;

        /**
         * @ Store Image With Image Intervention.
         */

        if ($request->hasFile('image')):

            $user->image = uploadImage($request, 'image', $this->public_path, 1280, 583);

            if (isset($request->oldImage) && $request->oldImage != '') {
                $regularPath = str_replace($request->root() . '/', '', $request->oldImage);
                //dd($regularPath);
                if (\File::exists(public_path($regularPath))):
                    \File::delete(public_path($regularPath));
                endif;
    
            }

        endif;

        $user->save();

        if(count($user->roles) > 0 ){
            foreach ($user->roles as $role) {
                $user->retract($role);
            }
        }

        if($request->has('roles') && count($request->roles) > 0 ){
            foreach ($request->input('roles') as $role) {
                $user->assign($role);
            }
    }   

       // session()->flash('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");

        return redirect()->route('users.index')->with('success', "لقد تم تعديل المستخدم ($user->name) بنجاح");
    }

    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
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
        $user = User::findOrFail($request->id);
        $user->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);
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
            $user = User::findOrFail($id);
            $user->delete();
        }


        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);
    }


    public function groupSuspend(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }


        $ids = $request->ids;
        $suspended_users = [];
        foreach ($ids as $id) {
            $user = User::findOrFail($id);

            if($user->is_suspend == 1){

                //array_push($suspended_users, $user->id);
                return response()->json([
                'status' => false,
                'message' => 'يوجد مستخدمين محظورين من قبل',
            ]);
            }

            $user->is_suspend = 1 ;

            $user->save();
        }

        if(count($suspended_users) > 0){

            return response()->json([
                'status' => false,
                'message' => 'يوجد مستخدمين محظورين من قبل',
            ]);
        }
        

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->ids
            ]
        ]);


    }


    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    function filter(Request $request)
    {

        $name = $request->keyName;

        $page = $request->pageSize;

        ## GET ALL CATEGORIES PARENTS
        $query = User::with('roles')->select();
        // $categories = Category::paginate($pageSize);


        if ($name != '') {
            $query->where('name', 'like', "%$name%");
        }

        $query->orderBy('created_at', 'DESC');
        $users = $query->paginate(($page) ?: 10);

        if ($name != '') {
            $users->setPath('users?name=' . $name);
        } else {
            $users->setPath('users');
        }


        if ($request->ajax()) {
            return view('admin.users.load', ['users' => $users])->render();
        }
        ## SHOW CATEGORIES LIST VIEW WITH SEND CATEGORIES DATA.
        return view('admin.users.index')
            ->with(compact('users'));
    }

     /**
     * Display a list of providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewProvidersRequests()
    {
        //is_approved = [0 => new , 1 => approved , 2 => rejected]
        $providers = User::join('companies','users.id','companies.user_id')->where('users.is_user',1)->where('users.is_provider',1)->where('users.is_approved',0)->select('users.*','companies.id as company_id' , 'companies.name as company_name')->get();
        
        return view('admin.users.providers_orders', compact('providers'));
    }

    /**
     * Display a list of providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProviders()
    {
        $users = User::join('companies','users.id','companies.user_id')->where('users.is_user',1)->where('users.is_provider',1)->where('users.is_approved',1)->select('users.*','companies.id as company_id' , 'companies.name as company_name')->get();
        
        return view('admin.users.providers', compact('users'));
    }

    /**
     * Display a listing of app users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        $users = User::where('is_user',1)->where('is_provider',0)->get();
        
        return view('admin.users.users', compact('users'));
    }

    public function activation(Request $request)
    {

        if ($request->agree == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك قم باختيار او رفض مزود الخدمة    ',
            ]);
        }

        if ($request->agree == 2 && $request->reason == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك ادخل سبب الرفض  ',
            ]);
       }

        $provider = User::find($request->providerId);
        if ($provider) {

            $provider->is_approved = $request->agree;
            $provider->reject_reason = $request->reason ? $request->reason : '';

            // send activation code to provider here
            if($request->agree == 1){
                $msg = 'تم قبول مزود الخدمة' ;
            }else{
                $msg = 'تم رفض مزود الخدمة';
            }
            if ($provider->save()) {
                return response()->json([
                    'status' => true,
                    'message' => $msg,
                    'id' => $provider->id
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }


}

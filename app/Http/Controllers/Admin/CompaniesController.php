<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\CompanyWorkDay;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;


class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('user', 'category')
            ->whereIsAgree(1)
            ->get();
        $companies->map(function ($q) {
            $q->avgRate = $q->rates()->avg('rate');
            $q->name = $q->{'name:ar'};
            // $q->likesCount = $q->likes()->where('like', 1)->count();
            // $q->dislikesCount = $q->likes()->where('like', 0)->count();
            return $q;
        });

        return view('admin.companies.index')->with(compact('companies'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $companies = Company::with('user', 'category')
            ->whereIsAgree(0)
            ->get();

//        $companies->map(function ($q) {
//            $q->likesCount = $q->likes()->where('like', 1)->count();
//            $q->dislikesCount = $q->likes()->where('like', 0)->count();
//            return $q;
//        });
        return view('admin.companies.orders')->with(compact('companies'));
    }


    public function activation(Request $request)
    {

        if ($request->agree == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك قم باختيار قبول الطلب لتفعيل المركز',
            ]);
        }

        $compay = Company::find($request->companyId);
        if ($compay) {
            $compay->is_agree = 1;
            if ($compay->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'لقد تم الموافقة على المركز بنجاح',
                    'id' => $compay->id
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }
    }

    public function getCompanies()
    {
        $posts = Company::join('users', 'companies.user_id', '=', 'users.id')
            ->select(['companies.id', 'companies.name', 'users.name as uname', 'users.email', 'companies.created_at', 'companies.updated_at']);


        return Datatables::of($posts)
            ->addColumn('action', function ($user) {
                return '<a href="#edit-' . $user->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make(true);


//        return Datatables::of($companies)->make();

//        $companies = DB::table('companies')->select('*');
//        return DataTables::of($companies)
//            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::with('images', 'comments.user', 'favorites', 'rates', 'products' ,'workDays')->findOrFail($id);

//
        //$offers = $company->offers;
        // $offers->map(function ($q) use ($company) {
        //     $original = new Carbon($q->created_at);
        //     $date = $original->addDays($company->membership->offer_time);
        //     $q->offerExpireDate = is_object($date) ? $date->toDateTimeString() : '';
        //     $changeDate = strtotime($q->offerExpireDate) - strtotime(Carbon::now());
        //     $q->diffDate = $changeDate;
        //     return $q;
        // });

//        return $company;
        return view('admin.companies.show')->with(compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

        $model = Company::findOrFail($request->id);


        $model->delete();
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
            $user = Company::findOrFail($id);
            $user->delete();
        }


        return response()->json([
            'status' => true,
        ]);
    }

    public function deleteComment(Request $request){

        if (!Gate::allows('companies_manage')) {
            return abort(401);
        }

        $comment = Comment::find($request->id);
        
        if(! $comment){
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }

        $comment->delete() ;

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id
            ]
        ]);

    }

    public function suspendComment(Request $request){

        if (!Gate::allows('companies_manage')) {
            return abort(401);
        }

        $comment = Comment::find($request->id);

        if(!$comment){
            return response()->json([
                'status' => false,
                'message' => 'Fail',
            ]);
        }

        $comment->is_suspend = $comment->is_suspend == 1 ? 0 : 1;
        $comment->save();

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $request->id ,
                'suspend' => $comment->is_suspend
            ]
        ]);

    }

}

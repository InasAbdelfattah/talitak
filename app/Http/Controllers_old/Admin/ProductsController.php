<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller
{

    public function delete(Request $request)
    {

        if (!Gate::allows('companies_manage')) {
            return abort(401);
        }

        $model = Service::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'عفواً, هذه الخدمة غير موجود او ربما تم حذفها'
            ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف الخدمة بنجاح'
            ]);
        }

    }

    public function update(Request $request)
    {

        if (!Gate::allows('companies_manage')) {
            return abort(401);
        }
        
        $model = Service::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'عفواً, هذه الخدمة غير موجود او ربما تم حذفها'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Abuse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbuseController extends Controller
{
    public function index()
    {
        $supports = Support::whereParentId(0)->get();
        return view('admin.supports.index')->with(compact('supports'));
    }

    public function show($id)
    {

        //$message = Support::with('user')->whereId($id)->first();
        $message = Support::whereId($id)->first();
        $message->is_read = 1;
        $message->save();

        return view('admin.supports.show')->with(compact('message'));
    }

    public function reply(Request $request, $id)
    {
        if ($request->message == '' && $request->reply_type == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك ادخل بيانات الرسالة ثم اعد الإرسال'
            ]);
        }


        if ($request->message == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك ادخل نص الرد '
            ]);
        }


        if ($request->reply_type == '') {
            return response()->json([
                'status' => false,
                'message' => 'من فضلك اختار وسيلة الرد '

            ]);
        }


        $support = new Support;
        $support->message = $request->message;
        $support->phone = $request->phone ? $request->phone : '';
        $support->name = $request->name ? $request->name : '';
        $support->email = $request->email ? $request->email : '';
        $support->user_id = auth()->id();
        $support->type = -1;

        $support->reply_type = $request->reply_type;

        $support->parent_id = $id ;
        $support->is_read = 0;

        if ($support->save()) {
            $support->created = $support->created_at->format(' Y/m/d  ||  H:i:s ');
            return response()->json([
                'status' => true,
                'message' => 'لقد تم إرسال الرد بنجاح',
                'data' => $support

            ], 200);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function delete(Request $request)
    {
        $model = Support::findOrFail($request->id);


        if ($model->children->count() > 0) {
            
            foreach($model->children as $child){
                $child->delete();
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function getUserNotifications(Request $request)
    {
        /**
         * Set Default Value For Skip Count To Avoid Error In Service.
         * @ Default Value 15...
         */
        if (isset($request->pageSize)):
            $pageSize = $request->pageSize;
        else:
            $pageSize = 15;
        endif;
        /**
         * SkipCount is Number will Skip From Array
         */
        $skipCount = $request->skipCount;
        $itemId = $request->itemId;

        $currentPage = $request->get('page', 1); // Default to 1


        $user = User::whereApiToken($request->api_token)->first();


        $notifications = $user->notifications()->skip($skipCount + (($currentPage - 1) * $pageSize))
            ->take($pageSize)->get();

        $notifications->map(function ($q) {
            $q->since = $q->created_at->diffForHumans();
        });


//        foreach ($notifications as $notify) {
//
//            if ($notify->count() > 1) {
//                $count = $notify->count();
//            } elseif ($notify->count() == 1) {
//                $count = '';
//            }
//
//            $data[] = [
//                'message' => "لديك" . $count . "تعليق جديد علي" . $this->getCompanyNameByID($notify[0]['target_id']),
//                'data' => null,
//                'count' => $notify->count()
//            ];
//        }

        return response()->json([
            'status' => true,
            'data' => $notifications
        ]);
//        foreach ($notifications as $row) {
//
//            if ($row->count() == 1) {
//                $count = "";
//            } elseif ($row->count() > 1) {
//                $count = $row->count();
//            }
//
//            $data[$count] = " لديك " . $count . " تعليق على المنشأة (صيدلية عبده) ";
//            $data[$row[0]['target_id']] = $row[0]['target_id'];
//
//        }


    }


    public function getCompanyNameByID($id)
    {
        $company = Company::whereId($id)->first();
        return $company->name;
    }


    public function delete(Request $request)
    {

        $user = User::whereApiToken($request->api_token)->first();


//        return $user->notifications;
        $is_deleted = $user->notifications()->where('id', $request->notifyId)->delete();

        if ($is_deleted) {
            return response()->json([
                'status' => true,
                'count' => $user->unreadNotifications->count()
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}

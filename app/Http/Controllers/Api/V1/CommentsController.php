<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Company;
use App\Events\NotifyAdminJoinApp;
use App\Events\NotifyUsers;
use App\Notifications\CommentsNotification;
use App\User;
use App\Abuse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class CommentsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Comment Create New Comment.
     */
    public function saveComment(Request $request)
    {

        $rules = [
            'centerId' => 'integer|required',
            'comment' => 'required|string|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $company = Company::whereId($request->centerId)->first();

        $user = User::byToken($request->api_token);
        //$user = Auth::user();
        if ($request->comment) {
            $comment = new Comment;
            $comment->comment = $request->comment;
            if ($request->parent_id)
                $comment->parent_id = $request->parent_id;
            else
                $comment->parent_id = 0;

            $comment->user_id = $user->id;

            if ($company->comments()->save($comment)) {

//                $message = "لديك تعليق جديد على المنشأة $company->name";
//                event(new NotifyUsers($user, $company, $message, 0));

                return response()->json([
                    'status' => true,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }


//    private function getUsersAreFavoriteCompany($id, $userId)
////    {
////
//        // get company
//        $company = Company::whereId($id)->first();
//        $userFavorites = $company->favorites->filter(function ($q) use ($userId) {
//            return $q->id != $userId;
//        })->values();
//
//        return $userFavorites;
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Update comment.
     */

    public function updateComment(Request $request)
    {

        $rules = [
            'commentId' => 'integer|required',
            'comment' => 'required|string|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }


        $comment = Comment::whereId($request->commentId)->first();

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'commentnotfound',
                'data' => []
            ]);
        }


        if ($comment->user && $comment->user->api_token == $request->api_token) {
            if ($request->comment) {
                $comment->comment = $request->comment;
                if ($comment->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'commentupdated',
                        'data' => []
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'commentnotupdated',
                        'data' => []
                    ]);
                }
            }
        }

    }


    public function commentList(Request $request)
    {
        $rules = [
            'centerId' => 'integer|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }
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

        $query = Comment::with('user')
            ->where('commentable_id', $request->centerId)
            ->orderBy('created_at', 'desc')
            ->select();

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        if (isset($request->filterby) && $request->filterby == 'date') {
            $query->orderBy('created_at', 'desc');
        }
        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $comments = $query->get();

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $comments
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Comment Delete.
     */
    public function deleteComment(Request $request)
    {
        $rules = [
            'commentId' => 'integer|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $comment = Comment::whereId($request->commentId)->first();
        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'commentnotfound',
                'data' => []
            ]);
        }

        if ($comment->user && $comment->user->api_token == $request->api_token) {

            if ($comment->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'commentdeleted',
                    'data' => []
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'commentnotdeleted',
                    'data' => []
                ]);
            }
        }
    }

    public function abuseComment(Request $request){
        // `user_id`, `company_id`, `abuseable_id`, `text`, `text`, `is_adopt`,
        $newModel = new Abuse();
        $newModel->user_id = $request->user_id ;
        $newModel->company_id = $request->center_id ;
        $newModel->abuseable_id = $request->comment_id ;
        $newModel->abuseable_type = 'App\Comment' ;
        $newModel->text = $request->text ;
        $newModel->is_adopt = 0 ;
        $newModel->save();

        return response()->json([
            'status' => true,
            'message' => 'commentabused',
            'data' => []
        ]);
    }
}

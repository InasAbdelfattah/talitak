<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Company;
use App\Events\NotifyAdminJoinApp;
use App\Events\NotifyUsers;
use App\Notifications\CommentsNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Comment Create New Comment.
     */
    public function saveComment(Request $request)
    {



        $company = Company::whereId($request->companyId)->first();

        $user = User::byToken($request->api_token);
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
//
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
            ->where('commentable_id', $request->companyId)
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
}

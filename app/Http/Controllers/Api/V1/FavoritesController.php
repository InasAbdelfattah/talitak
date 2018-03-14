<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoritesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function favoriteCompany(Request $request)
    {
        $user = auth()->user();
        try {
            if ($request->type == 1):
                $user->favorites()->syncWithoutDetaching($request->companyId);
            else:
                $user->favorites()->detach($request->companyId);
            endif;

            return response()->json([
                'status' => true,
                'message' => 'successaddtofavorite',
                'data' => []
            ]);

        } catch (QueryException $e) {

            return response()->json([
                'status' => false,
                'message' => 'erroraddtofavorite',
                'data' => []
            ]);
        }
    }


    public function getFavoriteListForUser(Request $request)
    {
        $user = User::whereApiToken($request->api_token)->first();
        $arrs = [];
        foreach ($user->favorites as $row) {
            $arrs[] = $row->id;
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
        $query = Company::whereIn('id', $arrs);

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */
        $favorites = $query->get();

        /**
         * Return Data Array
         */
        return response()->json([
            'status' => true,
            'data' => $favorites
        ]);


    }


//    public function favorite(Request $request)
//    {
//        $user = User::whereApiToken($request->api_token)->first();
//        try {
//            $user->favorites()->syncWithoutDetaching($request->advId);
//            return response()->json([
//                'status' => true,
//                'message' => 'successaddtofavorite',
//                'data' => []
//            ]);
//
//        } catch (QueryException $e) {
//
//            return response()->json([
//                'status' => false,
//                'message' => 'erroraddtofavorite',
//                'data' => []
//            ]);
//        }
//    }
//
//
//    public function unfavorite(Request $request)
//    {
//        $user = User::whereApiToken($request->api_token)->first();
//        try {
//
//            $user->favorites()->detach($request->advId);
//            return response()->json([
//                'status' => true,
//                'message' => 'successremovefromfavorite',
//                'data' => []
//            ]);
//        } catch (QueryException $e) {
//
//            return response()->json([
//                'status' => false,
//                'message' => 'errorremovefromfavorite',
//                'data' => []
//            ]);
//        }
//    }
//
//
//    public function favoritesList(Request $request, $pageSize = 15)
//    {
//        $user = User::whereApiToken($request->api_token)
//            ->with('favorites')
//            ->first();
//
//
//        $favs = $user->favorites;
//        $favs->map(function ($q)  {
//            $q->names = $this->getLangsNames($q->id);
//
//
//            $q->cities = $this->getCityNames($q->id);
//
//            return $q;
//        });
//
//
//
//        if ($favs->count() > 0)
//            return response()->json([
//                'status' => true,
//                'data' => $this->paginate($favs, $request->pageSize, $request->page)
//            ]);
//        else
//            return response()->json([
//                'status' => true,
//                'data' => $this->paginate($favs, $request->pageSize, $request->page)
//            ]);
//    }


}

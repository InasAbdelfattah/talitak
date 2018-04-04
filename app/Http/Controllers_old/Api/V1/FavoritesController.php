<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator ; 

class FavoritesController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function favoriteCompany(Request $request)
    {
        $rules = [
            'centerId' => 'integer|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $error_arr = validateRules($validator->errors(), $rules);
            return response()->json(['status'=>false,'data' => $error_arr]);
        }

        $user = auth()->user();

        try {
            if ($request->type == 1):
                $user->favorites()->syncWithoutDetaching($request->centerId);
            else:
                $user->favorites()->detach($request->centerId);
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

        $user = auth()->user();
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

}

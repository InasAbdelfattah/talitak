<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

class CategoriesController extends Controller
{
    
    
    
    function __construct(){
        app()->setlocale(request('lang'));
    }
    
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
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
        //$query = Category::select('id','name_ar','name_en','image')->whereParentId(0);
        
        $query = Category::select('id','name_'.$request->lang.' as name','description_'.$request->lang.' as description','image')->whereParentId(0);
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
        $categories = $query->get();

        /**
         * Return Data Array
         */
        return response()->json([
            'status' => true,
            'data' => $categories
        ]);

    }


    public function getSubCategories(Request $request, $id)
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
        $query = Category::whereParentId($id);

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
        $categories = $query->get();

        /**
         * Return Data Array
         */
        return response()->json([
            'status' => true,
            'data' => $categories
        ]);

    }

}

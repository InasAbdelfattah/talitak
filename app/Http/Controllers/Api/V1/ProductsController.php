<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UploadImage;

class ProductsController extends Controller
{

    public $public_path;

    public function __construct()
    {
        $this->public_path = 'files/companies/products/';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function saveProduct(Request $request)
    {

        /**
         * @ GET company...
         */
        $company = Company::whereId($request->centerId)->first();

        if (!$company)
            return response()->json(['status' => false, 'message' => 'Company Not Found in System']);

        $product = new Service;
        //$product->name = $request->name_ar;
        $product->{'description:ar'} = $request->description_ar;
        $product->{'description:en'} = $request->description_en;
        $product->{'name:ar'} = $request->name_ar;
        $product->{'name:en'} = $request->name_en;
        $product->price = $request->price;
        $product->gender_type = $request->gender;
        $product->provider_type = $request->provider_type;
        $product->serviceType_id = $request->serviceType_id;
        $product->service_place = $request->service_place;
        $product->provider_id = $company->user_id;
        $product->district_id = 0;
        $product->seen_count = 0;
        $product->status = 0;

        if ($request->hasFile('image')):
            $product->photo = UploadImage::uploadImage($request, 'image', $this->public_path);
        else:
            $product->photo = '';
        endif;

        if ($company->products()->save($product)) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function productsList(Request $request)
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

        $query = Service::where('company_id', $request->centerId)
            ->orderBy('created_at', 'desc')
            ->select();

        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }

        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */

        $products = $query->select('id','price','photo as image' , 'gender_type as gender' , 'provider_type' ,'service_place' ,'serviceType_id' , 'company_id' , 'created_at')->get();

        $products->map(function ($q)  {

            $q->name_ar = $q->{'name:ar'};
            $q->name_en = $q->{'name:en'};
            $q->description_ar = $q->{'description:ar'};
            $q->description_en = $q->{'description:en'};
            
        });

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $products
        ]);

    }


    public function update(Request $request)
    {
        $model = Service::whereId($request->serviceId)->first();

        if($request->has('description_ar') && $request->description_ar != ''):
            $model->{'description:ar'} = $request->description_ar;
        endif;

        if($request->has('description_en') && $request->description_en != ''):
            $model->{'description:en'} = $request->description_en;
        endif;

        if($request->has('name_ar') && $request->name_ar != ''):
            $model->{'name:ar'} = $request->name_ar;
        endif;

        if($request->has('name_en') && $request->name_en != ''):
            $model->{'name:en'} = $request->name_en;
        endif;

        if($request->has('price') && $request->price != ''):
            $model->price = $request->price;
        endif;

        if($request->has('gender') && $request->gender != ''):
            $model->gender_type = $request->gender;
        endif;

        if($request->has('provider_type') && $request->provider_type != ''):
            $model->provider_type = $request->provider_type;
        endif;

        if($request->has('serviceType_id') && $request->serviceType_id != ''):
            $model->serviceType_id = $request->serviceType_id;
        endif;

        if($request->has('service_place') && $request->service_place != ''):
            $model->service_place = $request->service_place;
        endif;

        if ($request->hasFile('image') && $request->image != ''):
            $model->photo = UploadImage::uploadImage($request, 'image', $this->public_path);
        endif;

        if ($model->save()) {
            return response()->json([
                'status' => true,
                'data' => $model
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Delete
     */

    public function delete(Request $request)
    {
        $model = Service::whereId($request->centerId)->first();

        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'هذه الخدمة غير موجودة'
            ]);
        }

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف الخدمة بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لقد حدث خطأ, من فضلك حاول مرة آخرى'
            ]);
        }


    }

}

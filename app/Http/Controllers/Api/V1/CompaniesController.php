<?php

namespace App\Http\Controllers\Api\V1;

use App\Conversation;
use App\Category;
use App\User;
use DB;
use App\Company;
use App\Service;
use App\CompanyWorkDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    public function details(Request $request)
    {
        $currentUser = User::whereApiToken($request->api_token)->first();


        $company = Company::with('images')->whereId($request->centerId)->select('id','user_id','category_id','phone','type','city_id','image','document_photo','visits_count')->first();
        $company->visits_count += 1;
        $company->save();

        $company->user->id;
        $currentUser->id;

        $company->name_ar = $company->{'name:ar'};
        $company->name_en = $company->{'name:en'};
        $company->description_ar = $company->{'description:ar'};
        $company->description_en = $company->{'description:en'};
        $company->place = $company->place == 0 ? 'منزل' : 'مركز';
        $company->providerType = $company->type == 0 ? 'فرد' : 'مركز';

        // $hasConversation = Conversation::whereHas('users', function ($q) use ($company) {
        //     $q->whereId($company->user->id);
        // })->whereHas('users', function ($q) use ($currentUser) {
        //     $q->whereId($currentUser->id);
        // })->first();


        // $visit = $company->visits()->where([
        //     'company_id' => $request->companyId,
        //     'ip' => $request->playerId
        // ])->first();

        // if (!$visit && $request->playerId) {
        //     $view = new Visit;
        //     $view->ip = $request->playerId;
        //     $company->visits()->save($view);
        // }

//        if(auth()->user())
//        {
        //$company->likes = $company->likes()->where('like', 1)->count();
        //$company->dislike = $company->likes()->where('like', 0)->count();
        $company->services = $this->getCompanyServices($company->id);
        $company->workDays = $this->getCompanyWorkDays($company->id);
        $company->workDaysCount = $company->workDays()->count();
        $company->favorites = $company->favorites()->count();
        $company->ratings = $company->rates()->where('user_id', auth()->id())->count();
        $company->rate = $company->rates()->avg('rate');
        $company->commentsCount = $company->comments()->count();
        //$company->hasConversation = ($hasConversation) ? true : false;
        // if ($hasConversation)
        //     $company->conversationId = $hasConversation->id;


//        }
        //$company->visits = $company->visits()->count();

        /**
         * Return Data Array
         */
        return response()->json([
            'status' => true,
            'data' => $company
        ]);
    }


    public function companiesList(Request $request)
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


        $query = Company::orderBy('created_at', 'desc')->select();


        $query->whereIsAgree(1);
        /**
         *
         * @@ Get By Name Of Company.
         */
        if ($request->companyName) :
            $query->where('name', 'Like', "%$request->companyName%");
        endif;

        /**
         * @@ Get By Name Of Product Related for Company.
         */
        if ($request->productName) :
            $query->whereHas('products', function ($q) use ($request) {
                $q->where('name', 'like', "%$request->productName%");
            })->get();
        endif;

        /**
         *
         * @@ Get By City Of Company.
         */
        if ($request->city) :
            $query->where('city_id', '=', $request->city);
        endif;


        /**
         * @@ Get By City Of Company.
         */

        if ($request->mainCategory) {

            $categories = Category::whereParentId($request->mainCategory)->get();

            $arrIds = [];

            foreach ($categories as $category):
                $arrIds[] = $category->id;
            endforeach;
            $query->whereIn('category_id', $arrIds);

        }


        /**
         * @@ Get By City Of Company.
         */

        if ($request->subCategory) {


            $query->where('category_id', $request->subCategory);

        }


        /**
         * @ If item Id Exists skipping by it.
         */
        if ($itemId) {
            $query->where('id', '<=', $itemId);
        }


        if (isset($request->filterby) && $request->filterby == 'date') {
            $query->orderBy('created_at', 'desc');
        } elseif (isset($request->filterby) && $request->filterby == 'visits') {
//            $query->whereHas('products', function ($q) use ($request) {
//                $q->where('company_id', $q->id);
//            })->get();
        }


        /**
         * @@ Skip Result Based on SkipCount Number And Pagesize.
         */
        $query->skip($skipCount + (($currentPage - 1) * $pageSize));
        $query->take($pageSize);

        /**
         * @ Get All Data Array
         */


//        if($request->visits){
//            /**
//             * @@ Get By Name Of Product Related for Company.
//             */
//
//            $query->whereHas('visits', function ($q) use ($request) {
//                    $q->orderBy('name', 'like', "%$request->productName%");
//                })->get();
//
//        }

        $companies = $query->select('id','user_id','category_id','phone','type','city_id','image','document_photo','visits_count')->get();
        $companies->map(function ($q) use ($request) {
            //$q->likes = $q->likes()->where('like', 1)->count();
            //$q->dislike = $q->likes()->where('like', 0)->count();
            $q->name_ar = $q->{'name:ar'};
            $q->name_en = $q->{'name:en'};
            $q->description_ar = $q->{'description:ar'};
            $q->description_en = $q->{'description:en'};
            $q->place = $q->place == 0 ? 'منزل' : 'مركز';
            $q->providerType = $q->type == 0 ? 'فرد' : 'مركز';
            //$q->favorites = $q->favorites()->count();
            //$q->currentUserRating = $q->rates()->where('user_id', auth()->id())->count();
            $q->rate = $q->rates()->avg('rate');
            //$q->visits = $q->visits()->count();
            $q->email = ($user = $this->companyCompleteFromUser($q->id)) ? $user->email : null;
            $q->city = $this->getCityForCompany($q->id);
            $q->commentsCount = $this->getCountsForCompany($q->id);
            $q->services = $this->getCompanyServices($q->id);
            $q->workDays = $this->getCompanyWorkDays($q->id);

        });

        if (isset($request->filterby) && $request->filterby == 'visits') {
            $sorted = $companies->sortByDesc('visits');
            $companies = $sorted->values()->all();
        }

        if (isset($request->filterby) && $request->filterby == 'rate') {
            $sorted = $companies->sortByDesc('ratings');
            $companies = $sorted->values()->all();
        }

        /**
         * Return Data Array
         */

        return response()->json([
            'status' => true,
            'data' => $companies
        ]);
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
     * @param $company
     * @return array|null
     */

    private function getCountsForCompany($company)
    {
        $company = Company::with('comments')->whereId($company)->first();

        return ($company && $company->comments) ? $company->comments->count() : NULL;
    }

    /**
     * @param $company
     * @return array|null
     */

    private function getCompanyServices($company)
    {
        $services = Service::where('company_id',$company)->select('id','company_id as centerId')->get();
        $services->map(function ($q)  {
            $q->name_ar = $q->{'name:ar'};
            $q->name_en = $q->{'name:en'};
            

        });
        return $services ? $services : NULL;
    }

    private function getCompanyWorkDays($company)
    {
        $workDays = CompanyWorkDay::where('company_id',$company)->select('id','day' ,'from' ,'to' , 'company_id as centerId')->get();
        $workDays->map(function ($q)  {
            $q->name_ar = day($q->day);
            $q->name_en = $q->day;
            

        });
        return $workDays ? $workDays : NULL;
    }

    /**
     * @param $company
     * @return array|null
     */

    private function getMembershipForCompany($company)
    {
        $company = Company::with('membership')->whereId($company)->first();
        return ($company && $company->membership) ? [
            'id' => $company->membership->id,
            'name' => $company->membership->name,
            'color' => $company->membership->color
        ] : NULL;
    }

    /**
     * @param $company
     * @return null
     */
    private function getCityForCompany($company)
    {
        $company = Company::with('city')->whereId($company)->first();
        return ($company && $company->city) ? $company->city->name : NULL;
    }


    /**
     * @param $company
     * @return mixed
     */
    private function companyCompleteFromUser($company)
    {
        $company = Company::with('user')->whereId($company)->first();
        return ($company && $company->user) ? $company->user : NULL;
    }


}

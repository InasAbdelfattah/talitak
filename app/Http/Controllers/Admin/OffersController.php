<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $offer = Offer::with('images')->whereId($id)->first();


        if (!$offer->company && !$offer->company->membership) {
            return 'Company Not Found';
        }


        $original = new Carbon($offer->created_at);

        $date = $original->addDays($offer->company->membership->offer_time);


        $offer->offerExpireDate = is_object($offer) ? $date->toDateTimeString() : '';


        return view('admin.offers.show')->with(compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $offer
     * @return string
     */
    public function offerDuration($offer)
    {
        $offer = Offer::whereId($offer)->first();
        return ($of = $offer->company) ?
            ($of->membership) ?
                $of->membership->offer_time : '' : '';
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @ Delete
     */

    public function delete(Request $request)
    {
        $model = Offer::whereId($request->id)->first();
        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'هذا العرض غير موجود'
            ]);
        }

        $original = new Carbon($model->created_at);
        $model->duration = $this->offerDuration($model->id);
        $date = $original->addDays($model->duration);
        $model->expiration = is_object($model) ? $date->toDateTimeString() : '';
        $changeDate = strtotime($model->expiration) - strtotime(Carbon::now());
        $model->diffDate = $changeDate;
        if ($model->diffDate > 0) {
            return response()->json([
                'status' => false,
                'message' => 'عفوا, لايمكنك حذف العرض الان, حاول بعد انتهاء مده العرض'
            ]);
        }


        $model->images()->delete();
        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'لقد تم حذف العرض بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'لقد حدث خطأ, من فضلك حاول مرة آخرى'
            ]);
        }
    }


}

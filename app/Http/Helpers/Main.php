<?php


namespace App\Http\Helpers;

class Main
{


    function html_rate_icons($rate)
    {
        $html = '';

        $flooredRate = floor($rate);
        $hasHalfStar = $flooredRate < $rate;
        $emptyStars = 5 - round($rate);

        if ($rate > 0) {
            foreach (range(1, $flooredRate) as $star) {
                $html .= '<i class="ionicons ion-star text-warning" style="font-size: 25px; color: #f39c12 !important"></i>';
            }
            if ($hasHalfStar) {
                $html .= '<i class="ionicons ion-ios-star-half fa-flip-horizontal text-warning" style="font-size: 25px; color: #f39c12 !important"></i>';
            }
        }

        if ($emptyStars > 0) {
            foreach (range(1, $emptyStars) as $star) {
                $html .= '<i class="ionicons ion-ios-star text-warning" style="font-size: 25px; color: #ebeff2  !important; "></i >';
            }
        }

        return $html;
    }


    function success_response($data, $msg, $additional)
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data,
            'additional' => $additional
        ], 200);
    }




}


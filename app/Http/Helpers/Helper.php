<?php

    function company($id)
    {
        return \App\Company::where('user_id' , $id)->first();
        //return $this->belongsTo(Company::class);
    }

    function day($key){
        $days_arr = ['saturday'=>'السبت' , 'sunday'=>'الأحد' , 'monday'=>'الإثنين' ,'tuesday'=>'الثلاثاء' , 'wednesday'=>'الأربعاء' , 'thursday'=>'الخميس' , 'friday'=>'الجمعة'] ;
         return $days_arr[$key];
    }

    function user($id){
        return App\User::find($id);
    }

    function type($id){
        return App\Category::find($id);
        
    }

    function countInvited($user_id){
        return App\UserInvitation::where('invited_by',$user_id)->count();
    }

    function countLastDiscounts($user_id){
        return App\UserDiscount::where('user_id',$user_id)->count();
    }

    function validateRules($errors, $rules) {

       $error_arr = [];

       foreach ($rules as $key => $value) {

           if( $errors->get($key) ) {

               array_push($error_arr, array('key' => $key, 'value' => $errors->first($key)));
           }
       }

       return $error_arr;
    }

    function netCount($user_id){
        $invited_count = App\UserInvitation::where('invited_by',$user_id)->count();
        $dicount_count = App\UserDiscount::where('user_id',$user_id)->count();
    }
?>
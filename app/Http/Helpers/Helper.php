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
?>
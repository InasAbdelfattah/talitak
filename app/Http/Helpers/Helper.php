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
        $invitations =  App\UserInvitation::where('invited_by',$user_id)->count();
        $last_invitations = App\UserDiscount::where('user_id',$user_id)->sum('registered_users_no');
        $net = $invitations - $last_invitations ;
        return $net ;
    }

    function countLastDiscounts($user_id){
        return App\UserDiscount::where('user_id',$user_id)->count();
    }

    function validateRules($errors, $rules) {

       $error_arr = [];

       foreach ($rules as $key => $value) {

           if( $errors->get($key) ) {

               array_push($error_arr, array($key => $errors->first($key)));
           }
       }

       return $error_arr;
    }

    function uploadImage($request, $name, $path = null, $width = null, $height = null)
    {
        if ($request->hasFile($name)):
            // Get File name from POST Form
            $image = $request->file($name);

            // Custom file name with adding Timestamp
            $filename = time() . '.' . str_random(20) . $image->getClientOriginalName();

            // Directory Path Save Images
            $path = public_path($path . $filename);

            // Upload images to Target folder By INTERVENTION/IMAGE
            $img = Image::make($image);

            // RESIZE IMAGE TO CREATE THUMBNAILS
            if (isset($width) || isset($height))
                $img->resize($width, $height, function ($ratio) {
                    $ratio->aspectRatio();
                });
            $img->save($path);

            // RETURN path to save in images tables DATABASE
            return $filename;
        endif;
    }

    function save64Img($base64_img, $path) {
        $image_data = base64_decode($base64_img);
        $source = imagecreatefromstring($image_data);
        $angle = 0;
        $rotate = imagerotate($source, $angle, 0); // if want to rotate the image
        $imageName = time() . str_random(20) . '.png';
        $path = $path . $imageName;
        $imageSave = imagejpeg($rotate, $path, 100);
        return $imageName;
    }


    function uploading($inputRequest, $folderNam, $resize = []) {

        $imageName = time().'.'.$inputRequest->getClientOriginalExtension();

        if(! empty($resize)) {

            foreach($resize as $dimensions) {

                $destinationPath = public_path( $folderNam . '_' . $dimensions);

                $img = Image::make($inputRequest->getRealPath());

                $dimension = explode('x', $dimensions);

                $img->resize($dimension[0], $dimension[1], function ($constraint) {
                    $constraint->aspectRatio();

                });

                //$img->insert('public/web/images/logo-sm.png', 'bottom-right');

                $img->save($destinationPath. DIRECTORY_SEPARATOR .$imageName);
            }
        }

        $destinationPath = public_path('/' . $folderNam);
        $inputRequest->move($destinationPath, $imageName);

        return $imageName ? $imageName : FALSE ;

    }

?>
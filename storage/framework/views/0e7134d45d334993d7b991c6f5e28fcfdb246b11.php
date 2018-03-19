<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">بيانات المركز</h3>
        </div>

        <!--
                        <div class="m-t-15 col-xs-6 col-md-8 col-sm-8 text-right">
                            <a href="profile_edit.html">
                                     <button type="button" class="btn btn-success">تعديل البيانات</button>
                                </a>
                        </div>
        -->
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        

                        <div class="m-t-20 text-center">
                            <?php if($company->image): ?>
                            <a data-fancybox="gallery"
                               href="<?php echo e(url('files/companies/' . $company->image)); ?>">
                                <img class="img-thumbnail" src="<?php echo e(url('files/companies/' . $company->image)); ?>"/>
                            </a>
                            <?php else: ?>
                            <img class="img-thumbnail" src="<?php echo e(request()->root().'/assets/admin/custom/images/default.png'); ?>"/>
                            <?php endif; ?>
                        </div>

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم مدير المركز بالكامل :</label>
                                <p><?php echo e($company->name); ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p><?php if($company->user): ?> <?php echo e($company->user->phone); ?> <?php else: ?> -- <?php endif; ?> </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم جوال المركز :</label>
                                <p><?php echo e($company->phone); ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>البريد الالكتروني :</label>
                                <p><?php if($company->user): ?> <?php echo e($company->user->email); ?> <?php else: ?> -- <?php endif; ?> </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>  مكان الخدمة :</label>
                                <p><?php echo e($company->place == 0 ? 'منازل' : 'مركز'); ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label> نوع مزود الخدمة :</label>
                                <p><?php echo e($company->type == 0 ? 'فرد' : 'منشأة'); ?></p>
                            </div>

                            <!-- <div class="col-lg-3 col-xs-12">
                                <label>العضوية :</label>
                                <p> <?php echo e($company->membership['name']); ?></p>
                            </div> -->

                            <div class="col-lg-3 col-xs-12">
                                <label>المدينة :</label>
                                <p><?php if($company->city): ?><?php echo e($company->city->{'name:ar'}); ?><?php endif; ?></p>
                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p><?php echo e($company->type == 0 ? 'وثيقة الهوية' : 'وثيقة السجل التجارى'); ?> : </p></label>
                                <?php if($company->document_photo != ''): ?>
                                    <a data-fancybox="gallery" href="<?php echo e(url('public/files/docs/' . $company->document_photo)); ?>">
                                        <img class="img-thumbnail" src="<?php echo e(url('public/files/docs/' . $company->document_photo)); ?>"/>
                                    </a>
                                <?php else: ?>
                                    <img class="img-thumbnail" src="<?php echo e(request()->root().'/assets/admin/custom/images/default.png'); ?>"/>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">الخدمات</h4>

                <?php if($company->products->count() > 0): ?>
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>صورة المنتج</th> -->
                            <th>اسم الخدمة</th>
                            <th>نوع مستقبل الخدمة</th>
                            <th>نوع مزود الخدمة</th>
                            <th>مكان الخدمة</th>
                            <th>الحى</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $company->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#</td>
                                <!-- <td>
                                    <a data-fancybox="gallery"
                                       href="<?php echo e($helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png')); ?>">
                                        <img style="width: 50px; height: 50px; border-radius: 50%"
                                             src="<?php echo e($helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png')); ?>"/>
                                    </a>
                                </td> -->
                                <td><?php echo e($row->name); ?></td>
                                <td><?php echo e($row->gender_type == 'male' ? 'رجال' : 'نساء'); ?></td>
                                <td><?php echo e($row->provider_type == 'male' ? 'رجال' : 'نساء'); ?></td>
                                <td><?php echo e($row->service_place == 'center' ? 'مركز' : 'منازل'); ?></td>
                                <td> <?php if($row->district): ?> <?php echo e($row->district->{'name:ar'}); ?> <?php endif; ?></td>
                                <td>
                                    <!-- <a href="javascript:;" id="updateRow<?php echo e($row->id); ?>" data-id="<?php echo e($row->id); ?>"
                                       data-url="<?php echo e(route('product.update')); ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a> -->

                                    <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>" data-id="<?php echo e($row->id); ?>"
                                       data-url="<?php echo e(route('product.delete')); ?>"
                                       class="btn btn-xs btn-danger removeElement">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                                لا توجد خدمات متاحة حالياً للمركز
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="col-lg-6">
            <div class="card-box">

                <h4 class="header-title m-t-0 m-b-30">مواعيد العميل</h4>
                <?php if($company->workDays->count() > 0): ?>
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>صورة المنتج</th> -->
                            <th>اليوم</th>
                            <th>من</th>
                            <th>إلى</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $company->workDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>#</td>
                                    
                                    <td><?php echo e(day($row->day)); ?></td>
                                    <td><?php echo e($row->from); ?></td>
                                    <td><?php echo e($row->to); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                            غير متوفر مواعيد عمل للمركز
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التعليقات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                <?php if($company->comments->count() > 0): ?>
                                    <table class="table table table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> نص التعليق </th>
                                            <th>حالة التعليق</th>
                                            <th>  الخيارات </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $company->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#</td>
                                                <td><?php if($comment->user): ?> <?php echo e($comment->user->name); ?> <?php else: ?> --- <?php endif; ?></td>
                                                <td><?php echo e($comment->comment); ?></td>
                                                <!-- <td><?php echo e($comment->created_at); ?></td> -->
                                                <td>
                                                    <a id="ban<?php echo e($comment->id); ?>" href="javascript:;" id="commentSuspend<?php echo e($comment->id); ?>" data-id="<?php echo e($comment->id); ?>" class="suspendElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5" data-overlayColor="#36404a"> <?php if($comment->is_suspend == 0): ?>حظر التعليق <?php else: ?> رفع الحظر <?php endif; ?>
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="javascript:;" id="commentDelete<?php echo e($comment->id); ?>" data-id="<?php echo e($comment->id); ?>" class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                
                                <?php else: ?>
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجد تعليقات متاحة حالياً للمركز
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التقييمات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                <?php if($company->rates->count() > 0): ?>
                                    <table class="table table table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> التقييم </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $company->rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#</td>
                                                <td><?php if( $rate->user ): ?><?php echo e(isset($rate->user->name) ? $rate->user->name : $rate->user->username); ?> <?php else: ?>
                                                                -- <?php endif; ?></td>
                                                <td><?php echo e($rate->rate); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                <div class="col-xs-12">
                                    <div class="alert alert-success">
                                        متوسط تقييم المركز : <?php echo e($company->rates->avg('rate')); ?>

                                    </div>
                                </div>
                                <?php else: ?>
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجود تقييمات حالياً للمركز
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>
    </div>

    

    
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>

    <script>
        $('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentDelete' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "لا يمكنك استرجاع المحذوفات مرة اخرى.",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "إلغاء",
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('companies.deleteComment')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            if (data.status == true) {
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت عملية الحذف بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;

                                $tr.find('td').fadeOut(1000, function () {
                                    $tr.remove();
                                });
                            }
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }
                        }
                    });
                } else {

                    swal({
                        title: "تم الالغاء",
                        text: "انت لغيت عملية الحذف تقدر تحاول فى اى وقت :)",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "موافق",
                        confirmButtonClass: 'btn-info waves-effect waves-light',
                        closeOnConfirm: false,
                        closeOnCancel: false

                    });

                }
            });
        });

        $('body').on('click', '.suspendElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentSuspend' + id).parent().parent());
            var $td = $(this).closest($('#ban' + id));
            swal({
                title: "هل انت متأكد؟",
                text: "",
                type: "error",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "إلغاء",
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('companies.suspendComment')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log('suspend : ', data.data.suspend);
                            
                            if (data.status == true) {
                                if(data.data.suspend == 1){
                                    // $td.removeClass('btn-danger');
                                    // $td.addClass('btn-success');
                                    $td.text('رفع الحظر');
                                }else{
                                    $td.text(' حظر');
                                }
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت العملية بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                                   
                                // $tr.find('td').fadeOut(1000, function () {
                                //     $tr.find('td:first').text('inas');
                                //     //$("#myDiv table table td:first").text("Picked")
                                // });
                            }
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }
                        }
                    });
                } else {

                    swal({
                        title: "تم الالغاء",
                        text: "انت لغيت عملية الحذر تقدر تحاول فى اى وقت :)",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "موافق",
                        confirmButtonClass: 'btn-info waves-effect waves-light',
                        closeOnConfirm: false,
                        closeOnCancel: false

                    });

                }
            });
        });


    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
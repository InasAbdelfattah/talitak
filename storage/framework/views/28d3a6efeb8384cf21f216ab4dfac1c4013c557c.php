<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                        data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
                                class="fa fa-cog"></i></span></button>

            </div>
            <h4 class="page-title">طلبات مزودى الخدمات</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="dropdown pull-right">
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    <!-- <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                        <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                    </a> -->
                </div>

                

                

                
                
                
                
                
                
                

                

                <h4 class="header-title m-t-0 m-b-30">طلبات مزودى الخدمات</h4>

                

                

                


                


                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        <!-- <th>#</th> -->
                        <th>الاسم</th>
                        <th>اسم المركز</th>
                        <th> الهاتف</th>
                        <th>النوع</th>
                        <th>تفعيل</th>
                        <th>تاريخ الانشاء</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="currentRowOn<?php echo e($row->id); ?>">
                            <!-- <td>
                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="<?php echo e($row->id); ?>"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td> -->
                            <td><?php echo e($row->name); ?></td>
                            <td><a target="_blank" href="<?php echo e(route('companies.show', $row->company_id)); ?>"><?php echo e($row->company_name); ?></a></td>
                            <td> <?php echo e($row->phone); ?> </td>
                            <td> <?php echo e($row->gender == 'male' ? 'رجال' : 'نساء'); ?> </td>
                            <td>
                                <a href="#custom-modal<?php echo e($row->id); ?>"
                                   data-id="<?php echo e($row->id); ?>" id="currentRow<?php echo e($row->id); ?>"
                                   class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
                                   data-animation="fadein" data-plugin="custommodal"
                                   data-overlaySpeed="100" data-overlayColor="#36404a">تفعيل</a>

                                <!-- Modal -->
                                <div id="custom-modal<?php echo e($row->id); ?>" class="modal-demo"
                                     data-backdrop="static">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">تفعيل مزود الخدمة <?php echo e($row->name); ?></h4>
                                    <div class="custom-modal-text text-right" style="text-align: right !important;">
                                        <form action="<?php echo e(route('provider.activation')); ?>" method="post"
                                              data-id="<?php echo e($row->id); ?>">

                                            <?php echo e(csrf_field()); ?>


                                            <input type="hidden" value="<?php echo e($row->id); ?>" name="providerId"
                                                   id="providerID"/>
                                        
                                            <div class="form-group ">
                                                <div class="checkbox checkbox-custom">
                                                    <input id="checkbox-signup" type="radio" value="1" required
                                                           required data-parsley-trigger="keyup"
                                                           data-parsley-required-message="لابد من قبول الطلب اولاً"
                                                           name="agree" id="agree" <?php echo e(old('agree') ? 'checked' : ''); ?>>
                                                    <label for="checkbox-signup">
                                                        قبول الطلب
                                                    </label>
                                                </div>

                                                <div class="checkbox checkbox-custom">
                                                    <input id="checkbox-signup" type="radio" value="2" required
                                                           required data-parsley-trigger="keyup"
                                                           data-parsley-required-message="لابد من رفض الطلب اولاً"
                                                           name="agree" id="agree" <?php echo e(old('agree') ? 'checked' : ''); ?>>
                                                    <label for="checkbox-signup">
                                                        رفض الطلب
                                                    </label>
                                                </div>
                                                <br>
                                                <div>
                                                    <label for="reason-signup">
                                                         سبب الرفض
                                                    </label>
                                                    <br>
                                                    <textarea id="reason-signup" value="<?php echo e(old('reason')); ?>" required
                                                           required data-parsley-trigger="keyup"
                                                           data-parsley-required-message="لابد من كتابة سبب الرفض اولاً"
                                                           name="reason" id="reason" class="form-control"></textarea>
                                                    
                                                </div>
                                            </div>


                                            <div class="form-group text-right m-t-20">
                                                <button class="btn btn-primary waves-effect waves-light m-t-0"
                                                        type="submit">
                                                    حفظ البيانات
                                                </button>
                                                <button onclick="Custombox.close();" type="reset"
                                                        class="btn btn-default waves-effect waves-light m-l-5 m-t-0">
                                                    إلغاء
                                                </button>
                                            </div>

                                        </form>


                                    </div>
                                </div>

                            </td>

                            <td><?php echo e($row->created_at); ?></td>
                            <!-- <td>
                                <a href="<?php echo e(route('companies.show', $row->id)); ?>"
                                   class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a>
                    
                                <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>"
                                   data-id="<?php echo e($row->id); ?>"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td> -->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>


                

            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>



    <script>

$('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#elementRow' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "يمكنك استرجاع المحذوفات مرة اخرى لا تقلق.",
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
                        url: '<?php echo e(route('company.delete')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {

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

                            // if (data.status == false) {
                            //     var shortCutFunction = 'error';
                            //     var msg = 'عفواً, لا يمكنك حذف العضوية الان نظراً لوجود 3 شركات مسجلين بها.';
                            //     var title = data.title;
                            //     toastr.options = {
                            //         positionClass: 'toast-top-left',
                            //         onclick: null
                            //     };
                            //     var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                            //     $toastlast = $toast;
                            // }


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
        

        $('.getSelected').on('click', function () {
            // var items = $('.checkboxes-items').val();
            var sum = [];
            $('.checkboxes-items').each(function () {
                if ($(this).prop('checked') == true) {
                    sum.push(Number($(this).val()));
                }

            });

            if (sum.length > 0) {
                //var $tr = $(this).closest($('#elementRow' + id).parent().parent());
                swal({
                    title: "هل انت متأكد؟",
                    text: "يمكنك استرجاع المحذوفات مرة اخرى لا تقلق.",
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
                            url: '<?php echo e(route('companies.group.delete')); ?>',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
                                $('#catTrashed').html(data.trashed);
                                if (data) {
                                    var shortCutFunction = 'success';
                                    var msg = 'لقد تمت عملية الحذف بنجاح.';
                                    var title = data.title;
                                    toastr.options = {
                                        positionClass: 'toast-top-left',
                                        onclick: null
                                    };
                                    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                    $toastlast = $toast;
                                }

                                $('.checkboxes-items').each(function () {
                                    if ($(this).prop('checked') == true) {
                                        $(this).parent().parent().parent().fadeOut();
                                    }
                                });
//                        $tr.find('td').fadeOut(1000, function () {
//                            $tr.remove();
//                        });
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
            } else {
                swal({
                    title: "تحذير",
                    text: "قم بتحديد عنصر على الاقل",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "موافق",
                    confirmButtonClass: 'btn-warning waves-effect waves-light',
                    closeOnConfirm: false,
                    closeOnCancel: false

                });
            }


        });


        $('form').on('submit', function (e) {
            e.preventDefault();


            var id = $(this).attr('data-id');


            // var $tr = $($('#currentRowOn' + id)).closest($('#currentRow' + id).parent().parent());

            // console.log($tr);


            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status == true) {
                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'نجاح';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                        Custombox.close();

                        $("#currentRow" + data.id).html('تم التفعيل');
                        $("#currentRow" + data.id).addClass('btn-danger').removeClass('btn-success');
                        setTimeout(function () {
                            $('#currentRowOn' + data.id).parents('table').DataTable()
                                .row($('#currentRowOn' + data.id))
                                .remove()
                                .draw();
                        }, 2000);




                        
                        
                        
                    }

                    if (data.status == false) {
                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'خطأ';
                        toastr.options = {
                            positionClass: 'toast-top-center',
                            onclick: null,
                            showMethod: 'slideDown',
                            hideMethod: "slideUp",

                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;
                    }

                },
                error: function (data) {

                }
            });
        });


    </script>


<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
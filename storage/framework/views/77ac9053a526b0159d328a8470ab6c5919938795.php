<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            
            <h4 class="page-title">الخصومات</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                
                <h4 class="header-title m-t-0 m-b-30">عرض الخصومات</h4>

                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المستخدم</th>
                        <th>رقم جوال المستخدم</th>
                        <th>عدد المسجلين من خلاله</th>
                        <th>عدد الخصومات السابقة</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr id="currentRow<?php echo e($row->id); ?>">
                            <td>#

                                
                            </td>

                            <td><?php echo e($row->name); ?></td>
                            <td><?php echo e($row->phone); ?></td>
                            <td id="invite<?php echo e($row->id); ?>"><?php echo e(countInvited($row->id)); ?></td>
                            <td><?php echo e(countLastDiscounts($row->id)); ?></td>
                            <td>
                                <a href="#custom-modal<?php echo e($row->id); ?>" data-id="<?php echo e($row->id); ?>" id="currentRow<?php echo e($row->id); ?>" class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><i class="fa fa-plus-circle"></i>
                                </a>
            
                                      <!-- Modal -->
                                  <div id="custom-modal<?php echo e($row->id); ?>" class="modal-demo"
                                          data-backdrop="static">
                                        <button type="button" class="close" onclick="Custombox.close();">
                                             <span>&times;</span><span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="custom-modal-title">اضافة خصم</h4>
                                        <div class="custom-modal-text text-right" style="text-align: right !important;">

                                            <form action="<?php echo e(route('user_discounts.addDiscount')); ?>" method="post" data-id="<?php echo e($row->id); ?>">
     
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="userId" value="<?php echo e($row->id); ?>">
                                                <input type="hidden" name="invitedCounts" value="<?php echo e(countInvited($row->id)); ?>">
                                                <div class="form-group ">
                                                        
                                                    <div>
                                                        <label for="discount-signup"> الخصم </label>
                                                        <br>
                                                        <input type="number" id="discount-signup" value="<?php echo e(old('discount')); ?>" name="discount" id="discount" class="form-control">
                                                    </div>

                                                    <div>
                                                        <label for="maxOrders"> أقصى عدد للطلبات المحددة للمستخدم للاستفادة من الخصم </label>
                                                        <br>
                                                        <input type="number" id="maxOrders" value="<?php echo e(old('max_orders')); ?>" name="maxOrders" id="maxOrders" class="form-control">
                                                    </div>
                                                                     
                                                    <div>
                                                        <label for="from-signup">
                                                              الخصم سارى من تاريخ : 
                                                        </label>
                                                        <br>
                                                        <input type="date" id="from_date-signup" value="<?php echo e(old('from_date')); ?>" name="from_date" id="from_date" class="form-control">
                                                    </div>

                                                    <div>
                                                        <label for="to-signup">
                                                                الخصم سارى إلى : 
                                                        </label>
                                                        <br>
                                                        <input type="date" id="to_date-signup" value="<?php echo e(old('to_date')); ?>" name="to_date" id="to_date" class="form-control">
                                                    </div>

                                                </div>
        
                                                <div class="form-group text-right m-t-20">
                                                    <button class="btn btn-primary waves-effect waves-light m-t-0" type="submit">
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
            
                                           <!-- Model -->

                                <a href="<?php echo e(route('user_discounts.show', $row->id)); ?>"
                                   class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>"
                                   data-id="<?php echo e($row->id); ?>"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    لا يوجد
                    <?php endif; ?>
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
                        url: '<?php echo e(route('orders.delete')); ?>',
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
                            url: '<?php echo e(route('orders.group.delete')); ?>',
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

            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        //$("#invite" + data.id).html(0);
                        //$("#currentRow" + data.id + "td:nth-child(2)").text('inas');
                        $("#currentRow" + data.id).find("#invite" + data.id).html('inas');
                        //$("#invite" + data.id).html('inas');
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

                        //$("#currentRow" + data.id).html('تم التفعيل');
                        //$("#currentRow" + data.id).addClass('btn-danger').removeClass('btn-success');
                        // setTimeout(function () {
                        //     $('#currentRowOn' + data.id).parents('table').DataTable()
                        //         .row($('#currentRowOn' + data.id))
                        //         .remove()
                        //         .draw();
                        // }, 2000);


                        
                        
                        
                    }

                    if (data.status == false) {
                      console.log(data);
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
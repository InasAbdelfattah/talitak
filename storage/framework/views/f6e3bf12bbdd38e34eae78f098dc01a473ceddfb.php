<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            
            <h4 class="page-title">الحجوزات</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="dropdown pull-right">
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                        <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                    </a>
                </div>

                
                
                <h4 class="header-title m-t-0 m-b-30">عرض الحجوزات</h4>

                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        
                        <th>اسم مزود الخدمة</th>
                        <th>عدد الطلبات المنفذة</th>
                        <th>مجمل نسبة التطبيق</th>
                        <th>المدفوع</th>
                        <th>المتبقى</th>
                        <th>حالة الدفع</th>
                        <th>وصل الدفع</th>
                        <th>تأكيد التحصيل</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php if(count($accounts) > 0): ?>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            

                            <td><?php if(user($row->provider_id)): ?><?php echo e(user($row->provider_id)->name); ?><?php endif; ?></td>
                            <td><?php echo e($row->orders_count); ?></td>
                            <td id="appRatio<?php echo e($row->id); ?>"> <?php echo e($row->net_app_ratio); ?> </td>
                            <td id="paid<?php echo e($row->id); ?>"><?php echo e($row->paid); ?></td>
                            <td id="remain<?php echo e($row->id); ?>"><?php echo e($row->remain); ?></td>
                            <td> <?php echo e($row->pay_status == 1 ? 'نعم' : 'لا'); ?> </td>
                            <td style="width: 10%;">
                                <?php if($row->pay_doc != ''): ?>
                                    <a data-fancybox="gallery"
                                        href="<?php echo e(url('files/pays/' . $row->pay_doc)); ?>">
                                        <img style="width: 50%; border-radius: 50%; height: 49px;"
                                                src="<?php echo e(url('files/pays/' . $row->pay_doc)); ?>"/>
                                    </a>
                                <?php else: ?>
                                    $row->pay_doc
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row->net_app_ratio != 0): ?>    
                                <a href="#custom-modal<?php echo e($row->id); ?>"
                                            data-id="<?php echo e($row->id); ?>" id="currentRow<?php echo e($row->id); ?>"
                                            class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
                                            data-animation="fadein" data-plugin="custommodal"
                                            data-overlaySpeed="100" data-overlayColor="#36404a">تأكيد الدفع</a>
                                <?php else: ?>
                                <span style="color:darkgreen;">تم التحصيل </span>
                                <?php endif; ?>
                                         <!-- Modal -->
                                         <div id="custom-modal<?php echo e($row->id); ?>" class="modal-demo"
                                              data-backdrop="static">
                                             <button type="button" class="close" onclick="Custombox.close();">
                                                 <span>&times;</span><span class="sr-only">Close</span>
                                             </button>
                                             <h4 class="custom-modal-title">هل تم تحصيل المبلغ بالكامل ؟</h4>
                                             <div class="custom-modal-text text-right" style="text-align: right !important;">
                                                <form action="<?php echo e(route('account.confirmPayment')); ?>" method="post"
                                                       data-id="<?php echo e($row->id); ?>">
         
                                                    <?php echo e(csrf_field()); ?>

                                             <input type="hidden" name="accountId" value="<?php echo e($row->id); ?>">
                                                    <div class="form-group ">
                                                            <div class="checkbox checkbox-custom">
                                                                <input id="checkbox-signup" type="radio" value="1" required
                                                                       required data-parsley-trigger="keyup"
                                                                       data-parsley-required-message="لا بد من اختيار حالة التحصيل"
                                                                       name="is_confirmed" id="agree" <?php echo e(old('is_confirmed') ? 'checked' : ''); ?>>
                                                                <label for="checkbox-signup">
                                                                     نعم
                                                                </label>
                                                            </div>
            
                                                            <div class="checkbox checkbox-custom">
                                                                <input id="checkbox-signup" type="radio" value="2" required
                                                                       required data-parsley-trigger="keyup"
                                                                       data-parsley-required-message="لا بد من اختيار حالة التحصيل"
                                                                       name="is_confirmed" id="agree" <?php echo e(old('is_confirmed') ? 'checked' : ''); ?>>
                                                                <label for="checkbox-signup">
                                                                    لا
                                                                </label>
                                                            </div>
                                                            <br>
                                                            <div>
                                                                <label for="paid-signup">
                                                                     المبلغ المحصل 
                                                                </label>
                                                                <br>
                                                                <input type="number" id="paid-signup" value="<?php echo e(old('paid')); ?>" 
                                                                       name="paid" id="paid" class="form-control">
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
                                                     
                                                </form>
         
                                             </div>
                                         </div>
                            </td>                            
                            <td>
                        
                                <a href="javascript:;" id="elementRow<?php echo e($row->id); ?>"
                                   data-id="<?php echo e($row->id); ?>"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        url: '<?php echo e(route('orders.delete_accounts')); ?>',
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

        $('form').on('submit', function (e) {
            e.preventDefault();


            var id = $(this).attr('data-id');


            // var $tr = $($('#currentRowOn' + id)).closest($('#currentRow' + id).parent().parent());

            // console.log($tr);


            var formData = new FormData(this);
            for (var value of formData.values()) {
                console.log(value); 
            }
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

                        $("#currentRow" + data.id).html('تم حفظ حالة الدفع');
                        $("#currentRow" + data.id).addClass('btn-danger').removeClass('btn-success');
                        $("#paid" + data.id).html(data.paid);
                        $("#remain" + data.id).html(data.remain);
                        $("#appRatio" + data.id).html(data.appRatio);
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
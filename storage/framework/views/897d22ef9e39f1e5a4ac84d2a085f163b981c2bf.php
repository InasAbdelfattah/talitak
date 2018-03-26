<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">

            </div>
            <h4 class="page-title">تفاصيل الرسالة</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                    <?php if($message->user): ?>
                        <?php if($message->user && $message->user->is_user == 1): ?>

                            

                            <a href="<?php echo e(route('companies.show', $message->user->companies->first()->id)); ?>"><h3
                                        class="m-t-0 m-b-10"><?php echo e(($message->user)?$message->user->companies->first()->name:''); ?></h3>
                            </a>

                        <?php else: ?>

                            <a href="<?php echo e(route('users.show', $message->user->id)); ?>"><h3
                                        class="m-t-0 m-b-10"><?php echo e(($message->user)?($message->user->name)?: $message->user->username :''); ?></h3>
                            </a>

                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if($message->type == 1): ?>
                            <span class="label label-danger">شكوى</span>
                        <?php elseif($message->type == 2): ?>
                            <span class="label label-success">إقتراح</span>
                        <?php else: ?>
                            <span class="label label-inverse">آخري</span>

                        <?php endif; ?>
                        <p class="m-t-10"><?php echo e($message->message); ?></p>
                        <p><i class="fa fa-calendar"></i> <?php echo e($message->created_at->format('Y/m/d  ||  H:i:s ')); ?></p>

                        <?php if($message->user && $message->user->is_user == 1): ?>
                            <div class="button-list m-t-20">
                                <button type="button" class="btn btn-facebook btn-sm waves-effect waves-light">
                                    <i class="fa fa-facebook"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-twitter waves-effect waves-light">
                                    <i class="fa fa-twitter"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-snapchat waves-effect waves-light">
                                    <i class="fa fa-snapchat-ghost"></i>
                                </button>

                            </div>
                        <?php endif; ?>

                    </div>


                    <div id="supportReplies">


                        <?php $__currentLoopData = App\Support::orderBy('created_at', 'desc')->whereParentId($message->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card bg-lightdark p-20 m-t-20">
                                <?php echo e($row->message); ?>

                            </div>
                            <p class="m-t-10"><i class="fa fa-calendar"></i> <?php echo e($row->created_at->format('Y/m/d  ||  H:i:s ')); ?>

                            </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <!--/ meta -->


        </div>
        <div class="col-md-6 col-xs-12">
            <form method="post" action="<?php echo e(route('support.reply',$message->id)); ?>" class="card-box">
             
                <span class="input-icon icon-right">
                    <textarea rows="5" class="form-control" name="message" required
                                placeholder="الرد على الرسالة الحاليه..."
                                data-parsley-error-message="ادخل نص الرد اولا"></textarea>
                </span>

                <select class="form-control m-t-10" name="reply_type" required
                        data-parsley-error-message="">
                    <option value="">إرسال عبر</option>
                    <option value="0">رسالة نصية (SMS)</option>
                    <!-- <option value="1">البريد الإلكتروني</option> -->
                </select>
                <div class="p-t-10">
                    <button class="btn btn-sm btn-primary waves-effect waves-light">إرسال
                        <i style="display: none;" id="spinnerDiv" class="fa fa-spinner fa-spin"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>


    <script>


        <?php if(session()->has('success')): ?>

        setTimeout(function () {
            showMessage('<?php echo e(session()->get('success')); ?>');
        }, 3000);


        <?php endif; ?>
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
                            url: '<?php echo e(route('categories.group.delete')); ?>',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
                                if (data) {
                                    var shortCutFunction = 'success';
                                    var msg = 'لقد تمت عملية الحذف بنجاح.';
                                    var title = data.title;
                                    toastr.options = {
                                        positionClass: 'toast-top-center',
                                        onclick: null,
                                        showMethod: 'slideDown',
                                        hideMethod: "slideUp",
                                    };
                                    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                    $toastlast = $toast;
                                }

                                $('.checkboxes-items').each(function () {
                                    if ($(this).prop('checked') == true) {
                                        $(this).parent().parent().parent().delay(200).fadeOut();
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
                        url: '<?php echo e(route('category.delete')); ?>',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت عملية الحذف بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-center',
                                    onclick: null,
                                    showMethod: 'slideDown',
                                    hideMethod: "slideUp",
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                            }

                            $tr.find('td').fadeOut(1000, function () {
                                $tr.remove();
                            });
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


        function showMessage(message) {

            var shortCutFunction = 'success';
            var msg = message;
            var title = 'نجاح!';
            toastr.options = {
                positionClass: 'toast-top-center',
                onclick: null,
                showMethod: 'slideDown',
                hideMethod: "slideUp",
            };
            var $toast = toastr[shortCutFunction](msg, title);
            // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;


        }


    </script>

    <script type="text/javascript">

        $('form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);


            $('#spinnerDiv').show();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status == true) {
                        $('#spinnerDiv').hide();
                        $("[name='message']").val('');
                        $("[name='reply_type']").val('');


                        var div = "<div class='card bg-lightdark p-20 m-t-20'>"
                            + data.data.message
                            + "</div>"
                            + "<p class='m-t-10'><i class='fa fa-calendar'></i> " + data.data.created + " </p>"
                        $('#supportReplies').prepend(div);

                        var shortCutFunction = 'success';
                        var msg = data.message;
                        var title = 'نجاح';
                        toastr.options = {
                            positionClass: 'toast-top-left',
                            onclick: null
                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;

                    }

                    if (data.status == false) {

                        var shortCutFunction = 'error';
                        var msg = data.message;
                        var title = 'نجاح';
                        toastr.options = {
                            positionClass: 'toast-top-left',
                            onclick: null
                        };
                        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                        $toastlast = $toast;


                        setTimeout(function () {
                            $('#spinnerDiv').hide();
                        }, 1000);
                    }




                    
                    
                    
                },
                error: function (data) {
                    $('#spinnerDiv').hide();
                }
            });
        });

    </script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
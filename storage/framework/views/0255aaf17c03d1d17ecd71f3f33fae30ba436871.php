<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('roles.store')); ?>" enctype="multipart/form-data" data-parsley-validate
          novalidate>
        <?php echo e(csrf_field()); ?>




    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">


                    <a href="<?php echo e(route('roles.index')); ?>" type="button" class="btn btn-custom waves-effect waves-light"
                       aria-expanded="false"> مشاهدة جميع الادوار
                        <span class="m-l-5">
                        <i class="fa fa-backward"></i>
                    </span>
                    </a>


                </div>
                <h4 class="page-title">إدارة الادوار</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">


                   <!--  <div id="errorsHere"></div>
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">إضافة دور جديد</h4>


                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName"> الاسم الظاهر*</label>
                            <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="form-control" required
                                   placeholder="الاسم الظاهر..."/>
                            <p class="help-block" id="error_userName"></p>
                            <?php if($errors->has('title')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('title')); ?>

                                </p>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="col-xs-12">
                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="usernames">الاسم *</label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control"
                                   required placeholder="الاسم..."/>
                            <?php if($errors->has('name')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('name')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="form-group<?php echo e($errors->has('roles') ? ' has-error' : ''); ?>">
                        <label for="passWord2">الصلاحيات *</label>
                        <select multiple="multiple" class="multi-select" id="my_multi_select1" name="abilities[]" required data-plugin="multiselect">
                            <optgroup label="الصلاحيات">
                            <?php $__currentLoopData = $abilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <option value="<?php echo e($ability->name); ?>" <?php echo e((collect(old('abilities'))->contains($ability->name)) ? 'selected':''); ?>>
                                    <?php if($ability == '*'): ?>
                                        كل الصلاحيات 
                                    <?php else: ?> <?php echo e($ability->title); ?>

                                    <?php endif; ?>
                                </option>
                           
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </optgroup>
                        </select>

                        <?php if($errors->has('abilities')): ?>
                            <p class="help-block"> <?php echo e($errors->first('abilities')); ?></p>
                        <?php endif; ?>

                    </div>

                    <div class="form-group text-right m-t-20">
                        <button class="btn btn-primary waves-effect waves-light m-t-20" type="submit">
                            حفظ البيانات
                        </button>
                        <button onclick="window.history.back();return false;" type="reset"
                                class="btn btn-default waves-effect waves-light m-l-5 m-t-20">
                            إلغاء
                        </button>
                    </div>

                </div>
            </div><!-- end col -->

            
        </div>
        <!-- end row -->
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>


    <script>

        <?php if(session()->has('error')): ?>
        setTimeout(function () {
            showMessage('<?php echo e(session()->get('error')); ?>');
        }, 3000);
        <?php endif; ?>

        function showMessage(message) {

            var shortCutFunction = 'error';
            var msg = message;
            var title = 'خطأ!';
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

        //In this code, if you click on one of the option group label, all sub-options will be selected automatically.

        $("optgroup").on("click", function() {

            $(this).children("option").prop("selected", "selected");
            $(this).next().children("option").prop("selected", false);
            $(this).prev().children("option").prop("selected", false); 

        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
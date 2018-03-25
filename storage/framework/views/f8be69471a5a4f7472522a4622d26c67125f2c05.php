<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">

                <a href="<?php echo e(route('abilities.create')); ?>" type="button" class="btn btn-custom waves-effect waves-light"
                   aria-expanded="false"> إضافة
                    <span class="m-l-5">
                        <i class="fa fa-user"></i>
                    </span>
                </a>

            </div>
            <h4 class="page-title">إدارة الصلاحيات</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-sm-4 col-xs-8 m-b-30" style="display: inline-flex">
                        مشاهدة الصلاحيات
                    </div>

                    <!-- <div class="col-sm-4 col-sm-offset-4">
                        <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                        </a>

                    </div> -->
                </div>
                <table class="table  table-striped" id="datatable-fixed-header">
                    <thead>
                    <tr>
                        <th>
                            <div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox" name="check" onchange="checkSelect(this)"
                                       value="option2"
                                       aria-label="Single checkbox Two">
                                <label></label>
                            </div>
                        </th>
                        <th>الاسم</th>
                        <th>الاسم الظاهر</th>
                        <th>الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $abilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-entry-id="<?php echo e($ability->id); ?>">
                                <td> #
                                    <!-- <div class="checkbox checkbox-primary checkbox-single">
                                        <input type="checkbox" class="checkboxes-items"
                                               value="<?php echo e($ability->id); ?>"
                                               aria-label="Single checkbox Two">
                                        <label></label>
                                    </div> -->
                                </td>
                                <td><?php echo e($ability->name); ?></td>
                                <td><?php echo e($ability->title); ?></td>
                                <td>
                                    <a href="<?php echo e(route('abilities.edit',[$ability->id])); ?>" class="btn btn-xs btn-info">تعديل</a>
                                    <?php if($ability->id != 1): ?>
                                    <?php echo Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['abilities.destroy', $ability->id])); ?>

                                    <?php echo Form::submit('حذف', array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">لا توجدبيانات</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <!-- End row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?> 
    <script>
        window.route_mass_crud_entries_destroy = '<?php echo e(route('abilities.mass_destroy')); ?>';
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
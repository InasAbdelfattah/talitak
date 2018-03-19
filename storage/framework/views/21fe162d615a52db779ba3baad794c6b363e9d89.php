<?php $__env->startSection('content'); ?>

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">تفاصيل الخصم</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">تفاصيل الخصم</h3>

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم المستخدم :</label>
                                <p><?php echo e($user->name); ?></p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p><?php echo e($user->phone); ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">الخصومات الحاصل عليها</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                        
                                <table class="table table table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الخصم</th>
                                            <th> الفترة من : </th>
                                            <th> الفترة إلى : </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>#</td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->from_date); ?></td>
                                                <td><?php echo e($row->to_date); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="2"> لا يوجد </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
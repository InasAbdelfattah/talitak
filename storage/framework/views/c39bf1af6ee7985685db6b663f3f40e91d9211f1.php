<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('administrator.settings.store')); ?>" data-parsley-validate="" novalidate="" method="post"
          enctype="multipart/form-data">

    <?php echo e(csrf_field()); ?>


    <!-- Page-Title -->

        <div class="row">
            <div class="col-sm-12">
                <!-- <div class="btn-group pull-right m-t-15">
                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
                                    class="fa fa-cog"></i></span></button>

                </div> -->
                <h4 class="page-title">ضبط بنود الإستخدام</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">


                    <div id="errorsHere"></div>
                    <!-- <div class="dropdown pull-right">
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

                    <h4 class="header-title m-t-0 m-b-30">بيانات بنود الإستخدام</h4>


                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName">العنوان *</label>
                            <input type="text" name="terms_title_ar"
                                   value="<?php echo e($setting->getBody('terms_title_ar')); ?>" class="form-control"
                                   required
                                   placeholder="العنوان ..."/>
                            <p class="help-block"></p>

                        </div>

                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName">العنوان - انجليزى*</label>
                            <input type="text" name="terms_title_en"
                                   value="<?php echo e($setting->getBody('terms_title_en')); ?>" class="form-control"
                                   required
                                   placeholder="العنوان ..."/>
                            <p class="help-block"></p>

                        </div>

                    </div>


                    <div class="col-xs-12">
                        <div class="form-group <?php echo e($errors->has('terms_ar') ? 'has-error' : ''); ?>">
                            <label for="terms_ar">المحتوي</label>
                            <textarea id="editor" name="terms_ar">
                                <?php echo e($setting->getBody('terms_ar')); ?>

                            </textarea>
                        </div>

                    </div>

                    <div class="col-xs-12">
                        <div class="form-group <?php echo e($errors->has('terms_en') ? 'has-error' : ''); ?>">
                            <label for="terms_en">المحتوي - انجليزى</label>
                            <textarea name="terms_en">
                                <?php echo e($setting->getBody('terms_en')); ?>

                            </textarea>
                        </div>

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
    <script src="https://cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'terms_en' );
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
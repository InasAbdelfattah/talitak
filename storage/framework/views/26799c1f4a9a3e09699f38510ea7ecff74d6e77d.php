<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <title>لوحة التحكم | <?php echo $__env->yieldContent('title'); ?></title>

    <!--Morris Chart CSS -->

    <?php echo $__env->make('admin.layouts._partials.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('styles'); ?>


    <style>


        /*
 _____   _           _         _                        _
|_   _| | |         | |       | |                      | |
  | |   | |__   __ _| |_ ___  | |_ ___  _ __ ___   __ _| |_ ___   ___  ___
  | |   | '_ \ / _` | __/ _ \ | __/ _ \| '_ ` _ \ / _` | __/ _ \ / _ \/ __|
 _| |_  | | | | (_| | ||  __/ | || (_) | | | | | | (_| | || (_) |  __/\__ \
 \___/  |_| |_|\__,_|\__\___|  \__\___/|_| |_| |_|\__,_|\__\___/ \___||___/

Oh nice, welcome to the stylesheet of dreams.
It has it all. Classes, ID's, comments...the whole lot:)
Enjoy responsibly!



        @ihatetomatoes

 */

        /* ==========================================================================
           Chrome Frame prompt
           ========================================================================== */

        .chromeframe {
            margin: 0.2em 0;
            background: #ccc;
            color: #000;
            padding: 0.2em 0;
        }

        /* ==========================================================================
           Author's custom styles
           ========================================================================== */
        p {
            line-height: 1.33em;
            color: #7E7E7E;
        }

        h1 {
            color: #EEEEEE;
        }

        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;

            height: 100%;
            z-index: 1050;

            width: calc(100% + 17px);
        }

        #loader {
            display: block;
            position: relative;
            right: 46%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */

            z-index: 1001;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg); /* IE 9 */
                transform: rotate(0deg); /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg); /* IE 9 */
                transform: rotate(360deg); /* Firefox 16+, IE 10+, Opera */
            }
        }

        @keyframes  spin {
            0% {
                -webkit-transform: rotate(0deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg); /* IE 9 */
                transform: rotate(0deg); /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg); /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg); /* IE 9 */
                transform: rotate(360deg); /* Firefox 16+, IE 10+, Opera */
            }
        }

        #loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            width: 51%;
            height: 100%;
            background: #222222;
            z-index: 1000;
            -webkit-transform: translateX(0); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(0); /* IE 9 */
            transform: translateX(0); /* Firefox 16+, IE 10+, Opera */
        }

        #loader-wrapper .loader-section.section-left {
            left: 0;
        }

        #loader-wrapper .loader-section.section-right {
            right: 0;
        }

        /* Loaded */
        .loaded #loader-wrapper .loader-section.section-left {
            -webkit-transform: translateX(-100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(-100%); /* IE 9 */
            transform: translateX(-100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded #loader-wrapper .loader-section.section-right {
            -webkit-transform: translateX(100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%); /* IE 9 */
            transform: translateX(100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded #loader {
            opacity: 0;
            -webkit-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .loaded #loader-wrapper {
            visibility: hidden;

            -webkit-transform: translateY(-100%); /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateY(-100%); /* IE 9 */
            transform: translateY(-100%); /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.3s 1s ease-out;
            transition: all 0.3s 1s ease-out;
        }

        /* JavaScript Turned Off */
        .no-js #loader-wrapper {
            display: none;
        }

        .no-js h1 {
            color: #222222;
        }

        #content {
            margin: 0 auto;
            padding-bottom: 50px;
            width: 80%;
            max-width: 978px;
        }

        /* ==========================================================================
           Helper classes
           ========================================================================== */

        /*
         * Image replacement
         */

        .ir {
            background-color: transparent;
            border: 0;
            overflow: hidden;
            /* IE 6/7 fallback */
            *text-indent: -9999px;
        }

        .ir:before {
            content: "";
            display: block;
            width: 0;
            height: 150%;
        }

        /*
         * Hide from both screenreaders and browsers: h5bp.com/u
         */

        .hidden {
            display: none !important;
            visibility: hidden;
        }

        /*
         * Hide only visually, but have it available for screenreaders: h5bp.com/v
         */

        .visuallyhidden {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        /*
         * Extends the .visuallyhidden class to allow the element to be focusable
         * when navigated to via the keyboard: h5bp.com/p
         */

        .visuallyhidden.focusable:active,
        .visuallyhidden.focusable:focus {
            clip: auto;
            height: auto;
            margin: 0;
            overflow: visible;
            position: static;
            width: auto;
        }

        /*
         * Hide visually and from screenreaders, but maintain layout
         */

        .invisible {
            visibility: hidden;
        }

        /*
         * Clearfix: contain floats
         *
         * For modern browsers
         * 1. The space content is one way to avoid an Opera bug when the
         *    `contenteditable` attribute is included anywhere else in the document.
         *    Otherwise it causes space to appear at the top and bottom of elements
         *    that receive the `clearfix` class.
         * 2. The use of `table` rather than `block` is only necessary if using
         *    `:before` to contain the top-margins of child elements.
         */

        .clearfix:before,
        .clearfix:after {
            content: " "; /* 1 */
            display: table; /* 2 */
        }

        .clearfix:after {
            clear: both;
        }

        /*
         * For IE 6/7 only
         * Include this rule to trigger hasLayout and contain floats.
         */

        .clearfix {
            *zoom: 1;
        }

        /* ==========================================================================
           EXAMPLE Media Queries for Responsive Design.
           These examples override the primary ('mobile first') styles.
           Modify as content requires.
           ========================================================================== */

        @media  only screen and (min-width: 35em) {
            /* Style adjustments for viewports that meet the condition */
        }

        @media  print,
        (-o-min-device-pixel-ratio: 5/4),
        (-webkit-min-device-pixel-ratio: 1.25),
        (min-resolution: 120dpi) {
            /* Style adjustments for high resolution devices */
        }

        /* ==========================================================================
           Print styles.
           Inlined to avoid required HTTP connection: h5bp.com/r
           ========================================================================== */

        @media  print {
            * {
                background: transparent !important;
                color: #000 !important; /* Black prints faster: h5bp.com/s */
                box-shadow: none !important;
                text-shadow: none !important;
            }

            a,
            a:visited {
                text-decoration: underline;
            }

            a[href]:after {
                content: " (" attr(href) ")";
            }

            abbr[title]:after {
                content: " (" attr(title) ")";
            }

            /*
             * Don't show links for images, or javascript/internal links
             */
            .ir a:after,
            a[href^="javascript:"]:after,
            a[href^="#"]:after {
                content: "";
            }

            pre,
            blockquote {
                border: 1px solid #999;
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group; /* h5bp.com/t */
            }

            tr,
            img {
                page-break-inside: avoid;
            }

            img {
                max-width: 100% !important;
            }

            @page  {
                margin: 0.5cm;
            }

            p,
            h2,
            h3 {
                orphans: 3;
                widows: 3;
            }

            h2,
            h3 {
                page-break-after: avoid;
            }
        }

        /*
            Ok so you have made it this far, that means you are very keen to on my code.
            Anyway I don't really mind it. This is a great way to learn so you actually doing the right thing:)
            Follow me


        @ihatetomatoes
 */
        .scroll-hidden {
            position: fixed;
        }

        .fade-scale {
            transform: scale(0);
            opacity: 0;
            -webkit-transition: all .5s linear;
            -o-transition: all .5s linear;
            transition: all .5s linear;
        }

        .fade-scale.in {
            opacity: 1;
            transform: scale(1);
        }

        .fade-scale.out {
            opacity: 1;
            transform: scale(1);
        }

        /*.modal {*/
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*transform: translate(-50%, -50%);*/
        /*}*/

        /*@keyframes  slideInFromLeft {*/
        /*0% {*/
        /*transform: translateX(-100%);*/
        /*}*/
        /*100% {*/
        /*transform: translateX(0);*/
        /*}*/
        /*}*/

        /*.page-title {*/
        /*!* This section calls the slideInFromLeft animation we defined above *!*/
        /*animation: 2s ease-out 0s 3 slideInFromLeft;*/

        /*background: #333;*/
        /*padding: 30px;*/
        /*}*/


    </style>


    <style>


        body {
            font-family: "JF-Flat-Regular" !important;
        }

        .ms-container {
            width: 100%;
            float: right;
        }

        .ms-container .ms-selectable, .ms-container .ms-selection {
            background: #fff;
            color: #555555;
            float: right;
            width: 45%;
        }

        .ms-container .ms-selection {
            float: left;
        }


    </style>


</head>


<body class="demo scroll-hidden"
      style="    font-family: 'JF-Flat-Regular' !important; font-weight: 600;">
<div id="loader-wrapper">
    <div id="loader"></div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

</div>
<?php echo $__env->make('admin.layouts._partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- validation errors message -->

<!-- <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?> -->
<!-- end validation errors message -->

<?php echo $__env->yieldContent('content'); ?>

<!-- Footer -->
<footer class="footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                . Adminto © 2016 - 2017
            </div>

        </div>
    </div>
</footer>
<!-- End Footer -->


<?php echo $__env->make('admin.layouts._partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function () {
        setTimeout(function () {
            $('body').addClass('loaded');
            $('body').removeClass('scroll-hidden');
        }, 2000);
    });


    function testAnim(x) {
        $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + x + '  animated');
    };
    $('#myModal').on('show.bs.modal', function (e) {
        var anim = "slideOutDown";
        testAnim(anim);
    })
    $('#myModal').on('hide.bs.modal', function (e) {
        var anim = "slideOutDown";
        testAnim(anim);
    });

</script>



<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true,
            columnDefs: [{orderable: false, targets: [0]}],
            "language": {
                "lengthMenu": "عرض _MENU_ للصفحة",
                "info": "عرض صفحة _PAGE_ من _PAGES_",
                "infoEmpty": "لا توجد بيانات مسجلة متاحة ",
                "infoFiltered": "(تصفية من _MAX_ الاجمالى)",
                "paginate": {
                    "first": "الاول",
                    "last": "الاخير",
                    "next": "التالى",
                    "previous": "السابق"
                },
                "search": "البحث:",
                "zeroRecords": "لا توجد بيانات متاحة حالياً",

            },

        });
    });


    $('#categories').DataTable({
        fixedHeader: true,
        "columns": [
            {"orderable": false},
            null,
            null,
            null,
            null
        ],
        "language": {
            "lengthMenu": "عرض _MENU_ للصفحة",
            "info": "عرض صفحة _PAGE_ من _PAGES_",
            "infoEmpty": "لا توجد بيانات مسجلة متاحة ",
            "infoFiltered": "(تصفية من _MAX_ الاجمالى)",
            "paginate": {
                "first": "الاول",
                "last": "الاخير",
                "next": "التالى",
                "previous": "السابق"
            },
            "search": "البحث:",
            "zeroRecords": "لا توجد بيانات متاحة حالياً",

        }
    });


</script>


<script type="text/javascript">

    <?php if(session()->has('success')): ?>
    setTimeout(function () {
        showMessage('<?php echo e(session()->get('success')); ?>' , 'success');
    }, 3000);

    <?php endif; ?>

    <?php if(session()->has('error')): ?>
    setTimeout(function () {
        showMessage('<?php echo e(session()->get('error')); ?>' , 'error');
    }, 3000);

    <?php endif; ?>

    function showMessage(message , type) {

        var shortCutFunction = type ;
        var msg = message;

        var title = type == 'success' ? 'نجاح' : 'فشل';
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

    $(function () {
        $('body').on('change', '.filteriTems', function (e) {

                e.preventDefault();

                var keyName = $('#filterItems').val();
                var pageSize = $('#recordNumber').val();

                var url = $(this).attr('data-url');

                if (keyName != '' && pageSize != '') {
                    var path = '<?php echo e(request()->root().'/'.request()->path()); ?>' + '?name=' + keyName + '&pageSize=' + pageSize;
                } else if (keyName != '' && pageSize == '' && pageSize == 'all') {
                    var path = '<?php echo e(request()->root().'/'.request()->path()); ?>' + '?name=' + keyName;
                } else if (keyName == '' && pageSize != '') {
                    var path = '<?php echo e(request()->root().'/'.request()->path()); ?>' + '?pageSize=' + pageSize;
                } else {
                    var path = '<?php echo e(request()->root().'/'.request()->path()); ?>' + '?pageSize=' + pageSize;
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keyName: keyName, path: path, pageSize: pageSize}
                }).done(function (data) {
                    window.history.pushState("", "", path);
                    $('.articles').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });


            }
        );
    });


    function redirectPage(route) {

        window.history.pushState("", "", route);
    }

    $('.dropify').dropify({
        messages: {
            'default': 'اسحب وافلت الصورة هنا',
            'replace': 'اسحب وافلت هنا او اضغط للإستبدال',
            'remove': 'حذف',
            'error': 'لقد حدث خطأ ما, حاول مرة آخرى.'
        },
        error: {
            'fileSize': 'The file size is too big (1M max).'
        }
    });


    function checkSelect(item) {
        var checked = $(item).prop('checked');

        $('.checkboxes-items').each(function (i) {
            $(this).prop('checked', checked);
        })
    }


    $(document).ready(function () {
        $('form').parsley();
    });


</script>


</body>
</html>
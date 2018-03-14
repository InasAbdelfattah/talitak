@extends('admin.layouts.master')


@section('styles')
    <style>

        .gold {
            text-align: center;
            color: #fff;
            padding: 3px 1em;
            border-radius: 5px;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#fceabb+0,f8b500+100,fbdf93+100 */
            background: #fceabb;
            /* Old browsers */
            background: -moz-radial-gradient(center, ellipse cover, #fceabb 0%, #f8b500 100%, #fbdf93 100%);
            /* FF3.6-15 */
            background: -webkit-radial-gradient(center, ellipse cover, #fceabb 0%, #f8b500 100%, #fbdf93 100%);
            /* Chrome10-25,Safari5.1-6 */
            background: radial-gradient(ellipse at center, #fceabb 0%, #f8b500 100%, #fbdf93 100%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fceabb', endColorstr='#fbdf93', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }

        .silver {
            text-align: center;
            color: #fff;
            padding: 3px 1em;
            top: 10px;
            left: 10px;
            border-radius: 5px;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e0e0e0+0,b8bac6+100,f5f6f6+100 */
            background: #e0e0e0;
            /* Old browsers */
            background: -moz-radial-gradient(center, ellipse cover, #e0e0e0 0%, #b8bac6 100%, #f5f6f6 100%);
            /* FF3.6-15 */
            background: -webkit-radial-gradient(center, ellipse cover, #e0e0e0 0%, #b8bac6 100%, #f5f6f6 100%);
            /* Chrome10-25,Safari5.1-6 */
            background: radial-gradient(ellipse at center, #e0e0e0 0%, #b8bac6 100%, #f5f6f6 100%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e0e0e0', endColorstr='#f5f6f6', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }

        .bronze {
            text-align: center;
            color: #fff;
            padding: 3px 1em;
            top: 10px;
            left: 10px;
            border-radius: 5px;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f3e2c7+0,b68d4c+100,e9d4b3+100 */
            background: #f3e2c7;
            /* Old browsers */
            background: -moz-radial-gradient(center, ellipse cover, #f3e2c7 0%, #b68d4c 100%, #e9d4b3 100%);
            /* FF3.6-15 */
            background: -webkit-radial-gradient(center, ellipse cover, #f3e2c7 0%, #b68d4c 100%, #e9d4b3 100%);
            /* Chrome10-25,Safari5.1-6 */
            background: radial-gradient(ellipse at center, #f3e2c7 0%, #b68d4c 100%, #e9d4b3 100%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3e2c7', endColorstr='#e9d4b3', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }


    </style>
@endsection
@section('content')


    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">

                <a href="{{ route('membership.create') }}" type="button" class="btn btn-custom waves-effect waves-light"
                   aria-expanded="false"> إضافة
                    <span class="m-l-5">
                        <i class="fa fa-user"></i>
                    </span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div>
            <h4 class="page-title">@lang('global.users_management')</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12 push-left m-b-10">
                        <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                        </a>
                    </div>
                </div>

                <table id="datatable-fixed-header" class="table  table-striped">
                    <thead>
                    <tr>
                        <th>
                            <div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox" style="margin-bottom: 0px;" name="check"
                                       onchange="checkSelect(this)"
                                       value="option2"
                                       aria-label="Single checkbox Two">
                                <label></label>
                            </div>
                        </th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>الصور</th>
                        <th> العروض المتاحة</th>
                        <th>سماح الفيديوهات</th>

                        <th>اللون</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($memberships as $membership)

                        <tr>
                            <td>
                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" style="margin-bottom: 0px;" class="checkboxes-items"
                                           value="{{ $membership->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td>
                            <td style="width: 10%;">
                                <a data-fancybox="gallery"
                                   href="{{ $helper->getDefaultImage($membership->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                    <img style="width: 50%; border-radius: 50%; height: 49px;"
                                         src="{{ $helper->getDefaultImage($membership->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                </a>

                            </td>

                            <td>{{ $membership->name }}</td>
                            <td>{{ $membership->images  }}</td>
                            <td>{{ $membership->offers }}</td>
                            <td>@if($membership->allow_video == 1) <label
                                        class="label label-success">مسموح</label> @else <label
                                        class="label label-danger">غير مسموح</label> @endif</td>


                            <td>
                                <label class="{{ $membership->color }}"
                                       style="text-transform: capitalize;">{{ $membership->color }}</label>
                            </td>
                            {{--<td>--}}
                            {{--@if($membership->is_active == 1)--}}
                            {{--<label class="label label-success label-xs">مفعل</label>--}}
                            {{--@else--}}
                            {{--<label class="label label-danger label-xs">غير مفعل</label>--}}
                            {{--@endif--}}
                            {{--</td>--}}


                            <td>
                                <a href="{{ route('membership.edit',$membership->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="javascript:;" id="elementRow{{ $membership->id }}"
                                   data-id="{{ $membership->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>

                                </a>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <!-- End row -->
@endsection


@section('scripts')

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
                        url: '{{ route('membership.delete') }}',
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

                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = 'عفواً, لا يمكنك حذف العضوية الان نظراً لوجود 3 شركات مسجلين بها.';
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

        $('.getSelected').on('click', function () {
            // var items = $('.checkboxes-items').val();
            var sum = [];
            $('.checkboxes-items').each(function () {
                if ($(this).prop('checked') == true) {
                    sum.push(Number($(this).val()));
                }

                var $tr = $(this).closest($('#elementRow' + $(this).val()).parent().parent());


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
                            url: '{{ route('memberships.group.delete') }}',
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
                                        $(this).parent().parent().parent().remove();
                                    }
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

        $('.getSelectedAndSuspend').on('click', function () {

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
                            url: '{{ route('users.group.suspend') }}',
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
                                        $(this).parent('tr').remove();
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

    </script>


@endsection




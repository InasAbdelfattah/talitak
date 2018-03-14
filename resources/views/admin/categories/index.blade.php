@extends('admin.layouts.master')


@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('categories.create') }}" class="btn btn-custom  waves-effect waves-light">
                    <span class="m-l-5">
                        <i class="fa fa-plus"></i> <span>إضافة</span> </span>
                </a>

            </div>
            <h4 class="page-title">أنواع الخدمات</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">

                <div class="dropdown pull-right">
                    @if($categories->count()> 0)
                        <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                        </a>
                    @endif
                </div>
                {{--<input type="text" name="filter" class="filteriTems" id="filterItems"/>--}}

                {{--<select id="recordNumber" class="filteriTems">--}}

                {{--<option value="5">5</option>--}}
                {{--<option value="10">10</option>--}}
                {{--<option value="15">15</option>--}}
                {{--<option value="20">20</option>--}}
                {{--<option value="25">25</option>--}}
                {{--<option value="50">50</option>--}}
                {{--<option value="100">100</option>--}}

                {{--</select>--}}

                <h4 class="header-title m-t-0 m-b-30">مشاهدة أنواع الخدمات</h4>

                <table class="table m-0  table-striped table-hover table-condensed" id="datatable-fixed-header">
                    <thead>
                    <tr>
                        <th>
                            #
                            {{--<div class="checkbox checkbox-primary checkbox-single">--}}
                            {{--<input type="checkbox" name="check" onchange="checkSelect(this)"--}}
                            {{--value="option2"--}}
                            {{--aria-label="Single checkbox Two">--}}
                            {{--<label></label>--}}
                            {{--</div>--}}
                        </th>
                        <th>صورة المنشأة</th>
                        <th>الاسم(عربى)</th>
                        <th>الاسم(انجليزى)</th>
                        <!-- <th>نوع المنشأة</th> -->
                        <th>نوع المستقبل</th>
                        <th>حالة التفعيل</th>
                        <th>تاريخ الانشاء</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($categories as $category)
                        <tr>
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="{{ $category->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>

                            </td>

                            <td style="width: 10%;">


                                <a data-fancybox="gallery"
                                   href="{{ $helper->getDefaultImage($category->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                    <img style="width: 50%; border-radius: 50%; height: 49px;"
                                         src="{{ $helper->getDefaultImage($category->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>

                                </a>

                            </td>
                            <td>{{ $category->name_ar }}</td>
                            <td>{{ $category->name_en }}</td>
                            <td>
                                @if($category->target_gender == 0)
                                    رجال
                                @elseif($category->target_gender == 1)
                                    نساء
                                @else
                                    كليهما معا
                                @endif
                            </td>
                            <!-- <td>{{ $category->target_gender == 0 ? 'رجال' : 'نساء' }}</td> -->
                            <td>{{ $category->is_active == 1 ? 'مفعل' : 'غير مفعل' }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>

                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="javascript:;" id="elementRow{{ $category->id }}" data-id="{{ $category->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>

                                </a>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>


                {{--<div class="articles">--}}

                {{--                    @include('admin.categories.load')--}}

                {{--</div>--}}
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->
@endsection


@section('scripts')


    <script>


        {{--@if(session()->has('success'))--}}

        {{--setTimeout(function () {--}}
        {{--showMessage('{{ session()->get('success') }}');--}}
        {{--}, 3000);--}}


        {{--@endif--}}
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
                            url: '{{ route('categories.group.delete') }}',
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
                        url: '{{ route('category.delete') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == true) {
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

                                $tr.find('td').fadeOut(1000, function () {
                                    $tr.remove();
                                });

                            } else {
                                var shortCutFunction = 'error';
                                var msg = data.message;
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


        // function showMessage(message) {
        //
        //     var shortCutFunction = 'success';
        //     var msg = message;
        //     var title = 'نجاح!';
        //     toastr.options = {
        //         positionClass: 'toast-top-center',
        //         onclick: null,
        //         showMethod: 'slideDown',
        //         hideMethod: "slideUp",
        //     };
        //     var $toast = toastr[shortCutFunction](msg, title);
        //     // Wire up an event handler to a button in the toast, if it exists
        //     $toastlast = $toast;
        //
        //
        // }
    </script>



@endsection



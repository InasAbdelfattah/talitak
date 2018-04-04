@extends('admin.layouts.master')


@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <!-- <div class="btn-group pull-right m-t-15">
                <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
                                class="fa fa-cog"></i></span></button>

            </div> -->
            <h4 class="page-title">طلبات إلتحاق بالمراكز</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="dropdown pull-right">
                    {{--<a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">--}}
                    {{--<i class="zmdi zmdi-more-vert"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li><a href="#">Action</a></li>--}}
                    {{--<li><a href="#">Another action</a></li>--}}
                    {{--<li><a href="#">Something else here</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li><a href="#">Separated link</a></li>--}}
                    {{--</ul>--}}

                    <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                        <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                    </a>
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

                <h4 class="header-title m-t-0 m-b-30">طلبات إلتحاق المراكز</h4>

                {{--<div class="articles">--}}

                {{--                    @include('admin.categories.load')--}}

                {{--</div>--}}


                {{--<table id="users" class="table table-striped table-hover table-condensed" style="width:100%"--}}


                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
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
                        <th>صورة الوثيقة</th>
                        <th>اسم المركز</th>
                        <th>البريد الإلكترونى</th>
                        <th> الهاتف</th>
                        <th>النوع</th>
                        <th>المدينة</th>
                        {{--<th>الاعجابات</th>--}}
                        {{--<th>التعليقات</th>--}}
                        <th>تفعيل</th>
                        {{--<th> المقيميين</th>--}}
                        <th>تاريخ الانشاء</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($companies as $row)
                        <tr id="currentRowOn{{ $row->id  }}">
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="{{ $row->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>

                            </td>

                            <td style="width: 10%;">
                                @if($row->document_photo != '')
                                <a data-fancybox="gallery"
                                   href="{{ url('files/docs/' . $row->document_photo) }}">
                                    <img style="width: 50%; border-radius: 50%; height: 49px;"
                                         src="{{ url('files/docs/' . $row->document_photo) }}"/>
                                </a>
                                @else
                                    غير مرفق مستند
                                @endif

                            </td>
                            <td>{{ $row->{'name:ar'} }}</td>
                            <td>{{ $row->email }}</td>
                            <td>@if($row->user){{ $row->user->phone }}@endif</td>
                            <td>{{ $row->type == 0 ? 'فرد' :'مركز' }}</td>
                            <td> @if($row->city) {{ $row->city->{'name:ar'} }} @endif </td>

                            {{--<td>--}}
                            {{--<p>--}}
                            {{--<i class="fa fa-thumbs-o-up"></i>--}}
                            {{--<span>{{ $row->likesCount }}</span>--}}
                            {{--</p>--}}

                            {{--<p>--}}
                            {{--<i class="fa fa-thumbs-o-down"></i>--}}
                            {{--<span>{{ $row->dislikesCount }}</span>--}}
                            {{--</p>--}}

                            {{--</td>--}}

                            {{--<td>--}}
                            {{--<label class="label label-success">{{ $row->comments->count() }}</label>--}}

                            {{--</td>--}}

                            <td>
                                <a href="#custom-modal{{ $row->id }}"
                                   data-id="{{ $row->id }}" id="currentRow{{ $row->id }}"
                                   class="btn btn-success btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
                                   data-animation="fadein" data-plugin="custommodal"
                                   data-overlaySpeed="100" data-overlayColor="#36404a">تفعيل</a>

                                <!-- Modal -->
                                <div id="custom-modal{{ $row->id }}" class="modal-demo"
                                     data-backdrop="static">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">تفعيل المركز :  {{ $row->name }}</h4>
                                    <div class="custom-modal-text text-right" style="text-align: right !important;">
                                        <form action="{{ route('company.activation') }}" method="post"
                                              data-id="{{ $row->id }}">

                                            {{ csrf_field() }}

                                            <input type="hidden" value="{{ $row->id }}" name="companyId"
                                                   id="companyID"/>
                                        
                                            <div class="form-group ">
                                                <div class="checkbox checkbox-custom">
                                                    <input id="checkbox-signup" type="checkbox" value="1" required
                                                           required data-parsley-trigger="keyup"
                                                           data-parsley-required-message="لابد من قبول الطلب اولاً"
                                                           name="agree" id="agree" {{ old('agree') ? 'checked' : '' }}>
                                                    <label for="checkbox-signup">
                                                        قبول الطلب
                                                    </label>
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


                                    </div>
                                </div>

                            </td>

                            {{--<td>--}}
                            {{--<label class="label label-inverse">{{ $row->ratings->count() }}</label>--}}
                            {{--</td>--}}

                            <td>{{ $row->created_at }}</td>
                            <td>
                                <a href="{{ route('companies.show', $row->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <!-- <button class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-edit"></i>
                                </button> -->
                                <!-- <button class="btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </button> -->

                                <a href="javascript:;" id="elementRow{{ $row->id }}"
                                   data-id="{{ $row->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                {{--                {{ $companies->links() }}--}}

            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->
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
                        url: '{{ route('company.delete') }}',
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
                            url: '{{ route('companies.group.delete') }}',
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


            // var $tr = $($('#currentRowOn' + id)).closest($('#currentRow' + id).parent().parent());

            // console.log($tr);


            var formData = new FormData(this);
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

                        $("#currentRow" + data.id).html('تم التفعيل');
                        $("#currentRow" + data.id).addClass('btn-danger').removeClass('btn-success');
                        setTimeout(function () {
                            $('#currentRowOn' + data.id).parents('table').DataTable()
                                .row($('#currentRowOn' + data.id))
                                .remove()
                                .draw();
                        }, 2000);




                        {{--setTimeout(function () {--}}
                        {{--window.location.href = '{{ route('categories.index') }}';--}}
                        {{--}, 3000);--}}
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


@endsection




@extends('admin.layouts.master')

@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                        data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
                                class="fa fa-cog"></i></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </div>
            <h4 class="page-title">الحجوزات</h4>
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

                <div class="row">
                <form action="{{route('orders.search')}}" method="post">
                    {{csrf_field()}}
                    <div class="col-lg-3">
                        نوع الخدمة : 
                        <input type="text" name="service_type" class="filteriTems" id="filterItems"/>
                    </div>
                    <div class="col-lg-3">
                        مزود الخدمة : 
                        <input type="text" name="service_provider" class="filteriTems" id="filterItems"/>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                    </form>
                    </div>
                </div>
                {{--<select id="recordNumber" class="filteriTems">--}}

                {{--<option value="5">5</option>--}}
                {{--<option value="10">10</option>--}}
                {{--<option value="15">15</option>--}}
                {{--<option value="20">20</option>--}}
                {{--<option value="25">25</option>--}}
                {{--<option value="50">50</option>--}}
                {{--<option value="100">100</option>--}}

                {{--</select>--}}

                <h4 class="header-title m-t-0 m-b-30">عرض الحجوزات</h4>

                <table id="datatable-fixed-header" class="table table-striped table-hover table-condensed"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم طالب الخدمة</th>
                        <th>اسم مزود الخدمة</th>
                        <th>اسم المركز</th>
                        <th>نوع الخدمة</th>
                        <th>اسم الخدمة</th>
                        <th>مكان الخدمة</th>
                        <th>وصف الخدمة</th>
                        <th>مدينة الخدمة</th>
                        <th>حالة الخدمة</th>
                        <th>وقت وتاريخ الخدمة</th>
                        <th>سعر الخدمة</th>
                        <th>تقييم الخدمة الخدمة</th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>

                    @if(count($orders) > 0)
                    @foreach($orders as $row)
                        <tr>
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="{{ $row->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>
                            </td>

                            <td>{{ $row->username }}</td>
                            <td>@if(user($row->provider_id)){{ user($row->provider_id)->name }}@endif</td>
                            <td> @if(type($row->serviceType)) {{type($row->serviceType)->name_ar}} @endif </td>
                            <td>{{ $row->company_name }}</td>
                            <td> {{$row->service_name}} </td>
                            <td> {{ $row->company_place == 0 ? 'منازل' : 'مركز' }} </td>
                            <td>{{$row->service_desc}}</td>                            
                            <td>
                            @php $city = App\City::find($row->city_id) ; @endphp
                            @if($city){{ $city->{'name:ar'} }}@endif</td>                            
                            <td> {{$row->status}} </td>
                            

                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->price }}</td>
                            <td>
                               <label class="label label-inverse">@if($row->rates){{ $row->rates->avg('rate') }}@else 'لم يقيم' @endif</label>
                            </td>
                            <td>
                                <!-- <a href="{{ route('orders.show', $row->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-info m-b-5">
                                    <i class="fa fa-eye"></i>
                                </a> -->

                                <a href="javascript:;" id="elementRow{{ $row->id }}"
                                   data-id="{{ $row->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    @endif
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
                        url: '{{ route('orders.delete') }}',
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
                            url: '{{ route('orders.group.delete') }}',
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

    </script>

@endsection

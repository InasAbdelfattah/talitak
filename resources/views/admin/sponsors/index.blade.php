@extends('admin.layouts.master')


@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('sponsors.create') }}" class="btn btn-custom waves-effect waves-light">إضافة <span
                            class="m-l-5">
                            <i class="fa fa-plus"></i></span>
                </a>

            </div>
            <h4 class="page-title">الإعلانات الممولة</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="dropdown pull-right">
                    @if($sponsors->count()> 0)
                        <a style="float: left; margin-right: 15px;" class="btn btn-danger btn-sm getSelected">
                            <i class="fa fa-trash" style="margin-left: 5px"></i> حذف المحدد
                        </a>
                    @endif
                </div>

                <h4 class="header-title m-t-0 m-b-30">مشاهدة الإعلانات الممولة</h4>

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

                        <th>البانر</th>
                        <th>الرابط الإعلان</th>

                        <th> نوع المنشأة </th>
                        <th>  تاريخ الإعلان </th>
                        <th>الخيارات</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($sponsors as $row)
                        <tr>
                            <td>

                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input type="checkbox" class="checkboxes-items"
                                           value="{{ $row->id }}"
                                           aria-label="Single checkbox Two">
                                    <label></label>
                                </div>

                            </td>


                            <td style="width: 10%;">
                                <a data-fancybox="gallery"
                                   href="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                    <img style="width: 50%; border-radius: 50%; height: 49px;"
                                         src="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                </a>

                            </td>
                            <td>
                                @if($row->type == 0)

                                    <a href="{{ $row->url }}">رابط الاعلان (خارجى) </a>
                                @else
                                    <a href="{{ route('companies.show', $row->company_id) }}">{{ (\App\Company::whereId($row->company_id)->first())?\App\Company::whereId($row->company_id)->first()->name: '*--*' }} </a>
                                @endif
                            </td>


                            <td>


                                @if($row->type == 0)
                                    <label class="label label-inverse">
                                        منشأة خارجية
                                    </label>
                                @else
                                    <label class="label label-success">
                                        منشأة داخليه
                                    </label>

                                @endif

                            </td>
                            <td>
                                {{ $row->created_at }}
                            </td>

                            {{--                            <td>{{ $row->created_at }}</td>--}}
                            <td>

                                <a href="{{ route('sponsors.edit', $row->id) }}"
                                   class="btn btn-icon btn-xs waves-effect btn-default m-b-5">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="javascript:;" id="elementRow{{ $row->id }}" data-id="{{ $row->id }}"
                                   class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                    <i class="fa fa-remove"></i>

                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->
@endsection


@section('scripts')



    <script>

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
                            url: '{{ route('sponsors.group.delete') }}',
                            data: {ids: sum},
                            dataType: 'json',
                            success: function (data) {
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
                        url: '{{ route('sponsor.delete') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
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


    </script>


@endsection




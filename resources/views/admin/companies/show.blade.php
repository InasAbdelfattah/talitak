@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">بيانات المركز</h3>
        </div>

        <!--
                        <div class="m-t-15 col-xs-6 col-md-8 col-sm-8 text-right">
                            <a href="profile_edit.html">
                                     <button type="button" class="btn btn-success">تعديل البيانات</button>
                                </a>
                        </div>
        -->
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        {{--<h3 class="m-t-0 m-b-0">بيانات المركز</h3>--}}

                        <div class="m-t-20 text-center">
                            @if($company->image)
                            <a data-fancybox="gallery"
                               href="{{ url('files/companies/' . $company->image) }}">
                                <img class="img-thumbnail" src="{{ url('files/companies/' . $company->image) }}"/>
                            </a>
                            @else
                            <img class="img-thumbnail" src="{{ request()->root().'/assets/admin/custom/images/default.png' }}"/>
                            @endif
                        </div>

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم مدير المركز بالكامل :</label>
                                <p>{{ $company->{'name:ar'} }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p>@if($company->user) {{ $company->user->phone }} @else -- @endif </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم جوال المركز :</label>
                                <p>{{ $company->phone }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>البريد الالكتروني :</label>
                                <p>@if($company->user) {{ $company->user->email }} @else -- @endif </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>  مكان الخدمة :</label>
                                <p>{{ $company->place == 0 ? 'منازل' : 'مركز' }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label> نوع مزود الخدمة :</label>
                                <p>{{ $company->type == 0 ? 'فرد' : 'مركز' }}</p>
                            </div>

                            <!-- <div class="col-lg-3 col-xs-12">
                                <label>العضوية :</label>
                                <p> {{ $company->membership['name'] }}</p>
                            </div> -->

                            <div class="col-lg-3 col-xs-12">
                                <label>المدينة :</label>
                                <p>@if($company->city){{ $company->city->{'name:ar'} }}@endif</p>
                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                                <label> <p>{{ $company->type == 0 ? 'وثيقة الهوية' : 'وثيقة السجل التجارى' }} : </p></label>
                                @if($company->document_photo != '')
                                    <a data-fancybox="gallery" href="{{ url('files/docs/' . $company->document_photo) }}">
                                        <img class="img-thumbnail" src="{{ url('files/docs/' . $company->document_photo) }}"/>
                                    </a>
                                @else
                                    <img class="img-thumbnail" src="{{request()->root().'/assets/admin/custom/images/default.png'}}"/>
                                @endif

                            </div>

                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">الخدمات</h4>

                @if($company->products->count() > 0)
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>صورة الخدمة</th>
                            <th>اسم الخدمة</th>
                            <th>نوع مستقبل الخدمة</th>
                            <th>نوع مزود الخدمة</th>
                            <th>مكان الخدمة</th>
                            <th>السعر</th>
                            <!-- <th>الحى</th> -->
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company->products  as $row)
                            <tr>
                                <td>#</td>
                                <td>
                                    <a data-fancybox="gallery"
                                       href="{{ $helper->getDefaultImage(request()->root().'/files/companies/products/'.$row->photo, request()->root().'/assets/admin/custom/images/default.png') }}">
                                        <img style="width: 50px; height: 50px; border-radius: 50%"
                                             src="{{ $helper->getDefaultImage(request()->root().'/files/companies/products/'.$row->photo, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                    </a>
                                </td>
                                <td>{{ $row->{'name:ar'} }}</td>
                                <td>
                                    @if( $row->gender_type == 'male') رجال 
                                    @elseif($row->gender_type == 'female')نساء
                                    @else كلاهما
                                    @endif
                                </td>
                                <td>{{ $row->provider_type == 'male' ? 'رجال' : 'نساء' }}</td>
                                <td>{{ $row->service_place == 'center' ? 'مركز' : 'منازل' }}</td>
                                <td>{{ $row->price }}</td>
                                <!-- <td> @if($row->district) {{$row->district->{'name:ar'} }} @endif</td> -->
                                <td>
                                    <!-- <a href="javascript:;" id="updateRow{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('product.update')  }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a> -->

                                    <a href="javascript:;" id="elementRow{{ $row->id }}" data-id="{{ $row->id }}"
                                       data-url="{{ route('product.delete')  }}"
                                       class="btn btn-xs btn-danger removeElement">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                                لا توجد خدمات متاحة حالياً للمركز
                            </div>
                        </div>
                    </div>

                @endif

            </div>

        </div>

        <div class="col-lg-6">
            <div class="card-box">

                <h4 class="header-title m-t-0 m-b-30">مواعيد العميل</h4>
                @if($company->workDays->count() > 0)
                    <table class="table table table-hover m-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <!-- <th>صورة المنتج</th> -->
                            <th>اليوم</th>
                            <th>من</th>
                            <th>إلى</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($company->workDays  as $row)
                                <tr>
                                    <td>#</td>
                                    
                                    <td>{{ day($row->day) }}</td>
                                    <td>{{ $row->from }}</td>
                                    <td>{{ $row->to }}</td>
                                </tr>
                            @endforeach
                       
                        </tbody>
                    </table>
                @else
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger text-center">
                            غير متوفر مواعيد عمل للمركز
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التعليقات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                @if($company->comments->count() > 0)
                                <!-- <table class="table m-0  table-striped table-hover table-condensed" > -->
                                    <table class="table table table-hover m-0" id="datatable-fixed-header">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> نص التعليق </th>
                                            <th>حالة التعليق</th>
                                            <th>  الخيارات </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($company->comments as $comment)
                                            <tr>
                                                <td>#</td>
                                                <td>@if($comment->user) {{ $comment->user->name }} @else --- @endif</td>
                                                <td>{{ $comment->comment }}</td>
                                                <!-- <td>{{ $comment->created_at }}</td> -->
                                                <td>
                                                    <a id="ban{{$comment->id}}" href="javascript:;" id="commentSuspend{{ $comment->id }}" data-id="{{$comment->id}}" class="suspendElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5" data-overlayColor="#36404a"> @if($comment->is_suspend == 0)حظر التعليق @else رفع الحظر @endif
                                                    </a>
                                                </td>
                                                <td>

                                                    <a href="javascript:;" id="commentDelete{{ $comment->id }}" data-id="{{$comment->id}}" class="removeElement btn btn-icon btn-trans btn-xs waves-effect waves-light btn-danger m-b-5">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                
                                @else
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجد تعليقات متاحة حالياً للمركز
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التقييمات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                @if($company->rates->count() > 0)
                                    <table class="table table table-hover m-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th> التقييم </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($company->rates as $rate)
                                            <tr>
                                                <td>#</td>
                                                <td>@if( $rate->user ){{ $rate->user->name  or $rate->user->username}} @else
                                                                -- @endif</td>
                                                <td>{{ $rate->rate }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                <div class="col-xs-12">
                                    <div class="alert alert-success">
                                        متوسط تقييم المركز : {{$company->rates->avg('rate')}}
                                    </div>
                                </div>
                                @else
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            لا توجود تقييمات حالياً للمركز
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>
    </div>
  
@endsection

@section('scripts')

    <script>
        $('body').on('click', '.removeElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentDelete' + id).parent().parent());
            swal({
                title: "هل انت متأكد؟",
                text: "لا يمكنك استرجاع المحذوفات مرة اخرى.",
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
                        url: '{{ route('companies.deleteComment') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
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
                                var msg = data.message;
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

        $('body').on('click', '.suspendElement', function () {
            var id = $(this).attr('data-id');
            var $tr = $(this).closest($('#commentSuspend' + id).parent().parent());
            var $td = $(this).closest($('#ban' + id));
            swal({
                title: "هل انت متأكد؟",
                text: "",
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
                        url: '{{ route('companies.suspendComment') }}',
                        data: {id: id},
                        dataType: 'json',
                        success: function (data) {
                            console.log('suspend : ', data.data.suspend);
                            
                            if (data.status == true) {
                                if(data.data.suspend == 1){
                                    // $td.removeClass('btn-danger');
                                    // $td.addClass('btn-success');
                                    $td.text('رفع الحظر');
                                }else{
                                    $td.text(' حظر');
                                }
                                var shortCutFunction = 'success';
                                var msg = 'لقد تمت العملية بنجاح.';
                                var title = data.title;
                                toastr.options = {
                                    positionClass: 'toast-top-left',
                                    onclick: null
                                };
                                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                                $toastlast = $toast;
                                   
                                // $tr.find('td').fadeOut(1000, function () {
                                //     $tr.find('td:first').text('inas');
                                //     //$("#myDiv table table td:first").text("Picked")
                                // });
                            }
                            if (data.status == false) {
                                var shortCutFunction = 'error';
                                var msg = data.message;
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
                        text: "انت لغيت عملية الحذر تقدر تحاول فى اى وقت :)",
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
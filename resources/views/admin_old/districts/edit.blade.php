@extends('admin.layouts.master')

@section('content')

    <div id="messageError"></div>
    <form data-parsley-validate novalidate method="POST" action="{{ route('districts.update', $district->id) }}"
          enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('districts.create') }}" class="btn btn-custom waves-effect waves-light">إضافة <span
                                class="m-l-5">
                            <i class="fa fa-plus"></i></span>
                    </a>

                </div>
                <h4 class="page-title">الأحياء</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">تعديل الحى ( {{ $district->{'name:ar'} }} )</h4>

                    <div class="form-group">
                        <label for="userName"> :  الاسم باللغة العربية*</label>
                        <input type="text" name="name_ar" parsley-trigger="change" required
                               placeholder=" ادخل اسم الحى باللغة العربية..." class="form-control"
                               value="{{ $district->{'name:ar'} or old('name_ar') }}"
                               id="userName"
                               data-parsley-required-message="هذا الحقل إلزامي">

                        @if ($errors->has('name_ar'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                           </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="userName"> الاسم باللغة الانجليزية*</label>
                        <input type="text" name="name_en" parsley-trigger="change" required
                               placeholder="ادخل الحى باللغة الانجليزية..." class="form-control"
                               value="{{ $district->{'name:en'} or old('name_en') }}"
                               id="userName"
                               data-parsley-required-message="هذا الحقل إلزامي">

                        @if ($errors->has('name_en'))
                            <span class="help-block">
                                <strong> {{ $errors->first('name_en') }} </strong>
                           </span>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="pass1">المدينة*</label>
                        <select class="form-control select2" name="city_id">
                            <!-- <option value="">ادخل المدينة</option> -->
                             @foreach($cities as $city) 
                                    <option value="{{ $city->id }}" {{$district->city_id == $city->id ? 'selected' : ''}}>
                                        {{ $city->{'name:ar'} }}
                                    </option>                                
                             @endforeach 

                        </select>
                    </div>


                    <div class="form-group text-right m-b-0">
                        <button class="btn btn-primary waves-effect waves-light" type="submit"> حفظ البيانات
                        </button>
                        <button onclick="window.history.back();return false;"
                                class="btn btn-default waves-effect waves-light m-l-5"> إلغاء
                        </button>
                    </div>

                </div>
            </div><!-- end col -->


        </div>
        <!-- end row -->
    </form>


@endsection


{{--@section('scripts')--}}
{{--<script type="text/javascript">--}}

{{--$('form').on('submit', function (e) {--}}
{{--e.preventDefault();--}}
{{--var formData = new FormData(this);--}}
{{--$.ajax({--}}
{{--type: 'POST',--}}
{{--url: $(this).attr('action'),--}}
{{--data: formData,--}}
{{--cache: false,--}}
{{--contentType: false,--}}
{{--processData: false,--}}
{{--success: function (data) {--}}

{{--//  $('#messageError').html(data.message);--}}

{{--var shortCutFunction = 'success';--}}
{{--var msg = data.message;--}}
{{--var title = 'نجاح';--}}
{{--toastr.options = {--}}
{{--positionClass: 'toast-top-left',--}}
{{--onclick: null--}}
{{--};--}}
{{--var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists--}}
{{--$toastlast = $toast;--}}
{{--setTimeout(function () {--}}
{{--window.location.href = '{{ route('categories.index') }}';--}}
{{--}, 3000);--}}
{{--},--}}
{{--error: function (data) {--}}

{{--}--}}
{{--});--}}
{{--});--}}

{{--</script>--}}
{{--@endsection--}}





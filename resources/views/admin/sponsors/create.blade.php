@extends('admin.layouts.master')
@section('styles')
    <style>
        .radio.radio-inline {
            display: inline-flex;
            margin-bottom: 20px;
            padding: 0px;
        }
    </style>
@endsection
@section('content')
    <form method="POST" action="{{ route('sponsors.store') }}" enctype="multipart/form-data" data-parsley-validate
          novalidate>
    {{ csrf_field() }}

    <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i
                                    class="fa fa-cog"></i></span></button>

                </div>
                <h4 class="page-title">إدارة الاعلانات الممولة</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">


                    <div id="errorsHere"></div>
                    <div class="dropdown pull-right">
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
                    </div>

                    <h4 class="header-title m-t-0 m-b-30"> بيانات الاعلان</h4>

                    <div class="form-group">
                        <p class="text-muted font-13 m-b-15 m-t-20">نوع الاعلان</p>
                        <div class="radio radio-info radio-inline">
                            <input type="radio" class="showCompaniesSelectors" data-show="0" id="inlineRadio1"
                                   value="0"
                                   name="type" checked>
                            <label for="inlineRadio1">منشأة خارجية</label>
                        </div>
                        <div class="radio radio-inline">
                            <input type="radio" class="showCompaniesSelectors" data-show="1" id="inlineRadio2"
                                   value="1"
                                   name="type">
                            <label for="inlineRadio2"> منشأة مسجلة </label>
                        </div>
                    </div>

                    <div class="col-xs-12" id="LinkSponsor">
                        <div class="form-group">
                            <label for="userName">رابط الاعلان *</label>
                            <input type="text" name="url" value="{{ old('url') }}" class="form-control"
                                   placeholder="رابط الإعلان..."/>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }} b-t-20"
                         id="selectorsCompanies"
                         @if($setting->getBody('comment_setting') != 2 ) style="display: none;" @endif>
                        <label for="passWord2">المنشأة</label>
                        <select name="company" class="select2 form-control">

                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                        @if($company->is_comment == 1) selected @endif>{{ $company->name }}</option>
                            @endforeach

                        </select>

                        @if($errors->has('companies'))
                            <p class="help-block"> {{ $errors->first('companies') }}</p>
                        @endif

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

            <div class="col-lg-4">
                <div class="card-box" style="overflow: hidden;">
                    <h4 class="header-title m-t-0 m-b-30">صورة الإعلان</h4>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" name="image" class="dropify" data-max-file-size="6M" required/>

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>
@endsection

@section('scripts')
    <script>


        $('.showCompaniesSelectors').on('change', function () {
            var show = $(this).attr('data-show');

            if (show == 1) {
                $('#LinkSponsor').fadeOut(500);
                $('#selectorsCompanies').delay(500).fadeIn(500);
            } else {
                $('#selectorsCompanies').fadeOut(500);
                $('#LinkSponsor').delay(500).fadeIn(500);
            }

        });

    </script>
@endsection
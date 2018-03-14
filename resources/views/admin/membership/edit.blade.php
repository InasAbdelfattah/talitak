@extends('admin.layouts.master')

@section('content')


    <form method="POST" action="{{ route('membership.update', $membership->id) }}" enctype="multipart/form-data"
          data-parsley-validate novalidate>
    {{ csrf_field() }}
    {{ method_field('PUT') }}



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
                <h4 class="page-title">تعديل المستخدم</h4>
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

                    <h4 class="header-title m-t-0 m-b-30">تعديل بيانات المستخدم</h4>


                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName">الاسم *</label>
                            <input type="text" name="name" value="{{ $membership->name or old('name') }}"
                                   class="form-control" required
                                   placeholder="اسم العضوية..."/>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                    </div>


                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName">السعر *</label>
                            <input type="text" name="price" value="{{ $membership->price  or old('price') }}"
                                   class="form-control" required
                                   data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                   data-parsley-type="digits"
                                   data-parsley-maxlength="10"
                                   placeholder="سعر العضوية..."/>
                            @if($errors->has('price'))
                                <p class="help-block">
                                    {{ $errors->first('price') }}
                                </p>
                            @endif
                        </div>

                    </div>


                    <div class="col-xs-12">
                        <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }}">
                            <label for="images">عدد الصور المسموحة*</label>
                            <input type="number" name="images" value="{{ $membership->images or  old('images') }}"
                                   class="form-control"
                                   data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                   data-parsley-type="digits"
                                   data-parsley-maxlength="4"
                                   required placeholder="عدد الصور المسموحة..."/>
                            @if($errors->has('images'))
                                <p class="help-block">
                                    {{ $errors->first('images') }}
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="col-xs-12">
                        <div class="form-group{{ $errors->has('offers') ? ' has-error' : '' }}">
                            <label for="offers">عدد العروض*</label>
                            <input type="number" name="offers" value="{{ $membership->offers or old('offers') }}"
                                   class="form-control"
                                   data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                   data-parsley-type="digits"
                                   data-parsley-maxlength="4"
                                   required placeholder="عدد العروض المسموحة..."/>
                            @if($errors->has('offers'))
                                <p class="help-block">
                                    {{ $errors->first('offers') }}
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="col-xs-12">
                        <div class="form-group{{ $errors->has('offers') ? ' has-error' : '' }}">
                            <label for="offers">مدة العرض *</label>
                            <input type="number" name="offer_time"
                                   value="{{ $membership->offer_time or old('offer_time') }}" class="form-control"
                                   data-parsley-validation-threshold="1" data-parsley-trigger="keyup"
                                   data-parsley-type="digits"
                                   data-parsley-maxlength="4"
                                   required placeholder="مدة العرض..."/>
                            @if($errors->has('offer_time'))
                                <p class="help-block">
                                    {{ $errors->first('offer_time') }}
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="userName">اللون *</label>
                            {{--<input type="text" name="color" value="{{ $membership->color or old('color') }}"--}}
                                   {{--class="form-control" required--}}
                                   {{--data-parsley-validation-threshold="1" data-parsley-trigger="keyup"--}}

                                   {{--placeholder="اللون..."/>--}}
                            <select name="color" class="form-control" required
                                    data-parsley-validation-threshold="1" data-parsley-trigger="keyup">
                                <option @if($membership->color == 'gold') selected @endif value="gold">ذهبى</option>
                                <option @if($membership->color == 'silver') selected @endif value="silver">فضى</option>
                                <option @if($membership->color == 'bronze') selected @endif value="bronze">برونزية</option>
                            </select>
                            @if($errors->has('color'))
                                <p class="help-block">
                                    {{ $errors->first('color') }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <div class="col-xs-6">

                        <div class="form-group ">

                            <div class="checkbox checkbox-custom">

                                <input id="checkbox-signup" type="checkbox"
                                       @if($membership->allow_video == 1) checked @endif
                                       name="allow_video" {{ old('allow_video') ? 'checked' : '' }}>
                                <label for="checkbox-signup">
                                    مسموح برابط فيديو
                                </label>
                            </div>


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

            <div class="col-lg-4">
                <div class="card-box" style="overflow: hidden;">


                    <h4 class="header-title m-t-0 m-b-30">الصورة الشخصية</h4>

                    <div class="form-group">
                        <div class="col-sm-12">

                            <input type="hidden" value="{{ $membership->image }}" name="oldImage"/>
                            <input type="file" name="image" class="dropify" data-max-file-size="6M"
                                   data-default-file="{{ $membership->image }}"/>

                        </div>
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </form>

@endsection


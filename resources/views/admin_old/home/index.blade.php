@extends('admin.layouts.master')
@section('title', 'الصفحة الرئيسية')
@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">لوحة التحكم</h4>
        </div>
    </div>


    @if(auth()->user()->can('statistics_manage'))

        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">مستخدمى التطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{ $data['usersCount'] }}<i
                                                 class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">     {{ $data['usersCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد مستخدي التطبيق</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['usersCount']}}%;">
                                <!-- <span class="sr-only">77% Complete</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30"> عدد مزودى الخدمات</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{ $data['providersCount'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">  {{ $data['providersCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد مزودى الخدمات </p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['providersCount']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">الرجال بالتطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{$data['mens_count']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['mens_count']}}</h2>
                            <p class="text-muted m-b-25">عدد الرجال</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['mens_count']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">النساء بالتطبيق</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-success pull-left m-t-20">{{$data['womens_count']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['womens_count']}}</h2>
                            <p class="text-muted m-b-25">عدد النساء</p>

                        </div>
                        <div class="progress progress-bar-success-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['womens_count']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">أنواع الخدمات </h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{ $data['categoriesCount'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0"> {{ $data['categoriesCount'] }} </h2>
                            <p class="text-muted m-b-25">عدد أنواع الخدمات </p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['categoriesCount']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">المراكز بالتطبيق</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{$data['centersCount']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['centersCount']}}</h2>
                            <p class="text-muted m-b-25">عدد المراكز </p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['centersCount']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30"> الخدمات بالتطبيق </h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{$data['services_app']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['services_app']}}</h2>
                            <p class="text-muted m-b-25">عدد الخدمات</p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['services_app']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">إبلاغات الإساءة الغير معتمدة</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-pink pull-left m-t-20">{{$data['notadoptedreports']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['notadoptedreports']}}</h2>
                            <p class="text-muted m-b-25">عدد إبلاغات الإساءة الغير معتمدة </p>
                        </div>
                        <div class="progress progress-bar-pink-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-pink" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['notadoptedreports']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->

                    <h4 class="header-title m-t-0 m-b-30">الحجوزات</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{  $data['orders'] }}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0"> {{  $data['orders'] }} </h2>
                            <p class="text-muted m-b-25">عدد الحجوزات </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['orders']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <!-- <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div> -->
                    <h4 class="header-title m-t-0 m-b-30">الرسائل المقروءة</h4>
                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{$data['read_contacts']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['read_contacts']}}</h2>
                            <p class="text-muted m-b-25">عدد الرسائل المقروءة </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['read_contacts']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-30">البريد الغير مقروء</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                                     <span class="badge badge-primary pull-left m-t-20">{{$data['notread_contacts']}}<i class="zmdi zmdi-trending-up"></i> </span>
                            <h2 class="m-b-0">{{$data['read_contacts']}}</h2>
                            <p class="text-muted m-b-25">عدد البريد الغير المقروء </p>
                        </div>
                        <div class="progress progress-bar-primary-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: {{$data['notread_contacts']}}%;">
                                <span class="sr-only">77% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->


        </div>
        <!-- end row -->



    @else



        <div class="alert alert-info fade in">

            <strong>مرحباً بك!</strong>
            <b style="color: #000;">{{ auth()->user()->name }}</b>
            فى لوحة تحكم تطبيق الشقردي
            </a>

        </div>



    @endif


@endsection
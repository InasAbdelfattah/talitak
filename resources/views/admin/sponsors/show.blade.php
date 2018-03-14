@extends('admin.layouts.master')



@section('content')

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-6 col-md-4 col-sm-4">
            <h3 class="page-title">بيانات الشركة</h3>
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
                        {{--<h3 class="m-t-0 m-b-0">بيانات الشركة</h3>--}}

                        <div class="m-t-20 text-center">
                            <a data-fancybox="gallery"
                               href="{{ $helper->getDefaultImage($company->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                <img class="img-thumbnail"
                                     src="{{ $helper->getDefaultImage($company->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                            </a>


                        </div>

                        <div class="panel-body">

                            <div class="col-lg-3 col-xs-12">
                                <label>اسم مدير الشركة بالكامل :</label>
                                <p>{{ $company->name }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>رقم الجوال :</label>
                                <p>@if($company->user) {{ $company->user->phone }} @else -- @endif </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>البريد الالكتروني :</label>
                                <p>@if($company->user) {{ $company->user->email }} @else -- @endif </p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>العضوية :</label>
                                <p> {{ $company->membership['name'] }}</p>
                            </div>

                            <div class="col-lg-3 col-xs-12">
                                <label>العنوان :</label>
                                <p>{{ $company->address }}</p>
                            </div>


                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">التقييمات</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">
                                @foreach($company->ratings as $rate)

                                    <div class="col-xs-6">
                                        <span>@if( $rate->user ){{ $rate->user->name  or $rate->user->username}} @else
                                                -- @endif</span>
                                    </div>
                                    {!! $main_helper->html_rate_icons($rate->rating) !!}
                                    <br/>
                                @endforeach
                            </div>
                        </div>


                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">صور الشركة</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">


                                @foreach($company->images as $image)
                                    <div class="col-xs-3">

                                        <a data-fancybox="gallery"
                                           href="{{ $helper->getDefaultImage($image->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                            <img class="img img-fluid"
                                                 style="width: 100px;margin-bottom: 10px;height: 100px;border-radius: 50%;"
                                                 src="{{ $helper->getDefaultImage($image->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                        </a>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card-box">
                @foreach($company->comments as $comment)
                    <div class="comment">
                        <img src="@if($comment->user) {{ $helper->getDefaultImage($comment->user->image, request()->root().'/assets/admin/custom/images/default.png') }} @else @endif"
                             alt=""
                             class="comment-avatar">
                        <div class="comment-body">
                            <div class="comment-text">
                                <div class="comment-header">
                                    <a href="#"
                                       title="">@if($comment->user) {{ $comment->user->name or   $comment->user->username}} @else @endif </a><span>    {{ $comment->created_at->diffForHumans() }} </span>
                                </div>
                                {{ $comment->comment }}
                            </div>

                        </div>
                    </div>


                @endforeach

            </div>


        </div>
    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="card-box">

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

                <h4 class="header-title m-t-0 m-b-30">المنتجات</h4>


                <table class="table table table-hover m-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>صورة المنتج</th>
                        <th>اسم المنتج</th>
                        <th>سعر المنتج</th>
                        <th>الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($company->products  as $row)
                        <tr>
                            <td>#</td>
                            <td>
                                <a data-fancybox="gallery"
                                   href="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                    <img style="width: 50px; height: 50px; border-radius: 50%"
                                         src="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                </a>
                            </td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->price }}</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div><!-- end col -->
        <div class="col-lg-6">
            <div class="card-box">

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

                <h4 class="header-title m-t-0 m-b-30">العروض</h4>


                <table class="table table table-hover m-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>بانر العرض</th>
                        <th>اسم العرض</th>
                        <th>وصف العرض</th>
                        <th>صور العرض</th>
                        <th> الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($company->offers as $row)
                        <tr>
                            <td>#</td>
                            <td>
                                <a data-fancybox="gallery"
                                   href="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                    <img style="width: 50px; height: 50px; border-radius: 50%"
                                         src="{{ $helper->getDefaultImage($row->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                </a></td>
                            <td>{{ $row->name }}</td>

                            <td>{{ str_limit($row->description, 10) }}</td>
                            <td>


                                @if($row->images->count() > 0)
                                    <a href="#custom-modal{{ $row->id }}"
                                       class="showImagesOffers btn btn-info btn-xs btn-trans waves-effect waves-light m-r-5 m-b-10"
                                       data-animation="fadein" data-plugin="custommodal"
                                       data-overlaySpeed="100" data-overlayColor="#36404a">الصور
                                        ({{ $row->images->count() }})</a>


                                    <!-- Modal -->
                                    <div id="custom-modal{{ $row->id }}" class="modal-demo">
                                        <button type="button" class="close" onclick="Custombox.close();">
                                            <span>&times;</span><span class="sr-only">Close</span>
                                        </button>

                                        <h4 class="custom-modal-title">Modal title</h4>
                                        <div class="custom-modal-text" id="contentModal">

                                            @foreach($row->images as $image)
                                                <a data-fancybox="gallery"
                                                   href="{{ $helper->getDefaultImage($image->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                                    <img style="width: 50px; height: 50px; border-radius: 50%"
                                                         src="{{ $helper->getDefaultImage($image->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                                                </a>

                                            @endforeach
                                        </div>
                                    </div>

                                @else

                                @endif

                            </td>
                            <td>
                                <a href="{{ route('offers.show', $row->id) }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>


                                    <a href="#"  @if(date("Y-m-d H:i:s") > date('Y-m-d', strtotime('offerExpireDate')) ) disabled @endif class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>


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
@extends('admin.layouts.master')



@section('content')

    <!-- Page-Title -->

    <div class="row">
        <div class="col-xs-8 col-md-8 col-sm-8">
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
        <div class="col-xs-8">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        {{--<h3 class="m-t-0 m-b-0">بيانات الشركة</h3>--}}

                        <div class="m-t-20 text-center">
                            <a data-fancybox="gallery"
                               href="{{ $helper->getDefaultImage($offer->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                <img class="img-thumbnail"
                                     src="{{ $helper->getDefaultImage($offer->image, request()->root().'/assets/admin/custom/images/default.png') }}"/>
                            </a>


                        </div>

                        <div class="panel-body">

                            <div class="col-lg-6 col-xs-12">
                                <label>اسم العرض :</label>
                                <p>{{ $offer->name }}</p>
                            </div>

                            <div class="col-lg-6 col-xs-12">
                                <label>وصف العرض :</label>
                                <p>{{ $offer->Description }}</p>
                            </div>


                            <div class="col-lg-6 col-xs-12">
                                <label> تاريخ بداية العرض :</label>
                                <p>{{ $offer->created_at }}</p>
                            </div>


                            <div class="col-lg-6 col-xs-12">
                                <label> تاريخ نهاية العرض :</label>
                                <p>{{ $offer->offerExpireDate }}</p>
                            </div>

                            <div class="col-lg-12 col-xs-12">
                                <label> باقى الوقت من العرض :</label>
                                <div id="countdown"></div>
                            </div>


                        </div>
                    </div>
                    <!-- end card-box-->


                </div>
            </div>
        </div>


        <div class="col-sm-4 col-xs-12 text-center">
            <div class="bg-picture card-box">
                <div class="profile-info-name">
                    <div class="profile-info-detail">
                        <h3 class="m-t-0 m-b-0">صور الشركة</h3>

                        <div class="col-xs-12 m-t-20">
                            <div class="row">


                                @foreach($offer->images as $image)
                                    <div class="col-xs-3">

                                        <a data-fancybox="gallery"
                                           href="{{ $helper->getDefaultImage($image->image, request()->root().'/assets/admin/custom/images/default.png') }}">
                                            <img class="img img-fluid"
                                                 style="width: 70px;margin-bottom: 10px;height: 70px;border-radius: 50%;"
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




@endsection


@section('scripts')


    <script>
        var end = new Date('{{  $offer->offerExpireDate }}');

        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;

        function showRemaining() {
            var now = new Date();
            var distance = end - now;
            if (distance < 0) {

                clearInterval(timer);
                document.getElementById('countdown').innerHTML = 'تم انتهاء العرض!';

                return;
            }
            var days = Math.floor(distance / _day);
            var hours = Math.floor((distance % _day) / _hour);
            var minutes = Math.floor((distance % _hour) / _minute);
            var seconds = Math.floor((distance % _minute) / _second);

            document.getElementById('countdown').innerHTML = days + ' يوم ';
            document.getElementById('countdown').innerHTML += hours + ' ساعة ';
            document.getElementById('countdown').innerHTML += minutes + ' دقيقة ';
            document.getElementById('countdown').innerHTML += seconds + ' ثانية';
        }

        timer = setInterval(showRemaining, 1000);
    </script>




    <script>
        var timer = new Timer();
        timer.start({countdown: true, startValues: {seconds: 1000}});
        $('#countdownExample .values').html(timer.getTimeValues().toString());
        timer.addEventListener('secondsUpdated', function (e) {
            $('#countdownExample .values').html(timer.getTimeValues().toString());
        });
        timer.addEventListener('targetAchieved', function (e) {
            $('#countdownExample .values').html('KABOOM!!');
        });</script>


@endsection

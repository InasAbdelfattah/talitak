@extends('admin.master')

@section('title')
    {!!  trans('admin.sideLevelsTitle') . ' ' . $data->name  !!}
@endsection

@section('sectionName')
    <a href="{{ route('levels') }}"> {{ trans('admin.sideLevelsTitle') }} </a>
@endsection

@section('pageName')
    {!!  trans('admin.sideLevelsTitleDe')  . ' : <span class="text-success">' . $data->name . '</span>' !!}
@endsection



@section('content')

    <div class="col-md-12">

        <!-- Advanced legend -->
        <form action="#" method="post" >
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('admin.adminNewLevelTitle') }} </h5>

                </div>


                <div class="panel-body">
                    <fieldset>


                        <div class="collapse in" id="demo1">
                            <div class="form-group">
                                <label> {{ trans('admin.groupName') }} </label>
                                <input readonly type="text" name="name" value="{{ $data->name }}" class="form-control"
                                       placeholder=" {{ trans('admin.groupName') }} ">
                            </div>

                            <div class="form-group">
                                <label> {{ trans('admin.addedBy') }} </label>
                                <input type="text" class="form-control" readonly
                                       value="{{ $data->username">
                            </div>


                            <div class="form-group">
                                <label> {{ trans('admin.groupItems') }} </label>
                                <div class="col-md-12">

                                    <?php $lData = json_decode($data->items); ?>
                                    @if(count($lData) > 0 )
                                        @foreach($lData as $route => $item)

                                            <a href="{{ route($route) }}" class="btn btn-sm btn-primary"
                                               style="margin: 3px;">

                                                @foreach( $menu as $row)
                                                    @foreach( $row['route'] as $key => $val)
                                                        @if($key == $route)
                                                            {!!  $val  !!}
                                                        @endif
                                                    @endforeach
                                                @endforeach

                                            </a>



                                        @endforeach

                                    @endif

                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <br>

                            <div class="form-group">
                                <label> {{ trans('admin.adminsADStatus') }} </label>
                                <input type="text" class="form-control" readonly
                                       value="{{  $data->status == 1 ?  trans('admin.settingsOpen') : trans('admin.settingsClose')  }}">

                            </div>

                            <div class="form-group">
                                <label> {{ trans('admin.AddedDate') }} </label>
                                <input type="text" class="form-control" readonly value="{{  $data->created_at }}">

                            </div>

                            <div class="form-group">
                                <label> {{ trans('admin.lastUpdate') }} </label>
                                <input type="text" class="form-control" readonly value="{{  $data->updated_at }}">

                            </div>

                        </div>
                    </fieldset>

                    <div class="text-right">

                    </div>
                </div>
            </div>
        </form>
        <!-- /a legend -->

    </div>


@endsection
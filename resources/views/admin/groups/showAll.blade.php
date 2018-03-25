@extends('admin.master')

@section('title')
{{ trans('admin.sideLevelsTitle') }}
@endsection

@section('sectionName')
{{ trans('admin.sideLevelsTitle') }}
@endsection

@section('pageName')
{{ trans('admin.sideLevelsShowAll') }}
@endsection


@section('content')

        <!-- Highlighting rows and columns -->
<div class="panel panel-flat">

    <table class="table table-bordered table-hover datatable-highlight">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.groupName') }}</th>
            <th>{{ trans('admin.groupItems') }}</th>
            <th> {{ trans('admin.addedBy') }} </th>
            <th>{{ trans('admin.AddedDate') }}</th>
            <th>{{ trans('admin.show') }}</th>
            <th>{{ trans('admin.edit') }}</th>
            <th>{{ trans('admin.delete') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($data) > 0)
            @foreach($data as $value)

                <tr>
                    <td>{{ $value->id }}</td>
                    <td><a href="{{ route('level-details', ['id' => $value->id]) }}">{{ $value->name }}</a></td>
                    <td>
                        <?php $count = count(json_decode($value->items)); ?>
                        @if($count > 0 )
                            <?php $i = 1; ?>
                            @foreach(json_decode($value->items) as $route => $item)

                                <a href="{{ route($route) }}" class="btn btn-sm btn-primary" style="margin: 3px;">

                                    @foreach( $menu as $row)
                                        @foreach( $row['route'] as $key => $val)
                                            @if($key == $route)
                                                {!!   $val !!}
                                            @endif
                                        @endforeach
                                    @endforeach

                                </a>

                                <?php if($i == 3)  { echo '...';  break; } ?>

                                <?php $i++; ?>

                            @endforeach

                        @endif

                    </td>

                    <td><a href="{{ route('admin-details', ['id' => $value->user_id ]) }}"> {{ $value->username }} </a> </td>
                    <td>{{ $value->created_at }}</td>
                    <td><a href="{{ route('level-details', ['id' => $value->id]) }}"><i class="icon-tv"
                                                                                        aria-hidden="true"></i></a></td>
                    <td><a href="{{ route('level-edit', ['id' => $value->id]) }}"><i class="icon-pencil"
                                                                                     aria-hidden="true"></i></a></td>
                    <td>
                    @if($value->id != 1)
                    <a class="do-delete" href="{{ route('level-delete', ['id' => $value->id]) }}"><i class="icon-database-remove"></i></a>
                    @endif
                    </td>
                </tr>

            @endforeach
        @endif
        </tbody>
    </table>
</div>



@endsection
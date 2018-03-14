@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.abilities.title')</h3>
    <form action="{{ route('abilities.store') }}" method="POST">
        {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label>Name</label>
                    <input name="name" value="{{ old('name') }}"  class="form-control" required/>
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <button >إضافة</button>
    </form>

@stop

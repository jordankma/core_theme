@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-companionunit::language.titles.manage') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <style>
        .control-label{
            padding-top: 5px !important;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                {!! Form::model($comgroup, ['url' => route('vne.comgroup.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 col-lg-3 col-12 control-label"
                                   for="comgroup">Nhóm đơn vị:</label>
                            <div class="col-md-9 col-lg-9 col-12{{ $errors->first('comgroup', 'has-error') }} ">
                                <input id="comgroup" name="comgroup" type="text"
                                       placeholder="Nhóm đơn vị..." value="{{$comgroup->comgroup}}"
                                       class="form-control"  autofocus required>
                                <span class="help-block">{{ $errors->first('comgroup', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::hidden('id') !!}
                </div>
                <div  class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('vne.comgroup.create') !!}"
                               class="btn btn-danger">{{ trans('vne-companionunit::language.buttons.discard') }}</a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                {!! Form::close() !!}
            </div>
            @if ( $errors->any() )
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
        });
    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-companionunit::language.titles.create') }}@stop

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
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
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
                <!-- errors -->
                {!! Form::open(array('url' => route('vne.comgroup.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'demoForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="comgroup">Nhóm đơn vị:</label>
                                <div class="col-md-9 col-lg-9 col-12{{ $errors->first('comgroup', 'has-error') }} ">
                                    <input id="comgroup" name="comgroup" type="text"
                                           placeholder="Nhóm đơn vị..."
                                           class="form-control"  autofocus required>
                                    <span class="help-block">{{ $errors->first('comgroup', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('vne.comgroup.create') !!}"
                                   class="btn btn-danger">{!! trans('vne-companionunit::language.buttons.discard') !!}</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
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
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        });
        $(function () {
            $('#lfm').filemanager('image');
        });
    </script>
@stop

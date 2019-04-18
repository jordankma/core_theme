@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-cachemanager::language.titles.contest_cache.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
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
                {!! Form::open(array('url' => route('contest.cachemanager.contest_cache.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'contest_cacheForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-8">
                        <label>Tên cache</label>
                        <div class="form-group {{ $errors->first('cache_name', 'has-error') }}">
                            {!! Form::text('cache_name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-cachemanager::language.placeholder.contest_cache.cache_name'))) !!}
                            <span class="help-block">{{ $errors->first('cache_name', ':message') }}</span>
                        </div>

                        <label>Cache key</label>
                        <div class="form-group {{ $errors->first('cache_key', 'has-error') }}">
                            {!! Form::text('cache_key', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-cachemanager::language.placeholder.contest_cache.cache_key'))) !!}
                            <span class="help-block">{{ $errors->first('cache_key', ':message') }}</span>
                        </div>

                        <label>Cache tags</label>
                        <div class="form-group {{ $errors->first('cache_tags', 'has-error') }}">
                            {!! Form::text('cache_tags', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-cachemanager::language.placeholder.contest_cache.cache_tags'))) !!}
                            <span class="help-block">{{ $errors->first('cache_tags', ':message') }}</span>
                        </div>

                        <label>Cache url</label>
                        <div class="form-group {{ $errors->first('cache_url', 'has-error') }}">
                            {!! Form::text('cache_url', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-cachemanager::language.placeholder.contest_cache.cache_url'))) !!}
                            <span class="help-block">{{ $errors->first('cache_url', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('contest.cachemanager.contest_cache.create') !!}"
                                   class="btn btn-danger">{{ trans('contest-cachemanager::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
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
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
    </script>
@stop

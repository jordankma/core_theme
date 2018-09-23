@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $title_page = trans('adtech-core::titles.setting.manage') }}
    @parent
@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        {{--<h1>{{ $title_page }}</h1>--}}
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title_page }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">

            <div class="the-box no-border">
                {!! Form::open(array('url' => route('adtech.core.setting.resetCache'), 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
                <div class="row">
                    <div class="col-sm-8">

                        <label>Cache name</label>
                        <div class="form-group">
                            {!! Form::text('cache_name', old('cache_name'), array('class' => 'form-control')) !!}
                        </div>

                        {{ $encrypted }}
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <label for="blog_category" class="">Actions</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('adtech.core.setting.manage') !!}"
                               class="btn btn-danger">{{ trans('adtech-core::buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 --> </div>
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
    <script src="{{ config('site.url_static') . ('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ config('site.url_static') . ('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" ></script>
    <script>
        $(function () {
            // var domain = "http://dhcd-release.vnedutech.vn/administrator/laravel-filemanager";
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
        })
    </script>
@stop

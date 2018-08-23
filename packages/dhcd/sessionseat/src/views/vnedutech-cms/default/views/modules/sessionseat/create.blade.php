@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-sessionseat::language.titles.create') }}@stop

{{-- page styles --}}
@section('header_styles')
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
                {!! Form::open(array('url' => route('dhcd.sessionseat.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'sessionseatForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <div class="row">
                    <div class="col-sm-8">
                        <label>Tên Phiên :</label>
                        <div class="form-group {{ $errors->first('sessionseat_name', 'has-error') }}">
                            {!! Form::text('sessionseat_name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-sessionseat::language.placeholder.name_here'),'required')) !!}
                            <span class="help-block">{{ $errors->first('sessionseat_name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label>Sơ đồ chỗ ngồi phiên :</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="sessionseat_img" value="{{old('sessionseat_img')}}" required>
                        </div>
                        <img id="holder" src="{{old('sessionseat_img')}}" style="margin-top:15px;max-height:100px;">
                        <br>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('dhcd.sessionseat.create') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-sessionseat::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $('#lfm').filemanager('image');
        })
    </script>
@stop

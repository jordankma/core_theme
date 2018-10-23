@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('exam-exammanage::language.titles.exam.create') }}@stop

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
                {!! Form::open(array('url' => route('exam.exammanage.exam.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'examForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="form-group {{ $errors->first('filepath', 'has-error') }}" id="image">
                                <label>Logo chính</label>
                                <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" c-data="image" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                                    <input class="form-control" id="thumbnail" type="text" name="filepath" value="{{old('filepath')}}">
                                </div>
                                <span class="help-block">{{ $errors->first('filepath', ':message') }}</span>
                                <img class="holder"
                                     @if(!empty(old('filepath')))
                                     src="{{asset(old('filepath'))}}"
                                     @endif
                                     style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                        <label>Tên cuộc
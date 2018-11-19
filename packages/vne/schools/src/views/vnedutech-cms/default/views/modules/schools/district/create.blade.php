@extends('layouts.default')
{{-- Page title --}}
@section('title'){{ $title = trans('vne-schools::language.titles.district') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}"
          rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/all.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .control-label {
            font-family: "Times New Roman", Times, serif;
            padding-top: 6px;
            padding-right: 0px;
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
                {!! Form::model( $provinces ,['url' => route('vne.schools.district.add'), 'method' => 'post', 'class' => 'bf', '_id' => 'districtForm', 'files'=> true]) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <label class="col-md-2 control-label"
                           for="province_id">{!! trans('vne-schools::language.label.province') !!}(<span
                                style="color: red">*</span>):</label>
                    <div class="form-group {{ $errors->first('province_id', 'has-error') }}">
                        <div class="col-md-6">
                            <select class="form-control select2" id="province_id" name="province_id">
                                @if(isset($provinces))
                                    @foreach($provinces as $province)
                                        <option value="{{$province->_id}}">{{$province->province}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label"
                               for="schoollevel">{!! trans('vne-schools::language.label.district') !!}(<span
                                    style="color: red">*</span>):</label>
                        <div class="col-md-6">
                            <input id="district" name="district" type="text"
                                   placeholder="{{ trans('vne-schools::language.placeholder.district') }}"
                                   class="form-control" required>
                            <span class="help-block">{{ $errors->first('district', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 col-sm-push-3">
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('vne.schools.district.create') !!}"
                               class="btn btn-danger">{{ trans('vne-schools::language.buttons.discard') }}</a>
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
    @jquery
    @toastr_js
    @toastr_render
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/validation.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $(".select2").select2({
                theme: "bootstrap"
            });
        });
    </script>
@stop

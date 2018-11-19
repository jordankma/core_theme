@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-schools::language.titles.province') }}@stop

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

        .btn-sm, .btn-xs {
            padding: 4px 10px 5px 10px;
            font-size: 14px;
            line-height: 1.5;
            border-radius: 3px;
            display: block;
            padding: 6px 12px;
            width: 100%;
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
                {!! Form::open(array('url' => route('vne.schools.province.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'provinceForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="row">
                        <label class="col-sm-2 control-label"
                               for="province">{!! trans('vne-schools::language.label.province') !!}(<span
                                    style="color: red">*</span>):</label>
                        <div class="col-sm-6">
                            <input id="province" name="province" type="text"
                                   placeholder="{{ trans('vne-schools::language.placeholder.province') }}"
                                   class="form-control" required>
                            <span class="help-block">{{ $errors->first('province', ':message') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 control-label"
                               for="region">{!! trans('vne-schools::language.label.region') !!}(<span
                                    style="color: red">*</span>):</label>
                        <div class="col-sm-6">
                            <select id="region" name="region" type="text" class="form-control">
                                <option value="Miền Bắc">Miền Bắc</option>
                                <option value="Miền Trung">Miền Trung</option>
                                <option value="Miền Nam">Miền Nam</option>
                            </select>
                            <span class="help-block">{{ $errors->first('region', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group ">
                        <div class="col-sm-3 col-sm-push-4">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('vne.schools.province.create') !!}"
                               class="btn btn-danger">{{ trans('vne-schools::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/ select2/js/select2.js') }}"></script>

    <!--end of page js-->
    <div class="modal fade" id="getprovince" tabindex="-1" role="dialog" aria-labelledby="getprovince"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

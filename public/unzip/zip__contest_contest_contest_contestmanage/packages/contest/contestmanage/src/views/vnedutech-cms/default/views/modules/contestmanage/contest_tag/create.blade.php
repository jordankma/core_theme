@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_tag.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <style>
        .text-on-pannel {
            background: #fff none repeat scroll 0 0;
            height: auto;
            margin-left: 20px;
            padding: 3px 5px;
            position: absolute;
            margin-top: -47px;
            /*border: 1px solid #337ab7;*/
            /*border-radius: 8px;*/
        }

        .panel {
            /* for text on pannel */
            margin-top: 27px !important;
        }

        .panel-body {
            padding-top: 30px !important;
        }
        .form-group{
            overflow: hidden;
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
            <div class="panel panel-primary" id="hidepanel1">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{$title}}
                    </h3>

                </div>
                <div class="panel-body ">
                <!-- errors -->
                {!! Form::open(array('url' => route('contest.contestmanage.contest_tag.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'examForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nhóm tag</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_tag.name_here'))) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <label>Tên tag</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_tag.name_here'))) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <label>Thứ tự mùa</label>
                            <div class="form-group {{ $errors->first('number', 'has-error') }}">
                                {!! Form::number('number', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('number', ':message') }}</span>
                            </div>
                            <label>Ngày bắt đầu:</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                            </span>
                                <input type="text" name="start_date" class="form-control" id="start_date"/>
                            </div>
                            <label>Ngày kết thúc:</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                            </span>
                                <input type="text" name="end_date" class="form-control" id="end_date"/>
                            </div>
                            <label>Mô tả</label>
                            <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_tag.description'))) !!}
                                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label>Thể lệ</label>
                        <div class="form-group {{ $errors->first('rules', 'has-error') }}">
                            {!! Form::textarea('rules', null, array('class' => 'form-control', 'id' => 'ckeditor_full','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_tag.rules'))) !!}
                            <span class="help-block">{{ $errors->first('rules', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('contest.contestmanage.contest_tag.create') !!}"
                               class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="modal fade in" id="config_list" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mr-auto">Chọn cấu hình</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    </div>
                </div>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <!--end of page js-->
    <script>
        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.group_exam.create') }}@stop

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
            <div class="panel panel-primary" id="hidepanel1">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{$title}}
                    </h3>

                </div>
                <div class="panel-body ">
                <!-- errors -->
                {!! Form::open(array('url' => route('contest.contestmanage.group_exam.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'contestForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="col-sm-8">
                        <label>Chọn vòng thi (*)</label>
                        <div class="form-group {{ $errors->first('round', 'has-error') }}">
                            {!! Form::select('round', $round, null, array('class' => 'form-control', 'autofocus'=>'autofocus')) !!}
                            <span class="help-block">{{ $errors->first('round', ':message') }}</span>
                        </div>
                        <label>Tên bảng (*)</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.group_exam.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                        <label>Mô tả</label>
                        <div class="form-group {{ $errors->first('description', 'has-error') }}">
                            {!! Form::textarea('description', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.group_exam.description'))) !!}
                            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-md-4">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('contest.contestmanage.group_exam.create') !!}"
                                   class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <!--end of page js-->
    <script>
        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
    </script>
@stop
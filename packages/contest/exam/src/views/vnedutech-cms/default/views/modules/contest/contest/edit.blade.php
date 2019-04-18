@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contest::language.titles.contest.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
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
                {!! Form::model($contest, ['url' => route('contest.exam.contest_list.update', ['contest_id' => $contest->contest_id]), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="row">
                    <div class="col-sm-8">
                        <label>Tên cuộc thi</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', $contest->name, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                        <label>Tên miền</label>
                        <div class="form-group {{ $errors->first('domain', 'has-error') }}">
                            {!! Form::select('domain',$domain, $contest->domain_id, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('domain', ':message') }}</span>
                        </div>
                        <label>DB Mysql</label>
                        <div class="form-group {{ $errors->first('db_mysql', 'has-error') }}">
                            {!! Form::text('db_mysql', $contest->db_mysql, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('db_mysql', ':message') }}</span>
                        </div>
                        <label>DB Mongo</label>
                        <div class="form-group {{ $errors->first('db_mongo', 'has-error') }}">
                            {!! Form::text('db_mongo', $contest->db_mongo, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('db_mongo', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('contest.exam.contest_list.create') !!}"
                               class="btn btn-danger">{{ trans('contest-contest::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
        })
    </script>
@stop

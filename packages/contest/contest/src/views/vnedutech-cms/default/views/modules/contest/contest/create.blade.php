@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contest::language.titles.contest.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->
@php
    $preview_url = config('site.url_static');
@endphp

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
                {!! Form::open(array('url' => route('contest.contest.contest_list.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'contestForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Tên cuộc thi</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Tên miền</label>
                        <div class="form-group {{ $errors->first('domain', 'has-error') }}">
                            {!! Form::select('domain',$domain, null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('domain', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Tag cuộc thi</label>
                        <div class="form-group {{ $errors->first('contest_tag', 'has-error') }}">
                            {!! Form::text('contest_tag', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.contest_tag'))) !!}
                            <span class="help-block">{{ $errors->first('contest_tag', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>URL static</label>
                        <div class="form-group {{ $errors->first('url_static', 'has-error') }}">
                            {!! Form::text('url_static', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.url_static'))) !!}
                            <span class="help-block">{{ $errors->first('url_static', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <label>Logo</label>
                        <div class="form-group">
                            <div class="input-group">
                        <span class="input-group-btn">
                        <a id="vne_fm" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> {{trans('vne-news::language.label.choise_image_display')}}
                        </a>
                        </span>
                                <input type="text" name="image" id="thumbnail2" class="form-control">
                            </div>
                            <img id="holder2" style="margin-top:15px;max-height:100px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>DB Mysql host</label>
                        <div class="form-group {{ $errors->first('mysql_host', 'has-error') }}">
                            {!! Form::text('mysql_host', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mysql_host', ':message') }}</span>
                        </div>
                        <label>DB Mysql port</label>
                        <div class="form-group {{ $errors->first('mysql_port', 'has-error') }}">
                            {!! Form::number('mysql_port', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mysql_port', ':message') }}</span>
                        </div>
                        <label>DB Mysql Database</label>
                        <div class="form-group {{ $errors->first('mysql_database', 'has-error') }}">
                            {!! Form::text('mysql_database', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mysql_database', ':message') }}</span>
                        </div>
                        <label>DB Mysql username</label>
                        <div class="form-group {{ $errors->first('mysql_username', 'has-error') }}">
                            {!! Form::text('mysql_username', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mysql_username', ':message') }}</span>
                        </div>
                        <label>DB Mysql password</label>
                        <div class="form-group {{ $errors->first('mysql_password', 'has-error') }}">
                            {!! Form::text('mysql_password', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mysql_password', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>MongoDB host</label>
                        <div class="form-group {{ $errors->first('mongodb_host', 'has-error') }}">
                            {!! Form::text('mongodb_host', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mongodb_host', ':message') }}</span>
                        </div>
                        <label>MongoDB port</label>
                        <div class="form-group {{ $errors->first('mongodb_port', 'has-error') }}">
                            {!! Form::number('mongodb_port', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mongodb_port', ':message') }}</span>
                        </div>
                        <label>MongoDB Database</label>
                        <div class="form-group {{ $errors->first('mongodb_database', 'has-error') }}">
                            {!! Form::text('mongodb_database', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mongodb_database', ':message') }}</span>
                        </div>
                        <label>MongoDB username</label>
                        <div class="form-group {{ $errors->first('mongodb_username', 'has-error') }}">
                            {!! Form::text('mongodb_username', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mongodb_username', ':message') }}</span>
                        </div>
                        <label>MongoDB password</label>
                        <div class="form-group {{ $errors->first('mongodb_password', 'has-error') }}">
                            {!! Form::text('mongodb_password', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('mongodb_password', ':message') }}</span>
                        </div>
                    </div>
                </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('contest.contest.contest_list.create') !!}"
                                   class="btn btn-danger">{{ trans('contest-contest::language.buttons.discard') }}</a>
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
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
            $('body').on('click','.show',function () {

            });
            $('#vne_fm').filemanager();
        });

        (function ($) {

            $.fn.filemanager = function (type, options) {
                type = type || 'file';
                var parent = this;
                this.on('click', function (e) {
                    if( $(parent).attr('data-choice') === 'files'){
                        type = 'file';
                        $("#isIcon").val(1);
                    }
                    if( $(parent).attr('data-choice') === 'icon'){
                        $("#isIcon").val(2);
                    }
                    var route_prefix = (options && options.prefix) ? options.prefix : '/file-manager/manage';
                    localStorage.setItem('target_input', $(this).data('input'));
                    localStorage.setItem('target_preview', $(this).data('preview'));
                    window.open(route_prefix + '?type=' + type , 'FileManager', 'width=900,height=600');
                    if ($("#mutil").val() === 'remove' && $(parent).attr('data-choice') === 'files') {
                        return true;
                    } else {
                        window.SetUrl = function (url, file_path) {
                            console.log(url);
                            //set the value of the desired input to image url
                            var target_input = $('#' + localStorage.getItem('target_input'));
                            target_input.val(file_path).trigger('change');

                            //set or change the preview image src
                            var target_preview = $('#' + localStorage.getItem('target_preview'));
                            target_preview.attr('src', url).trigger('change');
                        };
                        return false;

                    }
                });
            }

        })(jQuery);
        $(window).bind('storage', function (e) {
            if(e.originalEvent.key == 'file_select'){
                var preview_url = '{{ $preview_url }}';
                var target_input =   localStorage.getItem('target_input');
                var target_preview =   localStorage.getItem('target_preview');
                $('#' + target_input).val(e.originalEvent.newValue);
                $('#' + target_preview).attr("src",preview_url + e.originalEvent.newValue);
            }
        });
    </script>
@stop

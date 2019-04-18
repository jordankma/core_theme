@php
    header ("Access-Control-Allow-Origin: *");
    header ("Access-Control-Expose-Headers: Content-Length, X-JSON");
    header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    header ("Access-Control-Allow-Headers: *");
@endphp
@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contest::language.titles.user_field.create') }}@stop

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
        .row{
            margin-top: 15px;
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
                {!! Form::open(array('url' => route('contest.exam.user_field.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'contestForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-md-6">
                        <label>Tên trường thông tin (label) (*)</label>
                        <div class="form-group {{ $errors->first('label', 'has-error') }}">
                            {!! Form::text('label', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('label', ':message') }}</span>
                        </div>
                        <label>Tên biến (*)</label>
                        <div class="form-group {{ $errors->first('varible', 'has-error') }}">
                            {!! Form::text('varible', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('varible', ':message') }}</span>
                        </div>
                        <label>Hint text (placeholder)</label>
                        <div class="form-group {{ $errors->first('hint_text', 'has-error') }}">
                            {!! Form::text('hint_text', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('hint_text', ':message') }}</span>
                        </div>
                        <label>Định dạng dữ liệu (*)</label>
                        <div class="form-group {{ $errors->first('data_type', 'has-error') }}">
                            {!! Form::select('data_type',$data_type, null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('data_type', ':message') }}</span>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label>Loại view html (*)</label>
                        <div class="form-group {{ $errors->first('type_id', 'has-error') }}">
                            {!! Form::select('type_id',$html_type_list, null, array('class' => 'form-control type_id', 'placeholder'=> trans('contest-contest::language.placeholder.contest.type'))) !!}
                            <span class="help-block">{{ $errors->first('type_id', ':message') }}</span>
                        </div>
                        {!! Form::hidden('type_name',null, array('class' => 'type_name')) !!}
                        <div id="type">

                        </div>
                        <div id="param_hidden">

                        </div>
                        <div id="api">

                        </div>
                        <div id="data_view">

                        </div>
                        {{--<label>Link api</label>--}}
                        {{--<div class="form-group {{ $errors->first('api', 'has-error') }}">--}}
                            {{--{!! Form::text('api', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}--}}
                            {{--<span class="help-block">{{ $errors->first('api', ':message') }}</span>--}}
                        {{--</div>--}}

                        {{--<label>Data view</label>--}}
                        {{--<div class="form-group {{ $errors->first('data_view', 'has-error') }}">--}}
                            {{--{!! Form::text('data_view', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}--}}
                            {{--<span class="help-block">{{ $errors->first('data_view', ':message') }}</span>--}}
                        {{--</div>--}}
                        <label>Mô tả</label>
                        <div class="form-group {{ $errors->first('description', 'has-error') }}">
                            {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Bắt buộc nhập?</label>
                        <div class="form-group">
                            <input type="checkbox" name="is_require" class="allow_permission" data-size="mini" checked>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Trường mặc định?</label>
                        <div class="form-group">
                            <input type="checkbox" name="is_default" class="allow_permission" data-size="mini" checked>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Cho phép lọc trong tra cứu?</label>
                        <div class="form-group">
                            <input type="checkbox" name="is_search" class="allow_permission" data-size="mini" checked>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Hiển thị trong thông tin thí sinh?</label>
                        <div class="form-group">
                            <input type="checkbox" name="show_on_info" class="allow_permission" data-size="mini" checked>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Hiển thị trong tra cứu kết quả?</label>
                        <div class="form-group">
                            <input type="checkbox" name="show_on_result" class="allow_permission" data-size="mini" checked>
                        </div>
                    </div>

                </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('contest.exam.user_field.create') !!}"
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
            $('input[type="checkbox"].allow_permission').bootstrapSwitch({
                onSwitchChange:function(event, state) {
                }
            });
        });

        $('body').on('change','.type_id', function () {
            $('#param_hidden').html('');
            $('.type_name').val($('option:selected', this).text());
            $('#type').html('');
            $('#data_view').html('');
            var type_id = $('option:selected', this).val();
            if(type_id == 1){
                var html = ' <label>Tên biến nhận giá trị select (param hidden)</label>' +
                    '<div class="form-group {{ $errors->first('data_type', 'has-error') }}">' +
                        '{!! Form::text('params_hidden', null, array('class' => 'form-control', 'autofocus'=>'autofocus')) !!}' +
                    '<span class="help-block">{{ $errors->first('data_type', ':message') }}</span></div>';

                $('#param_hidden').html(html);
            }
            var type_list = @json($type);
            if(type_list[type_id]){
                var html = ' <label>Loại data</label>' +
                        '<div class="form-group {{ $errors->first('type', 'has-error') }}">' +
                            '<select class="form-control type" name="type">' +
                    '<option value="">Chọn loại</option>';
                $.each(type_list[type_id], function(key, item){
                    html += '<option value ="' + key + '">' + item + '</option>';
                });

                    html += '</select>' +
                            '<span class="help-block">{{ $errors->first('type', ':message') }}</span>' +
                        '</div>';

                $('#type').html(html);
            }
            else{
                showDataView();
            }
        });

        $('body').on('change', '.type', function () {
            $('#data_view').html('');
           var type = $('option:selected', this).val();
           if(type == 'data'){
               showDataView();
           }
           else if(type == 'api'){
               $('#data_view').html('<label>Link api</label>' +
                        '<div class="form-group {{ $errors->first('api', 'has-error') }}">' +
                            '{!! Form::text('api', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> 'Nhập link api')) !!}' +
                            '<span class="help-block">{{ $errors->first('api', ':message') }}</span>' +
                        '</div>' +
                   '<label>Field cha (Nhận value từ field cha truyền vào api)</label>' +
                        '<div class="form-group {{ $errors->first('parent_field', 'has-error') }}">' +
                            '{!! Form::text('parent_field', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> 'Nhập param field cha')) !!}' +
                            '<span class="help-block">{{ $errors->first('parent_field', ':message') }}</span>' +
                        '</div>');
           }
           else if(type == 'data_api'){
               $('#api').html('<label>Link api</label>' +
                   '<div class="form-group {{ $errors->first('api', 'has-error') }}">' +
                       '{!! Form::text('api', null, array('class' => 'form-control api', 'autofocus'=>'autofocus','placeholder'=> 'Nhập link api')) !!}' +
                       '<span class="help-block">{{ $errors->first('api', ':message') }}</span></div>' +
                   '<div class="form-group">' +
                        '<div class="col-md-6">' +
                            '<input type="text" class="form-control row key" placeholder="Nhập param key">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                            '<input type="text" class="form-control row value" placeholder="Nhập param value">' +
                        '</div>' +
                   '</div>' +
                   '<div class="form-group"><button type="button" class="btn btn-primary get_data">Nhận data</button></div>');
               showDataView();
           }
        });

        $('body').on('click', '#more_data', function () {
            $('#data_list').append(genDataInput());
        });

        $('body').on('click', '.get_data', function () {
           var url = $('.api').val();
           var key_param = $('.key').val();
           var value_param = $('.value').val();
           $.get(url, function (data) {
               if(data){
                   genDataViewFromApi(data, key_param, value_param)
               }
           });
        });
        
        function genDataViewFromApi(data, key_param, value_param) {
            var html = '';
            $.each(data.data, function (key, item) {
                html += '<div class="form-group" id="dataview-'+ key +'">' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[key][]" value="'+ item[key_param] +'" placeholder="Nhập key"></div> ' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[value][]" value="'+ item[value_param] +'" placeholder="Nhập giá trị"></div> ' +
                '<div class="col-md-2"><a href="javascript:void(0)" class="remove" c-data="'+ key +'" style="color:red">x</a></div> ' +
                '</div>'
            });
            $('#data_list').html(html);
        }
        
        function showDataView() {
            var html = '<div class="panel panel-primary">' +
                                '<div class="panel-body">' +
                                    '<p class="text-on-pannel text-primary"><strong> Data view </strong></p>' +
                                    '<div id="data_list">' +

                                    '</div>' +
                                    '<a href="javascript:void(0)" class="btn btn-default" id="more_data"><span class="glyphicon glyphicon-plus-sign"></span> Thêm</a>' +
                                '</div>' +
                            '</div>';
            $('#data_view').html(html);
        }
        
        function genDataInput() {
            var idx = $('#data_view').find('.form-group').length;
            idx = idx +1;
            var html = '<div class="form-group" id="dataview-'+ idx +'">' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[key][]" placeholder="Nhập key"></div> ' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[value][]" placeholder="Nhập giá trị"></div> ' +
                '<div class="col-md-2"><a href="javascript:void(0)" class="remove" c-data="'+ idx +'" style="color:red">x</a></div> ' +
                '</div>';
            return html;
        }

    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.rank_board.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/selectize/css/selectize.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/all.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/line/line.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/switchery/css/switchery.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/formelements.css') }}" rel="stylesheet"/>

    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
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
        .remove_header{
            color: red;
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
                {!! Form::open(array('url' => route('contest.contestmanage.rank_board.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'clientForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tiêu đề bảng (*)</label>
                            <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                {!! Form::text('title', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.rank_board.name_here'))) !!}
                                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Tên Param (*)</label>
                            <div class="form-group {{ $errors->first('params', 'has-error') }}">
                                {!! Form::text('params', null, array('class' => 'form-control')) !!}
                                <span class="help-block">{{ $errors->first('params', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Loại (*)</label>
                            <div class="form-group {{ $errors->first('type', 'has-error') }}">
                                {!! Form::select('type', $type,0, array('class' => 'form-control type')) !!}
                                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="header">
                        <div class="panel panel-primary" id="headers">
                            <div class="panel-body">
                                <p class="text-on-pannel text-primary"><strong> Tiêu đề bảng kết quả trả về </strong></p>
                                <div id="header_container">

                                </div>
                                <a href="javascript:void(0)" c-data="headers" class="btn btn-default" id="more_header"><span class="glyphicon glyphicon-plus-sign"></span> Thêm header</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="tab_list">

                        </div>
                        <a href="javascript:void(0)" class="btn btn-default" id="more_tab"><span class="glyphicon glyphicon-plus-sign"></span> Thêm tab con</a>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="form-group">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('contest.contestmanage.rank_board.manage') !!}"
                               class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>

    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/sifter/sifter.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/microplugin/microplugin.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/selectize/js/selectize.min.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/switchery/js/switchery.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
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

        $('body').on('click', '.remove_tab' ,function() {
            var id = $(this).attr('c-data');
            $('#'+id).remove();
        });
        $('body').on('change', '.type', function () {
            $('#header_container').html('');
            $('#tab_list').html('');
        });

        $('body').on('click', '#more_header', function () {
            var id = $(this).attr('c-data');
            var idx = $('#'+id).find('#header_container').find('.form-group').length;
            idx++;
            if(id == 'headers'){
                var html = '<div class="form-group" id="header-'+idx+'">' +
                    '<div class="col-md-3"><input type="number" name="header[order][]" class="form-control" placeholder="Nhập thứ tự" value="'+idx+'"></div>' +
                    '<div class="col-md-3"><input type="text" name="header[param][]" class="form-control" placeholder="Nhập tên biến"></div>' +
                    '<div class="col-md-3"><input type="text" name="header[title][]" class="form-control" placeholder="Nhập tiêu đề"></div>' +
                    '<div class="col-md-3"><a href="javascript:void(0)" class="remove_header" d-data="'+id+'" c-data="header-'+idx+'">x</div>' +
                    '</div>';
            }
            else{
                 var html = '<div class="form-group" id="header-'+idx+'">' +
                    '<div class="col-md-3"><input type="number" name="data_child[header][order][]" class="form-control" placeholder="Nhập thứ tự" value="'+idx+'"></div>' +
                    '<div class="col-md-3"><input type="text" name="data_child[header][param][]" class="form-control" placeholder="Nhập tên biến"></div>' +
                    '<div class="col-md-3"><input type="text" name="data_child[header][title][]" class="form-control" placeholder="Nhập tiêu đề"></div>' +
                    '<div class="col-md-3"><a href="javascript:void(0)" class="remove_header" d-data="'+id+'" c-data="header-'+idx+'">x</div>' +
                    '</div>';
            }

            $('#'+id).find('#header_container').append(html);
        });

        $('body').on('click', '.remove_header', function () {
            var id = $(this).attr('c-data');
            var parent_id = $(this).attr('d-data');
            $('#'+parent_id).find('#'+id).remove();
        });

        $('body').on('click', '#more_tab' ,function() {
            var idx = $('#tab_list').find('.form-group').length;
            idx++;
            var html =
                '<div class="panel panel-primary" id="tab-' + idx + '">' +
                '<div class="panel-body">' +
                '<p class="text-on-pannel text-primary"><strong> Tab con '+ idx +'   </strong><span><a href="javascript:void(0)" class="remove_tab" c-data="tab-' + idx + '"><span class="glyphicon glyphicon-remove" style="color: red"></span></a></span></p>' +
                '<div class="form-group"> ' +
                '<div class="col-md-3">' +
                '{!! Form::text('data_child[title][]',null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.rank_board.tab_title'))) !!}' +
                '</div>' +
                '<div class="col-md-3">' +
                '{!! Form::text('data_child[params][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.rank_board.tab_params'))) !!}' +
                '</div>' +
                '<div class="col-md-2">' +
                '{!! Form::number('data_child[limit][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.rank_board.tab_limit'))) !!}' +
                '</div>' +
                '<div class="col-md-2">' +
                '{!! Form::number('data_child[order][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.rank_board.tab_order'))) !!}' +
                '</div>' +
                ''+
                '</div>' +
                '<div class="form-group">' +
                    '<div class="panel panel-primary">' +
                            '<div class="panel-body">' +
                                '<p class="text-on-pannel text-primary"><strong> Tiêu đề bảng kết quả trả về </strong></p>' +
                                '<div id="header_container">' +

                                '</div>' +
                                '<a href="javascript:void(0)" c-data="tab-' + idx + '" class="btn btn-default" id="more_header"><span class="glyphicon glyphicon-plus-sign"></span> Thêm header</a>' +
                            '</div>' +
                        '</div>' +
                '</div>' +
                '</div></div>';
            $('#tab_list').append(html);
            $('#tag-' +idx).selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
        });
    </script>
@stop

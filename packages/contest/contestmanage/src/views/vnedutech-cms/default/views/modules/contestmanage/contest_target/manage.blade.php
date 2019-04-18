@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_target.manage') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css">
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
        #target_thead{
            font-weight: bold;
        }
        .a_action{
            margin-left: 15px;
        }
        #custom_area{
        }

        .remove_custom, .remove_custom_field, .remove_custom_group{
            margin-left: 15px;
            color: red;
        }
        .panel_custom{
            background-color: #dedede;
        }
        .panel_custom .text-on-pannel{
            background-color: transparent;

        }
        .panel_custom > .panel-body > .text-on-pannel{
            border: 1px solid #337ab7;
        }
        .input-title{
            display: inline;
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
                {!! Form::open(array('url' => route('contest.contestmanage.contest_target.update'), 'method' => 'post', 'class' => 'bf', 'id' => 'contestForm', 'files'=> true)) !!}
                <div class="panel-body ">
                <!-- errors -->
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <p class="text-on-pannel text-primary"><strong> Trường thông tin chung </strong></p>
                                <div id="target_thead" class="form-group">
                                    <div class="col-md-2">Nhãn</div>
                                    <div class="col-md-1">Thứ tự</div>
                                    <div class="col-md-1">Bắt buộc</div>
                                    <div class="col-md-2">Cho phép lọc</div>
                                    <div class="col-md-2">Hiển thị trong thông tin</div>
                                    <div class="col-md-2">Hiển thị trong kết quả</div>
                                    <div class="col-md-2">Thao tác</div>
                                </div>
                                <div id="general_field" class="field_container">
                                    @if(!empty($target->general))
                                        @foreach($target->general as $key => $value)
                                            <div class="form-group" id="{{ $value['id'] }}">
                                                <input type="hidden" name="general[{{ $value['params'] }}][field_id]" value="{{ $value['id'] }}" class="form-control"/>
                                                <div class="col-md-2">
                                                    <input type="text" name="general[{{ $value['params'] }}][label]" value="{{ $value['title'] }}" class="form-control"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" name="general[{{ $value['params'] }}][order]" value="{{ $value['order'] }}" class="form-control"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="checkbox" name="general[{{ $value['params'] }}][is_require]" class="allow_permission" data-size="mini"
                                                    @if($value['is_require'] == 1)
                                                            checked
                                                    @endif
                                                        >
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="general[{{ $value['params'] }}][is_search]" class="allow_permission" data-size="mini"
                                                           @if($value['is_search'] == 1)
                                                           checked
                                                            @endif
                                                    >
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="general[{{ $value['params'] }}][show_on_info]" class="allow_permission" data-size="mini"
                                                           @if($value['show_on_info'] == 1)
                                                           checked
                                                            @endif
                                                    >
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="general[{{ $value['params'] }}][show_on_result]" class="allow_permission" data-size="mini"
                                                           @if($value['show_on_result'] == 1)
                                                           checked
                                                            @endif
                                                    >
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="edit_field a_action" href="javascript:void(0)" data-type="general" c-data="{{ $value['id'] }}" title="Sửa field"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    <a class="show_field a_action" href="javascript:void(0)" data-type="general" c-data="{{ $value['id'] }}" title="Xem chi tiết"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                    <a class="remove_field a_action" href="javascript:void(0)" data-type="general" c-data="{{ $value['id'] }}" title="Xóa field" style="color:red"><span class="glyphicon glyphicon-trash"></span></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <p><a href="javascript:void(0)" class="btn btn-default more_field" data-type="general" c-data="general_field"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường thông tin</a></p>
                                <div class="custom_area">

                                </div>
                                <p><a href="javascript:void(0)" class="btn btn-default custom_field" data-type="general" c-data="general_field"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường tùy chọn</a></p>
                            </div>
                        </div>

                    </div>
                    <div class="row form-group" id="target_container">
                        @if(!empty($target->target))
                            @foreach($target->target as $key2 => $value2)
                                <div class="panel panel-primary" >
                                    <div class="panel-body">
                                        <p class="text-on-pannel text-primary"><strong> {{ $value2['name'] }}</strong></p>
                                        <input type="hidden" value="{{ $value2['name'] }}" name="target[{{ $key2 }}][name]">
                                        <div class="target_field" id="{{ $key2 }}">
                                            @if(!empty($value2['field']))
                                                @foreach($value2['field'] as $key3 => $value3)
                                                    <div class="form-group" id="{{ $value3['id'] }}">
                                                        <input type="hidden" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][field_id]" value="{{ $value3['id'] }}"/>

                                                        <div class="col-md-2">
                                                            <input type="text" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][label]" value="{{ $value3['title'] }}" class="form-control"/>
                                                            </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][order]" value="{{ $value3['order'] }}" class="form-control"/>
                                                            </div>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][is_require]" class="allow_permission" data-size="mini"
                                                                   @if($value3['is_require'] == 1)
                                                                   checked
                                                                    @endif
                                                            >
                                                            </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][is_search]" class="allow_permission" data-size="mini"
                                                                   @if($value3['is_search'] == 1)
                                                                   checked
                                                                    @endif
                                                            >
                                                            </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][show_on_info]" class="allow_permission" data-size="mini"
                                                                   @if($value3['show_on_info'] == 1)
                                                                   checked
                                                                    @endif
                                                            >
                                                            </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="target[{{ $key2 }}][field][{{ $value3['params'] }}][show_on_result]" class="allow_permission" data-size="mini"
                                                                   @if($value3['show_on_result'] == 1)
                                                                   checked
                                                                    @endif
                                                            >
                                                            </div>
                                                        <div class="col-md-2">
                                                            <a class="edit_field a_action" href="javascript:void(0)" data-type="target" d-data="{{ $key2 }}" c-data="{{ $value3['id'] }}" title="Sửa field"><span class="glyphicon glyphicon-pencil"></span></a>
                                                            <a class="show_field a_action" href="javascript:void(0)" data-type="target" d-data="{{ $key2 }}" c-data="{{ $value3['id'] }}" title="Xem chi tiết"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                            <a class="remove_field a_action" href="javascript:void(0)" data-type="target" d-data="{{ $key2 }}" c-data="{{ $value3['id'] }}" title="Xóa field" style="color:red"><span class="glyphicon glyphicon-trash"></span></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-default more_field" data-type="target" data-name="{{ $value2['name'] }}" c-data="{{ $key2 }}"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường thông tin</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <input class="form-control target_name" type="text" placeholder="Nhập tên đối tượng">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control target_varible" type="text" placeholder="Nhập tên biến định danh">
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" class="btn btn-default" id="more_target"><span class="glyphicon glyphicon-plus-sign"></span> Thêm đối tượng riêng</a>

                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-update">{{ trans('adtech-core::buttons.update') }}</button>
                            <a href="{!! route('contest.contestmanage.contest_target.update') !!}"
                               class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="modal fade in" id="field_list" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mr-auto">Chọn trường thông tin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <td>Tên trường</td>
                                    <td>Loại html</td>
                                    <td>Loại dữ liệu</td>
                                    <td>Mô tả</td>
                                    <td>Input data</td>
                                    <td>Tùy chọn</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($field_list as $key => $field)
                                    <tr>
                                        <td>{{$field['label']}}</td>
                                        <td>{{$field['type_name']}}</td>
                                        <td>{{$field['type']}}</td>
                                        <td>{{$field['description']}}</td>
                                        <td></td>
                                        <td>
                                            @if($field['is_require'] == 1)
                                                <p>is_require</p>
                                            @endif
                                            @if($field['is_search'] == 1)
                                                <p>is_search</p>
                                            @endif
                                            @if($field['show_on_info'] == 1)
                                                <p>show_on_info</p>
                                            @endif
                                            @if($field['show_on_result'] == 1)
                                                <p>show_on_result</p>
                                            @endif
                                        </td>
                                        <td><a href="javascript:void(0)" c-data="{{ $field['field_id'] }}" class="choose"><span class="glyphicon glyphicon-plus"></span></a> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="field_detail" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mr-auto">Sửa trường thông tin</h4>
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
    <script>
        function loadBSwitch(){
            $("[name='permission_locked']").bootstrapSwitch();
            $('input[type="checkbox"].allow_permission').bootstrapSwitch({
                onSwitchChange:function(event, state) {
                }
            });
        }
        loadBSwitch();
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $(document).on('click', '.remove_config' ,function() {
            $(this).parent().remove();
        });
        var param_array = Array();
        $('body').on('click','.custom_field', function () {
            var data_type = $(this).attr('data-type');
            var parent_type = $(this).attr('c-data');
            if(data_type == 'target'){
                var target_id = $(this).attr('d-data');
                var html = '<div class="col-md-3"><input type="text" class="form-control custom_field_name" placeholder="Nhập tên field" required></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control custom_field_param" placeholder="Nhập tên biến định danh" required></div>' +
                    '<div class="col-md-3"><input type="number" class="form-control custom_field_number" placeholder="Nhập số lượng phần tử" required></div>' +
                    '<div class="col-md-3"><button type="button" class="btn btn-success btn_create_custom_field" data-type="'+ data_type +'" d-data="'+ target_id +'" c-data="'+ parent_type +'">Tạo trường tùy chọn</button>' +
                    '<a href="javascript:void(0)" class="remove_custom_create"><span class="glyphicon glyphicon-remove"></span></a></div>';
            }
            else{
                var html = '<div class="col-md-3"><input type="text" class="form-control custom_field_name" placeholder="Nhập tên field" required></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control custom_field_param" placeholder="Nhập tên biến định danh" required></div>' +
                    '<div class="col-md-3"><input type="number" class="form-control custom_field_number" placeholder="Nhập số lượng phần tử" required></div>' +
                    '<div class="col-md-3"><button type="button" class="btn btn-success btn_create_custom_field" data-type="'+ data_type +'" c-data="'+ parent_type +'">Tạo trường tùy chọn</button>' +
                    '<a href="javascript:void(0)" class="remove_custom_create"><span class="glyphicon glyphicon-remove"></span></a></div>';
            }



           if(data_type == 'target'){
               var div_id = $(this).attr('d-data');
               $('#'+ div_id+' .custom_area').addClass('row');
               $('#'+ div_id+' .custom_area').html(html);
           }
           else{
               $('.custom_area').addClass('row');
               $('.custom_area').html(html);
           }

        });

        $('body').on('click', '#more_config' ,function() {
            var idx = $('#config_list').find('.form-group').length;
            idx++;
            var html =
                '<div class="form-group" id="config-' + idx + '"> ' +
                '<div class="col-md-4">' +
                '{!! Form::text('config[name][]',null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_name'))) !!}' +
                '</div>' +
                '<div class="col-md-3">' +
                '{!! Form::text('config[id][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_id'))) !!}' +
                '</div>' +
                '<div class="col-md-4">' +
                '{!! Form::text('config[value][]', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.config_value'))) !!}' +
                '</div>' +
                '<a href="javascript:void(0)" class="remove_config"><span class="glyphicon glyphicon-remove" style="color: red"></span></a>'+
                '</div>';
            $('#config_list').append(html);
        });

        $('body').on('click', '#more_target', function () {
            var target_name = $('.target_name').val();
            var target_varible = $('.target_varible').val();

            var html = '<div class="panel panel-primary" id="target_'+ target_varible +'">' +
                            '<div class="panel-body">' +
                                '<p class="text-on-pannel text-primary"><strong> '+ target_name +' </strong></p>' +
                                '<input type="hidden" value="'+ target_name +'" name="target['+ target_varible +'][name]">' +
                                '<div class="target_field" id="' + target_varible + '">' +
                                '<div class="custom_area"></div> ' +
                                '</div>' +
                                '<a href="javascript:void(0)" class="btn btn-default more_field" data-type="target" data-name="'+ target_name +'" c-data="' + target_varible + '"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường thông tin</a>' +
                            '<div class="custom_area"> </div>' +
                                '<p><a href="javascript:void(0)" class="btn btn-default custom_field" data-type="target" c-data="target_'+ target_varible +'" d-data="' + target_varible + '"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường tùy chọn</a></p>' +
                            '</div>' +
                        '</div>';
            $('#target_container').append(html);
        });

        $('body').on('click', '.btn_create_custom_field', function () {
            var name = $(this).parent().parent().find('.custom_field_name').val();
            var param = $(this).parent().parent().find('.custom_field_param').val();
            var number = $(this).parent().parent().find('.custom_field_number').val();
            var data_type = $(this).attr('data-type');
            if(name != '' && param != '' && number != ''){
                if(parseInt(number) < 2){
                    alert('Số phần tử phải lớn hơn 1');
                }
                else{
                    console.log(param);
                    console.log(param_array);
                    console.log(param_array.indexOf(param));
                    if(param_array.indexOf(param) == -1) {
                        param_array.push(param);
                        if(data_type == 'general'){
                            var html = '<div class="panel panel-primary panel_custom" id="'+ param +'_panel">' +
                                '<div class="panel-body">' +
                                '<p class="text-on-pannel text-primary"><strong> ' + name + ' </strong> <a href="javascript:void(0)" c-data="' + param + '_panel" class="remove_custom pull-right"><span class="glyphicon glyphicon-remove"></span></a></p>' +
                                '<input type="hidden" value="' + name + '" name="general[' + param + '][title]">' +
                                '<input type="hidden" value="' + param + '" name="general[' + param + '][params]">' +
                                '<input type="hidden" value="auto" name="general[' + param + '][type]">' +
                                '<input type="hidden" value="1" name="general[' + param + '][type_id]">' +
                                '<input type="hidden" value="string" name="general[' + param + '][data_type]">' +
                                '<input type="hidden" value="4" name="general[' + param + '][type_view]">' +
                                '<div id="' + param + '_container">';

                            for (var i = 1; i <= parseInt(number); i++) {
                                html += '<div class="panel panel-primary" id="' + param + '_' + i + '" >' +
                                    '<div class="panel-body">' +
                                    '<div class="text-on-pannel text-primary">' +
                                    '<div class="pull-left">' +
                                    '<input type="hidden" name="general[' + param + '][data_view][' + param + '_' + i + '][params]" value="' + param + '_' + i + '" > ' +
                                    '<input type="text" class="form-control col-md-3" name="general[' + param + '][data_view][' + param + '_' + i + '][title]" placeholder="Nhập tên hiển thị"> ' +
                                    '</div>' +
                                    '<a href="javascript:void(0)" c-data="' + param + '_' + i + '" class="remove_custom_group pull-right">' +
                                    '<span class="glyphicon glyphicon-remove"></span></a></div>' +
                                    '<div class="field_container">' +
                                    '</div> ' +
                                    '<a href="javascript:void(0)" class="btn btn-default more_field" data-type="custom" parent-param="'+ param +'" parent-type="general" data-name="' + name + '" c-data="' + param + '_' + i + '"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường thông tin</a>' +
                                    '</div></div>';
                            }

                            html += '</div>' +
                                '</div>' +
                                '</div>';
                            $('#general_field').append(html);
                        }
                        else{
                            var div_id = $(this).attr('c-data');
                            var con_id = $(this).attr('d-data');
                             var html = '<div class="panel panel-primary panel_custom" id="'+ param +'_panel">' +
                                '<div class="panel-body">' +
                                '<p class="text-on-pannel text-primary"><strong> ' + name + ' </strong> <a href="javascript:void(0)" c-data="' + param + '_panel" class="remove_custom pull-right"><span class="glyphicon glyphicon-remove"></span></a></p>' +
                                '<input type="hidden" value="' + name + '" name="target[' + param + '][title]">' +
                                '<input type="hidden" value="' + param + '" name="target[' + param + '][params]">' +
                                '<input type="hidden" value="auto" name="target[' + param + '][type]">' +
                                '<input type="hidden" value="1" name="target[' + param + '][type_id]">' +
                                '<input type="hidden" value="string" name="target[' + param + '][data_type]">' +
                                '<input type="hidden" value="4" name="target[' + param + '][type_view]">' +
                                '<div id="' + param + '_container">';

                            for (var i = 1; i <= parseInt(number); i++) {
                                html += '<div class="panel panel-primary" id="' + param + '_' + i + '" >' +
                                    '<div class="panel-body">' +
                                    '<div class="text-on-pannel text-primary">' +
                                    '<div class="pull-left">' +
                                    '<input type="hidden" name="target[' + param + '][data_view][' + param + '_' + i + '][params]" value="' + param + '_' + i + '" > ' +
                                    '<input type="text" class="form-control col-md-3" name="target[' + param + '][data_view][' + param + '_' + i + '][title]" placeholder="Nhập tên hiển thị"> ' +
                                    '</div>' +
                                    '<a href="javascript:void(0)" c-data="' + param + '_' + i + '" class="remove_custom_group pull-right">' +
                                    '<span class="glyphicon glyphicon-remove"></span></a></div>' +
                                    '<div class="field_container">' +
                                    '</div> ' +
                                    '<a href="javascript:void(0)" class="btn btn-default more_field" data-type="custom" target-param="'+ con_id +'" parent-param="'+ param +'" parent-type="target" data-name="' + name + '" c-data="' + param + '_' + i + '"><span class="glyphicon glyphicon-plus-sign"></span> Thêm trường thông tin</a>' +
                                    '</div></div>';
                            }

                            html += '</div>' +
                                '</div>' +
                                '</div>';
                            $('#' + div_id).find('#' + con_id).append(html);
                        }

                    }
                    else{
                        alert('Tên biến đã tồn tại!');
                    }
                }
            }
            else{
                alert('Vui lòng điền đủ thông tin!');
            }
        });

        $('body').on('click', '.more_field', function () {
            var varible = $(this).attr('c-data');
            var type = $(this).attr('data-type');
            if(type == 'target'){
                var name = $(this).attr('data-name');
                $('#field_list').attr('data-name', name);
            }
            else if(type == "custom"){
                var parent_type = $(this).attr('parent-type');
                var parent_param = $(this).attr('parent-param');
                $('#field_list').attr('parent-type', parent_type);
                $('#field_list').attr('parent-param', parent_param);
            }
            $('#field_list').attr('c-data', varible);
            $('#field_list').attr('data-type', type);
            $('#field_list').modal();
        });

        $('body').on('click', '.choose', function () {
            var id = $('#field_list').attr('c-data');
            var field_id = $(this).attr('c-data');
            var idx = $('#' + id).find('.form-group').length;
            var type = $('#field_list').attr('data-type');
            var varible = '';
            var parent_type = '';
            var parent_param = '';
            if(type == 'target'){
                varible = id;
            }
            else if(type == "custom"){
                varible = id;
                parent_type = $('#field_list').attr('parent-type');
                parent_param = $('#field_list').attr('parent-param');
            }
            var html  = genInputField(field_id, idx, type, varible, parent_type, parent_param);


            $('#target_thead').removeClass('hidden');
            if(type =='custom'){
                $('#' +id).find('.field_container').append(html);
            }
            else{
                $('#' +id).append(html);
            }
            loadBSwitch();
            $('#field_list').modal('hide');
        });
        function genInputField(field_id, idx, type, varible, parent_type, parent_param) {
            var field_list = @json($field_list);
            var field_data = field_list[field_id];
            var is_require, is_search, show_on_info, show_on_result = '';
            var html = '';

            if(field_data.is_require == 1){
                is_require = 'checked';
            }
            if(field_data.is_search == 1){
                is_search = 'checked';
            }
            if(field_data.show_on_info == 1){
                show_on_info = 'checked';
            }
            if(field_data.show_on_result == 1){
                show_on_result = 'checked';
            }
            if(type == 'general'){
                html = '<div class="form-group" id="'+ field_data.field_id +'">' +
                    '<div class="col-md-2">' +
                    '<input type="hidden" name="'+ type +'['+ field_data.varible +'][field_id]"  value="'+ field_data.field_id +'"/>' +
                    '<input type="text" name="'+ type +'['+ field_data.varible +'][label]" value="'+ field_data.label +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="text" name="'+ type +'['+ field_data.varible +'][order]" value="'+ (idx + 1) +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="checkbox" name="'+ type +'['+ field_data.varible +'][is_require]" class="allow_permission" data-size="mini" '+ is_require +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ field_data.varible +'][is_search]" class="allow_permission" data-size="mini" '+ is_search +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ field_data.varible +'][show_on_info]" class="allow_permission" data-size="mini" '+ show_on_info +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ field_data.varible +'][show_on_result]" class="allow_permission" data-size="mini" '+ show_on_result +'>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    // '<a class="edit_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Sửa field"><span class="glyphicon glyphicon-pencil"></span></a>' +
                    '<a class="show_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xem chi tiết"><span class="glyphicon glyphicon-eye-open"></span></a>' +
                    '<a class="remove_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xóa field" style="color:red"><span class="glyphicon glyphicon-trash"></span></a>' +
                    '</div>' +
                    '</div>';
            }
            else if(type == 'custom'){
                html = '<div class="form-group" id="'+ field_data.field_id +'">' +
                    '<div class="col-md-2">' +
                    '<input type="hidden" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][field_id]"  value="'+ field_data.field_id +'"/>' +
                    '<input type="text" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][label]" value="'+ field_data.label +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="text" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][order]" value="'+ (idx + 1) +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="checkbox" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][is_require]" class="allow_permission" data-size="mini" '+ is_require +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][is_search]" class="allow_permission" data-size="mini" '+ is_search +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][show_on_info]" class="allow_permission" data-size="mini" '+ show_on_info +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ parent_type +'['+parent_param+'][data_view]['+ varible +'][data_view]['+ field_data.varible +'][show_on_result]" class="allow_permission" data-size="mini" '+ show_on_result +'>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    // '<a class="edit_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Sửa field"><span class="glyphicon glyphicon-pencil"></span></a>' +
                    '<a class="show_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xem chi tiết"><span class="glyphicon glyphicon-eye-open"></span></a>' +
                    '<a class="remove_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xóa field" style="color:red"><span class="glyphicon glyphicon-trash"></span></a>' +
                    '</div>' +
                    '</div>';
            }
            else if(type == 'target'){
                html = '<div class="form-group" id="'+ field_data.field_id +'">' +
                    '<div class="col-md-2">' +
                     '<input type="hidden" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][field_id]"  value="'+ field_data.field_id +'"/>' +
                    '<input type="text" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][label]" value="'+ field_data.label +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="text" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][order]" value="'+ (idx + 1) +'" class="form-control"/>' +
                    '</div>'+
                    '<div class="col-md-1">' +
                    '<input type="checkbox" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][is_require]" class="allow_permission" data-size="mini" '+ is_require +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][is_search]" class="allow_permission" data-size="mini" '+ is_search +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][show_on_info]" class="allow_permission" data-size="mini" '+ show_on_info +'>' +
                    '</div>'+
                    '<div class="col-md-2">' +
                    '<input type="checkbox" name="'+ type +'['+ varible +'][field]['+ field_data.varible +'][show_on_result]" class="allow_permission" data-size="mini" '+ show_on_result +'>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    // '<a class="edit_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Sửa field"><span class="glyphicon glyphicon-pencil"></span></a>' +
                    '<a class="show_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xem chi tiết"><span class="glyphicon glyphicon-eye-open"></span></a>' +
                    '<a class="remove_field a_action" href="javascript:void(0)" c-data="'+ field_data.field_id +'" title="Xóa field" style="color:red"><span class="glyphicon glyphicon-trash"></span></a>' +
                    '</div>' +
                    '</div>';
            }

            return html;
        }

        $('body').on('click', '.remove_field', function () {
           var id = $(this).attr('c-data');
           $('#' + id).remove();
        });
        
        $('body').on('click', '.edit_field', function () {
            var target_type = $(this).attr('data-type');
            var key = $(this).attr('d-data');
            var id = $(this).attr('c-data');
            var target = @json($target);
            if(target[target_type]){
               var fields = target[target_type];
                 var route = '{{ route('contest.contestmanage.contest_target.field_detail') }}';
                 $.post(route, {target_type: target_type, id: id,key:key}, function (res) {
                     if(res){
                         $('#field_detail .modal-body').html('');
                         $('#field_detail .modal-body').html(res);
                         $('#field_detail').modal();
                     }
                 });
               }
        });
        $('body').on('change','.type_id', function () {
            $('.type_name').val($('option:selected', this).text());
            $('#type').html('');
            $('#data_view').html('');
            var type_id = $('option:selected', this).val();
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
                    '</div>');
            }
        });

        $('body').on('click', '#more_data', function () {
            $('#data_list').append(genDataInput());
        });
        $('body').on('click', '.remove', function () {
            $(this).parent().parent().remove();
        });

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
        $('body').on('click','.remove_custom', function () {
            var div_id = $(this).attr('c-data');
            var param = $(this).attr('d-data');
            param_array.splice(param_array.indexOf(param),1);
            $('#' + div_id).remove();
        });
        $('body').on('click','.remove_custom_create', function () {
            $('#custom_area').html('');
            $('#custom_area').removeClass('row');
        });
        $('body').on('click','.remove_custom_group', function () {
           var div_id = $(this).attr('c-data');
           $('#' + div_id).remove();
        });
    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.search_account.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/sortable_list.css')}}" rel="stylesheet">
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
                {!! Form::open(array('url' => route('contest.contestmanage.search_account.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'clientForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tên đăng nhập (*)</label>
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                {!! Form::text('email', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.u_name'))) !!}
                                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                            </div>
                            <label>Mật khẩu (*)</label>
                            <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                {!! Form::text('password',null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.password'))) !!}
                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            </div>
                            <label>Cấp tra cứu (*)</label>
                            <div class="form-group {{ $errors->first('type', 'has-error') }}">
                                {!! Form::select('type',$type,0, array('class' => 'form-control', 'id' => 'type', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.type'))) !!}
                                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                            </div>
                            <div class="form-group" id="province_container"></div>
                            <div class="form-group" id="district_container"></div>
                        </div>
                        <div class="col-md-6">
                            <label>Tên người đại diện (*)</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.name'))) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                            <label>Đơn vị</label>
                            <div class="form-group {{ $errors->first('unit', 'has-error') }}">
                                {!! Form::text('unit', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.unit'))) !!}
                                <span class="help-block">{{ $errors->first('unit', ':message') }}</span>
                            </div>
                            <label>Thông tin liên hệ</label>
                            <div class="form-group {{ $errors->first('contact', 'has-error') }}">
                                {!! Form::text('contact', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.contact'))) !!}
                                <span class="help-block">{{ $errors->first('contact', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <p class="text-on-pannel text-primary"><strong> Phân quyền tra cứu </strong></p>
                                <div id="role_list">
                                    <div class="col-md-6">
                                        <label id="role_label"></label>
                                        <div id="filter">
                                            <div class="block__list block__list_words">
                                                <ul id="editable" class="list-unstyled">

                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-md-8" id="role_select">
                                                {{--{!! Form::select('province_list',$province_list,0, array('class' => 'form-control', 'id' =>'province_list', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.province'))) !!}--}}
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary" id="btn_add_province">Thêm vào danh sách</button>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                {{--<a href="javascript:void(0)" class="btn btn-default" id="more_config"><span class="glyphicon glyphicon-plus-sign"></span> Thêm biến</a>--}}
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                            <a href="{!! route('contest.contestmanage.search_account.manage') !!}"
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
    {{--<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/sortablejs/js/Sortable.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
    <!--end of page js-->
    <script>
        $(document).ready(function () {
            // validate signup form on keyup and submit

        });

        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('body').on('click','.js-remove', function () {
            $(this).parent().remove();
        })
        
        $('body').on('click','#btn_add_province', function () {
            var selected_type = $(this).attr('c-data');
            if(selected_type == 'province'){
                var province_id = $('#province_id option:selected').val();
                var province_name = $('#province_id option:selected').text();
                var choosed = $('input[name="list_province_id[]"]');
                var check = false;
                $.each(choosed, function (key, item) {
                    if(item.value == province_id){
                        check = true;
                    }
                });
                if(check == false){
                    if(province_id != '' && province_id != 0 && province_id != undefined){
                        $('.block__list .list-unstyled').append('<li>'+ province_name +'<i class="js-remove">✖</i><input type="hidden" name="list_province_id[]" value="' + province_id + '"><input type="hidden" name="list_province_name[]" value="' + province_name + '"></li>');
                    }
                    else{
                        alert('Vui lòng chọn tỉnh');
                    }
                }
                else{
                    alert('Đã chọn tỉnh/tp này');
                }
            }
            else if(selected_type == 'district'){
                var district_id = $('#district_id option:selected').val();
                var district_name = $('#district_id option:selected').text();
                var choosed = $('input[name="list_district_id[]"]');
                var check = false;
                $.each(choosed, function (key, item) {
                    if(item.value == district_id){
                        check = true;
                    }
                });
                if(check == false){
                    if(district_id != '' && district_id != 0 && district_id != undefined){
                        $('.block__list .list-unstyled').append('<li>'+ district_name +'<i class="js-remove">✖</i><input type="hidden" name="list_district_id[]" value="' + district_id + '"><input type="hidden" name="list_district_name[]" value="' + district_name + '"></li>');
                    }
                    else{
                        alert('Vui lòng chọn quận/ huyện');
                    }
                }
                else{
                    alert('Đã chọn quận/ huyện này');
                }
            }
            else if(selected_type == 'school'){
                var school_id = $('#school_id option:selected').val();
                var school_name = $('#school_id option:selected').text();
                var choosed = $('input[name="list_school_id[]"]');
                var check = false;
                $.each(choosed, function (key, item) {
                    if(item.value == school_id){
                        check = true;
                    }
                });
                if(check == false){
                    if(school_id != '' && school_id != 0  && school_id != undefined){
                        $('.block__list .list-unstyled').append('<li>'+ school_name +'<i class="js-remove">✖</i><input type="hidden" name="list_school_id[]" value="' + school_id + '"><input type="hidden" name="list_school_name[]" value="' + school_name + '"></li>');
                    }
                    else{
                        alert('Vui lòng chọn trường');
                    }
                }
                else{
                    alert('Đã chọn trường này');
                }
            }

        });

        $('body').on('change','#type', function () {
            $('.block__list .list-unstyled').html('');
            $('#province_container').html('');
            $('#district_container').html('');
            $('#role_label').text('');
            $('#role_select').html('');
            var selected_type = $('option:selected', this).val();
            if(selected_type == 'district'){
                genProvinceInput();
            }
            else if(selected_type == 'school'){
                genProvinceInput();
                genDistrictInput();
            }
            else if(selected_type == 'province'){
                $('#province_container').html();

                var html = '{!! Form::select('province_id',$province_list,0, array('class' => 'form-control', 'id' =>'province_id', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.province'))) !!}';

                $('#role_label').text('');
                $('#role_label').text('Danh sách Tỉnh/ Tp được cấp quyền');
                $('#role_select').html('');
                $('#role_select').html(html);
            }
            $('#btn_add_province').attr('c-data',selected_type);
        });

        $('body').on('change','#province_id', function () {
            var selected_type = $('#type option:selected').val();
            if(selected_type == 'district' || selected_type == 'school') {
                $('#province_name').val($('option:selected', this).text());
                $('#district_id').html('');
                $('#school_id').html('');
                $('#district_id').append('<option value="">Chọn quận/ huyện</option>');
                var province_id = $('option:selected', this).val();
                if (province_id != 0 && province_id != '') {
                    var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistrictbyprovince?api_type=array&province_id=' + province_id;
                    $.get(url, function (res) {
                        if (res.data) {
                            $.each(res.data, function (key, value) {
                                $('#district_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                            });
                        }
                    });
                }
            }
        });

        $('body').on('change','#district_id', function () {
            var selected_type = $('#type option:selected').val();
            if(selected_type == 'school') {
                $('#school_id').html('');
                $('#district_name').val($('option:selected', this).text());
                // $('#school_id').append('<option value="">Tất cả trường</option>');
                var district_id = $('option:selected', this).val();
                if (district_id != 0 && district_id != '') {
                    var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschoolbydistrict?api_type=array&district_id=' + district_id;
                    $.get(url, function (res) {
                        if (res.data) {
                            $.each(res.data, function (key, value) {
                                $('#school_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                            })
                        }
                    });
                }
            }
        });

        function genProvinceInput() {
            var html = '<label>Chọn tỉnh/ TP (*)</label>' +
                '<div class="form-group">' +
                '{!! Form::select('province_id',$province_list,0, array('class' => 'form-control', 'id' =>'province_id', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.search_account.province'))) !!}' +
                '<input type="hidden" name="province_name" id="province_name">' +
                '</div>';
            $('#province_container').html(html);
            $('#role_label').text('Danh sách Quận/ huyện được cấp quyền');
            $('#role_select').html('<select name="district_id" id="district_id" class="form-control"><option value="">Chọn quận/ huyện</option></select>');
        }

        function genDistrictInput() {
            var html = '<label>Chọn quận/ huyện (*)</label><div class="form-group"><select name="district_id" id="district_id" class="form-control"></select><input type="hidden" name="district_name" id="district_name"></div>';
            $('#district_container').html(html);
            $('#role_label').text('Danh sách trường được cấp quyền');
            $('#role_select').html('<select name="school_id" id="school_id" class="form-control"><option value="">Chọn trường</option></select>');
        }
    </script>
@stop

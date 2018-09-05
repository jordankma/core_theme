@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-seat::language.namepro') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <!--end of page css-->
    <style type="text/css">
        .ui-widget-content
        {
            line-height: 30px;
        }
        .ui-widget-content .ui-state-focus
        {
            line-height: 30px;
            background: #EAEAEA;
            /*border: 1px solid #525763;*/
        }
        label {
            color: #000000 !important;
        }
        #myTable td {
            padding: 3px 5px;
        }
        .staff{
            display: inline !important;
            float:left;
        }
        .fa-trash{
            cursor:pointer! important;
            font-size: 20px;
        }
        .inline{
            padding-left: 2px! important;
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
                {!! Form::open(array('url' => route('dhcd.seat.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'seatForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Tên Đoàn (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('doan_id', 'has-error') }}">
                            <select class="form-control select2" id="doan_id" name="doan_id" required >
                            @if(!empty($doan))
                                @foreach($doan as $val)
                                    <option value="{{ $val['group_id'] }}" >{{ $val['name'] }}</option>
                                @endforeach
                            @endif
                            </select>
                            <span class="help-block">{{ $errors->first('doan_id', ':message') }}</span>
                        </div>

                        <label>Phiên làm việc (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('sessionseat_id', 'has-error') }}">
                            <select class="form-control select2" id="sessionseat_id" name="sessionseat_id" required >
                                @if(!empty($sessionseat))
                                    @foreach($sessionseat as $val)
                                        <option value="{{ $val['sessionseat_id'] }}" >{{ $val['sessionseat_name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('sessionseat_id', ':message') }}</span>
                        </div>

                        <label>Chỗ Ngồi (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('seat', 'has-error') }}">
                            {!! Form::text('seat', null, array('class' => 'form-control','placeholder'=> trans('dhcd-seat::language.placeholder.seat.name_here'),'required')) !!}
                            <span class="help-block">{{ $errors->first('seat', ':message') }}</span>
                        </div>
                        <label>Ghi chú :</label>
                        <div class="form-group {{ $errors->first('note', 'has-error') }}">
                            {!! Form::textarea('note', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-6">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <div class="col-md-12" style="padding-right: 0px">
                                    <span class="scheduler-border">
                                        Nhân Viên Phục Vụ (<span class="red">*</span>):
                                        <button type="button" class="btn btn-success pull-right addstaff">{{ trans('dhcd-seat::language.buttons.create') }}</button>
                                    </span>
                                </div>
                            </legend>
                            <div class="row" id="tablestaff">
                                <div class="form-group staff" id="staff0"></div>
                            </div>
                        </fieldset>
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-md-offset-2">
                        <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                        <a href="{{ route('dhcd.seat.create') }}"
                           class="btn btn-danger">{{ trans('dhcd-seat::language.buttons.discard') }}</a>
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
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/js/pages/add_package.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ config('site.url_static') .('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
    <script>
        $(function () {
            $(".select2").select2({
                theme:"bootstrap"
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.addstaff').on('click',function(){
                var count = $(".staff:last").attr("id");
                var eid = parseInt(count.slice(5,count.length));
                var arr = "<div class='form-group staff' id='staff"+ (++eid) +"'>" +
                    "<div class='form-group col-md-3 inline'>" +
                    "<label class='label'> Tên :</label>" +
                    "<input type='text' autocomplete='off'  class='form-control staffname' name='staffname[]'  required >" +
                    "</div>" +
                    "<div class='form-group col-md-3 inline'>" +
                    "<label class='label'> Chức Vụ :</label>"+
                    "<input type='text' autocomplete='off'  class='form-control staffpos' name='staffpos[]' >"+
                    "</div>" +
                    "<div class='form-group col-md-4 inline'>" +
                    "<label class='label'> Số Điện Thoại :</label>" +
                    "<input type='text' autocomplete='off' class='form-control phone'  name='phone[]' >"+
                    "</div>" +
                    "<div class='form-group col-md-2 inline' style='padding: 25px 0px 0px 10px'><a style='cursor:pointer' class='trash'><i class='fa fa-trash' ></i></a></div>" +
                    "</div>"
                var $name = $('.staff:last').find('input[name="staffname[]"]');
                if($name.length!=0 ) {
                    var idx=0;
                    $.each($name,function (i, item) {
                        if($name.val()==''){
                            idx=1;
                        }
                    });
                    if(idx!=1){
                        $('.staff:last').after(arr);
                    }
                }
                else{
                    $('#tablestaff').append(arr);
                }
            });
            $('body').on('click','.trash',function () {
                var id= $(this).parent().parent().attr('id');
                console.log(id);
                $('#'+id).remove();
            });
        });
    </script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
        })
    </script>

@stop

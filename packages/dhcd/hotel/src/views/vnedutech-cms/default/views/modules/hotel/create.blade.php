@extends('layouts.default')
@section('title'){{ $title = trans('dhcd-hotel::language.namepro') }}@stop
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
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
        .modal-body{
            overflow: hidden!important;
        }
        fieldset {
            display: block;
            -webkit-margin-start: 2px;
            -webkit-margin-end: 2px;
            -webkit-padding-before: 0.35em;
            -webkit-padding-start: 0.75em;
            -webkit-padding-end: 0.75em;
            -webkit-padding-after: 0.625em;
            min-width: -webkit-min-content;
            border-width: 0.5px;
            border-style: groove;
            border-color: #ededed;
            border-image: initial;
            border-radius: 5px;
        }
    </style>
@stop
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
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="the-box no-border">
                {!! Form::open(array('url' => route('dhcd.hotel.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'hotelForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Tên Đoàn</label>
                        <div class="form-group {{ $errors->first('doan', 'has-error') }}" id="boxDoan">
                            <select class="form-control" id="doan_id" name="doan_id[]" multiple="multiple">
                                @if(!empty($doan))
                                    @foreach($doan as $val)
                                        <option value="{{ $val['group_id'] }}" >{{ $val['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('doan', ':message') }}</span>
                        </div>

                        <label>Khách sạn (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('hotel', 'has-error') }}">
                            {!! Form::text('hotel', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-hotel::language.placeholder.hotel.name_here'),'required')) !!}
                            <span class="help-block">{{ $errors->first('hotel', ':message') }}</span>
                        </div>

                        <label>Địa chỉ (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('address', 'has-error') }}">
                            {!! Form::text('address', null, array('class' => 'form-control','placeholder'=> trans('dhcd-hotel::language.placeholder.hotel.address'),'required')) !!}
                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                        </div>

                        <label>Hình ảnh khách sạn :</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="img" value="{{old('img')}}">
                        </div>
                        <img id="holder" src="{{old('img')}}" style="margin-top:15px;max-height:100px;">
                        <br>

                        <label>Ghi chú :</label>
                        <div class="form-group {{ $errors->first('note', 'has-error') }}">
                            {!! Form::textarea('note', null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="row">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <div class="col-md-12" style="padding-right: 0px">
                                <span class="scheduler-border">
                                    <label><h4>Nhân Viên Phục Vụ (<span class="red">*</span>):</h4></label>
                                    <button type="button" class="btn btn-success pull-right addstaff">{{ trans('dhcd-hotel::language.buttons.create') }}</button>
                                </span>
                                </div>
                            </legend>
                            <div class="row" id="tablestaff">
                                <div class="form-group staff" id="staff0"></div>
                            </div>
                        </fieldset>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-md-offset-2">
                        <button type="submit" class="btn btn-success">{{ trans('dhcd-hotel::language.buttons.create') }}</button>
                        <a href="{!! route('dhcd.hotel.create') !!}"
                           class="btn btn-danger">{{ trans('dhcd-hotel::language.buttons.discard') }}</a>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Danh sách đoàn đại biểu</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success btndoan" data-dismiss="modal">Chọn</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" language="javascript" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
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
                    "</div>";
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

        $(function () {
            $('#lfm').filemanager('image');

            $("#doan_id").multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                buttonWidth: '100%',
                numberDisplayed: 100,
                maxHeight: 800,
                dropDown: true
            });
        });
    </script>

@stop

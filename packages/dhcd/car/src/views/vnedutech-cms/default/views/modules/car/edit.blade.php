@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-car::language.namepro') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css"/>
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
    <!--end of page css-->
@stop
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
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
                {!! Form::model($staff, ['url' => route('dhcd.car.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="row">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Tên Đoàn (<span class="red">*</span>):</label>
                            <div class="form-group {{ $errors->first('doan', 'has-error') }}" id="boxDoan">
                                <select class="form-control" id="doan_id" name="doan_id[]" multiple="multiple" required>
                                    @if(!empty($doan))
                                        @foreach($doan as $val)
                                            <option value="{{ $val['group_id'] }}" {{ in_array($val['group_id'], $doan_id) ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="help-block">{{ $errors->first('doan', ':message') }}</span>
                            </div>

                            <label>Số xe (<span class="red">*</span>):</label>
                            <div class="form-group {{ $errors->first('car_num', 'has-error') }}">
                                {!! Form::text('car_num', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-car::language.placeholder.car.car_num'),'required')) !!}
                                <span class="help-block">{{ $errors->first('car_num', ':message') }}</span>
                            </div>

                            <label>Biển số  (<span class="red">*</span>):</label>
                            <div class="form-group {{ $errors->first('car_bs', 'has-error') }}">
                                {!! Form::text('car_bs', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-car::language.placeholder.car.car_id'))) !!}
                                <span class="help-block">{{ $errors->first('car_bs', ':message') }}</span>
                            </div>

                            <label>Hình ảnh xe :</label>
                            <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                                <input id="thumbnail" class="form-control" type="text" name="img" value="{{$staff->img}}">
                            </div>
                            <img id="holder" src="{{config('site.url_storage') . ($staff->img)}}" style="margin-top:15px;max-height:100px;">
                            <br>
                            <label>Lộ trình</label>
                            <div class="form-group {{ $errors->first('note', 'has-error') }}">
                                {!! Form::textarea('note', null, array('class' => 'form-control', 'autofocus'=>'autofocus')) !!}
                                <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                            </div>
                        </div>
                        <!-- /.col-sm-8 -->
                        <div class="col-sm-6">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">
                                    <div class="col-md-12" style="padding-right: 0px">
                                    <span class="scheduler-border">
                                        Nhân Viên Phục Vụ:
                                        <button type="button" class="btn btn-success pull-right addstaff">{{ trans('dhcd-car::language.buttons.create') }}</button>
                                    </span>
                                    </div>
                                </legend>
                                <div class="row" id="tablestaff">
                                    @foreach($dataAction as $key=>$val)
                                        <div class="form-group staff" id="staff{{$key}}">
                                            <div class="form-group col-md-3 inline">
                                                <label class="label"> Tên :</label>
                                                <input type="text" autocomplete="off" class="form-control  staffname" name="staffname[]" value="{{$val['staffname']}}">
                                            </div>
                                            <div class="form-group col-md-3 inline">
                                                <label class="label"> Chức Vụ  :</label>
                                                <input type="text" autocomplete="off" class="form-control  staffpos" name="staffpos[]"  value="{{$val['staffpos']}}">
                                            </div>
                                            <div class="form-group col-md-4 inline">
                                                <label class="label"> Số Điện Thoại :</label>
                                                <input type="text" autocomplete="off" class="form-control phone"  name="phone[]" value="{{$val['phone']}}">
                                            </div>
                                            <div class="form-group col-md-2 inline" style="padding: 25px 0px 0px 10px"><a style='cursor:pointer' class="trash"><i class='fa fa-trash' ></i></a></div>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        <!-- /.col-sm-4 -->
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('dhcd.car.create') !!}"
                               class="btn btn-danger">{{ trans('dhcd-seat::language.buttons.discard') }}</a>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('car_id') !!}
                    </div>
                    <!-- /.col-sm-8 -->
                </div>
                <!-- /.row -->
               
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
             {!! Form::close() !!}
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" language="javascript" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" ></script>

    <script>
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

        $(document).ready(function () {
            $('.addstaff').on('click',function(){
                var count = $(".staff:last").attr("id");
                var eid = parseInt(count.slice(5,count.length));
                var arr = "<div class='form-group staff' id='staff"+ (++eid) +"'>" +
                    "<div class='form-group col-md-3 inline'>" +
                    "<label class='label'> Tên :</label>" +
                    "<input type='text' autocomplete='off'  class='form-control staffname' name='staffname[]'>" +
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
                $('#'+id).remove();
            });
        });
    </script>
@stop

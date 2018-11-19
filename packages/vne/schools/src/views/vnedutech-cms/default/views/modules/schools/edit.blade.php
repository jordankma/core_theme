@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-schools::language.titles.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}"
          rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/all.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .control-label {
            font-family: "Times New Roman", Times, serif;
            padding-top: 6px;
            padding-right: 0px;
            text-align: left !important;
        }

        .memname {
            padding: 5px !important;
        }

        .fa-times-circle {
            color: red;
            font-size: 18px;
            padding-top: 5px;
        }

        .fa-trash {
            font-size: 18px;
            padding-top: 8px;
        }

        .deletelevel {
            padding-top: 3px !important;
            font-size: 22px;
        }

        #units {
            text-align: center;
        }

        .tablepclass {
            border-style: groove;
            border-radius: 0px 0px 5px 5px;
            text-align: center;
        }

        .addpclass {
            padding: 5px !important;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .unitlabel {
            border-radius: 5px 5px 0px 0px;
            background-color: #F89A14;
            color: #fff;
            text-align: center;
            font-family: Noto Sans, serif !important;
            padding-top: 10px;
            padding-bottom: 5px;
            font-weight: bold;
        }

        .hr {
            margin: 5px !important;
        }

        #tablepit {
            padding: 10px !important;
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
                {!! Form::model($schools,['url' => route('vne.schools.update'), 'method' => 'put', 'class' => 'bf form-horizontal', '_id' => 'schools']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schoolprovince">{!! trans('vne-schools::language.label.province') !!}(<span
                                            style="color: red">*</span>)
                                    :</label>
                                <div class="col-md-9 {{ $errors->first('province_id', 'has-error') }}">
                                    <select class="form-control select2" id="province_id" name="province_id">
                                        @if(isset($province))
                                            <option value="{{$schools->schoolprovince}}">{{$province->province}}</option>
                                        @else
                                            <option value="">Chọn tỉnh thành</option>
                                        @endif
                                        @if(isset($provinces))
                                            @foreach($provinces as $province)
                                                <option value="{{$province->_id}}">{{$province->province}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span class="help-block">{{ $errors->first('province', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="district_id">{!! trans('vne-schools::language.label.district') !!}(<span
                                            style="color: red">*</span>):</label>
                                <div class="col-md-9 {{ $errors->first('district_id', 'has-error') }}">
                                    <select class="form-control select2" id="district_id" name="district_id">
                                        @if(isset($province))
                                            @if(isset($district))
                                                <option value="{{$district->_id}}">{{$district->district}}</option>
                                                @foreach($districtof as $district)
                                                    <option value="{{$district->_id}}">{{$district->district}}</option>
                                                @endforeach
                                            @else
                                                <option value="">Chọn quận huyện</option>
                                                @foreach($districtof as $district)
                                                    <option value="{{$district->_id}}">{{$district->district}}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                                <span class="help-block">{{ $errors->first('province', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schoolname">{!! trans('vne-schools::language.label.name') !!}(<span
                                            style="color: red">*</span>):</label>
                                <div class="col-md-9 col-lg-9 col-12 ">
                                    <input id="schoolname" name="schoolname" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.name') }}"
                                           class="form-control" value="{{$schools->schoolname}}" required>
                                    <span class="help-block">{{ $errors->first('schoolname', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schoollevel">{!! trans('vne-schools::language.label.level') !!}(<span
                                            style="color: red">*</span>):</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <select class="form-control {{ $errors->first('province_id', 'has-error') }}"
                                            id="level_id" name="level_id">
                                        <option value="{{$schools->schoollevel}}">
                                            @if($schools->schoollevel==1)
                                                Tiểu học
                                            @endif
                                            @if($schools->schoollevel==2)
                                                Trung Học Cơ Sở
                                            @endif
                                            @if($schools->schoollevel==3)
                                                Trung Học Phổ Thông
                                            @endif
                                            @if($schools->schoollevel==4)
                                                Đại Học ,Cao Đẳng
                                            @endif
                                        </option>
                                        <option value="1">Tiểu Học</option>
                                        <option value="2">Trung Học Cơ Sở</option>
                                        <option value="3">Trung Học Phổ Thông</option>
                                        <option value="4">Đại Học ,Cao Đẳng</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('province', ':message') }}</span>
                                    <span class="help-block">{{ $errors->first('level_id', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schooladdress">{!! trans('vne-schools::language.label.address') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <input id="schooladdress" name="schooladdress" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.address') }}"
                                           class="form-control" value="{{$schools->schooladdress}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schoolphone">{!! trans('vne-schools::language.label.phone') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <input id="schoolphone" name="schoolphone" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.phone') }}"
                                           class="form-control" value="{{$schools->schoolphone}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="row" id="tablemem">
                                @if(isset($mem))
                                    @foreach($mem as $key=>$val)
                                        <fieldset>
                                            <div class="form-group schoolmem" id="schoolmem{{$key}}">
                                                <div class="col-sm-5 memname"><input class="form-control" type="text"
                                                                                     name="memname[]"
                                                                                     placeholder="{{ trans("vne-schools::language.mem.name") }}"
                                                                                     value="{{$val['memname']}}"></div>
                                                <div class="col-sm-5 memname"><input class="form-control" type="text"
                                                                                     name="memphone[]"
                                                                                     placeholder="{{ trans("vne-schools::language.mem.phone") }}"
                                                                                     value="{{$val['memphone']}}"></div>
                                                <div class="col-sm-5 memname"><input class="form-control " type="text"
                                                                                     name="mememail[]"
                                                                                     placeholder="{{ trans("vne-schools::language.mem.email") }}"
                                                                                     value="{{$val['mememail']}}"></div>
                                                <div class="col-sm-5 memname"><input class="form-control " type="text"
                                                                                     name="mempos[]"
                                                                                     placeholder="{{ trans("vne-schools::language.mem.pos") }}"
                                                                                     value="{{$val['mempos']}}"></div>
                                                <a style="cursor:pointer" class="trash"><i class="fa fa-times-circle"
                                                                                           data-size="18"
                                                                                           data-loop="true"
                                                                                           data-c="#f56954"
                                                                                           data-hc="#f56954"></i></a>
                                            </div>
                                        </fieldset>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-sm-push-4">
                                <button type="button"
                                        class="btn btn-success addschoolmem">{{ trans('vne-schools::language.buttons.addmem') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('_id') !!}
                    </div>
                </div>
                <div class="row" id="tablepit">
                    @if(isset($punits))
                        @foreach($punits as $key =>$value)
                            <div class="col-sm-3" id="punit{{$key}}">
                                <div class="row units">
                                    <div class="row unitlabel">Khối {{$key}}
                                    </div>
                                    <div class="row tablepclass">
                                        <div class="row pclass" id="pclass{{$key}}">
                                            @if(isset($value))
                                                @foreach($value as $k=>$v)
                                                    <div class="lop form-group" id="lop-{{$key}}-{{$k}}">
                                                        <fieldset>
                                                            <div class='col-sm-3 control-label'>Lớp :</div>
                                                            <div class="col-sm-8">
                                                                <input class="form-control eclass" id="{{$key}}{{$k}}"
                                                                       type="text" name="pclass[{{ $key }}][{{ $k }}]"
                                                                       }} value="{{ $v }}">
                                                            </div>
                                                            <a style="cursor:pointer" class="deletepclass"
                                                               c-data="lop-{{$key}}-{{$k}}"><i class='fa fa-trash'></i></a>
                                                        </fieldset>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success addpclass" c-data="punit{{$key}}">
                                            Thêm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-sm-4 col-sm-push-5">
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('vne-schools::language.buttons.update') }}</button>
                            <a href="{!! route('vne.schools.create') !!}"
                               class="btn btn-danger">{{ trans('vne-schools::language.buttons.discard') }}</a>
                        </div>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/validation.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js') }}"></script>
    <script>
        $(function () {
            $(".select2").select2({
                theme: "bootstrap"
            });
        });
        $(document).ready(function () {
            // người phụ trách
            $('.addschoolmem').on('click', function () {
                var count = $('.schoolmem:last').attr("id");
                console.log(count);
                if (typeof(count) !== 'undefined') {
                    var smid = parseInt(count.slice(9, count.length));
                    console.log(smid);
                    var arr = "<div class='form-group schoolmem' id='schoolmem" + (++smid) + "'>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='memname[]' placeholder='{{ trans('vne-schools::language.mem.name') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='memphone[]' placeholder='{{ trans('vne-schools::language.mem.phone') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mememail[]' placeholder='{{ trans('vne-schools::language.mem.email') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mempos[]' placeholder='{{ trans('vne-schools::language.mem.pos') }}'></div>" +
                        "<a style='cursor:pointer' class='trash'><i class='fa fa-times-circle' data-size='18' data-loop='true' data-c='#f56954' data-hc='#f56954' ></i></a>" +
                        "</div>"
                    var $name = $('schoolmem:last').find('input[name="memname[]"]');
                    if ($name.length != 0) {
                        var idx = 0;
                        $.each($name, function (i, item) {
                            if ($name.val() == '') {
                                idx = 1;
                            }
                        });
                        if (idx != 1) {
                            $('.schoolmem:last').after(arr);
                        }
                    } else {
                        $('#tablemem').append(arr);
                    }
                } else {
                    var arr = "<div class='form-group schoolmem' id='schoolmem0'>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='memname[]' placeholder='{{ trans('vne-schools::language.mem.name') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='memphone[]' placeholder='{{ trans('vne-schools::language.mem.phone') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mememail[]' placeholder='{{ trans('vne-schools::language.mem.email') }}'></div>" +
                        "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mempos[]' placeholder='{{ trans('vne-schools::language.mem.pos') }}'></div>" +
                        "<a style='cursor:pointer' class='trash'><i class='fa fa-times-circle' data-size='18' data-loop='true' data-c='#f56954' data-hc='#f56954' ></i></a>" +
                        "</div>"
                    $('#tablemem').append(arr);
                }

            });

            //ajax get huyện
            $('#province_id').on('select2:select', function (e) {
                var province_id = e.params.data.id;
                console.log(province_id);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('vne.schools.getdistrict') }}',
                    data: {
                        'province_id': province_id
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        var arr = " <option value='0'>Chọn quận huyện</option>";
                        for (i = 0; i < data.length; i++) {
                            arr += '<option value="' + data[i]._id + '" >' + data[i].district + '</option>';
                        }
                        $('#district_id').html('');
                        $('#district_id').append(arr);
                    }
                }, 'json');
            });

            // add khối lớp
            $('#level_id').on('change', function () {
                var level_id = $('option:selected', this).attr('value');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('vne.schools.getpunit') }}',
                    data: {
                        'level_id': level_id
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        var arr = '';
                        $.each(data, function (k, v) {
                            arr += "<div class='col-sm-3' id='punit" + v.id + "'>" +
                                "<div class='row units'>" +
                                "<div class='row unitlabel' >" +
                                "Khối " + v.punit +
                                "</div>" +
                                "<div class='row tablepclass'>" +
                                "<div class='row pclass' id='pclass" + v.id + "'>" +
                                "</div>" +
                                "<hr class='hr'>" +
                                "<button type='button'  class='btn btn-success addpclass' c-data='punit" + v.id + "' >Thêm</button>" +
                                "</div>" +
                                "</div>" +
                                "</div>";
                        });
                        $('#tablepit').html('');
                        $('#tablepit').append(arr);
                    }
                }, 'json');
            });
            //xóa khối lớp
            $('body').on('click', '.deletelevel', function () {
                var id = $(this).parent().attr('id');
                console.log(id);
                $('#' + id).remove();
            });
            // xóa người phụ trách
            $('body').on('click', '.trash', function () {
                var id = $(this).parent().attr('id');
                console.log(id);
                $('#' + id).remove();
            });
            //add lop
            $('body').on('click', '.addpclass', function () {
                var id = $(this).attr("c-data");
                var khoi = parseInt(id.slice(5, id.length));
                var idx = $(this).parent().find('.pclass').find('.lop').length;
                var cdx = ++idx;
                var arr = "<div class='lop form-group' id='lop-" + khoi + "-" + cdx + "'><fieldset><div class='col-sm-3 control-label'>Lớp :</div>" +
                    "<div class='col-sm-8'>" +
                    "<input class='form-control eclass' type='text' id='" + khoi + cdx + "' name='pclass[" + khoi + "][" + cdx + "]' placeholder={{trans('vne-schools::language.pclass.lop') }}>" +
                    "</div><a style='cursor:pointer' class='deletepclass' c-data='lop-" + khoi + "-" + cdx + "'><i class='fa fa-trash'></i></a></fieldset></div>";
                $('#' + id).find('.pclass').append(arr);
            });
            //xóa lớp
            $('body').on('click', '.deletepclass', function () {
                var id = $(this).attr("c-data");
                console.log(id);
                console.log('#' + id);
                $('#' + id).remove();
            });
        });
    </script>
    <!--end of page js-->
@stop

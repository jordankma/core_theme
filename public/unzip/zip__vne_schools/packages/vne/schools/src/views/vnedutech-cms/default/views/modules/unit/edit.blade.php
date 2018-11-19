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
                {!! Form::model($unit,['url' => route('vne.unit.update'), 'method' => 'put', 'class' => 'bf form-horizontal', '_id' => 'schools']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitname">{!! trans('vne-schools::language.label.unitname') !!}(<span
                                            style="color: red">*</span>):</label>
                                <div class="col-md-9 col-lg-9 col-12 ">
                                    <input id="unitname" name="unitname" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.name') }}"
                                           class="form-control" value="{{$unit->unitname}}" required>
                                    <span class="help-block">{{ $errors->first('unitname', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="parent">{!! trans('vne-schools::language.label.parent') !!}
                                    :</label>
                                <div class="col-md-9 {{ $errors->first('parent', 'has-error') }}">
                                    <select class="form-control select2" id="parent" name="parent">
                                        @if($parent_id == 0)
                                            <option value="0" selected>Chọn đơn vị cha</option>
                                        @else
                                            <option value="0">Chọn đơn vị cha</option>
                                        @endif
                                        @if(isset($units))
                                            @foreach($units as $value)
                                                @if($value['_id'] == $parent_id)
                                                <option value="{{$value['_id']}}" selected>{{ str_repeat("--",$value['level']).$value['unitname']}}</option>
                                                @else
                                                <option value="{{$value['_id']}}">{{ str_repeat("--",$value['level']).$value['unitname']}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block">{{ $errors->first('parent', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="type">{!! trans('vne-schools::language.label.type') !!}
                                    :</label>
                                <div class="col-md-9 {{ $errors->first('type', 'has-error') }}">
                                    <select class="form-control select2" id="type" name="type" required>
                                        @if($types == null)
                                        <option value="0" selected>Chọn loại đơn vị</option>
                                        @else
                                        <option value="0">Chọn loại đơn vị</option>
                                            @foreach($types as $types)
                                                @if($types->_id == $type->_id)
                                                <option value="{{$types->_id}}" selected>{{$types->catunit}}</option>
                                                @else
                                                <option value="{{$types->_id}}">{{$types->catunit}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="schoolprovince">{!! trans('vne-schools::language.label.province') !!}(<span
                                            style="color: red">*</span>)
                                    :</label>
                                <div class="col-md-9 {{ $errors->first('province_id', 'has-error') }}">
                                    <select class="form-control select2" id="province_id" name="province_id">
                                        <option value="">Chọn tỉnh thành</option>
                                        @if(isset($provinces))
                                            @foreach($provinces as $province)
                                                @if($unit->unitprovince == $province->_id)
                                                <option value="{{$province->_id}}" selected>{{$province->province}}</option>
                                                @else
                                                <option value="{{$province->_id}}">{{$province->province}}</option>
                                                @endif
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
                                                    <option value="{{$district->_id}}" selected>{{$district->district}}</option>
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
                                       for="unitaddress">{!! trans('vne-schools::language.label.address') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <input id="unitaddress" name="unitaddress" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.address') }}"
                                           class="form-control" value="{{$unit->unitaddress}}">
                                    <span class="help-block">{{ $errors->first('unitaddress', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitphone">{!! trans('vne-schools::language.label.phone') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <input id="unitphone" name="unitphone" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.phone') }}"
                                           class="form-control" value="{{$unit->unitphone}}">
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
                <hr>
                <div class="row">
                    <div class="form-group col-sm-4 col-sm-push-5">
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('vne-schools::language.buttons.update') }}</button>
                            <a href="{!! route('vne.unit.create') !!}"
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
        });
    </script>
    <!--end of page js-->
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-schools::language.titles.unit') }}@stop

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
        }
        .memname {
            padding: 5px !important;
        }
        .fa-times-circle {
            color: red;
            font-size: 18px;
            padding-top: 5px;
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
                {!! Form::model($provinces , ['url' => route('vne.unit.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'unitForm', 'files'=> true]) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitname">{!! trans('vne-schools::language.label.unitname') !!}(<span
                                            style="color: red">*</span>):</label>
                                <div class="col-md-9 col-lg-9 col-12{{ $errors->first('unitname', 'has-error') }} ">
                                    <input id="unitname" name="unitname" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.unitname') }}"
                                           class="form-control"  autofocus required>
                                    <span class="help-block">{{ $errors->first('unitname', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="parent">{!! trans('vne-schools::language.label.parent') !!}
                                    :</label>
                                <div class="form-group {{ $errors->first('parent', 'has-error') }}">
                                    <div class="col-md-9">
                                        <select class="form-control select2" id="parent" name="parent" required>
                                            <option value="0">Chọn đơn vị cha</option>
                                            @if(isset($units))
                                                @foreach($units as $value)
                                                    <option value="{{$value['_id']}}">{{str_repeat('--',$value->level).$value->unitname}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block">{{ $errors->first('parent', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="type">{!! trans('vne-schools::language.label.type') !!}
                                    :</label>
                                <div class="form-group {{ $errors->first('type', 'has-error') }}">
                                    <div class="col-md-9">
                                        <select class="form-control select2" id="type" name="type" required>
                                            @if(isset($catunit))
                                                @foreach($catunit as $catunit)
                                                    <option value="{{$catunit->_id}}">{{$catunit->catunit}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitprovince">{!! trans('vne-schools::language.label.province') !!}(<span
                                            style="color: red">*</span>)
                                    :</label>
                                <div class="form-group {{ $errors->first('province_id', 'has-error') }}">
                                    <div class="col-md-9">
                                        <select class="form-control select2" id="province_id" name="province_id" required>
                                            <option value="">Chọn tỉnh thành</option>
                                            @if(isset($provinces))
                                                @foreach($provinces as $province)
                                                    <option value="{{$province->_id}}">{{$province->province}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="help-block">{{ $errors->first('province_id', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitdistrict">{!! trans('vne-schools::language.label.district') !!}(<span
                                            style="color: red">*</span>)
                                    :</label>
                                <div class="col-md-9 col-lg-9 col-12 {{ $errors->first('district_id', 'has-error') }}">
                                    <select class="form-control select2" id="district_id" name="district_id" required>
                                    </select>
                                    <span class="help-block">{{ $errors->first('district_id', ':message') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitaddress">{!! trans('vne-schools::language.label.address') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12">
                                    <input id="unitaddress" name="unitaddress" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.address') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="unitphone">{!! trans('vne-schools::language.label.phone') !!}:</label>
                                <div class="col-md-9 col-lg-9 col-12 {{ $errors->first('unitphone', 'has-error') }}">
                                    <input id="unitphone" name="unitphone" type="text"
                                           placeholder="{{ trans('vne-schools::language.placeholder.phone') }}"
                                           class="form-control">
                                    <span class="help-block">{{ $errors->first('unitphone', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="row" id="tablemem">
                                <div class="form-group unitmem" id="unitmem0">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4 col-sm-push-4">
                                <button type="button"
                                        class="btn btn-success addunitmem">{{ trans('vne-schools::language.buttons.addmem') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-sm-4 col-sm-push-5">
                        <button type="submit"
                                class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                        <a href="{!! route('vne.unit.create') !!}"
                           class="btn btn-danger">{{ trans('vne-schools::language.buttons.discard') }}</a>
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
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/validation.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js') }}"></script>
    <script>
        $(function () {
            $(".select2").select2({
                theme: "bootstrap"
            });
        });
        //thêm người phụ trách
        $(document).ready(function () {
            $('.addunitmem').on('click', function () {
                var count = $('.unitmem:last').attr("id");
                console.log(count);
                var smid = parseInt(count.slice(9, count.length));
                console.log(smid);
                var arr = "<div class='form-group unitmem' id='unitmem" + (++smid) + "'>" +
                    "<fieldset class='field_set'><div class='col-sm-5 memname'><input class='form-control ' type='text' name='memname[]' placeholder='{{ trans('vne-schools::language.mem.name') }}'></div>" +
                    "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='memphone[]' placeholder='{{ trans('vne-schools::language.mem.phone') }}'></div>" +
                    "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mememail[]' placeholder='{{ trans('vne-schools::language.mem.email') }}'></div>" +
                    "<div class='col-sm-5 memname'><input class='form-control ' type='text' name='mempos[]' placeholder='{{ trans('vne-schools::language.mem.pos') }}'></div>" +
                    "<a style='cursor:pointer' class='trash'><i class='fa fa-times-circle'></i></a>" +
                    "</fieldset></div>"
                var $name = $('unitmem:last').find('input[name="memname[]"]');
                if ($name.length != 0) {
                    var idx = 0;
                    $.each($name, function (i, item) {
                        if ($name.val() == '') {
                            idx = 1;
                        }
                    });
                    if (idx != 1) {
                        $('.unitmem:last').after(arr);
                    }
                } else {
                    $('#tablemem').append(arr);
                }
            });

            //xóa người phụ trách
            $('body').on('click', '.trash', function () {
                var id = $(this).parent().parent().attr('id');
                console.log(id);
                $('#' + id).remove();
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
        });
    </script>
    <!--end of page js-->
@stop

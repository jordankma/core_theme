@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_target.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/contest/contestmanage/css/normalize.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/contest/contestmanage/css/ion.rangeSlider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/contest/contestmanage/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet" type="text/css">

    <style>
        .tooltip.tooltip-main {
            margin-top: -40px;
        }
        .slider-handle:hover .tooltip{
            opacity: 1;
        }
        .slider-horizontal .slider-handle:hover .slider-horizontal .tooltip.show{
            opacity:1;
        }
        .form-group{
            overflow: hidden;
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
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
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
                    {!! Form::model($target, ['url' => route('contest.contestmanage.contest_target.update',['target_id' => $target->target_id]), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tỉnh/ tp</label>
                            <div class="form-group {{ $errors->first('city', 'has-error') }}">
                                {!! Form::select('city', $city, null, array('class' => 'form-control city', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_target.all'))) !!}
                                <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Quận/ huyện</label>
                            <div class="form-group {{ $errors->first('district', 'has-error') }}">
                                {!! Form::select('district', [], null, array('class' => 'form-control district', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_target.district'))) !!}
                                <span class="help-block">{{ $errors->first('district', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Trường</label>
                            <div class="form-group {{ $errors->first('school', 'has-error') }}">
                                {!! Form::select('school', [], null, array('class' => 'form-control school', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_target.school'))) !!}
                                <span class="help-block">{{ $errors->first('school', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <label>Khối lớp</label>
                                <div class="form-group {{ $errors->first('gclass', 'has-error') }}">
                                    {!! Form::select('gclass', [], null, array('class' => 'form-control gclass', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_target.gclass'))) !!}
                                    <span class="help-block">{{ $errors->first('gclass', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Giới tính</label>
                                <div class="form-group {{ $errors->first('gender', 'has-error') }}">
                                    {!! Form::select('gender', $gender, null, array('class' => 'form-control gclass')) !!}
                                    <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Theo độ tuổi</label>
                            <div class="form-group {{ $errors->first('ages', 'has-error') }}">
                                <input id="ex2" type="text" class="span2" name="ages" value=""/>
                                <span class="help-block">{{ $errors->first('ages', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /.col-sm-8 -->
                    <div class="row">
                        <div class="form-group col-xs-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.update') }}</button>
                                <a href="{!! route('contest.contestmanage.contest_target.show') !!}"
                                   class="btn btn-danger">{{ trans('contest-contestmanage::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/contest/contestmanage/js/jquery-1.12.3.min.js') }}" ></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/contest/contestmanage/js/ion.rangeSlider.js') }}" ></script>

    <script>
        $("#ex2").ionRangeSlider({
            hide_min_max: false,
            keyboard: true,
            min: 0,
            max: 100,
            from: 0,
            to: 100,
            type: 'double',
            step: 1,
            grid: true
        });
//            $("#ex2").slider({});
//            var slider = new Slider('#ex2', {});
        $('body').on('change', '.city', function () {
            var city_id = $(this).val();
//            var href = 'http://cuocthi.vnedutech.vn/admin/vne/getdistricts/' +city_id;
            var route = '{{ route('contest.contestmanage.contest_target.get_administrative') }}';
            $.post(route, {type: 'district', city_id: city_id}, function (res) {
                console.log(res.data);
                if(res.data){
                    $('.district').html('');
                    var newOption = new Option('Tất cả', 0, false, false);
                    $('.district').append(newOption).trigger('change');
                    $.each(res.data, function (key, item) {
                        console.log(item);
                        var newOption = new Option(item.district, item._id, false, false);
                        $('.district').append(newOption).trigger('change');
                    });
                }
            })
        })
    </script>
@stop

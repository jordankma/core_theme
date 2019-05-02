@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.result.next_round_filter') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
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

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                         data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title }}
                    </h4>
                    {{--<div class="pull-right">--}}
                        {{--<a href="{{ route('contest.contestmanage.candidate.create') }}" class="btn btn-sm btn-default"><span--}}
                                    {{--class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>--}}
                    {{--</div>--}}
                </div>
                <br/>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Loại </label>
                            <select name="type" class="form-control">
                                <option value="school">Trường</option>
                                <option value="district">Quận/ Huyện</option>
                                <option value="province">Tỉnh/TP</option>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Điều kiện điểm </label>
                            <input type="number" name="point_condition" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Số lượng </label>
                            <input type="number" name="number" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Số tuần tối thiểu </label>
                            <input type="number" name="topic_condition" class="form-control">
                        </div>
                        {{--@if(!empty($filter_data))--}}
                            {{--@foreach($filter_data as $key => $value)--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label>{{ $value['title'] }}</label>--}}
                                    {{--@if($value['type_view'] == 'input')--}}
                                        {{--{!! Form::text($value['params'], null, array('class' => 'form-control '.$value['params'],'id' => $value['params'], 'autofocus'=>'autofocus','placeholder'=> $value['hint_text'])) !!}--}}
                                    {{--@elseif($value['type_view'] == 'selectbox')--}}
                                        {{--@if(!empty($value['data_view']))--}}
                                            {{--<select name="{{$value['params']}}" id="{{ $value['params'] }}" data-type="{{ !empty($value['type'])?$value['type']:''}}" data-api="{{ !empty($value['api'])?$value['api']:'' }}" data-parent="{{ !empty($value['parent_field'])?$value['parent_field']:'' }}" class="form-control">--}}
                                                {{--<option value="">{{ $value['hint_text'] }}</option>--}}
                                                {{--@foreach($value['data_view'] as $key2 => $value2)--}}
                                                    {{--<option value="{{ $value2['key'] }}">{{ $value2['value'] }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--@else--}}
                                            {{--{!! Form::select($value['params'],array(), 0, array('class' => 'form-control '.$value['params'],'id' => $value['params'], 'autofocus'=>'autofocus','placeholder'=> $value['hint_text'])) !!}--}}
                                        {{--@endif--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    </div>
                    <div class="row text-center">
                        <button type="button" class="btn btn-primary search" id="btn_filter">Lọc kết quả</button>
                    </div>
                    <div class="table-responsive">
                        <div class="row">
                            <div id="sp_result">

                            </div>
                        </div>
                        <table class="table table-bordered" id="table2">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                @if(!empty($result_data))
                                    @foreach($result_data as $key1 => $value1)
                                        <th>{{ $value1['title'] }}</th>
                                    @endforeach
                                @endif
                            </tr>
                            </thead>
                        </table>
{{--                        {{ $candidates->links() }}--}}
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
        var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
        var schools = @json($schools);
        var limit = schools.length;
        var first_id = schools[0][0];
        console.log(first_id);
        var i = 0;
        $('body').on('change','#province_id', function () {
            $('#district_id').html('');
            $('#district_id').append('<option value="">Tất cả Quận/ huyện</option>');
            var province_id = $('#province_id option:selected').val();
            if(province_id != 0 && province_id != ''){
                var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistrictbyprovince?api_type=array&province_id=' + province_id;
                $.get(url,function (res) {
                    if(res.data){
                        $.each(res.data, function (key, value) {
                            $('#district_id').append('<option value="'+ value.key +'">'+ value.value +'</option>');
                        });
                    }
                });
            }

        });

        $('body').on('change','#round_id', function () {
            $('#topic_id').html('');
            $('#topic_id').append('<option value="">Tất cả</option>');
            var round_id = $('#round_id option:selected').val();
            if(round_id != 0 && round_id != ''){
                var url = contest_domain + '/api/contest/get/topic_list?round_id=' + round_id;
                $.get(url,function (res) {
                    if(res.data){
                        $.each(res.data, function (key, value) {
                            $('#topic_id').append('<option value="'+ key +'">'+ value +'</option>');
                        })
                    }
                });
            }

        });

        $('body').on('change','#district_id', function () {
            $('#school_id').html('');
            $('#school_id').append('<option value="">Tất cả trường</option>');
            var district_id = $('#district_id option:selected').val();
            if(district_id != 0 && district_id != '') {
                var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschoolbydistrict?api_type=array&district_id=' + district_id;
                $.get(url, function (res) {
                    if (res.data) {
                        $.each(res.data, function (key, value) {
                            $('#school_id').append('<option value="' + value.key + '">' + value.value + '</option>');
                        })
                    }
                });
            }
        });

        var route = '{{ route('contest.contestmanage.candidate.data_next_round') }}';
        $('body').on('click', '#btn_filter', function () {
            $('#export').html('<button type="btn btn-default button" class="export"><span class="glyphicon glyphicon-download-alt"></span> Xuất Excel trang kết quả này</button>');
            if(schools){
                run(0);
            }
        });


        function run(i) {
            $.get(route, {'id': schools[i][0]}, function (data) {
                console.log(data.messages);
            }, 'json');
        };

        $(document).ajaxComplete(function(){
            var times = 500;
            if(i<limit){
                delay(function(){
                    i++;
                    run(i);
                    $('#sp_result').html('Đang xử lý: '+i+' / '+limit);
                }, times );
            }
        });
        var delay = ( function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

    </script>


    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.candidate.list_next_round') }}@stop

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
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                             data-color="#000"></i>
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
                    <div class="pull-right">
                        <a href="#" id="import_next_round" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.candidate.import_next_round') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="row">
                        @if(!empty($provinces))
                            <div class="form-group">
                                <label>Loại danh sách</label>
                                <select name="list_type" class="form-control" id="list_type">
                                    <option value="1">Danh sách đã lọc</option>
                                    <option value="2">Danh sách xuất</option>
                                </select>
                            </div>
                                <div class="form-group">
                                    <label>Tỉnh</label>
                                    <select name="province_id" class="form-control" id="province_id">
                                        @foreach($provinces as $key => $value)
                                            <option value="{{ $value->key }}">{{ $value->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                        @endif
                    </div>
                    <div class="row text-center">
                        <button type="button" class="btn btn-primary search" id="btn_filter">Lọc kết quả</button>
                    </div>
                    <div class="table-responsive">
                        <div class="row">
                            <div id="export">

                            </div>
                        </div>
                        <table class="table table-bordered" id="table2">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>Tỉnh</th>
                                <th>Quận/ huyện</th>
                                <th>Trường</th>
                                <th>Lớp</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Ngày sinh</th>
                                <th>Đối tượng</th>
                                {{--@if(!empty($result_data))--}}
                                    {{--@foreach($result_data as $key1 => $value1)--}}
                                        {{--<th>{{ $value1['title'] }}</th>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
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


        $('body').on('click', '#btn_filter', function () {
            var list_type = $('#list_type option:selected').val();
            var province_id = $('#province_id option:selected').val();
            if(list_type == '1'){
                var route = '{{ route('contest.contestmanage.candidate.data_import_next_round') }}';
                $('#table2').DataTable().clear().destroy();
                var table = $('#table2').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: route,
                        data: { province_id: province_id},
                        type: 'get'
                    },
                    columns: [
                        { data: 'member_id', name: 'member_id' },
                        { data: 'province_name', name: 'province_name', defaultContent: '' },
                        { data: 'district_name', name: 'district_name', defaultContent: '' },
                        { data: 'school_name', name: 'school_name', defaultContent: '' },
                        { data: 'class_id', name: 'class_id', defaultContent: '' },
                        { data: 'u_name', name: 'u_name' },
                        { data: 'name', name: 'name' },
                        { data: 'birthday', name: 'birthday' },
                        { data: 'target', name: 'target', defaultContent: '' },
                    ],
                    language: $.parseJSON('{!! json_encode(trans("adtech-core::datatable")) !!}')
                });
                table.on('draw', function () {
                    $('.livicon').each(function () {
                        $(this).updateLivicon();
                    });
                });
                table.on( 'order.dt search.dt', function () {
                    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();
            }
            else if( list_type == '2'){
                $('#export').html('<button type="btn btn-default button" class="export"><span class="glyphicon glyphicon-download-alt"></span> Xuất Excel trang kết quả này</button>');

                var route = '{{ route('contest.contestmanage.candidate.data_list_next_round') }}';
                $('#table2').DataTable().clear().destroy();
                var table = $('#table2').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: route,
                        data: { province_id: province_id },
                        type: 'get'
                    },
                    columns: [
                        { data: 'member_id', name: 'member_id' },
                        { data: 'province_name', name: 'province_name', defaultContent: '' },
                        { data: 'district_name', name: 'district_name', defaultContent: '' },
                        { data: 'school_name', name: 'school_name', defaultContent: '' },
                        { data: 'class_id', name: 'class_id', defaultContent: '' },
                        { data: 'u_name', name: 'u_name' },
                        { data: 'name', name: 'name' },
                        { data: 'birthday', name: 'birthday' },
                        { data: 'target', name: 'target', defaultContent: '' },
                    ],
                    language: $.parseJSON('{!! json_encode(trans("adtech-core::datatable")) !!}')
                });
                table.on('draw', function () {
                    $('.livicon').each(function () {
                        $(this).updateLivicon();
                    });
                });
                table.on( 'order.dt search.dt', function () {
                    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();
            }


        });

        $('body').on('click', '.export', function () {
            var route = '{{ route('contest.contestmanage.candidate.export_next_round') }}';
            var link = route + '?province_id='+ $('#province_id option:selected').val();
            window.open(link,'_blank');
        });

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
    <div class="modal fade in" id="import_excel" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mr-auto">Nhập danh sách đã lọc từ excel</h4>
                </div>
                <form id="importForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Chọn vòng thi</label>
                        <select name="round_id" class="form-control" id="round_id">
                            @foreach($rounds as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Chọn file danh sách (.xls, .xlsx)</label>
                        <div class="col-md-6 {{ $errors->first('file_upload', 'has-error') }}">
                            {!! Form::file('file_upload', array("accept" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","required" => "required","class" => "form-control required", "id" => "file_upload")); !!}
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <p id="result"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="import" type="button">Nhập</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
            $('body').on('click','#import_next_round', function () {
                $('#import_excel').modal();
            });
            $('body').on('click','#import', function () {
                var route = '{{ route('contest.contestmanage.candidate.import_next_round_data') }}';
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: new FormData($('form#importForm')[0]),
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if(res.status == true){
                            $('#table2').DataTable().clear().destroy();
                            var table = $('#table2').DataTable({
                                processing: true,
                                autoWidth: false,
                                serverSide: false,
                                // destroy: true,
                                data: res.data,
                                columns: [
                                    { title: "#" },
                                    { title: "Họ tên" },
                                    { title: "Ngày sinh" }
                                ]
                            });
                            table.on('draw', function () {
                                $('.livicon').each(function () {
                                    $(this).updateLivicon();
                                });
                            });
                        }
                        else{
                            alert(res.messages);
                        }
                    }
                });
            });
            $( document ).ajaxStart(function() {
                $('#result').text('Đang xử lý ...');
            });
            $( document ).ajaxComplete(function() {
                $('#result').text('Done');
            });
        });
    </script>
@stop

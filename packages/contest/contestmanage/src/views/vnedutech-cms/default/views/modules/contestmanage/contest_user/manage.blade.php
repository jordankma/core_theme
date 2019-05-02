@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_user.manage') }}@stop
@php
    $preview_url = config('site.url_static');
@endphp
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
                </div>
                <br/>
                <div class="panel-body">
                    @if(!empty($user_info))
                    <div class="row">
                        <table class="table table-condensed">
                            <thead>
                                <th>Uname</th>
                                <th>Ngày sinh</th>
                                <th>Phone user</th>
                                <th>Chủ tk</th>
                                <th>số tk</th>
                                <th>ngân hàng</th>
                                <th>Chi nhánh</th>
                                <th>sđt ng nhận</th>
                                <th>CMT</th>
                                <th>Đ/c</th>
                                <th>email</th>

                            </thead>
                            <tbody>

                                @foreach($user_info as $key => $value)
                                    <tr>
                                        <td>{{ $value->u_name ?? '' }}</td>
                                        <td>{{ $value->birthday ?? '' }}</td>
                                        <td>{{ $value->phone_user ?? '' }}</td>
                                        <td>{{ $value->account_holder ?? '' }}</td>
                                        <td>{{ $value->account_number ?? '' }}</td>
                                        <td>{{ $value->bank_name ?? '' }}</td>
                                        <td>{{ $value->bank_agency ?? '' }}</td>
                                        <td>{{ $value->account_phone ?? '' }}</td>
                                        <td>{{ $value->indenty_number ?? '' }}</td>
                                        <td>{{ $value->address ?? '' }}</td>
                                        <td>{{ $value->email ?? '' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div class="row">
                        @if(!empty($filter_data))
                            @foreach($filter_data as $key => $value)
                                <div class="col-md-4">
                                    <label>{{ $value['title'] }}</label>
                                    @if($value['type_view'] == 'input')
                                        {!! Form::text($value['params'], null, array('class' => 'form-control '.$value['params'],'id' => $value['params'], 'autofocus'=>'autofocus','placeholder'=> $value['hint_text'])) !!}
                                    @elseif($value['type_view'] == 'selectbox')
                                        @if(!empty($value['data_view']))
                                            <select name="{{$value['params']}}" id="{{ $value['params'] }}" class="form-control">
                                                <option value="">{{ $value['hint_text'] }}</option>
                                                @foreach($value['data_view'] as $key2 => $value2)
                                                    <option value="{{ $value2['key'] }}">{{ $value2['value'] }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {!! Form::select($value['params'],array(), 0, array('class' => 'form-control '.$value['params'],'id' => $value['params'], 'autofocus'=>'autofocus','placeholder'=> $value['hint_text'])) !!}
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        {{--<div class="form-group">--}}
                            {{--<div class="input-group">--}}
                                   {{--<span class="input-group-btn">--}}
                                     {{--<a id="vne_fm" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">--}}
                                       {{--<i class="fa fa-picture-o"></i> {{trans('vne-news::language.label.choise_image_display')}}--}}
                                     {{--</a>--}}
                                   {{--</span>--}}
                                {{--<input type="text" name="image" id="thumbnail2" class="form-control">--}}
                            {{--</div>--}}
                            {{--<img id="holder2" style="margin-top:15px;max-height:100px;">--}}
                        {{--</div>--}}
                        {{--<div class="area-new-text" style="display: block;">--}}
                            {{--<div class="form-group">--}}
                                {{--<label>{{trans('vne-news::language.form.text.content')}} </label><br>--}}
                                {{--<div class='box-body pad form-group'>--}}
                                    {{--<textarea name="content" id="ckeditor" placeholder="{{trans('vne-news::language.form.content_placeholder')}}"></textarea>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <button class="btn btn-primary" id="btn_filter" type="button">Tìm</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered width100" id="table2">
                            <thead>
                            <tr class="filters">
                                <th></th>
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                @if(!empty($result_data))
                                    @foreach($result_data as $key1 => $value1)
                                        <th>{{ $value1['title'] }}</th>
                                    @endforeach
                                @endif
                                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                            </tr>
                            </thead>
                        </table>
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
    {{--<script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/ckeditor_news/ckeditor.js') }}" type="text/javascript"></script>--}}
    {{--<script>--}}
        {{--CKEDITOR.replace('ckeditor', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});--}}
    {{--</script>--}}

    <script>
        $('body').on('change','#province_id', function () {
            $('#district_id').html('');
            $('#district_id').append('<option>Tất cả Quận/ huyện</option>');
            var province_id = $('#province_id option:selected').val();
            if(province_id != 0 && province_id != ''){
                var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistrictbyprovince?api_type=array&province_id=' + province_id;
                $.get(url,function (res) {
                    if(res.data){
                        $.each(res.data, function (key, value) {
                            $('#district_id').append('<option value="'+ value.key +'">'+ value.value +'</option>');
                        })
                    }
                });
            }

        });

        $('body').on('change','#district_id', function () {
            $('#school_id').html('');
            $('#school_id').append('<option>Tất cả trường</option>');
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

        $('body').on('click', '#btn_filter', function () {
            var param_array = @json($filter_data);
            var object = {};
            if(param_array){
                $.each(param_array, function (key, item) {
                    var param = item.params;
                    if(item.type_view == 'input'){
                        object[param] = $('#'+param).val();
                    }
                    else if(item.type_view == "selectbox"){
                    object[param] = $('#'+param +' option:selected').val();
                    }
                });
            }
            var route = '{{ route('contest.contestmanage.contest_user.data') }}'
            var column_data = new Array();
            column_data.push({
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            });
            column_data.push({data: 'member_id', name: 'member_id'});
            var result_data = @json($result_data);
            if(result_data){
                $.each(result_data, function (key, item) {
                    if(item['params_hidden']){
                        column_data.push({data: item['params_hidden'], name:item['params_hidden'],defaultContent:"" });
                    }
                    else{
                        column_data.push({data: item['params'], name:item['params'],defaultContent:""});
                    }

                });
            }
            column_data.push({ data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'});
            $('#table2').DataTable().clear().destroy();
            var table = $('#table2').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: route,
                    data: object
                },
                columns: column_data,
                language: $.parseJSON('{!! json_encode(trans("adtech-core::datatable")) !!}')
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
            table.on( 'order.dt search.dt', function () {
                table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        });
        
        $('body').on('click','.reset_exam', function () {
            var round_id = $(this).attr('c-data');
            var topic_id = $(this).attr('d-data');
            var repeat_time = $(this).attr('repeat-data');
            var member_id = $(this).attr('data-user');
            var route = '{{ route('contest.contestmanage.contest_user.reset_exam') }}';
            $.post(route, {member_id: member_id, round_id: round_id, topic_id: topic_id, repeat_time: repeat_time}, function (res) {
                if(res.success){
                    alert('Reset thành công');
                }
                else{
                    alert('Có lỗi xảy ra');
                }
            });
        });

        {{--$(function () {--}}
            {{--var column_data = new Array();--}}
            {{--column_data.push({--}}
                {{--"className":      'details-control',--}}
                {{--"orderable":      false,--}}
                {{--"data":           null,--}}
                {{--"defaultContent": ''--}}
            {{--});--}}
            {{--column_data.push({data: 'member_id', name: 'member_id'});--}}
            {{--var result_data = @json($result_data);--}}
            {{--if(result_data){--}}
                {{--$.each(result_data, function (key, item) {--}}
                    {{--if(item['params_hidden']){--}}
                        {{--column_data.push({data: item['params_hidden'], name:item['params_hidden'],defaultContent:"" });--}}
                    {{--}--}}
                    {{--else{--}}
                        {{--column_data.push({data: item['params'], name:item['params'],defaultContent:""});--}}
                    {{--}--}}

                {{--});--}}
            {{--}--}}
            {{--column_data.push({ data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'});--}}
            {{--var table = $('#table2').DataTable({--}}
                {{--processing: true,--}}
                {{--serverSide: true,--}}
                {{--ajax: '{{ route('contest.contestmanage.contest_user.data') }}',--}}
                {{--columns: column_data,--}}
                {{--language: $.parseJSON('{!! json_encode(trans("adtech-core::datatable")) !!}')--}}
            {{--});--}}
            {{--table.on('draw', function () {--}}
                {{--$('.livicon').each(function () {--}}
                    {{--$(this).updateLivicon();--}}
                {{--});--}}
            {{--});--}}
            {{--table.on( 'order.dt search.dt', function () {--}}
                {{--table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {--}}
                    {{--cell.innerHTML = i+1;--}}
                {{--} );--}}
            {{--} ).draw();--}}
        {{--});--}}

        // Add event listener for opening and closing details
        $('body').on('click', 'td.details-control', function () {
            var table2 = $('#table2').DataTable();
            var tr = $(this).closest('tr');
            var row = table2.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                // row.child.show();
                tr.addClass('shown');
            }
        } );
        function format ( d ) {
            // `d` is the original data object for the row
            var round_list = @json($round_list);
            var topic_list = @json($topic_list);
            var html = '<table class="table table-striped" style="padding-left:50px;"><thead>' +
                '<th width="20%">Vòng thi</th>' +
                '<th width="20%">Tuần thi</th>' +
                '<th width="10%">Lượt thi</th>' +
                '<th width="15%">Điểm thi</th>' +
                '<th width="20%">Thời gian thi</th>' +
                '<th width="15%"></th>' +
                '</thead><tbody>';
            if(d.exam_result){
                $.each(d.exam_result, function (key, item) {
                    html += '<tr>' +
                            '<td>'+ round_list[item.round_id] + '</td>' +
                            '<td>'+ topic_list[item.topic_id] + '</td>' +
                            '<td>'+ item.repeat_time + '</td>' +
                            '<td>'+ item.total_point + '</td>' +
                            '<td>'+ convert_time(item.used_time) + '</td>' +
                            '<td><a href="javascript:void(0)" class="reset_exam" c-data="'+ item.round_id +'"  d-data="'+ item.topic_id +'" repeat-data="'+ item.repeat_time +'" data-user="'+ item.member_id +'" >Reset lượt thi</a></td>' +
                            '</tr>';
                });
            }
            html += '</tbody></table>';
            return html;
        }

        function convert_time(minisecond) {
            var res = '';
            if(minisecond){
                var minisecond = parseInt(minisecond);
                res += Math.ceil(minisecond/60000);
                res += ':';
                res += Math.ceil((minisecond - (Math.ceil(minisecond/60000)*60000))/1000);
                res += '.';
                res += new String(minisecond).slice(-3);
            }

            return res;
        }

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
    <div class="modal fade in" id="config_detail" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mr-auto">Chi tiết thí sinh</h4>
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



    {{--<script>--}}
        {{--$(function () {--}}
            {{--$('body').on('hidden.bs.modal', '.modal', function () {--}}
                {{--$(this).removeData('bs.modal');--}}
            {{--});--}}
            {{--$('body').on('click','.show',function () {--}}

            {{--});--}}
            {{--$('#vne_fm').filemanager();--}}
        {{--});--}}

        {{--(function ($) {--}}

            {{--$.fn.filemanager = function (type, options) {--}}
                {{--type = type || 'file';--}}
                {{--var parent = this;--}}
                {{--this.on('click', function (e) {--}}
                    {{--if( $(parent).attr('data-choice') === 'files'){--}}
                        {{--type = 'file';--}}
                        {{--$("#isIcon").val(1);--}}
                    {{--}--}}
                    {{--if( $(parent).attr('data-choice') === 'icon'){--}}
                        {{--$("#isIcon").val(2);--}}
                    {{--}--}}
                    {{--var route_prefix = (options && options.prefix) ? options.prefix : '/file-manager/manage';--}}
                    {{--localStorage.setItem('target_input', $(this).data('input'));--}}
                    {{--localStorage.setItem('target_preview', $(this).data('preview'));--}}
                    {{--window.open(route_prefix + '?type=' + type , 'FileManager', 'width=900,height=600');--}}
                    {{--if ($("#mutil").val() === 'remove' && $(parent).attr('data-choice') === 'files') {--}}
                        {{--return true;--}}
                    {{--} else {--}}
                        {{--window.SetUrl = function (url, file_path) {--}}
                            {{--console.log(url);--}}
                            {{--//set the value of the desired input to image url--}}
                            {{--var target_input = $('#' + localStorage.getItem('target_input'));--}}
                            {{--target_input.val(file_path).trigger('change');--}}

                            {{--//set or change the preview image src--}}
                            {{--var target_preview = $('#' + localStorage.getItem('target_preview'));--}}
                            {{--target_preview.attr('src', url).trigger('change');--}}
                        {{--};--}}
                        {{--return false;--}}

                    {{--}--}}
                {{--});--}}
            {{--}--}}

        {{--})(jQuery);--}}
        {{--$(window).bind('storage', function (e) {--}}
            {{--if(e.originalEvent.key == 'file_select'){--}}
                {{--var preview_url = '{{ $preview_url }}';--}}
                {{--var target_input =   localStorage.getItem('target_input');--}}
                {{--var target_preview =   localStorage.getItem('target_preview');--}}
                {{--$('#' + target_input).val(e.originalEvent.newValue);--}}
                {{--$('#' + target_preview).attr("src",preview_url + e.originalEvent.newValue);--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}
@stop

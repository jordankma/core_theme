@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.result.manage') }}@stop

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
                    {{--<div class="pull-right">--}}
                        {{--<a href="{{ route('contest.contestmanage.candidate.create') }}" class="btn btn-sm btn-default"><span--}}
                                    {{--class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>--}}
                    {{--</div>--}}
                </div>
                <br/>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Chọn bảng</label>
                            <div class="form-group {{ $errors->first('table_id', 'has-error') }}">
                                {!! Form::select('table_id', !empty($table)?$table:[], null, array('class' => 'form-control table_id', 'placeholder' => trans("contest-contestmanage::language.placeholder.candidate.table"))) !!}
                                <span class="help-block">{{ $errors->first('table_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Vòng thi</label>
                            <div class="form-group {{ $errors->first('round_id', 'has-error') }}">
                                {!! Form::select('round_id', !empty($round)?$round:[], null, array('class' => 'form-control round', 'placeholder' => trans("contest-contestmanage::language.placeholder.candidate.table"))) !!}
                                <span class="help-block">{{ $errors->first('round_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Tuần thi</label>
                            <div class="form-group {{ $errors->first('topic_id', 'has-error') }}">
                                {!! Form::select('topic_id', !empty($topic)?$topic:[], null, array('class' => 'form-control topic', 'placeholder' => trans("contest-contestmanage::language.placeholder.candidate.table"))) !!}
                                <span class="help-block">{{ $errors->first('topic_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Tên đăng nhập</label>
                            <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Chọn Tỉnh/ TP</label>
                            <div class="form-group {{ $errors->first('province_id', 'has-error') }}">
                                {!! Form::select('province_id', !empty($city)?$city:[], null, array('class' => 'form-control city')) !!}
                                <span class="help-block">{{ $errors->first('province_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Chọn Quận/ huyện</label>
                            <div class="form-group {{ $errors->first('district_id', 'has-error') }}">
                                {!! Form::select('district_id',$district,null, array('class' => 'form-control district', 'placeholder' => trans("contest-contestmanage::language.placeholder.candidate.district"))) !!}
                                <span class="help-block">{{ $errors->first('district_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Chọn Trường</label>
                            <div class="form-group {{ $errors->first('school_id', 'has-error') }}">
                                {!! Form::select('school_id',[], null, array('class' => 'form-control school', 'placeholder' => trans("contest-contestmanage::language.placeholder.candidate.school"))) !!}
                                <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <button type="button" class="btn btn-primary search">Lọc kết quả</button>
                    </div>
                    <div class="table-responsive">
                        <div class="row">
                            <div id="export">

                            </div>
                        </div>
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.username') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.birthday') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.round') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.topic') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.times') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.point') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.time') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.phone') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.email') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.city') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.district') }}</th>

                                <th>{{ trans('contest-contestmanage::language.table.result.school') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.class') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.result.gender') }}</th>
{{--                                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>--}}
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
        $(function () {
            $('#table').DataTable().clear().destroy();
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                destroy:true,
                scrollX: true,
                ajax: '{{ route('contest.contestmanage.candidate.data_result') }}',
                columns: [
                    { data: '_id', name: '_id' },
                        { data: 'candidate.name', name: 'name', defaultContent: '' },
                        { data: 'candidate.u_name', name: 'u_name', defaultContent: '' },
                        { data: 'candidate.birthday', name: 'birthday', defaultContent: '' },
                        { data: 'round_id', name: 'round_id', defaultContent: '' , "render": function (data) {
                            if(data){
                                var round = @json($round);
                                return Base64.decode(round[parseInt(data)]);
                            }
                        } },
                        { data: 'topic_id', name: 'topic_id', defaultContent: '', "render": function (data) {
                            if(data){
                                var topic = @json($topic);
                                return topic[data];
                            }
                        } },
                        { data: 'repeat_time', name: 'repeat_time', defaultContent: '' },
                        { data: 'total_point', name: 'total_point', defaultContent: '' },
                        { data: 'used_time', name: 'used_time', defaultContent: '',"render": function (data) {
                            if(data){
                                var min = Math.floor(data/60000);
                                var sec = Math.floor((data - (min*60000))/1000);
                                var tik = data.substr(-3);
                                return  min +"'"+sec+'"'+tik;
                            }
                        } },
                        { data: 'candidate.phone', name: 'phone', defaultContent: '' },
                        { data: 'candidate.email', name: 'email', defaultContent: '' },
                        { data: 'candidate.province_name', name: 'province_name', defaultContent: '' },
                        { data: 'candidate.district_name', name: 'district_name', defaultContent: '' },
                        { data: 'candidate.school_name', name: 'school_name', defaultContent: '' },
                        { data: 'candidate.class_id', name: 'class_id', defaultContent: '' },
                    { data: 'candidate.gender', name: 'gender', defaultContent: '',  "render": function (data) {
                            return data=="male"?"Nam":"Nữ";
                        } },
//                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
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
        });
        $('body').on('click','.search', function () {
            $('#table').DataTable().clear().destroy();
            var table_id = $('.table_id option:selected').val();
            var round_id = $('.round option:selected').val();
            var topic_id = $('.topic option:selected').val();
            var province_id = $('.city option:selected').val();
            var district_id = $('.district option:selected').val();
            var school_id = $('.school option:selected').val();
            var name = $('.name').val();

            $('#export').html('');
            $('#export').html('<button type="btn btn-default button" class="export"><span class="glyphicon glyphicon-download-alt"></span> Xuất Excel trang kết quả này</button>');

                $('#table .filters').html(' <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.name') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.username') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.birthday') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.round') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.topic') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.times') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.point') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.time') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.phone') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.email') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.city') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.district') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.donvi') }}</th>' +
                    '<th>{{ trans('contest-contestmanage::language.table.result.gender') }}</th>');
                var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy:true,
                    scrollX: true,
                    ajax: {
                        url: '{{ route('contest.contestmanage.candidate.data_result') }}',
                        data: {table_id: table_id, province_id: province_id, district_id: district_id, school_id: school_id, name: name, topic_id: topic_id, round_id:round_id}
                    },
                    columns: [
                        { data: '_id', name: '_id' },
                        { data: 'candidate.name', name: 'name', defaultContent: '' },
                        { data: 'candidate.u_name', name: 'u_name', defaultContent: '' },
                        { data: 'candidate.birthday', name: 'birthday', defaultContent: '' },
                        { data: 'round_id', name: 'round_id', defaultContent: '' , "render": function (data) {
                            if(data){
                                var round = @json($round);
                                return Base64.decode(round[parseInt(data)]);
                            }
                        } },
                        { data: 'topic_id', name: 'topic_id', defaultContent: '', "render": function (data) {
                            if(data){
                                var topic = @json($topic);
                                return topic[data];
                            }
                        } },
                        { data: 'repeat_time', name: 'repeat_time', defaultContent: '' },
                        { data: 'total_point', name: 'total_point', defaultContent: '' },
                        { data: 'used_time', name: 'used_time', defaultContent: '',"render": function (data) {
                            if(data){
                                var min = Math.floor(data/60000);
                                var sec = Math.floor((data - (min*60000))/1000);
                                var tik = data.substr(-3);
                                return  min +"'"+sec+'"'+tik;
                            }
                        } },
                        { data: 'candidate.phone', name: 'phone', defaultContent: '' },
                        { data: 'candidate.email', name: 'email', defaultContent: '' },
                        { data: 'candidate.province_name', name: 'province_name', defaultContent: '' },
                        { data: 'candidate.district_name', name: 'district_name', defaultContent: '' },
                        { data: 'candidate.don_vi', name: 'don_vi', defaultContent: '' },
                        { data: 'candidate.gender', name: 'gender', defaultContent: '',  "render": function (data) {
                                return data=="male"?"Nam":"Nữ";
                            } },
//                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
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
        });

        $('body').on('change','.city',function () {
            $(".district").html('<option value="0">Tất cả</option>');
            var province_id = $('.city option:selected').val();
            var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistrictbyprovince?api_type=array&province_id=' +province_id;
            $.get(url,function (res) {
                if(res){
                    $.each(res.data, function (key, value) {
                        var opt = new Option(value.value, value.key);
                      /*  $(opt).html("option text");*/
                        $(".district").append(opt);
                    })
                }
            })
        });

        $('body').on('change','.district',function () {
            $(".school").html('');
            var district_id = $('.district option:selected').val();
            var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschoolbydistrict?api_type=array&district_id=' +district_id;
            $.get(url,function (res) {
                if(res){
                    var opt = new Option('Tất cả', '');
                    $(".school").append(opt);
                    $.each(res.data, function (key, value) {
                        var opt = new Option(value.value, value.key);
                        /*  $(opt).html("option text");*/
                        $(".school").append(opt);
                    })
                }
            })
        });
        $('body').on('change','.round',function () {
            $(".topic").html('');
            var round_id = $('.round option:selected').val();
            var route = '{{ route('contest.contestmanage.contest_topic.get_list') }}';
            $.post(route,{round_id: round_id},function (res) {
                if(res){
                    var opt = new Option('Tất cả', '');
                    $(".topic").append(opt);
                    $.each(res, function (key, value) {
                        var opt = new Option(value.display_name, value.topic_id);
                        $(".topic").append(opt);
                    })
                }
            })
        });
        $('body').on('click', '.export', function () {
            var table_id = $('.table_id option:selected').val();
            var round_id = $('.round option:selected').val();
            var topic_id = $('.topic option:selected').val();
            var province_id = $('.city option:selected').val();
            var district_id = $('.district option:selected').val();
            var school_id = $('.school option:selected').val();
            var name = $('.name').val();
            var table = $('#table').DataTable();
            var page_info = table.page.info();
            var page = (page_info.page) + 1;
            var limit = page_info.length;

            var route = '{{ route('contest.contestmanage.candidate.export') }}';
            var link = route +'?table_id=' +table_id+ '&province_id=' + province_id+ '&district_id=' + district_id+ '&school_id=' + school_id+ '&name=' + name+ '&topic_id=' + topic_id+ '&round_id=' + round_id+ '&limit=' + limit+ '&page=' + page+ '&module=result';
            window.open(link,'_blank');
        })

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

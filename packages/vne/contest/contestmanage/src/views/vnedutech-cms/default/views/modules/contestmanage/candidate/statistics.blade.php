@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.statistics.manage') }}@stop

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
                            <div class="form-group {{ $errors->first('city_id', 'has-error') }}">
                                {!! Form::select('city_id', !empty($city)?$city:[], null, array('class' => 'form-control city')) !!}
                                <span class="help-block">{{ $errors->first('city_id', ':message') }}</span>
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
                        <button type="button" class="btn btn-primary search">Thống kê</button>
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
        $('body').on('click','.search', function () {
            $('#table').DataTable().clear().destroy();
            var table_id = $('.table_id option:selected').val();
            var round_id = $('.round option:selected').val();
            var topic_id = $('.topic option:selected').val();
            var city_id = $('.city option:selected').val();
            var district_id = $('.district option:selected').val();
            var school_id = $('.school option:selected').val();
            var name = $('.name').val();

//            $('#export').html('');
//            $('#export').html('<button type="btn btn-default button" class="export"><span class="glyphicon glyphicon-download-alt"></span> Xuất Excel</button>');

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                destroy:true,
                scrollX: true,
                ajax: {
                    url: '{{ route('contest.contestmanage.candidate.data_statistics') }}',
                    data: {table_id: table_id, city_id: city_id, district_id: district_id, school_id: school_id, name: name, topic_id: topic_id, round_id:round_id}
                },
                columns: [
                    { data: '_id', name: '_id' },
                    { data: 'name', name: 'name', defaultContent: '' },
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

        $('body').on('change','city',function () {
            var city_id = $('.city option:selected').val();
            var url = 'http://timhieubiendao.daknong.vn/admin/vne/member/member/get/district?city_id=' +city_id;
            $.get(url,function (res) {
                if(res){
                    $.each(res, function (key, value) {
                        var opt = new Option(value.name, value.district_id);
                      /*  $(opt).html("option text");*/
                        $(".district").append(opt);
                    })
                }
            })
        });
        $('body').on('change','.district',function () {
            $(".school").html('');
            var district_id = $('.district option:selected').val();
            var url = 'http://timhieubiendao.daknong.vn/admin/vne/member/member/get/school?district_id=' +district_id;
            $.get(url,function (res) {
                if(res){
                    var opt = new Option('Tất cả', '');
                    $(".school").append(opt);
                    $.each(JSON.parse(res), function (key, value) {
                        var opt = new Option(value.name, value.school_id);
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
            var city_id = $('.city option:selected').val();
            var district_id = $('.district option:selected').val();
            var school_id = $('.school option:selected').val();
            var name = $('.name').val();

            var route = '{{ route('contest.contestmanage.candidate.export') }}';
            var link = route +'?table_id=' +table_id+ '&city_id=' + city_id+ '&district_id=' + district_id+ '&school_id=' + school_id+ '&name=' + name+ '&topic_id=' + topic_id+ '&round_id=' + round_id+ '&module=result';
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

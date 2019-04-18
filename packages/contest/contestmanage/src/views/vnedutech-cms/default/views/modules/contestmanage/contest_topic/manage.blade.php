@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_topic.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
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
                        <a href="{{ route('contest.contestmanage.contest_topic.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>

                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn_clear_cache"><span
                                    class="glyphicon glyphicon-plus"></span> Xóa cache</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.type') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.config') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.round') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.start') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.end') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_topic.exam_repeat') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.status') }}</th>
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

    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('contest.contestmanage.contest_topic.data') }}',
                columns: [
                    { data: 'topic_id', name: 'topic_id' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'type', name: 'type' },
                    { data: 'topic_id', name: 'config', "render": function (data) {
                        return '<a href="javascript:void(0)" class="btn btn-default show_config" c-data="'+ data +'"><span class="glyphicon glyphicon-eye-open"></span> Xem</a>';
                    } },
                    { data: 'round_id', name: 'round_id' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'exam_repeat_time', name: 'exam_repeat_time' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
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
                    <h4 class="modal-title mr-auto">Chi tiết cấu hình</h4>
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
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
        $('body').on('click', '.btn_clear_cache', function () {
            var contest = @json($CURRENT_CONTEST);
            if(contest){
                var route = '{{ route('api.contest.post.reload_cache_contest') }}';
                var domain = contest.domain_name;
                $.post(route,{domain_name: domain}, function (res) {
                    if(res){
                        alert('Xóa thành công!');
                    }
                })
                // $.get('', function (res) {
                //     $.get('http://'+ contest.domain_name +'/api/contest/get/exam_info?type=test&reload_cache=1', function (res1) {
                //         if(res1.success == true){
                //             alert('Xóa thành công!');
                //         }
                //
                //     });
                // });
                // }
            }

        });
        $('body').on('click','.show_config', function () {
            var route = '{{ route('contest.contestmanage.contest_season.get_config') }}';
            var season_id = $(this).attr('c-data');
            $.post(route, {season_id : season_id}, function (res) {
                if(res){
                    var html = '';
                    $.each(res, function (key, item) {
                        html += ' <div class="panel panel-primary"> ' +
                            '<div class="panel-body"> ' +
                            '<p class="text-on-pannel text-primary"><strong> '+ item.environment+' </strong></p> ';
                        if(item){
                            $.each(item.config, function (key1, item1) {
                                $.each(item1, function (key2, item2) {
                                    if(item2.type == 'file'){
                                        html += '<div class="form-group"><span>'+ key2 +': </span> <img src="'+ item2.value +'" style="height: 70px; width: auto"></div>';
                                    }
                                    else{
                                        html += '<div class="form-group"><span>'+ key2 +': </span>'+ item2.value +'</div>';
                                    }
                                });

                            });
                        }
                        html +=  '</div></div>';
                    });

                    $('#config_detail .modal-body').html('');
                    $('#config_detail .modal-body').html(html);
                    $('#config_detail').modal();
                }

            });
        });
    </script>
@stop

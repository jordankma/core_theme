@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contest::language.titles.contest.manage') }}@stop

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
                        <a href="{{ route('contest.contest.contest_list.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contest::language.buttons.create') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('adtech-core::common.sequence') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.logo') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.name') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.alias') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.domain') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.mysql') }}</th>
                                <th>{{ trans('contest-contest::language.table.contest.mongo') }}</th>
                                <th>{{ trans('contest-contest::language.table.action') }}</th>
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
                ajax: '{{ route('contest.contest.contest_list.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'contest_id' },
                    { data: 'logo', name: 'logo', "render": function (data) {
                            return '<img src="{{ config('site.url_static') }}/' + data +'" style="width:100px; height:auto; max-height: 100px">';
                        } },
                    { data: 'name', name: 'name' },
                    { data: 'alias', name: 'alias' },
                    { data: 'domain_name', name: 'domain_name' },
                    { data: 'mysql_host', name: 'mysql_host', "render": function (data, type, row, meta) {
                            return '<p>Host: '+ row['mysql_host'] +'</p>' +
                                '<p>Port: '+ row['mysql_port'] +'</p>' +
                                '<p>DB: '+ row['mysql_database'] +'</p>' +
                                '<p>User: '+ row['mysql_username'] +'</p>' +
                                '<p>Pass: '+ row['mysql_password'] +'</p>';
                        } },
                    { data: 'mongodb_host', name: 'mongodb_host', "render": function (data, type, row, meta) {
                            return '<p>Host: '+ row['mongodb_host'] +'</p>' +
                                '<p>Port: '+ row['mongodb_port'] +'</p>' +
                                '<p>DB: '+ row['mongodb_database'] +'</p>' +
                                '<p>User: '+ row['mongodb_username'] +'</p>' +
                                '<p>Pass: '+ row['mongodb_password'] +'</p>';
                        } },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });

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
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop
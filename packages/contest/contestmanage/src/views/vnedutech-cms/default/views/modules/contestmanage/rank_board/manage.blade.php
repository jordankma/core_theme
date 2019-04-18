@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.rank_board.manage') }}@stop

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
                        <a href="{{ route('contest.contestmanage.rank_board.create') }}" class="btn btn-sm btn-default">
                            <span class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.rank_board.title') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.rank_board.params') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.rank_board.type') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.rank_board.data_child') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.rank_board.header') }}</th>
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
                ajax: '{{ route('contest.contestmanage.rank_board.data') }}',
                columns: [
                    { data: '_id', name: '_id' },
                    { data: 'title', name: 'title' },
                    { data: 'params', name: 'params' },
                    { data: 'type', name: 'type' },
                    { data: 'data_child', name: 'data_child' , defaultContent:"", "render": function (data, type, row, meta) {
                            if(data){
                                return '<a href="javascript:void(0)" class="label label-default view_tab" c-data="'+ row['_id'] +'">Xem các tab</a>';
                            }
                        }},
                    { data: 'header', name: 'header' , defaultContent:"", "render": function (data, type, row, meta) {
                            if(data){
                                return '<a href="javascript:void(0)" class="label label-default view_header" c-data="'+ row['_id'] +'">Xem format</a>';
                            }
                        }},
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
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

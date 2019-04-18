@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.search_account.manage') }}@stop

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
                        <a href="{{ route('contest.contestmanage.search_account.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('adtech-core::common.sequence') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.u_name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.first_pass') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.type') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.province') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.district') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.search_account.school') }}</th>
                                {{--<th>{{ trans('contest-contestmanage::language.table.action') }}</th>--}}
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
                ajax: '{{ route('contest.contestmanage.search_account.data') }}',
                columns: [
                    { data: '_id', name: '_id' },
                    { data: 'unit', name: 'unit' },
                    { data: 'u_name', name: 'u_name' },
                    { data: 'first_password', name: 'first_password' },
                    { data: 'type', name: 'type', "render": function(res){
                            if(res == 'province'){
                                return 'Cấp tỉnh';
                            }
                            else if(res == 'district'){
                                return 'Cấp quận';
                            }
                            else if(res == 'school'){
                                return 'Cấp trường';
                            }
                        } },
                    { data: 'province_data', name: 'province_data', "render": function(res){
                            console.log(res);
                            if(res){
                                var html = '';
                                $.each(res, function(key, item){
                                    html += '<p>'+ item +'</p>';
                                });
                                return html;
                            }
                        }},
                    { data: 'district_data', name: 'district_data', "render": function(res){
                            if(res){
                                var html = '';
                                $.each(res, function(key, item){
                                    html += '<p>'+ item +'</p>';
                                });
                                return html;
                            }
                        }},
                    { data: 'school_data', name: 'school_data', "render": function(res){
                            if(res){
                                var html = '';
                                $.each(res, function(key, item){
                                    html += '<p>'+ item +'</p>';
                                });
                                return html;
                            }
                        }},
                    // { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
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

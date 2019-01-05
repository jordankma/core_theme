@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.contest_client.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/sweetalert/css/sweetalert2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop
<style>
    #client_name{
        font-weight: bold;
    }
</style>

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
                    <div class="pull-right">
                        <a href="{{ route('contest.contestmanage.contest_client.create') }}" class="btn btn-sm btn-default">
                            <span class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>
                        {{--<a href="{{ route('contest.contestmanage.contest_client.environment') }}" class="btn btn-sm btn-default">--}}
                            {{--<span class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.environment') }}</a>--}}
                    </div>
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.environment') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.resource_path') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.width') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.height') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.contest_client.description') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.status') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
        <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

        <div class="modal fade" id="change_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                        <h4 class="modal-title" id="user_delete_confirm_title">Xác nhận chuyển client</h4>
                    </div>
                    <div class="modal-body">
                        <div><p>Bạn có chắc chắn muốn kích hoạt client: <span id="client_name"></span>?</p></div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" type="button" class="btn btn-default cancel_change">{{ trans('adtech-core::confirm.cancel') }}</a>
                        <a href="javascript:void(0)" type="button" class="btn btn-danger confirm_change">{{ trans('adtech-core::confirm.confirm') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="user_log_title"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>

    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('contest.contestmanage.contest_client.data') }}',
                columns: [
                    { data: 'client_id', name: 'client_id' },
                    { data: 'name', name: 'name' },
                    { data: 'environment', name: 'environment' },
                    { data: 'resource_path', name: 'resource_path' },
                    { data: 'width', name: 'width' },
                    { data: 'height', name: 'height' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' , "render": function (data, type, row, meta) {
                            if(data == "1"){
                                return  '<input type="checkbox" id="client-'+ row['client_id'] +'" class="allow_permission status" data-size="mini" readonly data-client-name="' + row['name'] + '" data-client-id="'+ row['client_id'] +'" checked>';
                            }
                            else{
                                return  '<input type="checkbox" id="client-'+ row['client_id'] +'" class="allow_permission status"  data-size="mini" data-client-name="' + row['name'] +'" data-client-id="'+ row['client_id'] +'">';
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
                $('input[type="checkbox"].allow_permission').bootstrapSwitch({
                    onSwitchChange:function(event, state) {
                        var client_id = $(this).data('client-id');
                        var name = $(this).data('client-name');

                       if(state == true){
                           $('#change_confirm').attr('c-data', client_id);
                           $('#change_confirm #client_name').html(name);
                           $('#change_confirm').modal();
                       }
                       else{

                       }

                    }
                });
            });
            table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });
        $('body').on('click','.cancel_change', function () {
            var id = $('#change_confirm').attr('c-data');
            $('#client-'+id).bootstrapSwitch('toggleState', false);
            $('#change_confirm').modal('hide');

        });

        $('body').on('click', '.confirm_change', function () {
            var id = $('#change_confirm').attr('c-data');
            var route = '{{ route('contest.contestmanage.contest_client.change') }}';
            $.post(route, {client_id: id}, function (res) {
                window.location.reload();
            });
        });

        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
            $("[name='permission_locked']").bootstrapSwitch();
            $('input[type="checkbox"].allow_permission').bootstrapSwitch({
                onSwitchChange:function(event, state) {
                    console.log(event);
                }
            });
        });
    </script>
@stop

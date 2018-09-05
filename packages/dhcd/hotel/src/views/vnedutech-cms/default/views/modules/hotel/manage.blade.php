@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-hotel::language.namepro') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap4.css') }}" />
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
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
                        <a href="{{ route('dhcd.hotel.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-hotel::language.buttons.create') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content" style="text-align: center; padding-top: 15px">STT</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.name') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.hotel') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.address') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.img') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.staff') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.note') }}</th>
                                <th style="text-align: center;">{{ trans('dhcd-hotel::language.table.action') }}</th>
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
    <script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.responsive.js') }}" ></script>
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dhcd.hotel.data') }}',
                columns: [
                    { data: 'rownum', name: 'rownum', "width": "5%" },
                    { data: 'doan_id', name: 'doan_id', "width": "10%" },
                    { data: 'hotel', name: 'hotel', "width": "15%" },
                    { data: 'address', name: 'address',"width": "15%" },
                    { data: 'img', name: 'img', "width": "15%" },
                    { data: 'hotel_staff', name: 'hotel_staff', "width": "15%" },
                    { data: 'note', name:'note', "width": "20%"},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content', "width": "5%"}
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

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-schools::language.titles.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .hr {
            margin: 4px !important;
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
                        <a href="{{ route('vne.schools.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('vne-schools::language.buttons.addschools') }}
                        </a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('adtech-core::common.sequence') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.name') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.level') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.address') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.phone') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.province') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.district') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.pclass') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.mem') }}</th>
                                <th class="datatable">{{ trans('vne-schools::language.label.action') }}</th>
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
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script>
        $(function () {
            var table = $('#table').DataTable({
                destroy: true,
                "processing": true,
                "serverSide": true,
                paging: true,
                ajax: {
                    url: '{{ route('vne.schools.data') }}',
                    error: function (xhr, error, thrown) {
                        alert( 'You are not logged in' );
                    }
                },
                columns: [
                    {data: '_id', name: '_id'},
                    {data: 'schoolname', name: 'schoolname'},
                    {data: 'schoollevel', name: 'schoollevel'},
                    {data: 'schooladdress', name: 'schooladdress'},
                    {data: 'schoolphone', name: 'schoolphone'},
                    {data: 'schoolprovince', name: 'schoolprovince'},
                    {data: 'schooldistrict', name: 'schooldistrict'},
                    {data: 'pclass', name: 'pclass'},
                    {data: 'schoolmem', name: 'schoolmem'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
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
    <div class="modal fade" id="memdetail" tabindex="-1" role="dialog" aria-labelledby="memdetail"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
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

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-administration::language.titles.provine_city.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
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
                        @if ($USER_LOGGED->canAccess('dhcd.administration.provine-city.create'))
                            <a href="{{ route('dhcd.administration.provine-city.create') }}" class="btn btn-sm btn-default"><span
                            class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-administration::language.buttons.create') }}</a>
                        @endif
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">#</th>
                                {{-- <th>{{ trans('dhcd-administration::language.table.provine_city.name') }}</th>   --}}
                                <th>{{ trans('dhcd-administration::language.table.provine_city.name') }}</th>
                                <th>{{ trans('dhcd-administration::language.table.provine_city.code') }}</th>
                                <th class="fit-content" style="width: 120px">{{ trans('dhcd-administration::language.table.action') }}</th>
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
    <script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dhcd.administration.provine-city.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'provine_city_id' },
                    { data: 'name_with_type', name: 'name_with_type'},
                    { data: 'code', name: 'code'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                language: $.parseJSON('{!! $DATATABLE_TRANS !!}')
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

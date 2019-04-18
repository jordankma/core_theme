@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contest::language.titles.user_field.manage') }}@stop

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
                        <a href="{{ route('contest.exam.user_field.create') }}" class="btn btn-sm btn-default"><span
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
                                <th>{{ trans('contest-contest::language.table.user_field.label') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.varible') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.type_name') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.hint_text') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.data_view') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.description') }}</th>
                                <th>{{ trans('contest-contest::language.table.user_field.require') }}</th>
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
                ajax: '{{ route('contest.exam.user_field.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'field_id' },
                    { data: 'label', name: 'label' },
                    { data: 'varible', name: 'varible' },
                    { data: 'type_name', name: 'type_name' },
                    { data: 'hint_text', name: 'hint_text' },
                    { data: 'data_view', name: 'data_view' ,"render": function () {
                            return '';
                        }},
                    { data: 'description', name: 'description' },
                    { data: 'require', name: 'require', "render": function (data, type, row, meta) {
                        var html = '';
                            if(row['is_default'] == 1){
                                html += '<p>Trường mặc định </p>';
                            }
                            if(row['is_search'] == 1){
                                html += '<p>Cho phép lọc trong tra cứu </p>';
                            }
                            if(row['is_require'] == 1){
                                html += '<p>Bắt buộc nhập </p>';
                            }
                            if(row['show_on_info'] == 1){
                                html += '<p>Hiển thị trong tra cứu thông tin </p>';
                            }
                            if(row['show_on_result'] == 1){
                                html += '<p>Hiển thị trong tra cứu kết quả </p>';
                            }
                            return html;
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

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.group_exam.list_candidate') }}@stop

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
            <li class="active"><a href="#">{{ $title  }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                         data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title . ' '. $group_exam->name}}
                    </h4>
                    <div class="pull-right">
                        <a href="javascript:void(0)" class="btn btn-sm btn-default add_candidate" c-data="{{ $group_exam->group_exam_id }}"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.group_exam.add') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.gender') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.city') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.district') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.school') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
    <div class="modal fade in" id="list_candidate" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mr-auto">Danh sách thí sinh</h4>
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
                ajax: {
                    "url":'{{ route('contest.contestmanage.group_exam.data_candidate') }}',
                    data: {group_exam_id: '{{ $group_exam->group_exam_id }}'}
                },
                columns: [
                    { data: 'member_id', name: 'member_id' },
                    { data: 'name', name: 'name' },
                    { data: 'gender', name: 'gender' },
                    { data: 'city', name: 'city' },
                    { data: 'district', name: 'district' },
                    { data: 'school', name: 'school' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content' }
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
        $('body').on('click','.add_candidate', function () {
            var group_exam_id = $(this).attr('c-data');
            var route = '{{ route('contest.contestmanage.group_exam.get_list_candidate') }}';
            $.post(route, {group_exam_id: group_exam_id}, function (res) {
                if(res){
                    $('#list_candidate').attr('c-data', group_exam_id);
                    $('#list_candidate .modal-body').html('');
                    $('#list_candidate .modal-body').html(res);
                    $('#list_candidate').modal();
                }
            })
        });
        $('body').on('click','.choose', function () {
            var id = $(this).attr('c-data');
            var group_exam_id = $('#list_candidate').attr('c-data');
            var route = '{{ route('contest.contestmanage.group_exam.add_candidate') }}';
            $.post(route, {member_id: id, group_exam_id:group_exam_id}, function (res) {
                window.location.reload();
            })
        });
    </script>
@stop

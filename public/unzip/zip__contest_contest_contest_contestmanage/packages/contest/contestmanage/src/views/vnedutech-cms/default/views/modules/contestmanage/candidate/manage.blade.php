@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.candidate.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .text-on-pannel {
            background: #fff none repeat scroll 0 0;
            height: auto;
            margin-left: 20px;
            padding: 3px 5px;
            position: absolute;
            margin-top: -47px;
            /*border: 1px solid #337ab7;*/
            /*border-radius: 8px;*/
        }

        .panel {
            /* for text on pannel */
            margin-top: 27px !important;
        }

        .panel-body {
            padding-top: 30px !important;
        }
        .form-group{
            overflow: hidden;
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
                    {{--<div class="pull-right">--}}
                        {{--<a href="{{ route('contest.contestmanage.candidate.create') }}" class="btn btn-sm btn-default"><span--}}
                                    {{--class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>--}}
                    {{--</div>--}}
                </div>
                <br/>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.name') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.username') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.city') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.district') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.school') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.class') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.candidate.gender') }}</th>
{{--                                <th>{{ trans('contest-contestmanage::language.table.action') }}</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td>{{$candidate->_id}}</td>
                                    <td>{{$candidate->name}}</td>
                                    <td>{{$candidate->u_name}}</td>
                                    <td>{{$candidate->city_name}}</td>
                                    <td>{{$candidate->district_name}}</td>
                                    <td>{{$candidate->school_name}}</td>
                                    <td>{{$candidate->class_id}}</td>
                                    <td>{{$candidate->gender}}</td>
                                    {{--<td><a href="javascript:void(0)" class="choose" c-data="{{$candidate->member_id}}"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="choose"></i></a></td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $candidates->links() }}
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
            {{--var table = $('#table').DataTable({--}}
                {{--processing: true,--}}
                {{--serverSide: false,--}}
                {{--destroy:true,--}}
                {{--ajax: '{{ route('contest.contestmanage.candidate.data') }}',--}}
                {{--columns: [--}}
                    {{--{ data: '_id', name: '_id' },--}}
                    {{--{ data: 'name', name: 'name', defaultContent: '' },--}}
                    {{--{ data: 'u_name', name: 'u_name', defaultContent: '' },--}}
                    {{--{ data: 'city_name', name: 'city_name', defaultContent: '' },--}}
                    {{--{ data: 'district_name', name: 'district_name', defaultContent: '' },--}}
                    {{--{ data: 'school_name', name: 'school_name', defaultContent: '' },--}}
                    {{--{ data: 'class_id', name: 'class_id', defaultContent: '' },--}}
                    {{--{ data: 'gender', name: 'gender', defaultContent: '' },--}}
                    {{--{ data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}--}}
                {{--],--}}
                {{--language: $.parseJSON('{!! json_encode(trans("adtech-core::datatable")) !!}')--}}
            {{--});--}}
            {{--table.on('draw', function () {--}}
                {{--$('.livicon').each(function () {--}}
                    {{--$(this).updateLivicon();--}}
                {{--});--}}
            {{--});--}}
            {{--table.on( 'order.dt search.dt', function () {--}}
                {{--table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {--}}
                    {{--cell.innerHTML = i+1;--}}
                {{--} );--}}
            {{--} ).draw();--}}
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

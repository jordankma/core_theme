@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-member::language.titles.member.manage') }}@stop

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
                    <h4 class="panel-title pull-left">
                        <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title }}
                    </h4>
                    <div class="pull-right">
                        @if ($USER_LOGGED->canAccess('dhcd.member.member.create'))
                            <a href="{{ route('dhcd.member.member.create') }}" class="btn btn-sm btn-default"><span
                        class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-member::language.buttons.create') }}</a>
                        @endif
                    </div>
                </div>
                <br/>
                <div style="margin-left:20px">
                    <div style="display: inline-block;">
                        @if ($USER_LOGGED->canAccess('dhcd.member.member.excel.get.import'))
                        <a href="{{route('dhcd.member.member.excel.get.import')}}" class="btn btn-success">
                            <i class="fa fa-picture-o"></i> Import Excel
                        </a>
                        @endif
                    </div>
                    {{-- <div style="display: inline-block;">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
                            <i class="fa fa-picture-o"></i> Export Excel
                        </a>
                    </div> --}}
                </div>
                @if (count($errors)>0) 
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $loi)
                            {{$loi}}<br>
                        @endforeach   
                    </div>
                @endif
                @if (session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}    
                    </div>   
                @endif
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">#</th>
                                <th>{{ trans('dhcd-member::language.table.member.name') }}</th>
                                <th>{{ trans('dhcd-member::language.table.member.position_current') }}</th>
                                <th>{{ trans('dhcd-member::language.table.member.group') }}</th>
                                <th>{{ trans('dhcd-member::language.table.member.trinh_do_chuyen_mon') }}</th>
                                <th>{{ trans('dhcd-member::language.table.member.trinh_do_ly_luan') }}</th>
                                <th class="fit-content">{{ trans('dhcd-member::language.table.action') }}</th>
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
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dhcd.member.member.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'DT_Row_Index' },
                    { data: 'name', name: 'name' },
                    { data: 'position', name: 'position' },
                    { data: 'group', name: 'group' },
                    { data: 'trinh_do_chuyen_mon', name: 'trinh_do_chuyen_mon' },
                    { data: 'trinh_do_ly_luan', name: 'trinh_do_ly_luan' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'fit-content'}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });
            var domain = "/admin/laravel-filemanager/";
            $('#lfm').filemanager('file', {prefix: domain});
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="block_confirm" tabindex="-1" role="dialog" aria-labelledby="user_block_confirm_title"
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

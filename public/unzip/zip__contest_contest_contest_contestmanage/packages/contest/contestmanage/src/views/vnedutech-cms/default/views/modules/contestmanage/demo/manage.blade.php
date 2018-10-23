@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.demo.manage') }}@stop

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
                        <a href="{{ route('contest.contestmanage.demo.create') }}" class="btn btn-sm btn-default"><span
                                    class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</a>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="container">
                        <div class="search-wrapper">
                            <div class="headline"><i class="fa fa-search"></i> Tra cứu danh sách thí sinh</div>
                            <form action="{{route('vne.memberfrontend.search.result.member')}}" class="search-form" method="get">
                                <div class="wrapper">
                                    <div class="form-group col-4">
                                        <label for="bangThi">Chọn bảng</label>
                                        <select class="form-control" name="table_id">
                                            <option value="0">Chọn bảng</option>
                                            @if(!empty($list_table))
                                                @foreach ($list_table as $element)
                                                    <option value="{{ $element->table_id }}" @if($element->table_id==$params['table_id']) selected="" @endif>{{ $element->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="name">Họ tên</label>
                                        <input type="name" class="form-control" value="{{$params['name']}}" placeholder="Họ tên" name="name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="provinceCity">Chọn tỉnh/thành phố</label>
                                        <select class="form-control" name="city_id">
                                            <option value="0">Chọn tỉnh/thành phố</option>
                                            @if(!empty($list_city))
                                                @foreach ($list_city as $element)
                                                    <option value="{{ $element->city_id }}" @if($element->city_id==$params['city_id']) selected="" @endif>{{ $element->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="district">Quận/huyện</label>
                                        <select class="form-control" name="district_id">
                                            <option value="0">Chọn quận/huyện</option>
                                            @if(!empty($list_district))
                                                @foreach ($list_district as $element)
                                                    <option value="{{ $element->district_id }}" @if($element->district_id==$params['district_id']) selected="" @endif>{{ $element->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="school">Trường</label>
                                        <select class="form-control" name="school_id">
                                            <option value="0">Chọn trường</option>
                                            @if(!empty($list_school))
                                                @foreach ($list_school as $element)
                                                    <option value="{{ $element->school_id }}" @if($element->school_id==$params['school_id']) selected="" @endif>{{ $element->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="class">Lớp</label>
                                        <input type="text" class="form-control" value="{{$params['class_id']}}" placeholder="Lớp" name="class_id">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="fit-content">{{ trans('adtech-core::common.sequence') }}</th>
                                <th>{{ trans('contest-contestmanage::language.table.demo.name') }}</th>
                                <th style="width: 120px">{{ trans('contest-contestmanage::language.table.created_at') }}</th>
                                <th style="width: 120px">{{ trans('contest-contestmanage::language.table.updated_at') }}</th>
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
                ajax: '{{ route('contest.contestmanage.demo.data') }}',
                columns: [
                    { data: 'DT_Row_Index', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at'},
                    { data: 'updated_at', name: 'updated_at'},
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

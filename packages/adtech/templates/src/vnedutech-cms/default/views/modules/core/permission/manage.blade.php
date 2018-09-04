@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('adtech-core::titles.permission.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/all.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/css/line/line.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/toastr/css/toastr.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/css/pages/toastr.css' }}" rel="stylesheet"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }} {{ $titleP }}</h1>
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
                </div>
                <br/>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th class="col-md-3">{{ trans('adtech-core::common.route.controller') }}</th>
                                <th>
                                    <table>
                                        <tr>
                                            <th class="col-md-3">View list</th>
                                            <th class="col-md-3">Create</th>
                                            <th class="col-md-3">Update</th>
                                            <th class="col-md-3">Delete</th>
                                        </tr>
                                    </table>
                                </th>
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
    <script type="text/javascript" src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js' }}"></script>
    <script type="text/javascript" src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js' }}"></script>
    <script type="text/javascript" src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js' }}"></script>

    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/toastr/js/toastr.min.js' }}"></script>
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/iCheck/js/icheck.js' }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/toastr/js/pages/ui-toastr.js' }}"></script>
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js' }}" type="text/javascript"></script>
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('adtech.core.permission.data') }}?object_type={{ $objectType }}&object_id={{ $objectId }}',
                columns: [
                    { data: 'controller', name: 'controller' },
                    { data: 'method', name: 'method' }
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });

                $('input[type="checkbox"].square').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                    increaseArea: '20%'
                });

                $('input[type="checkbox"].allow_permission').bootstrapSwitch({
                    onSwitchChange:function(event, state) {
                        $.ajax({
                            url: "{{ route('adtech.core.permission.set') }}",
                            method: "POST",
                            data: { object_type : '{{ $objectType }}', object_id : '{{ $objectId }}', allow : (state) ? 1 : 0, route_name : $(this).attr("data-name"), route_name1 : $(this).attr("data-name1")}
                        }).done(function( response ) {
                            if (typeof response.type !== 'undefined') {
                                if (response.type === 'success') {
                                    toastr.success(response.msg, response.group);
                                } else {
                                    toastr.error(response.msg, response.group);
                                }
                            }
                        });
                    }
                });
            });
        });

    </script>
@stop

<?php
header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token, x_csrftoken');
?>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="panel panel-primary ">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                 data-loop="true" data-c="#fff" data-hc="white"></i>
                Danh sách thí sinh
            </h4>
        </div>
        <br/>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table_item">
                    <thead>
                    <tr class="filters">
                        <th class="fit-content">{{ trans('contest-contestmanage::language.table.id') }}</th>
                        <th>{{ trans('contest-contestmanage::language.table.candidate.name') }}</th>
                        <th>{{ trans('contest-contestmanage::language.table.action') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
<script>

    var table = $('#table_item').DataTable({
        processing: true,
        serverSide: false,
        destroy: true,
        ajax: {
            "url":'{{ route('contest.contestmanage.candidate.get_list') }}',
            data: {group_exam_id: parseInt('{{ $group_exam_id }}')}
        },
        columns: [
            { data: 'member_id', name: 'member_id', defaultContent: '' },
            { data: 'name', name: 'name', defaultContent: '' },
            { data: 'member_id', name: 'actions', orderable: false, searchable: false, className: 'fit-content', "render": function (data, type, row, meta) {
                return '<a href="javascript:void(0)" c-data="' +data+  '" d-data="' + row['name'] + '" class="btn btn-success choose">Chọn</a>';
            }}
        ]
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

</script>


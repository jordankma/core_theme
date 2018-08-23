@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.tag.manage') }}@stop

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
                <h4 class="panel-title pull-left" style="padding-top: 5px;">
                    Danh sách
                </h4>
                <div class="pull-right">                   
                    @if ($USER_LOGGED->canAccess('dhcd.document.tag.create'))
                      <a href="{{ route('dhcd.document.tag.create') }}" class="btn btn-sm btn-default"><span
                            class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-document::language.buttons.create') }}</a>
                    @endif        
                </div>
            </div>
            <br/>
            <div class="panel-body">
                
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box danger">
                    
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>                                                                            
                                        <th>{{ trans('dhcd-document::language.table.name') }}</th>
                                        <th>{{ trans('dhcd-document::language.table.alias') }}</th>
                                        <th>{{ trans('dhcd-document::language.table.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                    @if(!empty($tags))
                                        @foreach($tags as $i => $tag)
                                        <tr>
                                            <td>{{ $i = $i +1 }}</td>
                                            <td>{{ $tag->name }}</td>
                                            <td>{{ $tag->alias }}</td>
                                            <td>
                                                @if ($USER_LOGGED->canAccess('dhcd.document.tag.log'))                                                
                                                    <a href='{{route('dhcd.document.tag.log',['type' => 'dhcd_tag', 'subject_id' => $tag['tag_id']])}}' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log document"></i></a>
                                                @endif
                                                                                            
                                                @if ($USER_LOGGED->canAccess('dhcd.document.tag.edit'))
                                                    <a href='{{route('dhcd.document.tag.edit',['tag_id' => $tag['tag_id']])}}'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="{{ trans('dhcd-document::language.buttons.edit') }}"></i></a>
                                                @endif
                                                @if ($USER_LOGGED->canAccess('dhcd.document.tag.delete'))
                                                    <a href='{{route('dhcd.document.tag.delete',['tag_id' => $tag['tag_id']])}}' onclick="return confirm('Bạn có chắc chắn muốn xóa?')" ><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="{{ trans('dhcd-document::language.buttons.delete') }}"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif                                                                        
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- END BORDERED TABLE PORTLET-->
                </div>
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

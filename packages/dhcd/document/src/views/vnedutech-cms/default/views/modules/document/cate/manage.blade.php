@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.doucment_cate.manage') }}@stop

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
                    {{ trans('dhcd-document::language.document_cate.table.title') }}
                </h4>
                <div class="pull-right">                   
                    @if ($USER_LOGGED->canAccess('dhcd.document.cate.add'))
                      <a href="{{ route('dhcd.document.cate.add') }}" class="btn btn-sm btn-default"><span
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
                                        
                                        <th>{{ trans('dhcd-document::language.document_cate.table.icon') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_cate.table.name') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_cate.table.parent_id') }}</th>
                                        <th>{{ trans('dhcd-document::language.document_cate.table.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                    @if(!empty($cates))
                                        {{$objCate->showIsTableCategories($cates, $parents, $USER_LOGGED)}}
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

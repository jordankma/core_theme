@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.document.manage') }}@stop

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
                <h4 class="panel-title pull-left" style="padding-top: 5px;">
                    {{ trans('dhcd-document::language.document.table.title') }}
                </h4>
                <div class="pull-right">                   
                    @if ($USER_LOGGED->canAccess('dhcd.document.doc.add'))
                     <a href="{{ route('dhcd.document.doc.add') }}" class="btn btn-sm btn-default">
                         <span class="glyphicon glyphicon-plus"></span> {{ trans('dhcd-document::language.buttons.create') }}
                     </a>
                    @endif
                </div>
               
            </div>
            <br/>
            <div class="panel-body">
                
                
                <div class="row">
                    <form id="search-form" class="form-horizontal" name='search-form' id='search-form' action="{{route('dhcd.document.doc.manage')}}" method="get">
                        <div class="col-md-1">
                            <div class="show-entries">                                
                                <select class="form-control show-page-limit" name="limit" style="width: 80px;">
                                    <option value="10" @if($request->limit == 10) selected @endif >10</option>
                                    <option value="20" @if($request->limit == 20) selected @endif>20</option>
                                    <option value="50" @if($request->limit == 50) selected @endif>50</option>
                                    <option value="100" @if($request->limit == 100) selected @endif>100</option>
                                </select>                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="show-entries">                                
                                <select class="form-control show-page-sort" name="sort" style="width: 120px;">
                                    <option value="desc" @if($request->sort == 'desc') selected @endif >{{ trans('dhcd-document::language.placeholder.document.sort_desc') }}</option>
                                    <option value="asc" @if($request->sort == 'asc') selected @endif>{{ trans('dhcd-document::language.placeholder.document.sort_asc') }}</option>                                  
                                </select>                                
                            </div>
                        </div>
                        <div class="col-md-4">
                                <input placeholder="{{ trans('dhcd-document::language.placeholder.document.name') }}" id="name" name="name" type="text"  value="{{old('name',!empty($request->name) ? $request->name : '')}}" class="form-control">                            
                       </div>     
                        <div class='col-md-2'>                                
                            <select class="form-control" name="document_type_id" >
                                <option value="0">{{ trans('dhcd-document::language.placeholder.document.type') }}</option>
                                @if(!empty($types))
                                    @foreach($types as $type)
                                    <option value="{{$type['document_type_id']}}" @if( $request->document_type_id == $type['document_type_id'] ) selected @endif >{{$type['name']}}</option>   
                                    @endforeach
                                @endif                                                                        
                            </select>                                                                                                                                            
                        </div>
                         <div class='col-md-2'>                                
                            <select class="form-control" name="document_cate_id" >
                                <option value="0">{{ trans('dhcd-document::language.placeholder.document.cate') }}</option>
                                    @if(!empty($cates)))
                                        {{$cateObj->showCategories($cates,$request->document_cate_id)}}
                                    @endif                                                                       
                            </select>                                                                                                                                            
                        </div>
                        <div class='col-md-1'>                                
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>                                                                                                                                           
                        </div>
                    </form>
                </div>
                
                
                <!-- BEGIN BORDERED TABLE PORTLET-->
                <div class="portlet box danger">
                    
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('dhcd-document::language.document.table.name') }}</th>
                                        <th>{{ trans('dhcd-document::language.document.table.file') }}</th>
                                        <th>{{ trans('dhcd-document::language.document.table.document_type_id') }}</th>
                                        <th>{{ trans('dhcd-document::language.document.table.document_cate_id') }}</th>                                        
                                        <th>{{ trans('dhcd-document::language.document.table.desc') }}</th>
                                        <th>{{ trans('dhcd-document::language.document.table.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @if(!empty($documents->toArray()['data']))
                                    @foreach($documents->toArray()['data'] as $key => $doc)
                                    <tr>
                                        <td>{{$key = $key +1}}</td>
                                        <td>{{$doc['name']}}</td>
                                        <td>
                                            @if(!empty($doc['avatar']) || !empty($doc['icon']))
                                                @if(!empty($doc['avatar']))
                                                    <img width="50px" src="{{$doc['avatar']}}" >
                                                @else    
                                                    <img width="50px" src="{{$doc['icon']}}" >
                                                @endif    
                                            @else                                                
                                                <i class="fa fa-file fa-5x"></i>
                                            @endif
                                        </td>
                                        <td>
                                           
                                           <span class="label label-sm label-warning">{{!empty($doc['get_type']) ? $doc['get_type']['name'] : ''}}</span>
                                        </td>
                                        <td>
                                            @if(!empty($doc['get_document_cate']))
                                                @foreach($doc['get_document_cate'] as $cate)
                                                <span class="label label-sm label-success">{{$cate['name']}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ \Illuminate\Support\Str::words($doc['descript'],30) }}</td>                                      
                                        <td>
                                            @if ($USER_LOGGED->canAccess('dhcd.document.doc.log'))                                                
                                                <a href='{{route('dhcd.document.doc.log',['type' => 'documents', 'subject_id' => $doc['document_id']])}}' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log document"></i></a>
                                            @endif
                                                                                        
                                            @if ($USER_LOGGED->canAccess('dhcd.document.doc.edit'))
                                                <a href='{{route('dhcd.document.doc.edit',['document_id' => $doc['document_id']])}}'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="{{ trans('dhcd-document::language.document.table.edit') }}"></i></a>
                                            @endif
                                            @if ($USER_LOGGED->canAccess('dhcd.document.doc.delete'))
                                                <a href='{{route('dhcd.document.doc.delete',['document_id' => $doc['document_id']])}}' onclick="return confirm('Bạn có chắc chắn muốn xóa?')" ><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="{{ trans('dhcd-document::language.document.table.delete') }}"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach       
                                    @endif
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="dataTables_paginate paging_simple_numbers">                                
                            <ul class="pagination">
                                @if(!empty($params))
                                {{$documents->appends(['document_cate_id' => $params['document_cate_id'],'document_type_id' => $params['document_type_id'], 'name' => $params['name'],'limit' => $params['limit']])->links('DHCD-DOCUMENT::modules.document.doc.pagination') }}                            
                                @else
                                {{$documents->links('DHCD-DOCUMENT::modules.document.doc.pagination') }}                            
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- END BORDERED TABLE PORTLET-->
                </div>
            </div>
        </div>
    </div>
</div>    <!-- row-->
</section>
<
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
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
    $('body').on('change','.show-page-limit',function(){
        $("#search-form").submit();
    });
    $('body').on('change','.show-page-sort',function(){
        $("#search-form").submit();
    });
});
</script>
@stop

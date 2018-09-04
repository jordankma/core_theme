@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.document.edit') }}@stop

{{-- page styles --}}
@section('header_styles')
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css"/>  
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
<style>
    .control-label{
        text-align: left !important;
    }
    .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover{
        background-color: #cccccc;
    }
</style>
@stop
<!--end of page css-->

@php
$list_file = !empty($document->file) ? json_decode($document->file,true) : '';
$document_type = !empty($document->getType) ? $document->getType->type : '';
$arr_tag = [];
if(!empty($document->getTags->toArray())){
    foreach($document->getTags->toArray() as $tag){
        $arr_tag[] = $tag['tag_id'];
    }    
}
@endphp


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>{{ $title }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('dhcd.document.doc.manage')}}">
                <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('adtech-core::labels.home') }}
            </a>
        </li>
        <li class="active"><a href="#">{{ $title }}</a></li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <!--main content-->
    <div class="row">

        <div class="the-box no-border">

            <form data-toggle="validator" role="form" id="form-add-document" class="form-horizontal" action="{{route('dhcd.document.doc.update',['document_id'=>$document->document_id])}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type='hidden' id='type_control' name='type_control' value="{{$document_type}}">
                <input type='hidden' id='mutil' name='mutil' value="remove">
                <input type='hidden' id='isIcon' name='isIcon' value="1">
                <fieldset>
                    <!-- Name input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">{{trans('dhcd-document::language.document.form.name')}}</label>
                        <div class=" col-md-6 ">
                            <input id="name" name="name" type="text" placeholder="{{trans('dhcd-document::language.placeholder.document.name')}}" value="{{old('name',isset($document) ? $document->name : '')}}" class="form-control">                                
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('dhcd-document::language.document.form.type')}}</label>                       
                        
                        <div class="col-md-6">                                                        
                            <label class="radio-inline radio radio-primary">
                                <input checked id="is_reserve" @if($document->is_reserve == 1) checked @endif type="checkbox" name="is_reserve" value="1">
                                <label style="padding: 0px 10px 0px 5px;" for="is_reserve">Đại biểu mời</label>
                            </label>
                            <label class="radio-inline radio radio-primary">
                                <input id="is_offical" @if($document->is_offical == 1) checked @endif type="checkbox" name="is_offical" value="1">
                                <label style="padding: 0px 10px 0px 5px;" for="is_offical">Đại biểu chính thức</label>
                            </label>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="document_type_id">{{trans('dhcd-document::language.document.form.document_cate_id')}}</label>
                        <div class="col-md-6">
                            <select id="document_cate_id" multiple="multiple" class="form-control" name="document_cate_id[]">
                                @if(!empty($cates))
                                {{$cateObj->showIsCategories($cates,$cateIds)}}
                                @endif
                            </select>
                        </div>     
                    </div> 
                     <!-- tag input-->
                     <div class="form-group">
                            <label class="col-md-2 control-label" for="name">Tag</label>
                            <div class=" col-md-6 ">
                            <select id="tag" name="tag[]" class="form-control select2" multiple>
                                @if(!empty($tags))
                                    @foreach($tags as $tag)
                                    <option @if(in_array($tag['tag_id'],$arr_tag)) selected @endif value="{{$tag['tag_id']}}">{{$tag['name']}}</option>
                                    @endforeach
                                @endif
                            </select>                                
                            </div>
                    </div>               
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="desc">{{trans('dhcd-document::language.document.form.desc')}}</label>
                        <div class=" col-md-6 ">
                            <textarea id="descript" name="descript" class="form-control" rows="5"> {{$document->descript}}</textarea>                               
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('dhcd-document::language.document.form.document_type_id')}}</label>
                        <div class="col-md-6">
                            @foreach($types as $type)                                
                            <label class="radio-inline radio radio-primary">
                                <input class='choice-type' data-types='{{$type['extentions']}}' id="type_{{$type['document_type_id']}}" type="radio" name="document_type_id"  value="{{$type['document_type_id']}}" {{$document->document_type_id == $type['document_type_id'] ? 'checked' : ''}} >
                                <label style="padding: 0px 10px 0px 5px;" for="type_{{$type['document_type_id']}}">{{$type['name']}}</label>
                            </label>
                            @endforeach             
                        </div>

                    </div>

                   <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.icon') }}</label>
                            <div class="col-md-6">
                                 <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="icon_doc" data-choice="icon" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="icon" value="{{old('icon',isset($document) ? $document->icon : '')}}">
                                 </div>
                                 <img id="holder" style="margin-top:15px;max-height:100px;display:block; " src=" {{old('icon',isset($document) ? $document->icon : '')}}">
                            </div>
                    </div>    

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">{{trans('dhcd-document::language.document.form.file')}}</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-choice="files" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                
                            </div>
                            
                        </div>
                    </div>
                    @if(!empty($list_file))
                    <div class="form-group " id="list-item" >
                        <label class="col-md-2 control-label">{{trans('dhcd-document::language.document.form.list_file')}}</label>
                        <div class="col-md-10" >
                            <table class="table table-striped table-bordered table-list" style='font-size: 12px;'>
                                <thead>
                                <th>File</th>
                                <th>Tên</th>
                                <th>Ảnh đại diện</th>
                                <th>Action</th>
                                </thead>
                                <tbody id="list-file">
                                    @foreach($list_file as $file)

                                    <tr class="{{$file['name']}}">
                                        <td>
                                            @if($document_type == 'image')
                                            <img src="{{$file['path']}}" width="75px">
                                            @else
                                            <i class="fa fa-file fa-5x"></i>
                                            @endif
                                        </td>
                                        <td>{{$file['name']}}</td>
                                        <td>
                                            @if($document_type == 'image')
                                            <input type="radio"  name="setAvatar"  value="{{$file['path']}}" @if($document->avatar == $file['path']) checked @endif >
                                            @endif       
                                        </td>
                                        <td>
                                            <a href="javascrip::void(0,0)"  class="btn btn-danger del-media" ><span style="margin:0px;" class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                        </td>
                                        <input type="hidden" name="file_names[]" value="{{$file['name']}}">
                                        <input type="hidden" name="file_types[]" value="{{$file['type']}}">
                                        <input type="hidden" name="path[]" value="{{$file['path']}}">
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <!-- Form actions -->
                    <div class="form-group">
                        <div class="col-md- text-center">
                            @if ($USER_LOGGED->canAccess('dhcd.document.doc.edit'))                                    
                            <button type="submit" class="btn btn-responsive btn-primary btn-sm text-button">{{ trans('dhcd-document::language.buttons.save') }}</button>
                            @endif                                
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--main content ends-->
</section>
<div id="myTag" class="modal fade" role="dialog" >
    <div class="modal-dialog" style="width: 400px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title ">Chọn danh mục</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-tag" action="#" method="post">                                                                  
                    @foreach($cates as $cate)
                    <div class="form-group row">
                        <label class="checkbox-inline label-tag" >
                            <input type="checkbox" class="check-tag custom-checkbox" id="{{$cate['document_cate_id']}}" idTag="{{$cate['document_cate_id']}}" value="{{$cate['name']}}" >{{$cate['name']}}
                        </label>
                    </div>    
                    @endforeach                                            
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<!-- begining of page js -->
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>                        
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>

<script src="{{ asset('/vendor/laravel-filemanager/js/lfm2.js') }}" type="text/javascript" ></script>
<!--end of page js-->
<script>

$(function () {
    $("[name='permission_locked']").bootstrapSwitch();
});
var domain = "/admin/laravel-filemanager/";
$('#icon_doc').filemanager2('image', {prefix: domain  });  
$('#lfm').filemanager2('application', {prefix: domain});
$(document).ready(function () {

    $("#document_cate_id").multiselect({
        enableFiltering: true,
        includeSelectAllOption: true,
        buttonWidth: '367px',
        maxHeight: 600,
        dropUp: false,
        nonSelectedText: 'Chọn danh mục',
    });
    $("#tag").select2({
        theme: "bootstrap",
        placeholder: "Chọn tag"
    });

    $("#form-add-document").bootstrapValidator({
        excluded: ':disabled',
        fields: {

            name: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa nhập tên tài liệu'
                    }
                }

            },
            'document_cate_id[]': {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa chọn danh mục tài liệu'
                    }
                }
            },
            document_type_id: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa chọn kiểu tài liệu'
                    }
                }
            }
            
        }
    });
});

function setData(data) {
    $("#list-item").css('display', 'block');
    $("#type_control").val(data.type_file);
    var html = '';
    html += '<tr class="' + data.title + '">';
    html += '<td>';
    if (data.type_file === 'img')
    {
        html += '<img src="' + data.src + '" width="75px">'
    } else {
        html += '<i class="fa fa-file fa-5x"></i>';
    }
    html += '</td>';
    html += '<td>' + data.title + '</td>';

    if (data.type_file === 'img')
    {
        html += '<td><input type="radio" name="setAvatar"  value="' + data.src + '"></td>';
    } else {
        html += '<td></td>';
    }
    html += '<td><a href="javascrip::void(0,0)"  class="btn btn-danger del-media" >';
    html += '<span style="margin:0px;" class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
    html += '</a></td>'
    html += '<input type="hidden" name="file_names[]"  value="' + data.title + '">';
    html += '<input type="hidden" name="file_types[]"  value="' + data.type + '">';
    html += '<input type="hidden" name="path[]"  value="' + data.src + '">';
    html += '</tr>';
    if ($("tr").hasClass(data.title)) {
        console.log("File này đã được chọn");
    } else
    {
        console.log("Đã chọn");
        $("#list-file").append(html);        
    }
    
}
function reSetData() {
    $("#icon_file").html('<i class="fa fa-file fa-5x"></i>');
    $("#list-item").css('display', 'none');
    $("#icon_file").append('');


}
$('body').on('click', '.del-media', function () {
    $(this).parent().parent().remove();
});
$('body').on('change', '.choice-type', function (e) {    
    $("#list-file").html('');    
});

</script>
@stop

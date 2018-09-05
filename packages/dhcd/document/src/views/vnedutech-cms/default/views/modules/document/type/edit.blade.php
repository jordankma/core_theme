@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-document::language.titles.document_type.edit') }}@stop

{{-- page styles --}}
@section('header_styles')
<link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
<style>
    .control-label{
        text-align: left !important;
    }
    fieldset 
    {
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }	

    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 20%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
    .form-group{
        margin-bottom: 0px;
    }
</style>
@stop
<!--end of page css-->

@php
$image_extentions = !empty($types[0]) ? json_decode($types[0]['extentions'],true) : [];  
$text_extentions = !empty($types[1]) ? json_decode($types[1]['extentions'],true) : [];
$video_extentions = !empty($types[2]) ? json_decode($types[2]['extentions'],true) : [];
$audio_extentions = !empty($types[3]) ? json_decode($types[3]['extentions'],true) : [];
@endphp

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>{{ $title }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('dhcd.document.type.edit')}}">
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


            <form role="form" action="{{route('dhcd.document.type.update')}}" method="post" enctype="multipart/form-data" id='form-edit'>
                <div class="row">
                    
                
                        <div class="form-group">
                            <fieldset class="col-md-6">    	
                                <legend>Hình ảnh</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">                                                                                        
                                            <label class="checkbox-inline">
                                                &nbsp;<input  @if(in_array('image/jpeg',$image_extentions)) checked @endif type="checkbox" name='image[]' value="image/jpeg" class="custom-checkbox" >&nbsp;image/jpeg
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('image/jpg',$image_extentions)) checked @endif type="checkbox" name='image[]' value="image/jpg" class="custom-checkbox" >&nbsp;image/jpg
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('image/png',$image_extentions)) checked @endif type="checkbox" name='image[]' value="image/png" class="custom-checkbox" >&nbsp;image/png
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('image/gif',$image_extentions)) checked @endif type="checkbox" name='image[]' value="image/gif" class="custom-checkbox" >&nbsp;image/gif
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('JPEG Image',$image_extentions)) checked @endif type="checkbox" name='image[]' value="JPEG Image" class="custom-checkbox" >&nbsp;JPEG Image
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="col-md-6">    	
                                <legend>Văn bản</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">                                                                                        
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('docx',$text_extentions)) checked @endif  type="checkbox" name='text[]' value="docx" class="custom-checkbox" >&nbsp;docx
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('doc',$text_extentions)) checked @endif type="checkbox" name='text[]' value="doc" class="custom-checkbox" >&nbsp;doc
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('xls',$text_extentions)) checked @endif type="checkbox" name='text[]' value="xls" class="custom-checkbox" >&nbsp;xls
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('xlsx',$text_extentions)) checked @endif  type="checkbox" name='text[]' value="xlsx" class="custom-checkbox" >&nbsp;xlsx
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('pdf',$text_extentions)) checked @endif type="checkbox" name='text[]' value="pdf" class="custom-checkbox" >&nbsp;pdf
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('Microsoft Excel',$text_extentions)) checked @endif type="checkbox" name='text[]' value="Microsoft Excel" class="custom-checkbox" >&nbsp;Microsoft Excel
                                            </label>
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('Adobe Acrobat',$text_extentions)) checked @endif type="checkbox" name='text[]' value="Adobe Acrobat" class="custom-checkbox" >&nbsp;Adobe Acrobat
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="col-md-6">    	
                                <legend>Video</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">                                                                                        
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('mp4',$video_extentions)) checked @endif type="checkbox" name='video[]' value="mp4" class="custom-checkbox" >&nbsp;mp4
                                            </label>                                            
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="col-md-6">    	
                                <legend>Audio</legend>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">                                                                                        
                                            <label class="checkbox-inline">
                                                    &nbsp;<input @if(in_array('mp3',$audio_extentions)) checked @endif type="checkbox" name='audio[]' value="mp3" class="custom-checkbox" >&nbsp;mp3
                                            </label>                                            
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>                        
                                                                        
                </div>
                <div class='row' style="margin-top: 20px;">
                    <div class="form-group">
                            <div class="col-md-12 text-center">
                                @if ($USER_LOGGED->canAccess('dhcd.document.type.edit'))                                    
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">{{ trans('dhcd-document::language.buttons.save') }}</button>
                                @endif
                                
                            </div>
                        </div>
                </div>
                <!-- /.row -->
            </form>
        </div>
    </div>
    <!--main content ends-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<!-- begining of page js -->
<script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
<script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<!--end of page js-->
<script>
$(function () {
    $("[name='permission_locked']").bootstrapSwitch();
});

$("#form-edit").bootstrapValidator({
    excluded: ':disabled',
    fields: {

        'image[]': {
            validators: {
                notEmpty: {
                    message: 'Bạn chưa chọn định dạng file hình ảnh'
                }
            }
        },
        'text[]': {
            validators: {
                notEmpty: {
                    message: 'bạn chưa chọn định dạng file văn bản'
                }
            }
        },
        'video[]': {
            validators: {
                notEmpty: {
                    message: 'Bạn chưa chọn định dạng file video'
                }
            }
        },
        'audio[]': {
            validators: {
                notEmpty: {
                    message: 'bạn chưa chọn định dạng file audio'
                }
            }
        }
    }
});
</script>
@stop

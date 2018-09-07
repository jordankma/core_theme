@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-managefile::language.titles.demo.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <style>
        .control-label{
            text-align: left !important;
        }
    </style>
@stop
<!--end of page css-->

@php

@endphp

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ trans('dhcd-document::language.titles.doucment_cate.create') }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('dhcd.document.cate.manage')}}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ trans('dhcd-document::language.titles.doucment_cate.create') }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
           
            <div class="the-box no-border">
               
                <form class="form-horizontal" action="{{route('dhcd.document.cate.create')}}" method="post" enctype="multipart/form-data" id='form-add'>
                    {{ csrf_field() }}
                    <fieldset>
                        <!-- Name input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.name') }}</label>
                            <div class=" col-md-6 ">
                                <input id="name" name="name" value="{{old('name')}}" type="text" placeholder="{{ trans('dhcd-document::language.placeholder.document_cate.name') }}" class="form-control">
                                
                            </div>
                        </div>                                               
                        <!-- Message body -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="parent_id">{{ trans('dhcd-document::language.document_cate.form.parent_id') }}</label>
                            <div class="col-md-6"> 
                                <select name="parent_id" class="form-control" >
                                    <option value="0">Root</option>
                                    @if(!empty($cates))
                                        {{$objCate->showCategories($cates)}}
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
                                    <option value="{{$tag['tag_id']}}">{{$tag['name']}}</option>
                                    @endforeach
                                @endif
                            </select>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">{{ trans('dhcd-document::language.document_cate.form.icon') }}</label>
                            <div class="col-md-6">
                                 <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="icon">
                                 </div>
                                 <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                        <!-- sort input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">Sort</label>
                            <div class=" col-md-3">
                                <input id="sort" name="sort" type="number" value="{{old('sort')}}" placeholder="Thứ tự sắp xếp" class="form-control">                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="desc">{{trans('dhcd-document::language.document.form.desc')}}</label>
                            <div class=" col-md-6 ">
                                <textarea id="desc" name="descript" class="form-control" rows="5">{{old('descript')}} </textarea>                               
                            </div>
                        </div>
                        <!-- Form actions -->
                        <div class="form-group">
                            <div class="col-md-8 text-center">
                                 @if ($USER_LOGGED->canAccess('dhcd.document.cate.add'))                                    
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm text-button">{{ trans('dhcd-document::language.buttons.create') }}</button>
                                 @endif
                            </div>
                        </div>
                    </fieldset>
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
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        });
        // var domain = "/admin/laravel-filemanager/";
        $('#lfm').filemanager('image');
        
        $("#form-add").bootstrapValidator({
                excluded: ':disabled',
                fields: {

                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Bạn chưa nhập tên danh mục'
                            }
                        }                       
                    },
                    icon: {
                        trigger: 'change keyup',
                        validators: {                            
                            notEmpty: {
                                message: 'Bạn chưa chọn icon'
                            }
                        }
                        
                    }
                }
            });
            $("#tag").select2({
                theme: "bootstrap",
                placeholder: "Chọn tag"
            });
    </script>
@stop

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-topic::language.titles.topic.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }} </a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <!-- errors -->
                <form action="{{route('dhcd.topic.topic.add')}}" method="post" id="form-add-topic">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-7">
                        <label>{{trans('dhcd-topic::language.form.text.name') }}</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <input type="text" class="form-control" name="name" placeholder="{{trans('dhcd-topic::language.placeholder.topic.name_here')}}">
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                        <label>{{trans('dhcd-topic::language.form.text.desc') }}</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <textarea type="text" class="form-control" name="desc" placeholder="{{trans('dhcd-topic::language.placeholder.topic.desc_here')}}"></textarea>
                            <span class="help-block">{{ $errors->first('desc', ':message') }}</span>
                        </div>
                        <label>{{trans('dhcd-topic::language.form.text.topic_hot') }}</label>
                        <div class="form-group">
                            <input type="radio" name="is_hot" value="1" id="topic_hot"> <label for="topic_hot" > {{trans('dhcd-topic::language.form.text.hot') }} </label> 
                            <input type="radio" name="is_hot" value="2" id="topic_normal" checked=""> <label for="topic_normal" style="margin-right: 40px"> {{trans('dhcd-topic::language.form.text.normal') }} </label>
                        </div>
                        <label>{{trans('dhcd-topic::language.form.text.select_image') }}</label>
                        <div class="form-group">
                            <div class="input-group">
                               <span class="input-group-btn">
                                 <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                   <i class="fa fa-picture-o"></i> Chọn ảnh
                                 </a>
                               </span>
                               <input id="thumbnail" value="" class="form-control" type="text" name="image">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="form-group col-xs-12" style="margin-top: 20px;">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('dhcd-topic::language.buttons.create') }}</button>
                                <a href="{!! route('dhcd.topic.topic.manage') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-topic::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
        var domain = "/admin/laravel-filemanager/";
        $('#lfm').filemanager('image', {prefix: domain});
    </script>

    <script type="text/javascript">
        $('#form-add-topic').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa nhập tiêu đề'
                        },
                        stringLength: {
                            max: 250,
                            message: 'Tên không được quá dài'
                        }
                    }
                },
                image: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa chọn ảnh đại diện'
                        }
                    }
                }
            }
        });    
    </script>
@stop

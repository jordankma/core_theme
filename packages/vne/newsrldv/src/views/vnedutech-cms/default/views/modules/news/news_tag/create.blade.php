@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-newsrldv::language.titles.news_cat.add') }} @stop
{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <!--main content-->
    <section class="content paddingleft_right15">
            <div class="the-box no-border">
                <div class="row">
                        <form action="{{route('vne.newsrldv.tag.add')}}" method="post" id="form-add-cat">
                            <div class="col-md-5" style="">
                                <div class="form-group ui-draggable-handle" style="position: static;">
                                    <label for="input-text-1">{{trans('vne-newsrldv::language.label.name')}}</label>
                                    <input type="text" name="name" class="form-control" id="input-text-1" placeholder="{{trans('vne-newsrldv::language.form.tags_placeholder')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success">{{trans('vne-newsrldv::language.buttons.create')}}</button>
                                <a href="{{route('vne.newsrldv.tag.manager')}}" class="btn btn-danger">{{trans('vne-newsrldv::language.buttons.discard')}}</a>
                            </div>
                        </form>
                </div>
            </div>
    </section>
    <!--main content ends-->            
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vne/news/js/news_cat/add.js') }}" type="text/javascript" ></script>
    <!--end of page js-->
    <script type="text/javascript">
        $('#form-add-cat').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Bạn chưa nhập tên tag'
                        },
                        stringLength: {
                            max: 250,
                            message: 'Tên không được quá dài'
                        }
                    }
                }
            }
        });
    </script>
@stop

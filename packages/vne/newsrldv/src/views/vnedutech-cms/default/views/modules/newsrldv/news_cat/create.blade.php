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
                        <form action="{{route('vne.newsrldv.cat.add')}}" method="post" id="form-add-cat">
                            <div class="col-md-5" style="">
                                <div class="form-group ui-draggable-handle" style="position: static;">
                                    <label for="input-text-1">{{trans('vne-newsrldv::language.label_cat.name_category')}}</label>
                                    <input type="text" name="name" class="form-control" id="input-text-1" placeholder="{{trans('vne-newsrldv::language.form_cat.category_placeholder')}}">
                                </div>
                                <div class="form-group ui-draggable-handle" id="list-cat">
                                    <label for="select-1">{{ trans('vne-newsrldv::language.table.list_news.category') }}</label>
                                    <select class="form-control" id="select-1" name="parent_id">
                                        <option value="0">Root</option>
                                        @if(!empty($list_news_cat))
                                            @foreach($list_news_cat as $news_cat)
                                                <option value="{{$news_cat->news_cat_id}}">{{str_repeat('---', $news_cat->level) .$news_cat->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success">{{trans('vne-newsrldv::language.buttons.create')}}</button>
                                <a href="{{route('vne.newsrldv.cat.manager')}}" class="btn btn-danger">{{trans('vne-newsrldv::language.buttons.discard')}}</a>
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
                            message: 'Bạn chưa nhập chuyên đề'
                        },
                        stringLength: {
                            max: 250,
                            message: 'Tên không được quá dài'
                        }
                    }
                }
            }
        });
        $('#cat-child').change(function(){
            if(this.checked){   
                $(this).val("1");
                $('#list-cat').fadeIn();
            }
            else{
                $(this).val("0");
                $('#list-cat').fadeOut();
            }
        });
    </script>
@stop

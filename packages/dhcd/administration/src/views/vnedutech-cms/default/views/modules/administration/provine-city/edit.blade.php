@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-administration::language.titles.provine_city.edit') }}@stop

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
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <!-- errors -->
                <form action="{{route('dhcd.administration.provine-city.update')}}" method="post" id="form-add-provice-city">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="provine_city_id" value="{{$provine_city->provine_city_id}}">
                <div class="row">
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-8">
                        <label>{{ trans('dhcd-administration::language.label.name') }}</label>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value ="{{$provine_city->name}}" placeholder="{{ trans('dhcd-administration::language.placeholder.provine_city.name') }}">
                        </div>
                        <label> {{ trans('dhcd-administration::language.label.type') }}</label>
                        <div class="form-group">
                            <input type="radio" name="type"  value="tinh" id="tinh" @if($provine_city->type=='tinh') checked="checked" @endif> <label for="tinh"> Tỉnh </label>
                            <input type="radio" name="type"  value="thanh-pho" id="thanh-pho" @if($provine_city->type=='thanh-pho') checked="checked" @endif>  <label for="thanh-pho"> Thành phố </label>
                        </div>
                        <div class="form-group">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('dhcd-administration::language.buttons.update') }}</button>
                                <a href="{!! route('dhcd.administration.provine-city.create') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-administration::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        
                    </div>
                    <!-- /.col-sm-4 -->
                </div>
                </form>
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
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
    </script>
    <script type="text/javascript">
        $('#form-add-provice-city').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Tên không được bỏ trống'
                        },
                        stringLength: {
                            max: 200,
                            message: 'Tên không được quá dài'
                        }
                    }
                }
            }
        });    
    </script>
@stop

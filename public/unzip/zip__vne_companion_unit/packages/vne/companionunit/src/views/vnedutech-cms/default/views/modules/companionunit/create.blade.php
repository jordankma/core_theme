@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-companionunit::language.titles.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <style>
        .inputGroup {
            padding-top: 15px;
            background-color: #fff;
            display: block;
            margin: 5px 0;
            position: relative;
        }
        .inputGroup label {
            border-radius: 5px;
            padding: 12px 20px;
            width: 100%;
            display: block;
            text-align: left;
            color: #3C454C;
            cursor: pointer;
            position: relative;
            z-index: 2;
            transition: color 200ms ease-in;
            overflow: hidden;
        }
        .inputGroup label:before {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            content: "";
            background-color: #5562eb;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale3d(1, 1, 1);
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            z-index: -1;
        }
        .inputGroup label:after {
            padding-top: 10px;
            width: 32px;
            height: 32px;
            content: "";
            border: 2px solid #D1D7DC;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
            background-repeat: no-repeat;
            background-position: 2px 3px;
            border-radius: 50%;
            z-index: 2;
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            transition: all 200ms ease-in;
        }
        .inputGroup input:checked ~ label {
            color: #fff;
        }
        .inputGroup input:checked ~ label:before {
            transform: translate(-50%, -50%) scale3d(56, 56, 1);
            opacity: 1;
        }
        .inputGroup input:checked ~ label:after {
            background-color: #54E0C7;
            border-color: #54E0C7;
        }
        .inputGroup input {
            width: 32px;
            height: 32px;
            order: 1;
            z-index: 2;
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            visibility: hidden;
        }


        *,
        *::before,
        *::after {
            box-sizing: inherit;
        }

        html {
            box-sizing: border-box;
        }

    </style>
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
                {!! Form::model($comtype,array('url' => route('vne.companionunit.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'companionunitForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Nhóm Đơn Vị (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('comtype', 'has-error') }}">
                            <select class="form-control select2" id="comtype" name="comtype" required>
                                @if(isset($comtype))
                                    @foreach($comtype as $comtype)
                                        <option value="{{$comtype->id}}">{{$comtype->comgroup}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('comtype', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>{{ trans('vne-companionunit::language.label.comname') }} (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('comname', 'has-error') }}">
                            {!! Form::text('comname', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('vne-companionunit::language.placeholder.comname'))) !!}
                            <span class="help-block">{{ $errors->first('comname', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div  class="row">
                    <div class="col-sm-6">
                        <label>{{ trans('vne-companionunit::language.label.cominfo') }} :</label>
                        <div class="form-group {{ $errors->first('comlink', 'has-error') }}">
                            {!! Form::text('comlink', null, array('class' => 'form-control','placeholder'=> trans('vne-companionunit::language.placeholder.cominfo'))) !!}
                            <span class="help-block">{{ $errors->first('comlink', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div  class="row">
                    <div class="col-sm-6">
                        <label>{{ trans('vne-companionunit::language.label.comnote') }} :</label>
                        <div class="form-group {{ $errors->first('comnote', 'has-error') }}">
                            {!! Form::textarea('comnote', null, array('class' => 'form-control','placeholder'=> trans('vne-companionunit::language.placeholder.comnote'))) !!}
                            <span class="help-block">{{ $errors->first('comnote', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div  class="row">
                    <div class="col-sm-6">
                        <label>Hình ảnh đại diện (<span class="red">*</span>):</label>
                        <div class="input-group {{ $errors->first('img', 'has-error') }}">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="img" value="{{old('img')}}">
                        </div>
                        <img id="holder" src="{{old('img')}}" style="margin-top:15px;max-height:100px;">
                        <span class="help-block">{{ $errors->first('img', ':message') }}</span>
                        <br>
                    </div>
                </div>
                <hr>
                <div  class="row">
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('vne.companionunit.create') !!}"
                                   class="btn btn-danger">{!! trans('vne-companionunit::language.buttons.discard') !!}</a>
                            </div>
                        </div>
                    </div>
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
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
    <script type="text/javascript"
            src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/js/select2.js') }}"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        });
        $(function () {
            $('#lfm').filemanager('image');
        });
        $(function () {
            $(".select2").select2({
                theme: "bootstrap"
            });
        });
    </script>
@stop

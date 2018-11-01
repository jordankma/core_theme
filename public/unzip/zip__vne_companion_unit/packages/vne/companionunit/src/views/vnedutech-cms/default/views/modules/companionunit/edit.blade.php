@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-companionunit::language.titles.manage') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/select2/css/select2-bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <!--end of page css-->
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
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                {!! Form::model($Comunit,['url' => route('vne.companionunit.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="row">
                    <div class="col-sm-6">
                        <label>Nhóm Đơn Vị (<span class="red">*</span>):</label>
                        <div class="form-group {{ $errors->first('comtype', 'has-error') }}">
                            <select class="form-control select2" id="comtype" name="comtype" required>
                                <option value="{{$comtype->id}}">{{$comtype->comgroup}}</option>
                                @if(isset($comgroup))
                                    @foreach($comgroup as $comgroup)
                                    <option value="{{$comgroup->id}}">{{$comgroup->comgroup}}</option>
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
                        <label>{{ trans('vne-companionunit::language.label.cominfo') }} (<span class="red">*</span>):</label>
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
                        <label>Hình ảnh đại diện</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="img" value="{{$Comunit->img}}">
                        </div>
                        <img id="holder" src="{{asset($Comunit->img)}}" style="margin:25px 0px 25px 0px;max-height:100px;">
                        <br>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::hidden('id') !!}
                </div>
                <div  class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('vne.companionunit.create') !!}"
                               class="btn btn-danger">{{ trans('vne-companionunit::language.buttons.discard') }}</a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                {!! Form::close() !!}
            </div>
            @if ( $errors->any() )
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
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
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
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

@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-province::language.titles.update') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet"
          type="text/css">
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
                {!! Form::model($province, ['url' => route('vne.schools.province.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true]) !!}
                <div class="row">
                    <label class="col-sm-2 control-label"
                           for="province">{!! trans('vne-schools::language.label.province') !!}(<span
                                style="color: red">*</span>):</label>
                    <div class="col-sm-6">
                        <input id="province" name="province" type="text"
                               placeholder="{{ trans('vne-schools::language.placeholder.province') }}"
                               class="form-control" value="{{$province->province}}" required>
                        <span class="help-block">{{ $errors->first('province', ':message') }}</span>
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('_id') !!}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 control-label"
                           for="region">{!! trans('vne-schools::language.label.region') !!}(<span
                                style="color: red">*</span>):</label>
                    <div class="col-sm-6">
                        <select id="region" name="region" type="text" class="form-control">
                            <option value="{{ $province->region  }}">{{ $province->region  }}</option>
                            <option value="Miền Bắc">Miền Bắc</option>
                            <option value="Miền Trung">Miền Trung</option>
                            <option value="Miền Nam">Miền Nam</option>
                        </select>
                        <span class="help-block">{{ $errors->first('region', ':message') }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group ">
                        <div class="col-sm-3 col-sm-push-4">
                            <button type="submit"
                                    class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('vne.schools.province.create') !!}"
                               class="btn btn-danger">{{ trans('vne-schools::language.buttons.discard') }}</a>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script>
        $(function () {
            $("[name='permission_locked'], [name='status']").bootstrapSwitch();
        })
    </script>
@stop

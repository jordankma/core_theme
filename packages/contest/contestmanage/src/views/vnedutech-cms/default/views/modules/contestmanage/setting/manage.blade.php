@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('contest-contestmanage::language.titles.setting.manage') }}@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tab.css') }}" />
    <style>
        @media (min-width:320px) and (max-width:425px){
            .popover.left{
                width:100px !important;
            }
        }
        .nav-tabs .nav-link:hover {
            text-decoration: none;
            background-color: #eee ;
        }
        .nav-pills .nav-link:hover {
            text-decoration: none;
            background-color: #eee ;
        }
        .btn-default:hover{
            color: #fff;
        }
        .tab_panel .nav-link:active{
            background-color: rgba(255, 255, 255, .23);
        }
        .form-group{
            overflow: hidden;
        }
    </style>
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

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                         data-loop="true" data-c="#fff" data-hc="white"></i>
                        {{ $title }}
                    </h4>
                    <div class="pull-right">
                        <button class="btn btn-sm btn-default create"><span class="glyphicon glyphicon-plus"></span> {{ trans('contest-contestmanage::language.buttons.create') }}</button>
                    </div>
                </div>
                <br/>
                <div class="panel-body">
                    <div class="bs-example">
                        <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                            @if(!empty($setting))
                                @foreach($setting as $key => $item)
                                    <li class=" nav-item ">
                                        <a href="#{{ $item->param }}" data-toggle="tab" class="nav-link">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @if(!empty($setting))
                                @foreach($setting as $key => $item)
                                    <div class="tab-pane fade" id="{{ $item->param }}">
                                        {!! Form::open(array('url' => route('contest.contestmanage.setting.update',['param' => $item->param]), 'method' => 'post', 'class' => 'bf', 'id' => 'clientForm', 'files'=> true)) !!}
                                        <p class="m-r-6">
                                            <div id="item_container">
                                                @if(!empty($item->data))
                                                        @if($item->data_type == 'array')
                                                            @foreach($item->data as $key1 => $value1)
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Key</span>
                                                                            <input type="text" name="data[key][]" value="{{$value1['key']}}" class="form-control" id="key"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Value</span>
                                                                            <input type="text" name="data[value][]" value="{{$value1['value']}}" class="form-control" id="value"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @elseif($item->data_type == 'text')
                                                            <div class="form-group">
                                                                {!! Form::text('data', null, array('class' => 'form-control data', 'autofocus'=>'autofocus')) !!}
                                                            </div>
                                                        @elseif($item->data_type == 'number')
                                                            <div class="form-group">
                                                                {!! Form::number('data',0, array('class' => 'form-control data', 'autofocus'=>'autofocus')) !!}
                                                            </div>
                                                        @endif
                                                @endif
                                            </div>
                                            @if($item->data_type == 'array')
                                                <a href="javascript:void(0)" c-data="{{ $item->data_type }}" data-param="{{ $item->param }}" class="btn btn-default more_item">Thêm data</a>
                                            @endif
                                            <button class="btn btn-primary btn_update">Update</button>
                                        </p>
                                        {!! Form::close() !!}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
        <div class="modal fade" id="create_setting" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                        <h4 class="modal-title" id="user_delete_confirm_title">Tạo setting</h4>
                    </div>
                    <div class="modal-body">
                        <label>Tiêu đề (*)</label>
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {!! Form::text('name', null, array('class' => 'form-control name', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('label', ':message') }}</span>
                        </div>
                        <label>Biến định danh (*)</label>
                        <div class="form-group {{ $errors->first('param', 'has-error') }}">
                            {!! Form::text('param', null, array('class' => 'form-control param', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('param', ':message') }}</span>
                        </div>
                        <label>Loại dữ liệu (*)</label>
                        <div class="form-group {{ $errors->first('data_type', 'has-error') }}">
                            {!! Form::select('data_type',$data_type, 0, array('class' => 'form-control data_type', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.name_here'))) !!}
                            <span class="help-block">{{ $errors->first('data_type', ':message') }}</span>
                        </div>
                        <div id="number">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Hủy</button>
                        <a href="javascript:void(0)" type="button" class="btn btn-success btn_create">Tạo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/tabs_accordions.js') }}" type="text/javascript"></script>--}}
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
        $('body').on('click', '.create', function () {
            $('#create_setting').modal();
        });

        $('body').on('change', '.data_type', function () {
            $('#number').html('');
            var val = $(this).val();
            if(val == 'array'){
               var html = '<label>Số lượng phần tử (*)</label>' +
                        '<div class="form-group {{ $errors->first('element_number', 'has-error') }}">' +
                            '{!! Form::number('element_number', null, array('class' => 'form-control number','placeholder'=> trans('contest-contestmanage::language.placeholder.contest_client.name_here'))) !!}' +
                            '<span class="help-block">{{ $errors->first('element_number', ':message') }}</span>' +
                        '</div>';
                $('#number').html(html);
            }

        });
        $('body').on('click', '.btn_create', function () {
            var element_number = 0;
            var name = $('.name').val();
            var param = $('.param').val();
            var data_type = $('.data_type').val();
            if(data_type == 'array'){
                element_number = $('.number').val();
            }
            var route = '{{ route('contest.contestmanage.setting.add') }}';
            $.post(route, {name: name, param: param, data_type: data_type, element_number: element_number}, function (res) {
               if(res.status == true){
                   window.location.reload();
               }
            });
        });
        
        $('body').on('click', '.more_item', function () {
           var param = $(this).attr('data-param');
          var html = '<div class="form-group"> ' +
              '<div class="col-md-6"> <div class="input-group">' +
              '<span class="input-group-addon">Key</span>' +
              '<input type="text" name="data[key][]" class="form-control" id="key"/>' +
              '</div>' +
              '</div>' +
              '<div class="col-md-6"> <div class="input-group">' +
                '<span class="input-group-addon">Value</span>' +
              '<input type="text" name="data[value][]" class="form-control" id="value"/>' +
              '</div>' +
              '</div>' +
              '</div>';
          $('#'+param).find('#item_container').append(html);
        });

    </script>
@stop

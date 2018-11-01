@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-timeline::language.titles.timeline') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/timeline.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .card-title {
            background-color: #00c0ef;
            padding: 10px;
            border-radius: 5px 5px 0px 0px;
            margin-bottom: 0px !important;
        }
        .btn-group {
            float: right;
        }
        .control-label {
            font-family: "Times New Roman", Times, serif;
            padding-top: 6px;
            padding-right: 0px;
            width: 90px;
        }
        .dropdown-menu-right {
            margin-right: -10px !important;
            width: 30px !important;
        }
        a.dngaz:hover
        {
            color:white !important;
            font-weight:bold;
            background-color: #00c0ef !important;
        }
        .edit{
            float: right !important;
        }
        .delete{
            float: right !important;
        }
        .actions{
            padding: 4px !important;
            border-width: 0px !important;
            margin-top: -15px !important;
            margin-right: -10px !important;
        }
    </style>
@stop
<!--end of page css-->


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000" data-loop="true"></i>
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
            <div class="card-heading">
                <h3 class="card-title">
                    <i class="livicon" data-name="share" data-size="16" data-loop="true" data-c="#fff"
                       data-hc="white"></i>
                    Timeline
                </h3>
            </div>
            <div class="the-box no-border">
                <!-- errors -->
                {!! Form::open(array('url' => route('vne.timeline.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'timelineForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12 my-3">
                        <div class="card panel-primary">
                            <div class="card-body">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="col-md-3 col-lg-3 col-12 control-label" for="titles">Titles :</label>
                                                <div class="col-md-9 col-lg-9 col-12{{ $errors->first('titles', 'has-error') }} ">
                                                    <input name="titles" type="text" placeholder="{{ trans('vne-timeline::language.placeholder.titles') }}" class="form-control" autofocus required>
                                                    <span class="help-block">{{ $errors->first('titles', ':message') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label class="col-md-3 col-lg-3 col-12 control-label" for="time">Time :</label>
                                                <div class="col-md-9 col-lg-9 col-12{{ $errors->first('time', 'has-error') }} ">
                                                    <input name="time" type="text"  class="form-control" required>
                                                    <span class="help-block">{{ $errors->first('time', ':message') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-md-3 col-lg-3 col-12 control-label"
                                                           for="note">Note :</label>
                                                    <div class="col-md-9 col-lg-9 col-12{{ $errors->first('note', 'has-error') }} ">
                                                        {!! Form::textarea('note', null, array('class' => 'form-control','rows'=>'5','placeholder'=> trans('vne-timeline::language.placeholder.note'))) !!}
                                                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-push-5">
                                            <div class="form-group col-xs-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                                    <a href="{!! route('vne.timeline.create') !!}" class="btn btn-danger">{{ trans('vne-timeline::language.buttons.discard') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <!--timeline-->
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="timeline" id="timeline">
                                        </ul>
                                    </div>
                                </div>
                                <!--timeline ends-->
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/pages/datepicker.js') }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        });
        $('input[name="time"]').daterangepicker({
            format: 'DD-MM-YYYY',
            minDate: new Date()
        });
        $(document).ready(function () {
            $( function () {
                $.ajax({
                    type : 'GET',
                    url: '{{route('vne.timeline.data')}}',
                    success:function (data) {
                        var data = JSON.parse(data);
                        var arr='';
                        for (i = 0; i < data.length; i++) {
                            if(i%2){
                                arr +="<li class='timeline-inverted'><div class='timeline-badge danger'>"+
                                    "<i class='livicon' data-name='alarm' data-c='#fff' data-hc='#fff' data-size='18' data-loop='true'></i>"+
                                    "</div><div class='timeline-panel'>"+
                                    "<div class='btn-group'><button type='button' class='btn btn-primary btn-sm dropdown-toggle actions' data-toggle='dropdown'>"+
                                    "<i class='livicon' data-name='gear' data-size='16' data-loop='true' data-c='#fff' data-hc='white'></i>"+
                                    "<span class='caret'></span></button>"+
                                    "<ul class='dropdown-menu dropdown-menu-right ' role='menu'>"+
                                    "<li><a href='show?id="+data[i].id+"'  class='dngaz' data-toggle='modal' data-target='#edit'>Edit<i class='livicon edit' data-name='edit' data-size='18' data-loop='true' data-c='#428BCA' data-hc='#428BCA' title='update timeline'></i></a></li>"+
                                    "<li><a href='confirm-delete?id="+data[i].id+"'  class='dngaz' data-toggle='modal' data-target='#delete_confirm'>Delete<i class='livicon delete' data-name='trash' data-size='18' data-loop='true' data-c='#f56954' data-hc='#f56954' title='delete Comunit'></i></a></li>"+
                                    "</ul></div>"+
                                    "<div class='timeline-heading'>"+
                                    "<h4 class='timeline-title'>"+ data[i].titles+ "</h4>"+
                                    "</div><p><small class='text-muted'>"+
                                    "<i class='livicon' data-name='bell' data-c='#F89A14' data-hc='#F89A14' data-size='14' data-loop='true' data-hc='white'></i>" +"Từ :"+data[i].starttime +" "+"Đến :"+data[i].endtime +
                                    "</small></p><div class='timeline-body'>"+ data[i].note +"</p></div></div></li>";
                                $('#timeline').html('');
                                $('#timeline').append(arr);
                            }else{
                                arr +="<li><div class='timeline-badge'><i class='livicon' data-name='calendar' data-c='#fff' data-hc='#fff' data-size='18' data-loop='true'></i></div>" +
                                    "<div class='timeline-panel' style='display:inline-block;'>"+
                                    "<div class='timeline-heading'>" +
                                    "<div class='btn-group'><button type='button' class='btn btn-primary btn-sm dropdown-toggle actions' data-toggle='dropdown'>"+
                                    "<i class='livicon' data-name='gear' data-size='16' data-loop='true' data-c='#fff' data-hc='white'></i>"+
                                    "<span class='caret'></span></button>"+
                                    "<ul class='dropdown-menu dropdown-menu-right' role='menu'>"+
                                    "<li><a href='show?id="+data[i].id+"'  class='dngaz' data-toggle='modal' data-target='#edit'>Edit<i class='livicon edit' data-name='edit' data-size='18' data-loop='true' data-c='#428BCA' data-hc='#428BCA' title='update timeline'></i></a></li>"+
                                    "<li><a href='confirm-delete?id="+data[i].id+"'  class='dngaz' data-toggle='modal' data-target='#delete_confirm'>Delete<i class='livicon delete' data-name='trash' data-size='18' data-loop='true' data-c='#f56954' data-hc='#f56954' title='delete Comunit'></i></a></li>"+
                                    "</ul></div>"+
                                    "<h4 class='timeline-title'>"+ data[i].titles+ "</h4><p><small class='text-muted'>" +
                                    "<i class='livicon' data-name='bell' data-c='#F89A14' data-hc='#F89A14' data-size='14' data-loop='true' data-hc='white'></i>" +"Từ :"+data[i].starttime +" "+"Đến :"+data[i].endtime +
                                    "</small></p></div><div class='timeline-body'><p>" + data[i].note +"</p></div></div></li>";
                                $('#timeline').html('');
                                $('#timeline').append(arr);
                            }

                        };
                        $('.livicon').each(function () {
                            $(this).updateLivicon();
                        });
                    }
                },'json');
            });
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop

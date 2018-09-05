@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-events::language.titles.events.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/form_layouts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .label {
            color: #000000;
        }

        #myTable td {
            padding: 3px 5px;
        }
        #myTable1 td {
            padding: 3px 5px;
        }

        .content_details {
            min-width: 80px;
        }

        #boxMyTable {
            height: 250px;
            overflow: auto;
        }
        #boxMyTable1 {
            height: 250px;
            overflow: auto;
        }
        .fa-trash{
            cursor:pointer !important;
        }
    </style>
@stop
<!--end of page css-->
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title = trans('dhcd-events::language.titles.events.create') }}</h1>
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

            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-body">
                        <div class="row">
                                {!! Form::open(array('url' => route('dhcd.events.events.add'), 'method' => 'post', 'class' => 'bf form-horizontal', 'id' => 'eventsForm', 'files'=> true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                        <label class="control-label col-md-3">{{trans('dhcd-events::language.titles.events.name')}} (<span class="red">*</span>):</label>
                                        <div class="col-md-9">
                                            {!! Form::text('name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-events::language.placeholder.events.name_here'))) !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('date', 'has-error') }}">
                                        <label class="control-label col-md-3">{{trans('dhcd-events::language.titles.events.date')}} (<span class="red">*</span>):</label>
                                        <div class="col-md-9">
                                            {!! Form::text('date', null, array('class' => 'form-control singledate', 'placeholder'=> trans('dhcd-events::language.placeholder.events.date_here'))) !!}
                                        </div>
                                    </div>

                                    {{--<div class="form-group {{ $errors->first('content', 'has-error') }}">--}}
                                        {{--<label class="control-label col-md-3">{{trans('dhcd-events::language.titles.events.content')}} (<span class="red">*</span>):</label>--}}
                                        {{--<div class="col-md-9">--}}
                                            {{--{!! Form::textarea('content', null, array('class' => 'form-control', 'placeholder'=> trans('dhcd-events::language.placeholder.events.content_here'))) !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn btn-success" >{{ trans('dhcd-events::language.buttons.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">
                                                <div class="col-md-12" style="padding-right: 0px">
                                                    <span class="scheduler-border">
                                                        {{$title = trans('dhcd-events::language.titles.events.event_detail')}} :
                                                        <button type="button" class="btn btn-success pull-right btn_new" >{{ trans('dhcd-events::language.buttons.create') }}</button>
                                                    </span>
                                                </div>
                                            </legend>
                                            <div class="col-md-12 ">
                                                <div class="form-group" id="boxMyTable">
                                                    <table id="myTable" >
                                                        <tr id="beforeID"></tr>
                                                    </table>
                                                </div >
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">
                                                <div class="col-md-12" style="padding-right: 0px">
                                                    <span class="scheduler-border">
                                                        {{$title = trans('dhcd-events::language.titles.events.event_detail')}} :
                                                        <button type="button" class="btn btn-success pull-right btn_new1" >{{ trans('dhcd-events::language.buttons.create') }}</button>
                                                    </span>
                                                </div>
                                            </legend>
                                            <div class="col-md-12 ">
                                                <div class="form-group" id="boxMyTable1">
                                                    <table id="myTable1" >
                                                        <tr id="beforeID1"></tr>
                                                    </table>
                                                </div >
                                            </div>
                                        </fieldset>
                                    </div>

                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @if ( $errors->any() )
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(document).ready(function () {
            $('.btn_new').click(function () {
                var $input = $('#myTable').find('input[name="event_content[]"]');
                // console.log($input.length);
                // var $input = document.getElementsByName("start_time[]");
                if($input.length!=0) {
                    var idx=0;
                    $input.each(function () {
                        if($(this).val()==''){
                                idx=1;
                            }
                        });
                    if(idx!=1){
                        myFunction();
                    }
                    // else{
                    //     console.log('thieu du lieu');
                    // }
                }
                else{
                    myFunction();
                }
            });
            $('.btn_new1').click(function () {
                var $input = $('#myTable1').find('input[name="event_content1[]"]');
                // console.log($input.length);
                // var $input = document.getElementsByName("start_time[]");
                if($input.length!=0) {
                    var idx=0;
                    $input.each(function () {
                        if($(this).val()==''){
                                idx=1;
                            }
                        });
                    if(idx!=1){
                        myFunction1();
                    }
                    // else{
                    //     console.log('thieu du lieu');
                    // }
                }
                else{
                    myFunction1();
                }
            });
        });
        $(function () {
            $(".singledate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: new Date(),
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        })
    </script>
    <script>
        function myFunction() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            // cell1.innerHTML = "";
            cell2.innerHTML = "<label class='label'>Thời gian :      </label><input type='text' class='form-control' name='start_time[]'>";
            // cell5.innerHTML = "";
            cell6.innerHTML = "<label class='label'>Nội Dung :     </label><input type='text' class='form-control content_details' name='event_content[]'>";
            cell7.innerHTML = "<i style='font-size:20px' type='button' value='Delete' onclick='deleteRow(this)' class='fa fa-trash'></i>";
            $('#beforeID').before(row);
        }
        function deleteRow(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("myTable").deleteRow(i);
        }

        function myFunction1() {
            var table = document.getElementById("myTable1");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            // cell1.innerHTML = "";
            cell2.innerHTML = "<label class='label'>Thời gian :      </label><input type='text' class='form-control' name='start_time1[]'>";
            // cell5.innerHTML = "";
            cell6.innerHTML = "<label class='label'>Nội Dung :     </label><input type='text' class='form-control content_details' name='event_content1[]'>";
            cell7.innerHTML = "<i style='font-size:20px' type='button' value='Delete' onclick='deleteRow1(this)' class='fa fa-trash'></i>";
            $('#beforeID1').before(row);
        }
        function deleteRow1(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("myTable1").deleteRow(i);
        }
        </script>
@stop

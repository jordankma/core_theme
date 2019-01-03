@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('vne-mail::language.titles.mail.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css' }}" rel="stylesheet" type="text/css"/>
    <link href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css' }}" rel="stylesheet" type="text/css">
    <style>
        .area{
            display: none;
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
        <div class="the-box no-borderrow">
            <h3>Chọn đối tượng gửi</h3>
            <div class="row">
                <form action="" method="POST">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" class="sent-type" name="sent_type" value="1">HĐĐ Trung Ương</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" class="sent-type" name="sent_type" value="2">HĐĐ cấp Tỉnh/ TP</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" class="sent-type" name="sent_type" value="3">HĐĐ cấp Quận/ Huyện</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" class="sent-type" name="sent_type" value="4">TPT Trường</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" class="sent-type" name="sent_type" value="5">Phụ huynh</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group area area-1 area-trung-uong">
                                              
                                </div>
                            </div>
                        </div>
                        <div class="form-group area area-2 area-tinh-tp">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control province" name="province">
                                        <option disabled>Chọn tỉnh nhận</option>
                                        <option value="0">Tất cả các tỉnh</option>
                                        @if(!empty($list_province['data']))
                                        @foreach($list_province['data'] as $element)
                                            <option value="{{ $element['_id'] }}">{{ $element['province'] }}</option>   
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group area area-3 area-quan-huyen area">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control province" name="province">
                                        <option disabled>Chọn tỉnh nhận</option>
                                        <option value="0">Tất cả các tỉnh</option>
                                        @if(!empty($list_province['data']))
                                        @foreach($list_province['data'] as $element)
                                            <option value="{{ $element['_id'] }}">{{ $element['province'] }}</option>   
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control district" name="district">
                                        <option disabled>Chọn huyện nhận</option>
                                        <option value="0">Tất cả các huyện</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group area area-4 area-tpt-truong area">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control province" name="province">
                                        <option disabled>Chọn tỉnh nhận</option>
                                        <option value="0">Tất cả các tỉnh</option>
                                        @if(!empty($list_province['data']))
                                        @foreach($list_province['data'] as $element)
                                            <option value="{{ $element['_id'] }}">{{ $element['province'] }}</option>   
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control district" name="district">
                                        <option disabled>Chọn huyện nhận</option>
                                        <option value="0">Tất cả các huyện</option>
                                        
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control school" name="school">
                                        <option disabled>Chọn trường</option>
                                        <option value="0">Tất cả các huyện</option>
                                        
                                    </select>
                                </div>
                            </div>    
                        </div>
                        <div class="form-group area area-5 area-phu-huynh">
                                
                        </div>
                    </div>
                    <div class="col-sm-12">

                    </div>
                    <div class="col-sm-4">
                        <label>{{trans('vne-mail::language.label.title') }}</label>
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="{{trans('vne-mail::language.placeholder.mail.title') }}">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label>{{trans('vne-mail::language.label.content')}} </label><br>
                        <div class="form-group">
                            <div class='form-group'>
                                <textarea name="content" id="ckeditor" placeholder="{{trans('vne-mail::language.placeholder.mail.content')}}"></textarea>
                            </div>
                        </div>
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
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js' }}" type="text/javascript"></script>
    <script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js' }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin .'/vendors/ckeditor2/js/ckeditor.js') }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('ckeditor',{
                height: '300px',
                toolbar: [
                    {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                    '',
                    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
                    '',
                    {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                    {name: 'colors', items: ['TextColor', 'BGColor']},
                    //{name: 'insert', items: [ 'Image' ] },
                    {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                ]

            });
            $('body').on('click', ".sent-type", function (event) {
                var sent_type = $(this).val();
                $('.area').css('display','none');    
                $('.area').css('visibility','hidden');      
                $('.area-' + sent_type).css('display','block');
                $('.area-' + sent_type).css('visibility','visible'); 
            }); 


        });
    </script>
@stop

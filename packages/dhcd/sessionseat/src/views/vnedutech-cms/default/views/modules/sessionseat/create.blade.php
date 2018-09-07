@extends('layouts.default')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-sessionseat::language.titles.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ config('site.url_static') .('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
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
                {!! Form::open(array('url' => route('dhcd.sessionseat.add'), 'method' => 'post', 'class' => 'bf', 'id' => 'sessionseatForm', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <div class="row">
                    <div class="col-sm-8">
                        <label>Tên Phiên :</label>
                        <div class="form-group {{ $errors->first('sessionseat_name', 'has-error') }}">
                            {!! Form::text('sessionseat_name', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('dhcd-sessionseat::language.placeholder.name_here'),'required')) !!}
                            <span class="help-block">{{ $errors->first('sessionseat_name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-8">

                        <label>Sơ đồ chỗ ngồi phiên :</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a data-input="thumbnail" data-preview="holder" class="btn lfm btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="sessionseat_img[]" value="{{old('sessionseat_img')[0]}}" required>
                        </div>
                        <img id="holder" src="{{old('sessionseat_img')[0]}}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <div id="boxMusicResource">

                        </div>

                        <a href="#" onclick="funcCreate()"><i class="livicon" data-name="plus" data-size="80" data-loop="true" data-c="#333" data-hc="#333"></i></a>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <div class="form-group col-xs-12">
                            <label for="blog_category" class="">Actions</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.create') }}</button>
                                <a href="{!! route('dhcd.sessionseat.create') !!}"
                                   class="btn btn-danger">{{ trans('dhcd-sessionseat::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-sm-4 -->
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
    <script src="{{ config('site.url_static') .('/vendor/laravel-filemanager/js/lfm.js?t=' . time()) }}" ></script>
    <!--end of page js-->
    <script type="text/javascript">
        $(function () {
            $('.lfm').filemanager('image');
        });

        function makeid() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 5; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        function funcCreate() {
            var div = document.createElement('div');
            div.className = 'col-sm-12';
            var randStr = makeid();
            var randStr1 = makeid();
            div.innerHTML =
                '<label>Chọn ảnh</label>\n' +
                '                            <a href="#" onclick="removeRow(this)" class="pull-right">\n' +
                '                                <i class="livicon" data-name="trash" data-size="20" data-loop="true" data-c="#333" data-hc="#333"></i>\n' +
                '                            </a>\n' +
                '                            <div class="input-group">\n' +
                '                               <span class="input-group-btn">\n' +
                '                                 <a data-input="'+ randStr +'" data-preview="'+ randStr1 +'" class="btn lfm btn-primary">\n' +
                '                                   <i class="fa fa-picture-o"></i> Choose\n' +
                '                                 </a>\n' +
                '                               </span>\n' +
                '                                <input id="'+ randStr +'" class="form-control" type="text" name="sessionseat_img[]" value="" required>\n' +
                '                            </div>\n' +
                '                            <img id="'+ randStr1 +'" src="" style="margin-top:15px;max-height:100px;">\n' +
                '                            <br><br>';

            if (validateForm()) {
                document.getElementById('boxMusicResource').appendChild(div);
                $('.lfm').filemanager('image');
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            }
        }

        function removeRow(input) {
            document.getElementById('boxMusicResource').removeChild(input.parentNode);
        }

        function validateForm()
        {
            return true;
            var container, inputs, index;

            // Get the container element
            container = document.getElementById('sessionseatForm');

            // Find its child `input` elements
            inputs = container.getElementsByTagName('input');
            for (index = 0; index < inputs.length; ++index) {
                if (inputs[index].value === '') {
                    inputs[index].focus();
                    alert("Yêu cầu nhập đủ thông tin!");
                    return false;
                }
                // deal with inputs[index] element.
            }
            return true;
        }
    </script>
@stop

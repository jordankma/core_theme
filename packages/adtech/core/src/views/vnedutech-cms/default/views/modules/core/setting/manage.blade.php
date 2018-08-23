@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $title_page = trans('adtech-core::titles.setting.manage') }}
    @parent
@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <!--end of page css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        {{--<h1>{{ $title_page }}</h1>--}}
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}"> <i class="livicon" data-name="home" data-size="16"
                                                                         data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title_page }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">

            {{--<ul class="nav nav-tabs" style="margin-bottom: 15px;">--}}
                {{--<li class="active">--}}
                    {{--<a href="#home" data-toggle="tab">Home</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#profile" data-toggle="tab">Profile</a>--}}
                {{--</li>--}}
                {{--<li class="disabled">--}}
                    {{--<a>Disabled</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--<div id="myTabContent" class="tab-content">--}}
                {{--<div class="tab-pane fade active in" id="home">--}}
                    {{--<p class="m-r-6">--}}
                        {{--It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane fade" id="profile">--}}
                    {{--<p  class="m-r-6">--}}
                        {{--There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane fade" id="dropdown1">--}}
                    {{--<p class="m-r-6">--}}
                        {{--Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<div class="tab-pane fade" id="dropdown2">--}}
                    {{--<p class="m-r-6">--}}
                        {{--Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.--}}
                    {{--</p>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="the-box no-border">
                {!! Form::open(array('url' => route('adtech.core.setting.update'), 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
                <div class="row">
                    <div class="col-sm-8">

                        <label>{{ trans('adtech-core::labels.setting.title_page') }}</label>
                        <div class="form-group">
                            {!! Form::text('title', $title, array('class' => 'form-control', 'autofocus'=>'autofocus', 'placeholder'=> trans('adtech-core::common.setting.title_here'))) !!}
                        </div>

                        <label>Logo</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail" class="form-control" type="text" name="logo" value="{{ $logo }}">
                        </div>
                        <img id="holder" src="{{ $logo }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <label>Logo mini</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail2" class="form-control" type="text" name="logo_mini" value="{{ $logo_mini }}">
                        </div>
                        <img id="holder2" src="{{ $logo_mini }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <label>Favicon</label>
                        <div class="input-group">
                           <span class="input-group-btn">
                             <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                           </span>
                            <input id="thumbnail1" class="form-control" type="text" name="favicon" value="{{ $favicon }}">
                        </div>
                        <img id="holder1" src="{{ $favicon }}" style="margin-top:15px;max-height:100px;">
                        <br><br>

                        <label>Logo link</label>
                        <div class="form-group">
                            {!! Form::text('logo_link', $logo_link, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.logo_link_here'))) !!}
                        </div>

                        <label>Company Name</label>
                        <div class="form-group">
                            {!! Form::text('company_name', $company_name, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.company_name_here'))) !!}
                        </div>

                        <label>Address</label>
                        <div class="form-group">
                            {!! Form::text('address', $address, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.address_here'))) !!}
                        </div>

                        <label>Email</label>
                        <div class="form-group">
                            {!! Form::text('email', $email, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.email_here'))) !!}
                        </div>

                        <label>Phone number</label>
                        <div class="form-group">
                            {!! Form::text('phone', $phone, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.phone_here'))) !!}
                        </div>

                        <label>Hotline</label>
                        <div class="form-group">
                            {!! Form::text('hotline', $hotline, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.hotline_here'))) !!}
                        </div>

                        <label>GA Code</label>
                        <div class="form-group">
                            {!! Form::textarea('ga_code', $ga_code, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.ga_code_here'))) !!}
                        </div>

                        <label>Chat Code</label>
                        <div class="form-group">
                            {!! Form::textarea('chat_code', $chat_code, array('class' => 'form-control', 'placeholder'=> trans('adtech-core::common.setting.chat_code_here'))) !!}
                        </div>


                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">
                        <label for="blog_category" class="">Actions</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{ trans('adtech-core::buttons.save') }}</button>
                            <a href="{!! route('adtech.core.setting.manage') !!}"
                               class="btn btn-danger">{{ trans('adtech-core::buttons.discard') }}</a>
                        </div>
                    </div>
                    <!-- /.col-sm-4 --> </div>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}" ></script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
        })
    </script>
@stop

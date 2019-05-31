@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('title') {{ 'Đăng ký thông tin' }} @stop
@section('header_styles')
	<link rel="stylesheet" href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/bootstrap-datetimepicker/bootstrap-datetimepicker-standalone.css' }}">
	<link rel="stylesheet" href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/bootstrap-datetimepicker/bootstrap-datetimepicker.css' }}">
	<style>
		#loading {
			background-color:white;
			position: fixed;
			display: block;
			top: 0;
			bottom: 0;
			z-index: 1000000;
			opacity: 0.5;
			width: 100%;
			height: 100%;
			text-align: center;
		}

		#loading img {
			margin: auto;
			display: block;
			top: calc(50% - 100px);
			left: calc(50% - 10px);
			position: absolute;
			z-index: 999999;
		}
	</style>
@stop
@section('content')
<main class="main">
	<div id="loading" style="display:none">
		<img src="{{ config('site.url_static')  . '/files/photos/image/loading.gif' }}" alt="Đang tải..."/>
	</div>
	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<h3 style="text-align: center; font-size:20px">ĐĂNG KÝ THÔNG TIN TÀI KHOẢN</h3>
				@if(Session::has('messages'))
					<p style="color:red;text-align: center">{{ Session::get('messages') }}</p>
				@endif
				<p style="font-style: italic;text-align: center">(Bạn cần đăng ký thông tin tài khoản để tham gia cuộc thi)</p>
				@if(Session::has('error'))
				<p style="color:#fff;text-align: center;background: rgba(255, 0, 0, 0.7)">{{ Session::get('error') }}</p>
				@endif
				<form action="{{ route('frontend.member.register.update') }}" method="post" id="form-register-member">
                    <input type="hidden" name="member_id" id="member_id">
					<input type="hidden" name="u_name" id="u_name">
					<input type="hidden" name="token" id="token">
					<p style="font-weight: bold"> Bước 1: Đăng ký thông tin thí sinh. </p> 
					<p style="color:red"> Bạn cần nhập chính xác các thông tin dưới đây.Thông tin đăng ký của 
					thí sinh chỉ được nhập 01 lần duy nhất và không thể chỉnh sửa </p>
                    {!! $form_data_default !!}
					<div class="btn-group">
						<button type="submit" class="btn btn-save">Lưu</button>
					</div>
				</form>
			</div>
			{{-- @else
			<div class="inner">
				<h3 style="text-align: center; font-size:20px">ĐĂNG KÝ THÔNG TIN TÀI KHOẢN</h3>
				<p style="color:red;text-align: center">{{ Session::get('messages') }}</p>
			</div>
			@endif --}}
		</div>
	</section>
	<!-- registration end -->

</main>
@stop
@section('footer_scripts')
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/bootstrap-datetimepicker/moment.min.js' }}"></script>
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js' }}"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $(document).ajaxStart(function() {
                $("#loading").show();
                $('.btn-save').attr('type', 'button');
                $('.btn-save').text('Đang tải dữ liệu ...');

            });
            $(document).ajaxStop(function() {
                $("#loading").hide();
                $('.btn-save').attr('type', 'submit');
                $('.btn-save').text('Lưu');
            });
        });
		var bearer_token = '{{ env("BEARER_TOKEN") }}';
		var route_get_form_register = '{{route("frontend.member.get.form.register")}}';
		var route_get_form_register_2 = '{{route("frontend.member.get.form.register.2")}}';
		document.addEventListener("DOMContentLoaded", function() {
			var elements = document.getElementsByTagName("INPUT");
			for (var i = 0; i < elements.length; i++) {
				elements[i].oninvalid = function(e) {
					e.target.setCustomValidity("");
					if (!e.target.validity.valid) {
						e.target.setCustomValidity("Trường này không được bỏ trống");
					}
				};
				elements[i].oninput = function(e) {
					e.target.setCustomValidity("");
				};
			}
		})
		const datepicker = $('.datepicker');
		if (datepicker) {
			datepicker.datetimepicker({
				defaultDate: "10/10/1995",
				format: 'DD/MM/YYYY'
			});
		}
	</script>
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/js_form.js' }}"></script>
	
@stop
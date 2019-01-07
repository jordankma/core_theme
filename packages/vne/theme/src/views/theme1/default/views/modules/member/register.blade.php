@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<h3 style="text-align: center; font-size:20px">ĐĂNG KÝ THÔNG TIN TÀI KHOẢN</h3>
				<p style="color:red;text-align: center">Bạn cần đăng ký thông tin tài khoản để tham gia cuộc thi</p>
				<form action="{{ route('frontend.member.register.update') }}" method="post" id="form-register-member">
                    <input type="hidden" name="member_id" id="member_id">
					<input type="hidden" name="u_name" id="u_name">
					<p style="font-weight: bold"> Bước 1: Đăng ký thông tin thí sinh. </p> 
					<p style="color:red"> Bạn cần nhập chính xác các thông tin dưới đây.Thông tin đăng ký của 
					thí sinh chỉ được nhập 01 lần duy nhất và không thể chỉnh sửa </p>
                    {!! $form_data_default !!}
					<div class="btn-group">
						<button type="submit" class="btn btn-save">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!-- registration end -->

</main>
@stop
@section('footer_scripts')
	<script type="text/javascript">
		var bearer_token = '{{ env("BEARER_TOKEN") }}';
		var route_get_form_register = '{{route("frontend.member.get.form.register")}}';
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
	</script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form.js?t=' . time()) }}"></script>
	
@stop
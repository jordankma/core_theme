<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	<link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">
	<!-- css -->
	<link rel="stylesheet" href="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/css/main.min.css' }}">
	@yield('header_styles')
	{{-- <style>
		.nav-item{
			display: inline-block !important;
		}
	</style> --}}
	{!! isset($SETTING['ga_code']) ? $SETTING['ga_code'] : '' !!}
</head>

<body class="home">
	
	<noscript>
		<![if !(lte IE 9)]>
		<div class="noscript-message">
			<div class="noscript-message__content">
				<p>Trinh duyệt của bạn không hỗ trợ hoặc đã tắt JavaScript, bạn vui lòng cập nhận trình đuyệt web hoặc mở
					JavaScript trong
					phần cài đặt.</p>
			</div>
		</div>
		<![endif]>
	</noscript>

	<div id="app" style="background-image: url({{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/bg-body.png' }});">

		<!-- header -->
		@include('VNE-HOCVALAMTHEOBAC::layouts.header')
		<!-- header end -->

		<!-- main -->
		@yield('content')
		<!-- main end -->

		<!-- footer -->
		@include('VNE-HOCVALAMTHEOBAC::layouts.footer')
		<!-- footer end -->


		<!-- slide out -->
		@include('VNE-HOCVALAMTHEOBAC::layouts._menu_mobile')
		<!-- slideout end -->

		<!-- popup -->
		{{-- @include('VNE-HOCVALAMTHEOBAC::layouts._modal_login') --}}
		{{-- @include('VNE-HOCVALAMTHEOBAC::layouts._modal_register') --}}
		
		<!-- popup end -->

		<div class="body-overlay js-body-overlay"></div>


	</div>

	<!-- js -->
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/jquery-3.3.1.min.js' }}"></script>
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/slick.min.js' }}"></script>
	<script src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/js/main.js' }}"></script>
	@yield('footer_scripts')
	<script type="text/javascript">
		checkLogin();
		var message_notifi_verify = '{{ Session::get('notifi_verify') }}';
		if(message_notifi_verify != ''){
			$('.js-message').css('opacity',1);
			$('.js-message .inner-message').text(message_notifi_verify);
		}
		$('body').click(function(){
			$('.js-message').css('opacity',0);
		});
		function checkLogin() {
	        $.ajax({
	            url: 'http://eid.vnedutech.vn/get-status-login',
	            method: 'get',
	            xhrFields: {
	                withCredentials: true
	            },
	            headers: {
	                'X-Requested-With': 'XMLHttpRequest'
	            },
	            success: function (data) {
	                if (data.authorized !== false) {
						var member_id = data.data.user_id;
	                	$('input[name=member_id]').val(member_id);
	                	$('input[name=u_name]').val(data.data.username);
	                	$('input[name=token]').val(data.data.token);
	                	$('#online-now').css('display','block');	
	                	$('#online-now').css('visibility','visible');
	                	$('#offline-now').css('display','none');	
	                	$('#offline-now').css('visibility','hidden');
	                	$('#text-user-name').append(data.data.username);
	                	$('#text-user-name').attr('href','/ket-qua-thi-sinh?member_id='+ member_id);

	                	var url_thi_thu = $('#btn-try-exam').attr('href') + '?token=' + data.data.token;	
	                	$('#btn-try-exam').attr('href',url_thi_thu);
	                	var url_thi_that = $('#btn-real-exam').attr('href') + '?token=' + data.data.token;	
	                	$('#btn-real-exam').attr('href',url_thi_that);
	                	
						var url_cap_nhat_thong_tin = $('.btn-update-info').attr('href') + '?member_id=' + member_id;	
	                	$('.btn-update-info').attr('href',url_cap_nhat_thong_tin);

						document.cookie = "member_id=" + member_id;
	                } 
	                else{
	                	$('#offline-now').css('display','block');	
	                	$('#offline-now').css('visibility','visible');
	                	$('#online-now').css('display','none');	
	                	$('#online-now').css('visibility','hidden');	
	                }
	            },
	            error: function (data) {
	                console.log('Fail')
	            }
	        });
		}
		
	</script>
</body>

</html>
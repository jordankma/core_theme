<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	<link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">
	<!-- css -->
	<link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/css/main.min.css?t=' . time()) }}">
	@yield('header_styles')
	<style type="text/css">
		#menu-info .nav-item{
			display: inline-block !important;
			overflow: hidden !important;
		}
		.timeline .timeline-list::after{
			background:url("{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/cup1.png?t=' . time()) }}")
		}
		button, input, optgroup, select, textarea{
			line-height:normal;
		}
	</style>
	{!! isset($SETTING['ga_code']) ? $SETTING['ga_code'] : '' !!}
</head>

<body @if(isset($type_page)) class="home" @endif>

	<noscript>
		<![if !(lte IE 9)]>
		<div class="noscript-message">
			<div class="noscript-message__content">
				<p>Trình duyệt của bạn không hỗ trợ hoặc đã tắt JavaScript, bạn vui lòng cập nhận trình đuyệt web hoặc mở
					JavaScript trong phần cài đặt.</p>
			</div>
		</div>
		<![endif]>
	</noscript>
	<div id="app">

		<!-- header -->
		@include('VNE-THEME::layouts.header')
		<!-- header end -->

		<!-- main -->
		@yield('content')
		<!-- main end -->

		<!-- footer -->
		@include('VNE-THEME::layouts.footer')
		<!-- footer end -->


		<!-- slide out -->
		@include('VNE-THEME::layouts._menu_mobile')
		<!-- slideout end -->

		<!-- popup -->
		@include('VNE-THEME::layouts._modal_login')
		@include('VNE-THEME::layouts._modal_register')
		@include('VNE-THEME::layouts._modal_notification')
		
		<!-- popup end -->

		<div class="body-overlay js-body-overlay"></div>

		<div class="hotline_home" style="position: fixed;bottom: 3px;right: 20px;z-index: 9999;">
			<a class="btn btn-primary" style="font-size: 18px;color: #fff;line-height: 40px;border-radius: 90px; background-color: #337ab4;
			border-color: #337ab7;" href="tel:{{ isset($SETTING['hotline']) ? $SETTING['hotline'] : '' }}" onclick="goog_report_conversion('tel:{{ isset($SETTING['hotline']) ? $SETTING['hotline'] : '' }}')">
				<i class="fa fa-1x fa-phone-square" aria-hidden="true"></i>
				<span class="hotline_text">HOTLINE: </span>
				<span> {{ isset($SETTING['hotline']) ? $SETTING['hotline'] : '' }} </span>
				-<span> {{ isset($SETTING['phone']) ? $SETTING['phone'] : '' }}</span>
			</a>
        </div>
	</div>

	<!-- js -->
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/jquery-3.3.1.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/flipclock.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/slick.min.js?t=' . time()) }}"></script>
	{{-- <script src="{{ asset('/vendor/vnedutech-cms/default/vendors/bootstrapvalidator/js/bootstrapValidator.min.js?t=' . time()) }}"></script> --}}
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/main.js?t=' . time()) }}"></script>
	<script type="text/javascript">
		var route_logout = '{{ route('vne.member.logout')}}';
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
	                	$('input[name=member_id]').val(data.data.user_id);
	                	$('input[name=u_name]').val(data.data.username);
	                	$('#online-now').css('display','block');	
	                	$('#online-now').css('visibility','visible');
	                	$('#offline-now').css('display','none');	
	                	$('#offline-now').css('visibility','hidden');
	                	$('#text-user-name').append(data.data.username);

	                	var url_thi_thu = $('#btn-try-exam').attr('href') + '?token=' + data.data.token;	
	                	$('#btn-try-exam').attr('href',url_thi_thu);
	                	var url_thi_that = $('#btn-real-exam').attr('href') + '?token=' + data.data.token;	
	                	$('#btn-real-exam').attr('href',url_thi_that);
	                	
						var url_cap_nhat_thong_tin = $('.btn-update-info').attr('href') + '?member_id=' + data.data.user_id;	
	                	$('.btn-update-info').attr('href',url_cap_nhat_thong_tin);
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
		// $('body').on('click', "#button-logout", function (event) {
	    // 	event.preventDefault();	
	    // 	$.ajax({
	    //         url: 'http://eid.vnedutech.vn/logout',
	    //         method: 'get',
	    //         xhrFields: {
	    //             withCredentials: true
	    //         },
	    //         headers: {
	    //             'X-Requested-With': 'XMLHttpRequest'
	    //         },
	    //         success: function (data) {
	    //         	var url = '{{ route('vne.member.logout')}}';
	    //         	window.location.assign(url);
	    //         },
	    //         error: function (data) {
	    //             console.log('Fail')
	    //         }
	    //     });
	    // });
	</script>
	@yield('footer_scripts')
</body>

</html>
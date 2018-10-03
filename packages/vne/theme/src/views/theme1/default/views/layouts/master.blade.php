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

	<div id="app" style="background-image: url(../images/bg-body.png);">

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
		
		<!-- popup end -->

		<div class="body-overlay js-body-overlay"></div>


	</div>

	<!-- js -->
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/jquery-3.3.1.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/flipclock.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/vendor/slick.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/main.js?t=' . time()) }}"></script>
	@yield('footer_scripts')
</body>

</html>
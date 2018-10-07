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

	<div id="app" style="background-image: url({{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/bg-body.png?t=' . time()) }}../);">

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
	<script src="{{ asset('/vendor/vnedutech-cms/default/vendors/bootstrapvalidator/js/bootstrapValidator.min.js?t=' . time()) }}"></script>
	<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/main.js?t=' . time()) }}"></script>
	@yield('footer_scripts')
	<script type="text/javascript">
		$('body').on('submit', "#form-login", function (event) {
	        event.preventDefault();
	        var _crsfToken = $('meta[name=csrf-token]').prop('content');
	        var email = $('input[name=email]').val();
	        var password = $('input[name=password]').val(); 
	        var url = '/login';
	        $.post(url, {_token: _crsfToken, email: email, password: password}, function (result) {
	            if (!result.status) {
	                $('#form-login .help-block').text(result.messeger);
	                $('#form-login .help-block').css('display','block');
	                return false;
	            }else{
	                location.reload(true);
	            }
	        }, 'json');
	    });
	    $('body').on('submit', "#form-register", function (event) {
	        event.preventDefault();
	        var _crsfToken = $('meta[name=csrf-token]').prop('content');
	        var u_name = $('input[name=u_name]').val();
	        var email = $('input[name=email]').val();
	        var phone = $('input[name=phone]').val();
	        var password = $('input[name=password]').val(); 
	        var conf_password = $('input[name=conf_password]').val(); 
	        console.log(u_name=='');
	        if(u_name=='' && email=='' && phone=='' && password=='' && conf_password=='' ){
	        	console.log('1');
	        	$('#form-register .help-block').text('Các trường này không được bỏ trống');
                $('#form-register .help-block').css('display','block');	
	        } else {
	        	console.log('2');
		        // var url = '/register';
		        // $.post(url, {_token: _crsfToken, email: email, password: password}, function (result) {
		        //     if (!result.status) {
		        //         $('#form-login .help-block').text(result.messeger);
		        //         $('#form-login .help-block').css('display','block');
		        //         return false;
		        //     }else{
		        //         location.reload(true);
		        //     }
		        // }, 'json');
	        }
	    });
	</script>
</body>

</html>
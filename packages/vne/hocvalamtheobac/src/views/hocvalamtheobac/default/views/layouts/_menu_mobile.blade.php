<div class="nav-trigger js-trigger" style="top: 15px; left: 15px;">
	<span class="bar"></span>
	<span class="bar"></span>
	<span class="bar"></span>
</div>
<div class="slideout js-slideout">
	<div class="inner">
		<ul class="nav">
			{{-- <li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
			<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li> --}}
			<div id="online-now" style="display: flex;visibility: hidden;"> 
				<li class="nav-item" style="display: inline-block">
					<i class="fa fa-user"></i>
					<a href="" id="text-user-name"></a> 
				</li>
				<li class="nav-item" style="display: inline-block">
					<i class="ii ii-bachelor"></i><a href="http://">Vào thi</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<i class="fa fa-edit"></i>
							<a href="{{ route('vne.get.try.exam') }}" class="nav-link" id="btn-try-exam">Thi Thử</a>
						</li>
						<li class="nav-item">
							<i class="ii ii-bachelor"></i>
							<a href="{{ route('vne.get.real.exam') }}" class="nav-link" id="btn-real-exam">Thi thật</a>
						</li>
						{{-- <li class="nav-item"><i class="fa fa-clone"></i><a href="" class="nav-link">Tự luận</a></li> --}}
					</ul>
				</li>

				<li class="nav-item" id="" style="display: inline-block">
					<i class="fa fa-edit"></i> 
					<a href="{{ 'http://eid.vnedutech.vn/logout?site=' . config('app.url') }}" >Đăng xuất</a> 
				</li>	
			</div>
			<div id="offline-now" style="display: flex; visibility: hidden;">
				@php 
					$url_login = "http://eid.vnedutech.vn/login?site=" . config('app.url');
					$url_register = "http://eid.vnedutech.vn/register?site=" . config('app.url');
				@endphp
				<li class="nav-item" style="display: inline-block"><i class="ii ii-bachelor"></i><a href="{{ $url_login }}">Vào thi</a></li>
				<li class="nav-item" style="display: inline-block"><i class="fa fa-user"></i><a href="{{ $url_login }}">Đăng nhập</a></li>
				<li class="nav-item" style="display: inline-block"><i class="fa fa-edit"></i><a href="{{ $url_register }}">Đăng ký</a></li>
			</div>
		</ul>
		<nav class="slideout-navbar">
			@php 
				showCategories($MENU_LEFT); 
			@endphp
		</nav>
		<div class="contact">
			<p class="phone">Hỗ trợ: {{ isset($SETTING['hotline']) ? $SETTING['hotline'] : '' }} - {{ isset($SETTING['phone']) ? $SETTING['phone'] : '' }}</p>
			<p class="email">Email: {{ isset($SETTING['email']) ? $SETTING['email'] : '' }} </p>
		</div>

	</div>
</div>
<div class="nav-trigger js-trigger">
	<span class="bar"></span>
	<span class="bar"></span>
	<span class="bar"></span>
</div>
<div class="slideout js-slideout">
	<div class="inner">
		<ul class="nav">
			<li class="nav-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
			<li class="nav-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
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
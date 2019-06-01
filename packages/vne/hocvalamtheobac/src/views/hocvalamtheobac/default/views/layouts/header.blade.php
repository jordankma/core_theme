@php

function showCategories($categories, $parent_id = 0, $char = '')
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $class = $parent_id == 0 ? 'nav js-navbar' : '';
    $cate_child = array();
    if(!empty($categories)){
	    foreach ($categories as $key => $item)
	    {
	        // Nếu là chuyên mục con thì hiển thị
	        if ($item->parent == $parent_id)
	        {
	            $cate_child[] = $item;
	            // unset($categories[$key]);
	        }
	    }
    }
    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if (!empty($cate_child))
    {
        echo '<ul class="'.$class.'">';
        foreach ($cate_child as $key => $item)
        {
            // Hiển thị tiêu đề chuyên mục
            $url = ($item->route_name != '#') ? ($item->route_params) ? route($item->route_name, [$item->route_params]) : route($item->route_name) : '#';
            echo '<li class="nav-item">';
            echo '<a href="'.$url.'" class="nav-link">'.$item->menuLocale->name.'</a>';
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($categories, $item->menu_id, $char.'|---');
            echo '</li>';
        }
        echo '</ul>';
    }
}
@endphp

<header class="header">
	<!-- top bar -->
	<section class="top-bar">
		<div class="container">
			<div class="inner">
				<div class="contact">
					<p class="phone">Hỗ trợ: {{ isset($SETTING['hotline']) ? $SETTING['hotline'] : '' }} - {{ isset($SETTING['phone']) ? $SETTING['phone'] : '' }}</p>
					<p class="email">Email: {{ isset($SETTING['email']) ? $SETTING['email'] : '' }}</p>
				</div> <!-- /top bar -->
				<ul class="nav">
					<div id="online-now" style="display: flex;visibility: hidden;"> 
						<li class="nav-item" style="display: inline-block">
							<i class="fa fa-user"></i>
							<a href="" id="text-user-name"></a> 
						</li>
						<li class="nav-item" style="display: inline-block">
							<i class="ii ii-bachelor"></i><a href="#">Vào thi</a>
							<ul class="sub-menu">
								<a href="{{ route('vne.get.try.exam') }}" class="nav-link" id="btn-try-exam" style="color:#fff">
									<li class="nav-item">
										<i class="fa fa-edit"></i>
										Thi Thử
									</li>
								</a>
									<li class="nav-item">
										<i class="ii ii-bachelor"></i>
										<a href="{{ route('vne.get.real.exam') }}" class="nav-link" id="btn-real-exam">
											Thi thật
										</a>
									</li>
								
							</ul>
						</li>
						<a href="{{ 'http://eid.vnedutech.vn/logout?site=' . config('app.url') }}" style="color:#fff">
							<li class="nav-item" id="" style="display: inline-block">
								<i class="fa fa-edit"></i> 
								Đăng xuất 
							</li>	
						</a>
					</div>
					<div id="offline-now" style="display: flex; visibility: hidden;">
						@php 
							$url_login = "http://eid.vnedutech.vn/login?site=" . config('app.url');
							$url_register = "http://eid.vnedutech.vn/register?site=" . config('app.url');
						@endphp
						<a href="{{ $url_login }}" style="color:#fff"> <li class="nav-item" style="display: inline-block"><i class="ii ii-bachelor"></i>Vào thi</li></a>
						<a href="{{ $url_login }}" style="color:#fff"> <li class="nav-item" style="display: inline-block"><i class="fa fa-user"></i>Đăng nhập</li> </a>
						<a href="{{ $url_register }}" style="color:#fff"> <li class="nav-item" style="display: inline-block"><i class="fa fa-edit"></i>Đăng ký</li> </a>
					</div>
				</ul> <!-- nav -->
			</div>
		</div>
	</section>
	<!-- top bar end -->

	<!-- navbar -->
	<nav class="navbar">
		<div class="container">
			<div class="wrapper">
				<div class="branb">
					<a class="logo" href="{{ route('index') }}"><img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/logo.png' }}" alt=""></a>
					<div class="text">
						<div class="inner">
							<p style="margin-bottom:5px">CUỘC THI TUỔI TRẺ HỌC TẬP VÀ LÀM THEO</p>
							<p style="margin-bottom:5px">TƯ TƯỞNG, ĐẠO ĐỨC, PHONG CÁCH</p>
							<p style="margin-bottom:5px">HỒ CHÍ MINH</p>
							<p>LẦN THỨ V, NĂM 2019</p>
						</div>
					</div>
				</div>
				@php 
					showCategories($MENU_LEFT); 
				@endphp
			</div>
		</div>
	</nav>
	<!-- navbar end -->

</header>
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
	            unset($categories[$key]);
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
            echo '<a href="'.$url.'" class="nav-link">'.$item->name.'</a>';
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
					<span class="phone"><i class="fa fa-phone"></i> Hotline: 1900 636 444</span>
					<span class="email"><i class="fa fa-email"></i> Email: gthd@egroup.vn</span>
				</div> <!-- /top bar -->
				<ul class="nav" id="menu-info">
					{{-- @if($USER_INFO != null) --}}
						<div id="online-now" style="display: none;visibility: hidden;"> 
							<li class="nav-item" id="text-user-name"><i class="fa fa-user"></i></li>
							<li class="nav-item" id="button-logout"><i class="fa fa-edit"></i> Đăng xuất </li>	
						</div>
					{{-- @else --}}
						<div id="offline-now">
							@php 
								$url = "http://eid.vnedutech.vn/login?site=" . config('app.url');
							@endphp
							<li class="nav-item"><a href="{{ $url }}"><i class="fa fa-user"></i>Đăng nhập</a></li>
							<li class="nav-item js-toggle-registration"><i class="fa fa-edit"></i>Đăng ký</li>
						</div>
					{{-- @endif --}}
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
					<a class="logo" href="{{ route('index') }}"><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/logo_bak.png?t=' . time()) }}" alt=""></a>
				</div>
				@php 
					showCategories($MENU_LEFT); 
				@endphp
			</div>
		</div>
	</nav>
	<!-- navbar end -->

</header>
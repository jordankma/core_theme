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
				<div class="branb">
					<a href="http://"><img src="images/logo_new.png" alt=""></a>
				</div> <!-- /branb -->
				<ul class="btn-group">
					<li class="btn-item"><a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/rldv.png?t=' . time()) }}" alt=""></a></li>
					<li class="btn-item"><a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/slldt.png?t=' . time()) }}" alt=""></a></li>
					{{-- <ul class="user">
						<li class="user-item js-toggle-login"><i class="fa fa-user"></i> Đăng nhập</li>
						<li class="user-item js-toggle-registration"><i class="fa fa-user"></i> Đăng ký</li>
					</ul> <!-- /btn group --> --}}
				</ul> <!-- /btn group -->
			</div>
		</div>
	</section>
	<!-- top bar end -->

	<!-- navbar -->
	<nav class="navbar">
		<div class="container">
			<div class="wrapper">
				@php 
					showCategories($MENU_LEFT); 
				@endphp
			</div>
		</div>
	</nav>
	<!-- navbar end -->

</header>
<!-- rating right -->
<section class="section rating-right">
    <div class="info">
        <div class="icon"><img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/images/cup.png' }}" alt=""></div>
        <div class="number">{{ $count_thi_sinh_dang_ky }}</div>
        <p>Thí sinh đăng ký</p>
    </div>
    <h2 class="headline">{{ isset($list_thi_sinh_dan_dau_tuan->title) ? $list_thi_sinh_dan_dau_tuan->title : '' }}</h2>
    <div class="list">
        @if(!empty($list_thi_sinh_dan_dau_tuan->data[0]->data_table ))
        @foreach($list_thi_sinh_dan_dau_tuan->data[0]->data_table as $element)
        @if(!empty($element))
        <div class="list-item" style="padding-top:10px">
            <div class="number"> {{ $loop->index+1 }} </div>
            <div class="img">
                <div class="img-cover">
                    <a href="#" class="img-cover__wrapper">
                        <img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/user1.png' }}" alt="">
                    </a>
                </div>
            </div>
            <div class="info">
                <h4 class="title">{{ isset($element[1]) ? $element[1] : '' }}</h4>
                <p class="date">{{ isset($element[2]) ? $element[2] : '' }}</p>
                <p class="name-school">{{ isset($element[3]) ? $element[3] : '' }} - {{ isset($element[4]) ? $element[4] : '' }}</p>
            </div>
        </div>
        @endif
        @endforeach
        @endif
    </div>
</section>
<!-- rating right end -->

<!-- video right -->
<section class="section video-right">
	<h3 class="headline">Video nổi bật</h3>
	<div class="video-item">
		<div class="img-cover">
			<a href="#" class="img-cover__wrapper">
				<img src="images/video.png" alt="">
			</a>
		</div>
		<h4 class="title"><a href="http://">Video phát động cuộc thi “Tìm hiểu về biển, đảo
				Việt Nam” năm 2018</a></h4>
	</div>
	<ul class="list">
		<li class="list-item">
			<h5 class="title"><a href="">Giới thiệu cuộc thi “Tìm hiểu về biển, đảo Việt
					Nam” năm 2018</a></h5>
			<p class="date">29/11/2016</p>
		</li>
		<li class="list-item">
			<h5 class="title"><a href="">VTV1 đưa tin về lễ trao giải các vòng thi trắc nghiệm cuộc thi "Tìm hiểu về
					biển, đảo
					Việt Nam" năm 2018</a></h5>
			<p class="date">29/11/2016</p>
		</li>
		<li class="list-item">
			<h5 class="title"><a href="">Biển đảo Việt Nam nguồn cội tự bao giờ</a></h5>
			<p class="date">29/11/2016</p>
		</li>
	</ul>
	<a href="" class="btn btn-light">Xem thêm</a>
</section>
<!-- video right end -->

<!-- facebook right -->
<section class="section facebook-right">
	<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=270&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=226666764204714"
	  width="100%" height="270" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"
	  allow="encrypted-media"></iframe>
</section>
<!-- facebook right end -->

<!-- advertising right -->
<section class="section advertising-right">
	<div class="advertising-item">
		<a href=""><img src="images/adv.png" alt=""></a>
	</div>

</section>
<!-- advertising right end -->
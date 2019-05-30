<!-- rating right -->
<section class="section rating-right">
    <div class="info">
        <div class="icon"><img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/images/cup.png' }}" alt=""></div>
        <div class="number">{!! $count_thi_sinh_dang_ky !!}</div>
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
@if(!empty($list_videonoibat))
<section class="section video-right">
    <h3 class="headline">Video nổi bật</h3>
    @php 
        $videonoibat = config('site.news_box.videonoibat');
    @endphp
    @foreach($list_videonoibat as $element)
    @php 
        $alias = $element->title_alias . '.html';
    @endphp
    @if($loop->index == 0)
    <div class="video-item">
        <div class="img-cover">
            <a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
                <img src="{{ config('site.url_static') . $element->image }}" alt="">
            </a>
        </div>
        <h4 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h4>
    </div>
    <ul class="list">
    @else
        <li class="list-item">
            <h5 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h5>
            <p class="date">{{ date_format($element->created_at,"d/m/Y H:i:s") }}</p>
        </li>
    @endif
    @if($loop->last)
    </ul>
    @endif
    @endforeach
    <a href="{{ route('frontend.news.list.box',$videonoibat) }}" class="btn btn-light">Xem thêm</a>
</section>
@endif
<!-- video right end -->

<!-- facebook right -->
<section class="section facebook-right">
        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhocvalamtheobac%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=368588296958531" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
</section>
<!-- facebook right end -->

<!-- advertising right -->
{{-- <section class="section advertising-right">
	<div class="advertising-item">
		<a href=""><img src="images/adv.png" alt=""></a>
	</div>
</section> --}}
<!-- advertising right end -->
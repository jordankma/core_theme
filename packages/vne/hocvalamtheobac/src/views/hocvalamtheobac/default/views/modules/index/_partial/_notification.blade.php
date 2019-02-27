<section class="section notification">
    <div class="notification-item">
        @php 
			$thongbaobtc = config('site.news_box.thongbaobtc');
        @endphp
        <h2 class="headline"><a href="{{ route('frontend.news.list.box',$thongbaobtc) }}">Thông báo BTC</a></h2>
        <div class="list">
            @if(!empty($list_news_event))
            @foreach($list_news_event as $element)
            @php 
                $alias = $element->title_alias . '.html';
            @endphp
            <div class="list-item">
                <h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h3>
                <p class="date">Ngày: {{ date_format($element->created_at,"d/m/Y") }}</p>
            </div>
            @endforeach
			@endif
        </div>
    </div>
</section>
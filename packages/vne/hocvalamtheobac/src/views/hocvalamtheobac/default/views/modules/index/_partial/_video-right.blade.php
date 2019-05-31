@if(count($list_videonoibat) > 0)
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
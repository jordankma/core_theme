<div class="col-lg-4">
    <!-- quest -->
    <section class="section quest">
        <div class="headline">HỌ NÓI VỀ CHÚNG TÔI</div>
        <div class="quest-list js-carousel-02">
            @if(!empty($list_news_honoivechungtoi))
            @foreach($list_news_honoivechungtoi as $element)
            @php $alias = $element->title_alias . '.html'; @endphp
            <div class="item">
                <div class="avatar">
                    <div class="img-cover">
                        <a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
                        <img src="{{ config('site.url_static') . $element->image }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="info">
                    <div class="commit">{!! $element->content !!}</div>
                    <div class="name">{{ $element->title }}</div>
                    <div class="address">{{ $element->desc }}</div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </section>
    <!-- quest end -->
</div>
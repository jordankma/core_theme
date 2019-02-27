<section class="section hero">
    <div class="container">
        <div class="carousel js-carousel">
            @if(!empty($list_banner))
            @foreach($list_banner as $banner)
            <div class="img-cover carousel-item">
                <a href="{{ $banner->link }}" class="img-cover__wrapper">
                    <img src="{{ config('site.url_static') . $banner->image }}" alt="">
                </a>
            </div>
            @endforeach
		    @endif
        </div>
    </div>
</section>
<section class="section hero">
    <div class="container">
        <div class="carousel js-carousel">
            @if(!empty($banner_ngang_trang_chu_1))
            @foreach($banner_ngang_trang_chu_1 as $banner)
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
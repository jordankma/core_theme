<section class="section logo-group">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="logo-list">
                    <h2 class="title">Ban tổ chức cuộc thi</h2>
                    <div class="carousel js-carousel-01">
                        @if(!empty($list_logo_ban_to_chuc_cuoc_thi))
                        @foreach($list_logo_ban_to_chuc_cuoc_thi as $element)
                        <a class="carousel-item" href="{{ $element->link }}">
                            <div class="logo">
                                <img src="{{ config('site.url_static') . $element->img }}" alt="">
                            </div>
                            <h3 class="name">{{ $element->comname }}</h3>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="logo-list">
                    <h2 class="title">Đơn vị đồng hành</h2>
                    <div class="carousel js-carousel-02">
                        @if(!empty($list_logo_don_vi_dong_hanh))
                        @foreach($list_logo_don_vi_dong_hanh as $element)
                        <a class="carousel-item" href="{{ $element->link }}">
                            <div class="logo">
                                <img src="{{ config('site.url_static') . $element->img }}" alt="">
                            </div>
                            <h3 class="name">{{ $element->comname }}</h3>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
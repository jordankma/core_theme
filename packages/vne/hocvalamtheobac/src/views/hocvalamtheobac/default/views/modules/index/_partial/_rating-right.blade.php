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
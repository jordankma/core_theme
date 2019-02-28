<section class="new-user" style="background-image: url({{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/bg.png'}});">
    <div class="container">
        <h2 class="headline">Thành viên mới nhất</h2>
        <div class="row">
            @if(!empty($list_thi_sinh_moi->data))
            @foreach ($list_thi_sinh_moi->data as $element)
            <div class="col-md-6 col-lg-3 user-item">
                <div class="wrapper">
                    <div class="img-cover avatar">
                        <span class="img-cover__wrapper">
                            <img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/user1.png'}}" alt="">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="name">{{ $element->name }}</h3>
                    <p class="address">{{ (isset($element->class_name) && $element->class_name != '') ? $element->class_name : ''  }} 
                                    - {{ (isset($element->school_name) && $element->school_name != '') ? $element->school_name : '' }} 
                                    - {{ (isset($element->province_name) && $element->province_name != '') ? $element->province_name : '' }}
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            {{-- <div class="col-md-6 col-lg-3 user-item">
                <div class="wrapper">
                    <div class="img-cover avatar">
                        <span class="img-cover__wrapper">
                            <img src="images/user1.png" alt="">
                        </span>
                    </div>
                    <div class="info">
                        <h3 class="name">Nguyễn Thị Ngân</h3>
                        <p class="class-school">Lớp 12 -
                            <span>THPT Hoài Đức A -</span></p>
                        <p class="district">Quảng Bình</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
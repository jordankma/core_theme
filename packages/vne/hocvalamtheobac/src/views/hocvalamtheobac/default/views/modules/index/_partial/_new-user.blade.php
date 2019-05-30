{{-- <section class="new-user" style="background-image: url({{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/bg.png'}});">
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
                        <h3 class="name" style="font-size:12px">{{ $element->name }}</h3>
                        <p style="margin:0px; font-size:10px"> {{ (isset($element->class_name) && $element->class_name != '') ? $element->class_name : ''  }}  </p>
                        <p style="margin:0px; font-size:10px"> {{ (isset($element->school_name) && $element->school_name != '') ? $element->school_name : '' }} </p>
                        <p style="margin:0px; font-size:10px"> {{ (isset($element->province_name) && $element->province_name != '') ? $element->province_name : '' }} </p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section> --}}
@if(count($list_logo_don_vi_tai_tro) > 0)
<section class="section logo-group v1" style="background: #00adeea3;padding-top: 15px; padding-bottom: 0px;">
    <h2 class="headline">Đơn vị tài trợ</h2>
    <div class="container">
        <div class="carousel js-carousel-03" style="margin-top: 0px;">
            @foreach($list_logo_don_vi_tai_tro as $element)
            <a class="carousel-item" href="{{ $element->comlink }}">
                <div class="logo">
                    <img src="{{ config('site.url_static') . $element->img }}" alt="">
                </div>
                <h3 class="name" style="color:#0e2871;margin: 0px;">{{ $element->comname }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
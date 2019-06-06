<section class="section timeline js-timeline">
    <div class="container">
        <div class="timeline-inner">
            <h2 class="headline"><a href="">Timeline cuộc thi</a></h2>
            <ul class="timeline-list">
                @if(!empty($list_time_line))
                @php 
                    $date_now = new Datetime();
                    $date_now_string = $date_now->format('Y-m-d H:i:s');
                @endphp
                @foreach ($list_time_line as $element)
                    <li class="item @if($element->starttime > $date_now_string) item-new @endif">
                        <div class="inner">
                            <div class="title"> {{ $element->titles }} </div>
                            <div class="date"> 
                                Từ {{ date_format(date_create($element->starttime),"d/m/Y") }} <br> 
                                Đến {{ date_format( date_create($element->endtime),"d/m/Y") }}
                            </div>
                        </div>
                    </li>
                @endforeach
                @endif
            </ul>
            <div class="info">
                {{-- <div class="user user-registration">--}}
                    {{--<img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/images/cup2.png' }}" alt="">--}}
                    {{--<div class="number">{!! $count_thi_sinh_dang_ky !!}</div>--}}
                    {{--<div class="title">THÍ SINH ĐĂNG KÝ</div>--}}
                {{--</div> --}}
                {{--<div class="user user-active">--}}
                    {{--<img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/images/flag.png' }}" alt="">--}}
                    {{--<div class="number">{!! $count_thi_sinh_thi !!}</div>--}}
                    {{--<div class="title">THÍ SINH ĐÃ THI</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</section>
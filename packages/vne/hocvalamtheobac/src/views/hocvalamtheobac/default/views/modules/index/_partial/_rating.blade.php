<section class="section rating">
    <div class="rating-item">
        <div class="wrapper">
            <h2 class="headline">{{ isset($list_top_thi_sinh_dang_ky->title) ? $list_top_thi_sinh_dang_ky->title : '' }}</h2>
            <div class="tab js-tab">
                @if(!empty($list_top_thi_sinh_dang_ky->data_child))
                @foreach ($list_top_thi_sinh_dang_ky->data_child as $element)
                    <div class="tab-item @if($loop->index == 0) active @endif">
                        <div class="title"> {{ $element->title }}</div>
                        <ul class="list">
                            @if(!empty($element->data_table))
                            @foreach ($element->data_table as $element2)
                            @if(!empty($element2))
                            <li class="list-item">
                                <div class="number">{{ $loop->index +1 }}</div>
                                <div class="info">
                                    <div class="number-user"> {{ isset($element2[2]) ? $element2[2] : '' }} <span>thí sinh</span></div>
                                    <div class="address"> {{ isset($element2[1]) ? $element2[1] : '' }} </div>
                                </div>
                            </li>
                            @endif
                            @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
                @endif
            </div>
            <a href="{{ !empty($list_top_thi_sinh_dang_ky) ? route('frontend.get.top',$list_top_thi_sinh_dang_ky->params) : ''}}" class="btn btn-light">Xem thêm</a>
        </div>
    </div>
    <div class="rating-item">
        <div class="wrapper">
            <h2 class="headline">{{ isset($list_top_thi_sinh_da_thi->title) ? $list_top_thi_sinh_da_thi->title : '' }}</h2>
            <div class="tab js-tab">
                @if(!empty($list_top_thi_sinh_da_thi->data_child))
                @foreach ($list_top_thi_sinh_da_thi->data_child as $element)
                    <div class="tab-item @if($loop->index == 0) active @endif">
                        <div class="title"> {{ $element->title }}</div>
                        <ul class="list">
                            @if(!empty($element->data_table))
                            @foreach ($element->data_table as $element2)
                            @if(!empty($element2))
                            <li class="list-item">
                                <div class="number">{{ $loop->index +1 }}</div>
                                <div class="info">
                                    <div class="number-user"> {{ isset($element2[2]) ? $element2[2] : '' }} <span>thí sinh</span></div>
                                    <div class="address"> {{ isset($element2[1]) ? $element2[1] : '' }} </div>
                                </div>
                            </li>
                            @endif
                            @endforeach
                            @endif
                        </ul>
                    </div>
                @endforeach
                @endif
            </div>
            <a href="{{ !empty($list_top_thi_sinh_da_thi->params) ? route('frontend.get.top',$list_top_thi_sinh_da_thi->params) : ''}}" class="btn btn-light">Xem thêm</a>
        </div>
    </div>
</section>
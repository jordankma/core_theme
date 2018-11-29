@extends('VNE-THEME::layouts.master')
@section('content')
<!-- main -->
<main class="main">
    <section class="info" >
        <div class="container">
            <div class="detail" style="background: #fff; padding: 10px;">
                <p> Họ tên :  </p>
                <p> Tên tài khoản :  </p>
                <p> Ngày sinh :  </p>
            </div>
        </div>	
    </section>
    <section class="result search-results">
        <div class="container">
            <div class="detail" style="background: #f1f1f1;">
                @if(!empty($headers))
                <ul class="detail-row title">
                    @foreach ($headers as $element)
                        <li class="detail-col-5">{{ $element }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="detail-list">
                    @if(!empty($data))
                    @foreach($data as $key => $element)
                        <ul class="detail-row item">
                            @if(!empty($element))
                            @foreach($element as $key2 => $element2)
                                <li class="detail-col-5">{{ $element2 }}</li>
                            @endforeach
                            @endif
                        </ul>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
<!-- main end -->
@stop
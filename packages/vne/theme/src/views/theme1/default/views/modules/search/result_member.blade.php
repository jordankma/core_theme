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
            <div class="table-responsive detail">
                <table class="table">
                    @if(!empty($headers))
                    <thead>
                        <tr>
                            @foreach ($headers as $element)
                                <th>{{ $element }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    @endif
                    <tbody>
                        @if(!empty($data))
                        @foreach($data as $key => $element)
                            <tr>
                                @if(!empty($element))
                                @foreach($element as $key2 => $element2)
                                    <td>{{ $element2 }}</td>
                                @endforeach
                                @endif
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<!-- main end -->
@stop
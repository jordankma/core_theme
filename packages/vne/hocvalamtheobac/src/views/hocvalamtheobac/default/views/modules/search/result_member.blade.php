@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('content')
<!-- main -->
<main class="main">
    <section class="info" >
        <div class="container">
            <div class="detail" style="background: #fff; padding: 10px;margin-top:40px">
                <h3>Thông tin thí sinh</h3>
                @if(!empty($user_info))
                @foreach ($user_info as $item)
                    <p style="display: inline-block; margin-left:40px">
                        {{ isset($item->value) && $item->value !='null' ? $item->title : ''  }}
                         {{  isset($item->value) && $item->value !='null' ? ':' . $item->value : '' }}
                    </p>
                @endforeach
                @endif
            </div>
        </div>	
    </section>
    <section class="result search-results">
        <div class="container">
            <div class="table-responsive detail">
                <table class="table" style="text-align: left; background: #ccc;">
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
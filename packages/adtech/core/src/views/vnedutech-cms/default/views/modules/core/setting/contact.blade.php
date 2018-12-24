@extends('web.web')
@section('content')
@section('title')
    Liên hệ
@stop
<section class="tittle-list-sub tittle-list-sub-detail-new">
    <div class="container text-center">
        <h5>Liên hệ</h5>
        <p>
            <a href="index.html">Trang chủ</a>&ensp;
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>&ensp;
            <a href="list-new.html">Liên hệ</a>
        </p>
    </div>
</section>
@php
    use Jenssegers\Agent\Agent;
    $agent = new Agent(); 
@endphp 
<section class="container contact-content">
    <p class="tittle-contact-details text-center" style="
    @if( $agent->isMobile() ) 
        {{ 'margin:0px' }}
    @endif
    ">
        Để Học cùng thủ khoa hỗ trợ bạn nhanh hơn và hiệu quả hơn, vui lòng mô tả chi tiết thông tin bạn cần hỗ trợ,
        cùng với số điện thoại và email bạn đang học trên Học cùng thủ khoa (nếu có)
    </p>
    <div class="row">
        <div class="col-md-4 col-xs-12 div-contact-left">
            <div class="div-contact-1 div-contact">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>Địa chỉ</span>
                <p class="font-size-16">
                @php
                    $contact = json_decode($systemsetting->info);
                @endphp
                {{ $contact->addr }}
                </p>
            </div>

            <div class="div-contact-2 div-contact">
                <i class="fa fa-mobile" aria-hidden="true"></i>
                <span>Hotline</span>
                <p class="color-red robo-bold font-size-16">
                    @php
                        $hotline = array();
                        $hotline = json_decode($systemsetting->hotline);
                        $contact = json_decode($systemsetting->info);
                    @endphp
                    {{$hotline[0]}}
                </p>
            </div>

            <div class="div-contact-3 div-contact">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <span class="span-email">Email</span>
                <p class="color-red robo-bold font-size-16">
                @php
                        $contact = json_decode($systemsetting->info);
                @endphp
                {{ $contact->email }}
                </p>
            </div>
        </div>
        @if (session('finish'))
            <div class="alert alert-success setime">
                {{session('finish')}}    
            </div>   
        @endif
        <div class="col-md-8 col-xs-12 div-contact-right">
            <form method="post" action="{{ route('contacts') }}">
                @foreach($errors->all() as $messages)
                <p class="alert alert-danger setime">{{ $messages }}</p>
                @endforeach
                <div class="col-md-6 col-xs-12 ">
                    <input required type="text" name="fullname" class="form-control" placeholder="Họ tên">
                </div>
                <div class="col-md-6 col-xs-12">
                    <input required type="text" name="mail" class="form-control" placeholder="Địa chỉ email">
                </div>
                <div class="col-md-6 col-xs-12">
                    <input required type="text" name="title" class="form-control" placeholder="Tiêu đề">
                </div>
                <div class="col-md-6 col-xs-12">
                    <input required type="text" name="phone" class="form-control" placeholder="Số điện thoại">
                </div>
                <div class="col-md-12 col-xs-12">
                    <textarea required name="contacttext" class="form-control" id=""></textarea>
                </div>
                <button class="btn btn-sent-contact">liên hệ</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</section>
@stop
@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.setime').delay(3000).slideUp();
    });
</script>

@endsection
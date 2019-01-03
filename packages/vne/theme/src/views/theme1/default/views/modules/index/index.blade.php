@extends('VNE-THEME::layouts.master')
@section('title') {{ 'Trang chủ'}} @stop
@section('header_styles')
	{{-- .timeline .timeline-list::after{
		background:url({{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/cup1.png?t=' . time()) }})
	} --}}
@stop
@section('content')
<main class="main">

	<div class="hero-countdown" style="background-image: url({{ asset('/vendor/' . $group_name . '/' . $skin . '/images/bg-banner1.png?t=' . time()) }});">
		<div class="container">
			<div class="row no-spacing">
				<!-- hero -->
				@include('VNE-THEME::layouts.index._banner')
				<!-- hero end -->
				<!-- Countdown clock -->
				<section class="col-lg-4 no-spacing section countdown-clock">
					<h2 class="headline">Cuộc thi GIAO THÔNG HỌC ĐƯỜNG </h2>
					<div data-minutes="{{ $minutes_countdown }}"></div>
					<div class="button-group">
						{{-- <a class="btn" href="{{ route('vne.get.real.exam') }}" id="btn-real-exam">Vào thi</a> --}}
						{{-- <a class="btn" href="{{ route('vne.get.try.exam') }}" id="btn-try-exam">Thi thử</a> --}}
					</div>
				</section>
				<!-- Countdown clock end -->
			</div>
		</div>
	</div>

	<div class="container container-main">
		<div class="row">

			@include('VNE-THEME::layouts.index._logo_group')
			@if(!empty($banner_ngang_trang_chu_1))
			<div class="col-12">
				<!-- adv -->
				<div class="section adv">
					<a href="{{ $banner_ngang_trang_chu_1->link }}" target="_blank">
						<img src="{{ $banner_ngang_trang_chu_1->image }}">
					</a>
				</div>
				<!-- adv end -->
			</div>
			@endif

			@include('VNE-THEME::layouts.index._timeline')

			@if(!empty($banner_ngang_trang_chu_2))
			<div class="col-12">
				<!-- adv -->
				<div class="section adv">
					<a href="{{ $banner_ngang_trang_chu_2->link }}" target="_blank">
						<img src="{{ $banner_ngang_trang_chu_2->image }}">
					</a>
				</div>
				<!-- adv end -->
			</div>
			@endif

			@include('VNE-THEME::layouts.index._notification')

			@if(!empty($banner_ngang_trang_chu_3))
			<div class="col-12">
				<!-- adv -->
				<div class="section adv">
					<a href="{{ $banner_ngang_trang_chu_3->link }}" target="_blank">
						<img src="{{ $banner_ngang_trang_chu_3->image }}">
					</a>
				</div>
				<!-- adv end -->
			</div>
			@endif

			@include('VNE-THEME::layouts.index._rating')

			@include('VNE-THEME::layouts.index._news_hot')
			
			@include('VNE-THEME::layouts.index._news_event')

			@include('VNE-THEME::layouts.index._news_group')
			@include('VNE-THEME::layouts.index._images_videos')

			@include('VNE-THEME::layouts.index._news_member_said')
			
			

			@include('VNE-THEME::layouts.index._new_member')
	
			<div class="col-lg-4">
				<!-- social -->
				<section class="section social">
					<h2 class="headline">GTHĐ TRÊN CÁC MẠNG XÃ HỘI</h2>
					<ul class="list">
						<li><a href="https://www.facebook.com/CuocThiGiaoThongHocDuong/"><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/social-facebook.png?t=' . time()) }}" alt=""></a></li>
						{{-- <li><a href="https://www.facebook.com/CuocThiGiaoThongHocDuong/"><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/social-youtube.png?t=' . time()) }}" alt=""></a></li> --}}
					</ul>
				</section>
				<!-- social end -->
			</div>

		</div>

	</div>

</main>
@stop
@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('content')
<main class="main">
	<!-- hero -->
	@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._hero')
	<!-- hero end -->

	<!-- logo list -->
	@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._logo-group')
	<!-- logo list end -->

	<!-- adv -->
	@if(!empty($banner_ngang_trang_chu_2))
	<div class="section adv">
		<div class="container">
			<a href="{{ $banner_ngang_trang_chu_2->link }}" target="_blank">
				<img src="{{ config('site.url_static') . $banner_ngang_trang_chu_2->image }}">
			</a>
		</div>
	</div>
	@endif
	<!-- adv end -->

	<div class="container container-main">
		<div class="row">
			<div class="col-lg-8 left-main">

				<!-- notification -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._notification')
				
				<!-- notification end -->

				<!-- adv -->
				@if(!empty($banner_ngang_trang_chu_3))
				<div class="section adv">
					<a href="{{ $banner_ngang_trang_chu_3->link }}" target="_blank">
						<img src="{{ config('site.url_static') . $banner_ngang_trang_chu_3->image }}">
					</a>
				</div>
				@endif
				<!-- adv end -->

				<!-- rating -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._rating')
				<!-- rating end -->

				<!-- new -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._news')
				<!-- new end -->

			</div>
			<div class="col-lg-4 right-main">

				<!-- rating right -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._rating-right')
				<!-- rating right end -->

				<!-- video right -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._video-right')
				<!-- video right end -->

				<!-- facebook right -->
				<section class="section facebook-right">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=270&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=226666764204714"
						width="100%" height="270" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"
						allow="encrypted-media"></iframe>
				</section>
				<!-- facebook right end -->

				<!-- advertising right -->
				<section class="section advertising-right">
					<div class="advertising-item">
						<a href=""><img src="images/adv.png" alt=""></a>
					</div>

				</section>
				<!-- advertising right end -->

			</div>
		</div>

	</div>

	<!-- new user -->
		@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._new-user')
	<!-- new user end -->

</main>	
@stop
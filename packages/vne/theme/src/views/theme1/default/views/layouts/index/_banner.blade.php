<section class="col-lg-8 no-spacing section hero">
	<div class="carousel js-carousel">
		@if(!empty($list_banner))
		@foreach($list_banner as $banner)
		<div class="img-cover carousel-item">
			<a href="{{ $banner->link }}" class="img-cover__wrapper">
				<img src="{{ $banner->image }}" alt="">
			</a>
		</div>
		@endforeach
		@endif
	</div>
</section>
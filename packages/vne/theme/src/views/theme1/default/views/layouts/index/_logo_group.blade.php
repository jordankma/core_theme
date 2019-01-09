<div class="col-12">
	<!-- logo list -->
	<section class="section logo-group">
		<div class="logo-list">
			<h2 class="title">Ban tổ chức cuộc thi</h2>
			<div class="carousel js-carousel-01">
				@if(!empty($list_don_vi_dong_hanh))
				@foreach($list_don_vi_dong_hanh as $element)
				<a class="carousel-item" href="{{ $element->comlink }}">
					<div class="logo">
						<img src="{{ config('site.url_static') . $element->img }}" alt="">
					</div>
					<h3 class="name">{{ $element->comname }}</h3>
				</a>
				@endforeach
				@endif
			</div>
		</div>
	</section>
	<!-- logo list end -->
</div>
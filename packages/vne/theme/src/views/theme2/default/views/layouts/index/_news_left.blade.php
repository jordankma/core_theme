<div class="col-md-6">
	<!-- news -->
	<section class="section news">
		<div class="headline-section bg-navy">
			<h2><a href="">rèn luyện đội viên 360</a></h2>
			<a href="">Xem tất cả</a>
		</div>
		<div class="news-list">
			@if(!empty($list_news_ren_luyen_doi_vien))
			@foreach ($list_news_ren_luyen_doi_vien as $element)
			@php 
				$alias = $element->title_alias . '.html';
				$date = $element->created_at;
			@endphp
			<figure class="item">
				<div class="img-cover">
					<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
						<img src="{{ $element->image }}" alt="">
					</a>
				</div>
				<div class="content">
					<h3 class="title">
						<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
					</h3>
					<div class="description">{{ $element->desc }}</div>
				</div>
			</figure>
			@endforeach
			@endif
		</div>
	</section>
	<!-- news end -->
</div>
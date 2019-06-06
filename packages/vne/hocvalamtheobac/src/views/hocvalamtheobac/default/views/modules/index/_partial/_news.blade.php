@if(!empty($list_tintuc))
<section class="section news">
	<div class="news-wrapper">
		@php 
			$tintuc = config('site.news_box.tintuc');
        @endphp
		<h2 class="headline"><a href="{{ route('frontend.news.list.box',$tintuc) }}" style="text-decoration: none">Tin tức - Sự kiện</a></h2>
		<div class="news-list">
			@foreach ($list_tintuc as $element)
			@php 
				$alias = $element->title_alias . '.html';
				$tintuc = config('site.news_box.tintuc');
			@endphp
			<figure class="news-item">
				<h2 class="title">
					<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
				</h2>
				<div class="content">
					<div class="img-cover">
						<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
							<img src="{{ config('site.url_static') . $element->image }}" alt="">
						</a>
					</div>
					<div class="info">
						<div class="date">{{ date_format($element->created_at,"d/m/Y") }}</div>
						<div class="description">{{ $element->desc }}</div>
						{{-- <div class="copyright"><i class="ii ii-bachelor-blue"></i> {{ $element->create_by }}</div> --}}
					</div>
				</div>
			</figure>
			@endforeach
		</div>
		<a href="{{ route('frontend.news.list.box',$tintuc) }}" class="btn btn-primary">Còn rất nhiều tin mới. Xem thêm ngay!</a>
		{{-- id="load_more_news" --}}
	</div>
</section>
@endif
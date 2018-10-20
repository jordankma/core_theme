<section class="section media">
	<div class="container">
		<h2 class="headline">VIDEO - HÌNH ẢNH NỔI BẬT</h2>
		<div class="row media-list">
			@if(!empty($list_news_hinh_anh_video))
			@foreach ($list_news_hinh_anh_video as $element)
			@php 
				$alias = $element->title_alias . '.html';
				$date = $element->created_at;
			@endphp
			<figure class="col-md-3 media-item video">
				<div class="img-cover">
					<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
						<img src="{{ $element->image }}" alt="">
					</a>
				</div>
				<h3 class="title">
					<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
				</h3>
			</figure>
			@endforeach
			@endif
		</div>
	</div>
</section>
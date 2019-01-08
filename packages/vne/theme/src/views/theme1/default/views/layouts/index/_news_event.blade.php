<div class="col-lg-6">
	<!-- news event -->
	<section class="section news-event">
		@php 
			$sukien = config('site.news_box.sukien');
		@endphp
		<h2 class="headline"><a href="{{ route('frontend.news.list.box',$sukien) }}">SỰ KIỆN</a></h2>
		<div class="inner">
			@if(!empty($list_news_event))
			@foreach($list_news_event as $element)
			@php 
				$alias = $element->title_alias . '.html';
			@endphp
			<figure class="news-item">
				<div class="img-cover">
					<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
						<img src="{{ $element->image }}" alt="">
					</a>
				</div>
				<div class="content">
					<h3 class="title">
						<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
					</h3>
					<div class="info">
						<span class="date">{{ date_format($element->created_at,"d/m/Y H:i:s") }}</span>
						{{-- <span class="view"><i class="fa fa-eye"></i> 1.802</span>
						<span class="commit"><i class="fa fa-chat"></i> 0</span> --}}
					</div>
				</div>
			</figure>
			@endforeach
			@endif
		</div>
	</section>
	<!-- news event end -->
</div>
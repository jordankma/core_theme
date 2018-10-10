<div class="col-md-6">
	<!-- message -->
	<section class="section message">
		<div class="headline-section">
			<h2><a href="">THÔNG BÁO CỦA HỘI ĐỒNG ĐỘI TW</a></h2>
			<a href="">Xem tất cả</a>
		</div>
		<ul class="message-list">
			@if(!empty($list_news_thong_bao_hoi_dong_doi))
			@foreach ($list_news_thong_bao_hoi_dong_doi as $element)
			@php 
				$alias = $element->title_alias . '.html';
				$date = $element->created_at;
			@endphp
			<li class="item">
				<div class="date">
					<div class="day">{{ date_format($date,"d") }}</div>
					<div class="month">{{ date_format($date,"m") }}</div>
				</div>
				<h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h3>
			</li>
			@endforeach
			@endif
		</ul>
	</section>
	<!-- message end -->
</div>
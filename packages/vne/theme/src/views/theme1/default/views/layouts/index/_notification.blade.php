<div class="col-12">
	<!-- notification -->
	<section class="section notification">
		<div class="notification-item">
			<div class="headline">
				@php 
					$thongbaobtc = config('site.news_box.thongbaobtc');
				@endphp
				<h2><a href="{{ route('frontend.news.list.box',$thongbaobtc) }}">THÔNG BÁO CỦA BAN TỔ CHỨC</a></h2>
				<a class="btn" href="{{ route('frontend.news.list.box',$thongbaobtc) }}">Xem thêm</a>
			</div>
			<div class="list">
				@if(!empty($list_thong_bao_btc))
				@foreach($list_thong_bao_btc as $element)
				@php 
					$alias = $element->title_alias . '.html';
				@endphp
				<div class="list-item">
					<p class="date">{{ date_format($element->created_at,"d/m/Y") }}</p>
					<h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h3>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</section>
	<!-- notification end -->
</div>
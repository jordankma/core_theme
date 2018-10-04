<div class="col-12">
	<!-- notification -->
	<section class="section notification">
		<div class="notification-item">
			<div class="headline">
				<h2><a href="">THÔNG BÁO CỦA BAN TỔ CHỨC</a></h2>
				<a class="btn" href="">Xem thêm</a>
			</div>
			<div class="list">
				@if(!empty($list_thong_bao_btc))
				@foreach($list_thong_bao_btc as $element)
				@php 
					$alias = $element->title_alias . '.html';
				@endphp
				<div class="list-item">
					<p class="date">{{ $element->created_at }}</p>
					<h3 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h3>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</section>
	<!-- notification end -->
</div>
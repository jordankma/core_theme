<footer class="footer">
	<div class="footer-top">
		<div class="container">
			<div class="carousel js-carousel-03">
				@if(!empty($list_don_vi_tai_tro))
				ĐƠN VỊ BẢO TRỢ TRUYỀN THÔNG
				@foreach($list_don_vi_tai_tro as $element)
				<div class="carousel-item">
					<a href="{{ $element->link }}"><img src="{{ $element->img }}" alt=""></a>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					{!! isset($SETTING['info_footer_1']) ? $SETTING['info_footer_1'] : '' !!}
				</div>
				<div class="col-md-4">
					{!! isset($SETTING['info_footer_2']) ? $SETTING['info_footer_2'] : '' !!}
				</div>
				<div class="col-md-4">
					{!! isset($SETTING['info_footer_3']) ? $SETTING['info_footer_3'] : '' !!}
				</div>
			</div>
		</div>
	</div>
</footer>
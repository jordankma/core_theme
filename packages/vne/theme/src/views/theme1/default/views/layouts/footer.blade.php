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
	<!-- Subiz -->
	<script>
		(function(s, u, b, i, z){
		u[i]=u[i]||function(){
		u[i].t=+new Date();
		(u[i].q=u[i].q||[]).push(arguments);
		};
		z=s.createElement('script');
		var zz=s.getElementsByTagName('script')[0];
		z.async=1; z.src=b; z.id='subiz-script';
		zz.parentNode.insertBefore(z,zz);
		})(document, window, 'https://widgetv4.subiz.com/static/js/app.js', 'subiz');
		subiz('setAccount', 'acqeyphvbknesdswtlgt');
	</script>
	<!-- End Subiz -->
</footer>
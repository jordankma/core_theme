<footer class="footer">
	<div class="footer-top">
		<div class="container">
			<div class="carousel js-carousel-03">
				<div class="carousel-item">
					<a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/vnedutech-logo.png?t=' . time()) }}" alt=""></a>
				</div>
				<div class="carousel-item">
					<a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/logo_bak.png?t=' . time()) }}" alt=""></a>
				</div>
				<div class="carousel-item">
					<a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/mgc.png?t=' . time()) }}" alt=""></a>
				</div>
				<div class="carousel-item">
					<a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/thieunien.png?t=' . time()) }}" alt=""></a>
				</div>
				<div class="carousel-item">
					<a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/hoahoctro.png?t=' . time()) }}" alt=""></a>
				</div>
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
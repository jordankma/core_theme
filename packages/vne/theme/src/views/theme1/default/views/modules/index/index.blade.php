@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<div class="hero-countdown" style="background-image: url({{ asset('/vendor/' . $group_name . '/' . $skin . '/images/bg-banner1.png?t=' . time()) }});">
		<div class="container">
			<div class="row no-spacing">
				<!-- hero -->
				@include('VNE-THEME::layouts.index._banner')
				<!-- hero end -->
				<!-- Countdown clock -->
				<section class="col-lg-4 no-spacing section countdown-clock">
					<h2 class="headline">Cuộc thi LUẬT GIA TƯƠNG LAI</h2>
					<div data-minutes="600000"></div>
					<div class="button-group">
						<a class="btn" href="">Vào thi</a>
						<a class="btn" href="">Thi thử</a>
					</div>
				</section>
				<!-- Countdown clock end -->
			</div>
		</div>
	</div>

	<div class="container container-main">
		<div class="row">

			@include('VNE-THEME::layouts.index._logo_group')

			@include('VNE-THEME::layouts.index._adv')

			@include('VNE-THEME::layouts.index._timeline')
			

			@include('VNE-THEME::layouts.index._adv')

			@include('VNE-THEME::layouts.index._notification')

			

			@include('VNE-THEME::layouts.index._adv')

			@include('VNE-THEME::layouts.index._rating')

			@include('VNE-THEME::layouts.index._news_hot')
			
			@include('VNE-THEME::layouts.index._news_event')

			@include('VNE-THEME::layouts.index._news_group')
			@include('VNE-THEME::layouts.index._images_videos')
			
			<div class="col-lg-4">
				<!-- quest -->
				<section class="section quest">
					<div class="headline">HỌ NÓI VỀ CHÚNG TÔI</div>
					<div class="quest-list js-carousel-02">
						<div class="item">
							<div class="avatar">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</a>
								</div>
							</div>
							<div class="info">
								<div class="commit">Deserunt amet eiusmod adipisicing exercitation. Ut nostrud duis consequat est commodo eu
									occaecat excepteur eiusmod magna magna.</div>
								<div class="name">Hồ Phi Khánh</div>
								<div class="address">Học sinh lớp 11 Tin, trường THPT chuyên Nguyễn Huệ</div>
							</div>
						</div>
						<div class="item">
							<div class="avatar">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</a>
								</div>
							</div>
							<div class="info">
								<div class="commit">Deserunt amet eiusmod adipisicing exercitation. Magna magna proident culpa est nostrud
									labore deserunt sit.</div>
								<div class="name">Hồ Phi Khánh</div>
								<div class="address">Học sinh lớp 11 Tin, trường THPT chuyên Nguyễn Huệ</div>
							</div>
						</div>
						<div class="item">
							<div class="avatar">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</a>
								</div>
							</div>
							<div class="info">
								<div class="commit">Deserunt amet eiusmod adipisicing exercitation. Incididunt mollit ad occaecat fugiat ut
									cupidatat labore dolor fugiat amet fugiat nostrud amet.</div>
								<div class="name">Hồ Phi Khánh</div>
								<div class="address">Học sinh lớp 11 Tin, trường THPT chuyên Nguyễn Huệ</div>
							</div>
						</div>
					</div>
				</section>
				<!-- quest end -->
			</div>

			<div class="col-lg-4">
				<!-- new user -->
				<section class="section new-user">
					<h2 class="headline">Thành viên mới nhất</h2>
					<div class="list-item">
						<div class="user-item">
							<div class="wrapper">
								<div class="img-cover avatar">
									<span class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</span>
								</div>
								<div class="info">
									<h3 class="name">Nguyễn Thị Ngân</h3>
									<p class="address">Lớp 12 - <a href="">THPT A Kim Bảng</a> - Hà Nam</p>
								</div>
							</div>
						</div>
						<div class="user-item">
							<div class="wrapper">
								<div class="img-cover avatar">
									<span class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</span>
								</div>
								<div class="info">
									<h3 class="name">Nguyễn Thị Ngân</h3>
									<p class="address">Lớp 12 - <a href="">THPT A Kim Bảng</a> - Hà Nam</p>
								</div>
							</div>
						</div>
						<div class="user-item">
							<div class="wrapper">
								<div class="img-cover avatar">
									<span class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</span>
								</div>
								<div class="info">
									<h3 class="name">Nguyễn Thị Ngân</h3>
									<p class="address">Lớp 12 - <a href="">THPT A Kim Bảng</a> - Hà Nam</p>
								</div>
							</div>
						</div>
						<div class="user-item">
							<div class="wrapper">
								<div class="img-cover avatar">
									<span class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</span>
								</div>
								<div class="info">
									<h3 class="name">Nguyễn Thị Ngân</h3>
									<p class="address">Lớp 12 - <a href="">THPT A Kim Bảng</a> - Hà Nam</p>
								</div>
							</div>
						</div>
						<div class="user-item">
							<div class="wrapper">
								<div class="img-cover avatar">
									<span class="img-cover__wrapper">
										<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
									</span>
								</div>
								<div class="info">
									<h3 class="name">Nguyễn Thị Ngân</h3>
									<p class="address">Lớp 12 - <a href="">THPT A Kim Bảng</a> - Hà Nam</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- new user end -->
			</div>

			<div class="col-lg-4">
				<!-- social -->
				<section class="section social">
					<h2 class="headline">GTHĐ TRÊN CÁC MẠNG XÃ HỘI</h2>
					<ul class="list">
						<li><a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/social-facebook.png?t=' . time()) }}" alt=""></a></li>
						<li><a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/social-youtube.png?t=' . time()) }}" alt=""></a></li>
					</ul>
				</section>
				<!-- social end -->
			</div>

		</div>

	</div>

</main>
@stop
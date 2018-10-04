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

			

			

			

			<div class="col-12">
				<!-- group news -->
				<section class="section news-group">
					<h2 class="headline"><a href="http://">HÀNH TRÌNH GIAO THÔNG HỌC ĐƯỜNG</a></h2>
					<div class="accordion js-accordion">
						<ul class="buttons js-accordion-buttons">
							<li class="active">Vòng cấp trường</li>
							<li>Vòng cấp tỉnh</li>
							<li>Vòng toàn quốc</li>
							<li>tin tức khác</li>
						</ul>
						<div class="blocks js-accordion-bodys">
							<div class="block active">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- group news end -->
			</div>

			<div class="col-12">
				<!-- images videos -->
				<section class="section images-videos">
					<h2 class="headline"><a href="http://">HÌNH ẢNH - VIDEO NỔI BẬT</a></h2>
					<div class="accordion js-accordion">
						<ul class="buttons js-accordion-buttons">
							<li class="active">Video Nổi bật</li>
							<li>Hình ảnh</li>
						</ul>
						<div class="blocks js-accordion-bodys">
							<div class="block active">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã
												tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho
												học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã
												tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho
												học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã
												tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho
												học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
							<div class="block">
								<div class="inner">
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần III</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học đường" lần
												III</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Trường THCS Dư Hàng Kênh từng bừng lễ trao giải vòng trường</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Vào sáng nay (06/03), trường THCS Dư Hàng Kênh, quận Lê Chân , thành phố Hải
												Phòng đã
												tổ chức lễ trao giải cuộc thi...</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Sự kiện mừng xuân Mậu Tuất 2018</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">[KHAI XUÂN – ĐÓN LỘC] Sự kiện mừng xuân Mậu Tuất 2018</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/new.jpg" alt="">
											</a>
										</div>
										<div class="content">
											<h3 class="title">
												<a href="">Bảo đảm an toàn giao thông cho học sinh, sinh viên dịp Tết Nguyên đán Mậu Tuất</a>
											</h3>
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Các nhà trường tăng cường giáo dục kiến thức tham gia giao thông, đảm bảo an toàn
												cho
												học sinh trong dịp Tết.</div>
										</div>
									</figure>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- images videos end -->
			</div>

			<div class="col-lg-4">
				<!-- quest -->
				<section class="section quest">
					<div class="headline">HỌ NÓI VỀ CHÚNG TÔI</div>
					<div class="quest-list js-carousel-02">
						<div class="item">
							<div class="avatar">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
										<img src="images/user.jpg" alt="">
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
						<li><a href=""><img src="src/images/social-facebook.png" alt=""></a></li>
						<li><a href=""><img src="src/images/social-youtube.png" alt=""></a></li>
					</ul>
				</section>
				<!-- social end -->
			</div>

		</div>

	</div>

</main>
@stop
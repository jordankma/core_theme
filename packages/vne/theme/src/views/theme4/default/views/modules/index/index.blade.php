@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

			<div class="hero-countdown" style="background-image: url(images/bg-banner.png);">
				<div class="container">
					<div class="row no-spacing">
						<!-- hero -->
						<section class="col-lg-8 no-spacing section hero">
							<div class="carousel js-carousel">
								<div class="img-cover carousel-item">
									<a href="#" class="img-cover__wrapper">
										<img src="images/slider.jpg" alt="">
									</a>
								</div>
								<div class="img-cover carousel-item">
									<a href="#" class="img-cover__wrapper">
										<img src="images/slider1.jpg" alt="">
									</a>
								</div>
							</div>
						</section>
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

					<div class="col-12">
						<!-- logo list -->
						<section class="section logo-group">
							<div class="logo-list">
								<h2 class="title">Ban tổ chức cuộc thi</h2>
								<div class="carousel js-carousel-01">
									<a class="carousel-item" href="">
										<div class="logo">
											<img src="images/btp-icon.png" alt="">
										</div>
										<h3 class="name">Bộ tư pháp</h3>
									</a>
									<a class="carousel-item" href="">
										<div class="logo">
											<img src="images/thieunien.png" alt="">
										</div>
										<h3 class="name">Thiếu liên tiền phong</h3>
									</a>
									<a class="carousel-item" href="">
										<div class="logo">
											<img src="images/vnedutech-logo.png" alt="">
										</div>
										<h3 class="name">Vnedutech</h3>
									</a>
									<a class="carousel-item" href="">
										<div class="logo">
											<img src="images/logo3.png" alt="">
										</div>
										<h3 class="name">Tập đoàn Giáo dục Egroup</h3>
									</a>
								</div>
							</div>
						</section>
						<!-- logo list end -->
					</div>

					<div class="col-12">
						<!-- adv -->
						<div class="section adv">
							<a href="" target="_blank">
								<img src="images/adv.png">
							</a>
						</div>
						<!-- adv end -->
					</div>

					<div class="col-12">
						<section class="section timeline">
							<h2 class="headline"><a href="">Timeline cuộc thi</a></h2>
							<ul class="timeline-list">
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 1</div>
										<div class="date">02/10 - 08/10</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 2</div>
										<div class="date">09/10 - 15/10</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 3</div>
										<div class="date">16/10 - 22/10</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 4</div>
										<div class="date">23/10 - 29/10</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 5</div>
										<div class="date">30/10 - 05/11</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 6</div>
										<div class="date">06/11 - 12/11</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Vòng loại online</div>
										<div class="date">27/11 - 30/11</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Vòng CK tập trung</div>
										<div class="date">02/12 - 03/12</div>
									</div>
								</li>
							</ul>
							<div class="info">
								<div class="user user-registration">
									<img src="src/images/cup2.png" alt="">
									<div class="number">233.657</div>
									<div class="title">THÍ SINH ĐĂNG KÝ</div>
								</div>
								<div class="user user-active">
									<img src="src/images/flag.png" alt="">
									<div class="number">197.998</div>
									<div class="title">THÍ SINH ĐÃ THI</div>
								</div>
							</div>
						</section>
					</div>

					<div class="col-lg-8 left-main">

						<!-- notification -->
						<section class="section notification">
							<div class="notification-item">
								<div class="headline">
									<h2><a href="">THÔNG BÁO CỦA BAN TỔ CHỨC</a></h2>
									<a class="btn" href="">Xem thêm</a>
								</div>
								<div class="list">
									<div class="list-item">
										<p class="date">11/06/2018</p>
										<h3 class="title"><a href="http://">Thông báo kết quả Cuộc thi “Tuổi trẻ học tập và làm theo tư tưởng, đạo
												đức,</a></h3>
									</div>
									<div class="list-item">
										<p class="date">11/06/2018</p>
										<h3 class="title"><a href="http://">Danh sách chính thức các thí sinh đoạt giải Vòng chung kết cá nhân xếp
												hạng</a></h3>
									</div>
									<div class="list-item">
										<p class="date">11/06/2018</p>
										<h3 class="title"><a href="http://">Danh sách chính thức các thí sinh đoạt giải Vòng chung kết cá nhân xếp
												hạng</a></h3>
									</div>
								</div>
							</div>
						</section>
						<!-- notification end -->

						<!-- new -->
						<section class="section news">
							<div class="news-wrapper">
								<div class="news-list">
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
									<figure class="news-item">
										<div class="inner">
											<div class="img-cover">
												<a href="#" class="img-cover__wrapper">
													<img src="images/new1.png" alt="">
												</a>
											</div>
											<div class="content">
												<h2 class="title">
													<a href="">Video: Tổng kết Cuộc thi Luật gia tương lai năm 2017</a>
												</h2>
												<div class="info">
													<span class="date">26/12/2017</span>
													<span class="view"><i class="fa fa-eye"></i> 1.802</span>
													<span class="commit"><i class="fa fa-chat"></i> 0</span>
												</div>
												<div class="description">17 tỉnh, thành phố tích cực hưởng ứng với trên 233.000 thí sinh tham gia, trong
													đó, vòng sơ khảo có trên 575.000 lượt
													thí sinh tham gia, vòng chung</div>
												<div class="copyright"><i class="fa fa-graduation-cap"></i> Ban tổ chức cuộc thi</div>
											</div>
										</div>
									</figure>
								</div>
								<a href="" class="btn btn-primary">Còn rất nhiều tin mới. Xem thêm ngay!</a>
							</div>
						</section>
						<!-- new end -->

					</div>

					<div class="col-lg-4 right-main">

						<!-- rating -->
						<section class="section rating">
							<div class="rating-item">
								<div class="wrapper">
									<h2 class="headline">Top thí sinh đăng ký</h2>
									<div class="tab js-tab">
										<div class="tab-item active">
											<div class="title">Sở GD & ĐT Tỉnh/TP</div>
											<ul class="list">
												<li class="list-item">
													<div class="number">01</div>
													<div class="info">
														<div class="number-user">180356 <span>thí sinh</span></div>
														<div class="address">Phú Thọ</div>
													</div>
												</li>
												<li class="list-item">
													<div class="number">02</div>
													<div class="info">
														<div class="number-user">92297 <span>thí sinh</span></div>
														<div class="address">Hà Nội</div>
													</div>
												</li>
												<li class="list-item">
													<div class="number">03</div>
													<div class="info">
														<div class="number-user">92297 <span>thí sinh</span></div>
														<div class="address">Thái Nguyên</div>
													</div>
												</li>
											</ul>
										</div>
										<div class="tab-item">
											<div class="title">Trường</div>
											<ul class="list">
												<li class="list-item">
													<div class="number">01</div>
													<div class="info">
														<div class="number-user">180356 <span>thí sinh</span></div>
														<div class="address">THPT Lưu Nhân Chú, Đại Từ</div>
													</div>
												</li>
												<li class="list-item">
													<div class="number">02</div>
													<div class="info">
														<div class="number-user">92297 <span>thí sinh</span></div>
														<div class="address">Trường Đại Học Nguyễn Tất Thành</div>
													</div>
												</li>
												<li class="list-item">
													<div class="number">03</div>
													<div class="info">
														<div class="number-user">92297 <span>thí sinh</span></div>
														<div class="address">THPT Lý Thái Tổ</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<a href="" class="btn btn-light">Xem thêm</a>
								</div>
							</div>
						</section>
						<!-- rating end -->

						<!-- rating right -->
						<section class="section rating-right">
							<div class="info">
								<div class="icon"><img src="src/images/cup.png" alt=""></div>
								<div class="number">1.120.726</div>
								<p>Thí sinh đăng ký</p>
							</div>
							<h3 class="headline">TOP Thí sinh dẫn đầu tuần</h3>
							<div class="list-user">

								<div class="tab js-tab">
									<div class="tab-item active">
										<div class="title">Bảng A</div>
										<div class="list">
											<div class="list-item">
												<div class="number">1</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Nguyễn Thanh Tuấn</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THTT Bảo Lộc</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">2</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Nguyễn Nam Hưng</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THPT Phạm Hồng Thái</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">3</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Lê Hồng Hạnh</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">Trường Đại học Sư phạm Hà Nội 2</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">4</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Phạm Ngọc Ánh</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THPT Hoài Đức A</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">5</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Huỳnh Thanh Thân</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">Trường Đại học Ngoại Thương</p>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-item">
										<div class="title">Bảng B</div>
										<div class="list">
											<div class="list-item">
												<div class="number">1</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Nguyễn Nam Hưng</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THTT Bảo Lộc</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">2</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Nguyễn Thanh Tuấn</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THPT Phạm Hồng Thái</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">3</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Lê Hồng Hạnh</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">Trường Đại học Sư phạm Hà Nội 2</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">4</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Phạm Ngọc Ánh</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">THPT Hoài Đức A</p>
												</div>
											</div>
											<div class="list-item">
												<div class="number">5</div>
												<div class="img">
													<div class="img-cover">
														<a href="#" class="img-cover__wrapper">
															<img src="images/user.png" alt="">
														</a>
													</div>
												</div>
												<div class="info">
													<h4 class="title">Huỳnh Thanh Thân</h4>
													<p class="date">200 - 00:15:016</p>
													<p class="name-school">Trường Đại học Ngoại Thương</p>
												</div>
											</div>
										</div>
									</div>

								</div>

							</div>
						</section>
						<!-- rating right end -->

						<!-- video right -->
						<section class="section video-right">
							<h3 class="headline">Video nổi bật</h3>
							<div class="video-item">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="images/video.png" alt="">
									</a>
								</div>
								<h4 class="title"><a href="http://">Video phát động cuộc thi “Tìm hiểu về biển, đảo
										Việt Nam” năm 2018</a></h4>
							</div>
							<ul class="list">
								<li class="list-item">
									<h5 class="title"><a href="">Giới thiệu cuộc thi “Tìm hiểu về biển, đảo Việt
											Nam” năm 2018</a></h5>
									<p class="date">29/11/2016</p>
								</li>
								<li class="list-item">
									<h5 class="title"><a href="">VTV1 đưa tin về lễ trao giải các vòng thi trắc nghiệm cuộc thi "Tìm hiểu về
											biển, đảo
											Việt Nam" năm 2018</a></h5>
									<p class="date">29/11/2016</p>
								</li>
								<li class="list-item">
									<h5 class="title"><a href="">Biển đảo Việt Nam nguồn cội tự bao giờ</a></h5>
									<p class="date">29/11/2016</p>
								</li>
							</ul>
							<a href="" class="btn btn-light">Xem thêm</a>
						</section>
						<!-- video right end -->

						<!-- quest -->
						<section class="section quest">
							<div class="headline">HỌ NÓI VỀ CHÚNG TÔI</div>
							<div class="quest-list js-carousel-02">
								<div class="item">
									<div class="avatar">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
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
												<img src="images/user1.png" alt="">
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
												<img src="images/user1.png" alt="">
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

						<!-- facebook right -->
						<section class="section facebook-right">
							<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=270&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=226666764204714"
							 width="100%" height="270" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"
							 allow="encrypted-media"></iframe>
						</section>
						<!-- facebook right end -->

					</div>

					<div class="col-12">
						<!-- new user -->
						<section class="section new-user">
							<h2 class="headline">Thành viên mới nhất</h2>
							<div class="row list-item">
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-4 user-item">
									<div class="wrapper">
										<div class="img-cover avatar">
											<span class="img-cover__wrapper">
												<img src="images/user1.png" alt="">
											</span>
										</div>
										<div class="info">
											<h3 class="name">Nguyễn Thị Ngân</h3>
											<p class="address">Lớp 11-THCS và THPT Mỹ Thuận -Sóc Trăng</p>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!-- new user end -->
					</div>

				</div>

			</div>

		</main>
@stop
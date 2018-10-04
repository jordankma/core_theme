@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

			<div class="hero-countdown" style="background-image: url(../images/bg-banner1.png);">
				<div class="container">
					<div class="row no-spacing">
						<!-- hero -->
						<section class="col-lg-8 no-spacing section hero">
							<div class="carousel js-carousel">
								<div class="img-cover carousel-item">
									<a href="#" class="img-cover__wrapper">
										<img src="images/_73.jpg" alt="">
									</a>
								</div>
								<div class="img-cover carousel-item">
									<a href="#" class="img-cover__wrapper">
										<img src="images/_75.jpg" alt="">
									</a>
								</div>
								<div class="img-cover carousel-item">
									<a href="#" class="img-cover__wrapper">
										<img src="images/bannner-26-thang-3_78.jpg" alt="">
									</a>
								</div>
							</div>
						</section>
						<!-- hero end -->
						<!-- Countdown clock -->
						<section class="col-lg-4 no-spacing section countdown-clock">
							<h2 class="headline">Hộ thi ánh sáng soi đường</h2>
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

					<div class="col-lg-8">
						<!-- organizations -->
						<section class="section organizations">
							<h2 class="headline">ĐƠN VỊ TỔ CHỨC</h2>
							<ul class="list js-carousel-01">
								<li><a href=""><span>Ban Tuyên Giáo<br> Trung ương Đảng</span></a></li>
								<li><a href=""><img src="images/doan-tncs.png" alt=""><span>Trung ương Đoàn<br> TNCS Hồ Chí Minh</span></a></li>
								<li><a href=""><span>Bộ Giáo dục<br> và Đào tạo</span></a></li>
							</ul>
						</section>
						<!-- organizations end -->
					</div>

					<div class="col-lg-4">
						<!-- organizations -->
						<section class="section organizations">
							<h2 class="headline">ĐƠN VỊ ĐỒNG HÀNH</h2>
							<ul class="list">
								<li><a href=""><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/egroup-logo.png?t=' . time()) }}" alt=""></a></li>
							</ul>
						</section>
						<!-- organizations end -->
					</div>

					<div class="col-12">
						<!-- timeline -->
						<section class="section timeline">
							<h2 class="headline"><a href="">Timeline cuộc thi</a></h2>
							<ul class="timeline-list">
								<li class="item active">
									<div class="inner">
										<div class="title">thi thử</div>
										<div class="date">26/02 - 02/03</div>
									</div>
								</li>
								<li class="item">
									<div class="inner">
										<div class="title">Tuần 1</div>
										<div class="date">02/10 - 08/10</div>
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
							</ul>
							<div class="info">
								<div class="user">
									<img src="src/images/cup2.png" alt="">
									<div class="number">416.329</div>
									<div class="title">THÍ sinh dự thi</div>
								</div>
							</div>
						</section>
						<!-- timeline end -->
					</div>

					<div class="col-12">
						<!-- notification -->
						<section class="section notification">
							<div class="notification-item">
								<div class="headline">
									<h2><a href="">THÔNG BÁO CỦA BAN TỔ CHỨC</a></h2>
									<a class="btn" href="">Xem thêm</a>
								</div>
								<div class="list">
									<div class="list-item">
										<p class="date">09/05/18</p>
										<h3 class="title"><a href="http://">Danh sách thí sinh đạt giải cấp tỉnh/thành phố Cuộc thi "Giao thông học
												đường" lần III</a></h3>
									</div>
									<div class="list-item">
										<p class="date">17/05/18</p>
										<h3 class="title"><a href="http://">THÔNG BÁO v/v điều chỉnh cơ cấu giải thưởng cuộc thi "Giao thông học
												đường" lần thứ III...</a></h3>
									</div>
									<div class="list-item">
										<p class="date">03/05/18</p>
										<h3 class="title"><a href="http://">DANH SÁCH THÍ SINH THAM GIA VÒNG THI CHUNG KẾT TOÀN QUỐC CUỘC THI "GIAO
												THÔNG HỌC ĐƯỜNG"...</a></h3>
									</div>
									<div class="list-item">
										<p class="date">14/05/18</p>
										<h3 class="title"><a href="http://">Thư mời tham dự vòng thi chung kết xếp hạng toàn quốc và lễ trao giải
												cuộc thi...</a></h3>
									</div>
									<div class="list-item">
										<p class="date">08/05/18</p>
										<h3 class="title"><a href="http://">Danh sách thí sinh đạt giải tuần 3, 4, 5, 6 Cuộc thi "Giao thông học
												đường" lần...</a></h3>
									</div>
								</div>
							</div>
						</section>
						<!-- notification end -->
					</div>

					<div class="col-lg-4">
						<!-- rating -->
						<section class="section rating v1">
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
					</div>

					<div class="col-lg-4">
						<!-- rating -->
						<section class="section rating v2">
							<div class="rating-item">
								<div class="wrapper">
									<h2 class="headline">TOP THÍ SINH ĐÃ THI</h2>
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
					</div>

					<div class="col-lg-4">
						<!-- rating right -->
						<section class="section rating-right">
							<h2 class="headline">TOP Thí sinh dẫn đầu tuần</h2>
							<div class="tab js-tab">
								<div class="tab-item active">
									<div class="title">Tuần</div>
									<div class="list">
										<div class="list-item">
											<div class="number">1</div>
											<div class="img">
												<div class="img-cover">
													<a href="#" class="img-cover__wrapper">
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
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
											<div class="number">3</div>
											<div class="img">
												<div class="img-cover">
													<a href="#" class="img-cover__wrapper">
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
													</a>
												</div>
											</div>
											<div class="info">
												<h4 class="title">Nguyễn Thanh Tuấn</h4>
												<p class="date">200 - 00:15:016</p>
												<p class="name-school">THTT Bảo Lộc</p>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-item">
									<div class="title">Chung cuộc</div>
									<div class="list">
										<div class="list-item">
											<div class="number">1</div>
											<div class="img">
												<div class="img-cover">
													<a href="#" class="img-cover__wrapper">
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
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
											<div class="number">3</div>
											<div class="img">
												<div class="img-cover">
													<a href="#" class="img-cover__wrapper">
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
													</a>
												</div>
											</div>
											<div class="info">
												<h4 class="title">Nguyễn Thanh Tuấn</h4>
												<p class="date">200 - 00:15:016</p>
												<p class="name-school">THTT Bảo Lộc</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<a href="" class="btn btn-light">Xem bảng xếp hạng</a>
						</section>
						<!-- rating right end -->
					</div>

					<div class="col-lg-6">
						<!-- news hot -->
						<section class="section news-hot">
							<h2 class="headline"><a href="http://">Tin Nóng</a></h2>
							<div class="inner">
								<figure class="news-item">
									<h3 class="title">
										<a href="">Veniam anim culpa amet eiusmod ullamco fugiat nisi amet proident ipsum exercitation enim sint.</a>
									</h3>
									<div class="content">
										<div class="img-cover">
											<a href="#" class="img-cover__wrapper">
												<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
											</a>
										</div>
										<div class="wrapper">
											<div class="info">
												<span class="date">26/12/2017</span>
												<span class="view"><i class="fa fa-eye"></i> 1.802</span>
												<span class="commit"><i class="fa fa-chat"></i> 0</span>
											</div>
											<div class="description">Qui reprehenderit est commodo amet officia esse nisi minim. Ut labore ut
												reprehenderit proident Lorem voluptate aliquip reprehenderit id in in proident. Qui consequat consectetur
												elit.</div>
										</div>
									</div>
								</figure>
								<ul class="list">
									<li class="item">
										<h4 class="title"><a href="http://">Elit officia est eiusmod officia qui reprehenderit laborum ut adipisicing
												fugiat officia nisi magna voluptate.</a></h4>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</li>
									<li class="item">
										<h4 class="title"><a href="http://">Aliquip amet amet occaecat dolor ipsum est dolore mollit quis consectetur
												mollit.</a></h4>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</li>
									<li class="item">
										<h4 class="title"><a href="http://">Exercitation pariatur quis eu velit dolor mollit deserunt exercitation
												nisi ad enim.</a></h4>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</li>
									<li class="item">
										<h4 class="title"><a href="http://">Proident excepteur cupidatat cillum sunt sit laboris excepteur ea elit.</a></h4>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</li>
								</ul>
							</div>
						</section>
						<!-- news hot end -->
					</div>

					<div class="col-lg-6">
						<!-- news event -->
						<section class="section news-event">
							<h2 class="headline"><a href="http://">SỰ KIỆN</a></h2>
							<div class="inner">
								<figure class="news-item">
									<div class="img-cover">
										<a href="#" class="img-cover__wrapper">
											<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
										</a>
									</div>
									<div class="content">
										<h3 class="title">
											<a href="">Minim et ea pariatur tempor id labore non Lorem minim.</a>
										</h3>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</div>
								</figure>
								<figure class="news-item">
									<div class="img-cover">
										<a href="#" class="img-cover__wrapper">
											<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
										</a>
									</div>
									<div class="content">
										<h3 class="title">
											<a href="">Sint enim occaecat proident deserunt occaecat.</a>
										</h3>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</div>
								</figure>
								<figure class="news-item">
									<div class="img-cover">
										<a href="#" class="img-cover__wrapper">
											<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
										</a>
									</div>
									<div class="content">
										<h3 class="title">
											<a href="">Non aliqua qui sint nulla veniam.</a>
										</h3>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</div>
								</figure>
								<figure class="news-item">
									<div class="img-cover">
										<a href="#" class="img-cover__wrapper">
											<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
										</a>
									</div>
									<div class="content">
										<h3 class="title">
											<a href="">Quis cillum aliquip excepteur anim qui reprehenderit ea in ex mollit aute.</a>
										</h3>
										<div class="info">
											<span class="date">26/12/2017</span>
											<span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span>
										</div>
									</div>
								</figure>
							</div>
						</section>
						<!-- news event end -->
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
														<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/new.jpg?t=' . time()) }}" alt="">
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
											<p class="address"><a href="http://">Trường Đại học Y Hải Phòng</a></p>
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
											<p class="address"><a href="http://">Trường Đại học Y Hải Phòng</a></p>
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
											<p class="address"><a href="http://">Trường Đại học Y Hải Phòng</a></p>
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
											<p class="address"><a href="http://">Trường Đại học Y Hải Phòng</a></p>
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
											<p class="address"><a href="http://">Trường Đại học Y Hải Phòng</a></p>
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
							<div class="headline">
								<h2>ÁNH SÁNG SOI ĐƯỜNG</h2>
								<p>Trên các Mạng xã hội</p>
							</div>
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
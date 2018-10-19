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
					<h2 class="headline">Cuộc thi GIAO THÔNG HỌC ĐƯỜNG</h2>
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
										<img src="http://stc.giaothonghocduong.com.vn/upload/giaothong_banner/100/36/ong-khuat-viet-hung_36_300x300.jpg?t=1513042815" alt="">
									</a>
								</div>
							</div>
							<div class="info">
								<div class="commit">“Với mục tiêu cuộc thi sẽ là cơ sở đánh giá và chứng nhận phần thi lý thuyết giấy phép lái xe hạng A1, A2, Ủy ban An toàn giao thông Quốc gia sẽ tiếp tục phối hợp cùng Bộ Giao thông vận tải, Bộ Giáo dục và Đào tạo, Tập đoàn giáo dục Egroup và các cơ quan liên quan hoàn thiện cơ sở hạ tầng công nghệ kỹ thuật, đánh giá nội dung bộ đề thi và kiến nghị các cơ quan quản lý nhà nước về việc sừa đổi những quy định liên quan nhằm nâng cao chất lượng của  cuộc thi, tạo một sân chơi lành mạnh, bổ ích và có ý nghĩa thực tiễn thu hút sự tham gia rỗng rãi và đông đảo các em học sinh PTTH trên toàn quốc.”</div>
								<div class="name">Ông Khuất Việt Hùng</div>
								<div class="address">Phó Chủ tịch Chuyên trách Ủy ban An toàn giao thông Quốc gia </div>
							</div>
						</div>
						<div class="item">
							<div class="avatar">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="http://stc.giaothonghocduong.com.vn/upload/giaothong_banner/100/37/em-nguyen-thi-lan-anh_37_300x300.jpg?t=" alt="">
									</a>
								</div>
							</div>
							<div class="info">
								<div class="commit">“Cuộc thi Giao thông học đường đã giúp em rất nhiều trong việc rèn luyện kiến thức cũng như văn hóa về an toàn giao thông. Với vinh dự được đứng trên ngôi vị cao nhất tại cuộc thi lần I, em sẽ cố gắng hết sức mình để thực hiện cũng như truyền tải những hành động, thông điệp an toàn giao thông tới mọi người.”</div>
								<div class="name">Em Nguyễn Thị Lan Anh</div>
								<div class="address">Lớp 11A1, trường THPT Trung Giã, Sóc Sơn, Hà Nội</div>
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
						<li><a href="https://www.facebook.com/CuocThiGiaoThongHocDuong/"><img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/social-youtube.png?t=' . time()) }}" alt=""></a></li>
					</ul>
				</section>
				<!-- social end -->
			</div>

		</div>

	</div>

</main>
@stop
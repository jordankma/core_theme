@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	<!-- breadcrumb -->
	<nav class="section breadcrumb">
		<div class="container">
			<ul class="breadcrumb-list">
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Trang chủ</a>
				</li>
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Liên hệ</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- breadcrumb end -->

	<!-- contact -->
	<section class="section contact">
		<div class="container">
			<div class="wrapper">
				<h1 class="headline">Thông tin liên hệ</h1>
				<div class="row">
					<div class="col-lg-6">
						<div class="maps">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6363086371703!2d105.79868641539858!3d21.007210986010058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aca143131561%3A0x5d47295f81445f37!2zMjVUMSBUcnVuZyBIb8OgIE5ow6JuIENow61uaA!5e0!3m2!1svi!2s!4v1536573738817"
							 width="100%" height="410" frameborder="0" style="border:0" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="info">
							<div class="info-item">
								<h2 class="title">BAN THANH NIÊN TRƯỜNG HỌC TRUNG ƯƠNG ĐOÀN TNCS HỒ CHÍ MINH</h2>
								<p><i class="fa fa-user"></i> Đồng Chí: Nguyễn Bá Cát, Cán bộ Ban Thanh Niên Trường học TW Đoàn, ĐTDĐ: 046 2631 777</p>
								<p><i class="fa fa-address"></i> 64 Bà Triệu, Quận Hoàn Kiếm, Thành Phố Hà Nội.</p>
							</div>
							<div class="info-item">
								<h2 class="title">CÔNG TY CỔ PHẦN TẬP ĐOÀN GIÁO DỤC EGAME (EGROUP)</h2>
								<p><i class="fa fa-user"></i> Đồng chí: Phạm Thu Huế - Phòng Cộng Đồng, Công Ty Cổ Phần Tập Đoàn Giáo Dục Egroup , ĐTDĐ: 0962 411 566.</p>
								<p><i class="fa fa-address"></i> Tầng 3, Tòa Nhà 25T1, Hoàng Đạo Thúy, Trung Hòa, Cầu Giấy, Hà Nội.</p>
								<p><i class="fa fa-phone"></i> 043 5555 1939</p>
							</div>
							<div class="info-item">
								<h2 class="title">THƯỜNG TRỰC BAN TỔ CHỨC:</h2>
								<p><i class="fa fa-email"></i> Email: anhsangsoiduong2017@gmail.com</p>
							</div>
						</div>
						<form action="" class="form-contact">
							<h2 class="title">Liên hệ với chúng tôi:</h2>
							<div class="row">
								<div class="form-group col-md-6">
									<input type="name" class="form-control" placeholder="Họ và tên">
								</div>
								<div class="form-group col-md-6">
									<input type="email" class="form-control" placeholder="Email">
								</div>
								<div class="form-group col-12">
									<textarea class="form-control" rows="8" placeholder="Nội dung"></textarea>
								</div>
							</div>
							<button class="btn btn-primary" type="submit">Gửi thông tin</button>
						</form>
					</div>
				</div>
			</div>
		</div>

	</section>
	<!-- contact end -->

</main>
@stop
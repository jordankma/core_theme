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
					<a class="breadcrumb-link" href="#">Tra cứu</a>
				</li>
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Danh sách thí sinh</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- breadcrumb end -->

	<!-- search -->
	<section class="section search">
		<div class="container">
			<div class="search-wrapper">
				<div class="headline"><i class="fa fa-search"></i> Tra cứu danh sách thí sinh</div>
				<form action="" class="search-form">
					<div class="wrapper">
						<div class="form-group col-12">
							<label for="bangThi">Chọn bảng</label>
							<select class="form-control">
								<option>Chọn bảng</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="id">Tên đăng nhập</label>
							<input type="id" class="form-control" placeholder="Tên đăng nhập">
						</div>
						<div class="form-group col-md-4">
							<label for="name">Họ tên</label>
							<input type="name" class="form-control" placeholder="Họ tên">
						</div>
						<div class="form-group col-md-4">
							<label for="provinceCity">Chọn tỉnh/thành phố</label>
							<select class="form-control">
								<option>Chọn tỉnh/thành phố</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="district">Quận/huyện</label>
							<select class="form-control">
								<option>Chọn quận/huyện</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="school">Trường</label>
							<select class="form-control">
								<option>Chọn trường</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="class">Lớp</label>
							<select class="form-control">
								<option>Chọn lớp</option>
							</select>
						</div>
					</div>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>
			</div>
		</div>
	</section>
	<!-- search end -->

	<!-- search results -->
	<section class="section search-results">
		<div class="container">
			<div class="results">Tổng só: <span>1.965.697</span> lượt thi</div>
			<!-- pagination -->
			<nav class="pagination">
				<ul class="nav">
					<li class="item">
						<a class="link disabled" href="#">Đầu</a>
					</li>
					<li class="item">
						<a class="link disabled" href="#"><i class="fa fa-angle-right"></i></a>
					</li>
					<li class="item">
						<a class="link active" href="#">1</a>
					</li>
					<li class="item">
						<a class="link" href="#">2</a>
					</li>
					<li class="item">
						<a class="link" href="#">3</a>
					</li>
					<li class="item">
						<a class="link" href="#">4</a>
					</li>
					<li class="item">
						<a class="link" href="#">5</a>
					</li>
					<li class="item">
						<a class="link" href="#">6</a>
					</li>
					<li class="item">
						<a class="link" href="#">7</a>
					</li>
					<li class="item">
						<a class="link" href="#">8</a>
					</li>
					<li class="item">
						<a class="link" href="#">9</a>
					</li>
					<li class="item">
						<a class="link" href="#">10</a>
					</li>
					<li class="item">
						<a class="link" href="#"><i class="fa fa-angle-left"></i></a>
					</li>
					<li class="item">
						<a class="link" href="#">Cuối</a>
					</li>
				</ul>
			</nav>
			<!-- pagination end -->
			<div class="detail">
				<ul class="detail-row title">
					<li class="detail-col-1">STT</li>
					<li class="detail-col-2">Họ tên</li>
					<li class="detail-col-3">Tên đăng nhập</li>
					<li class="detail-col-4">Lớp</li>
					<li class="detail-col-5">Trường</li>
					<li class="detail-col-6">Quận/Huyện</li>
					<li class="detail-col-7">Thành phố</li>
					<li class="detail-col-8">Thời gian</li>
					<li class="detail-col-9">Điểm</li>
				</ul>
				<div class="detail-list">
					<ul class="detail-row item">
						<li class="detail-col-1">1</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">2</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">3</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">4</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">5</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">6</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">7</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">8</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">9</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">10</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">11</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">12</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">13</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">14</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">15</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">16</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">17</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">18</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">19</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A10</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
					<ul class="detail-row item">
						<li class="detail-col-1">20</li>
						<li class="detail-col-2">Nguyễn Trí Đức Nghĩa</li>
						<li class="detail-col-3">banhbeovodung0102</li>
						<li class="detail-col-4">Lớp A1</li>
						<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
						<li class="detail-col-6">Quận 5</li>
						<li class="detail-col-7">TP. Hồ Chí Minh</li>
						<li class="detail-col-8">00:15:018</li>
						<li class="detail-col-9">200</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- search results end -->


</main>
@stop
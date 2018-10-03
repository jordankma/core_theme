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
					<a class="breadcrumb-link" href="#">Tự luận</a>
				</li>
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Danh sách bài thi</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- breadcrumb end -->

	<!-- search -->
	<section class="section search">
		<div class="container">
			<div class="search-wrapper">
				<div class="headline"><i class="fa fa-search"></i> Tra cứu bài thi</div>
				<form action="" class="search-form">
					<div class="wrapper">
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
							<label for="name_post">Tên bài viết</label>
							<input type="name_post" class="form-control" placeholder="Tên bài viết">
						</div>
						<div class="form-group col-md-4">
							<label for="topic">Đề tài</label>
							<select class="form-control">
								<option>Chọn đề tài</option>
							</select>
						</div>
					</div>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>
			</div>
		</div>
	</section>
	<!-- search end -->

	<!-- posts -->
	<div class="section posts">
		<div class="container">
			<div class="wrapper">
				<div class="inner">
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
					<figure class="post-item">
						<div class="img-cover">
							<a href="#" class="img-cover__wrapper">
								<img src="images/new.jpg" alt="">
							</a>
						</div>
						<div class="content">
							<h3 class="title">
								<a href="">Suy nghĩ của bản thân về luận điểm "Việt Nam phấn đấu trở...</a>
							</h3>
							<div class="date">10:37 28/07/2018</div>
						</div>
					</figure>
				</div>
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
			</div>
		</div>
	</div>
	<!-- posts end -->


</main>
@stop
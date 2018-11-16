@extends('VNE-THEME::layouts.master')
@section('content')
<!-- main -->
<main class="main">
	<!-- ratings -->
	<section class="section ratings">
		<div class="container">
			
			<div class="ratings-wrapper">
				<h1 class="headline">{{ $title}}</h1>
				<form class="ratings-search" action="{{ route('frontend.get.top',$type) }}" method="GET">
					<select class="form-control" name="data_child_params">
						@if(!empty($list_top))
						@foreach ($list_top as $element)
							<option value="{{ $element->params }}">Top {{ $element->title }}</option>	
						@endforeach
						@endif
					</select>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>
				<!-- pagination -->
				<nav class="pagination" style="padding-left: 30%;">
					<ul class="">
						<li class="page-item">
							<a class="page-link disabled" href="#">Đầu</a>
						</li>
						<li class="page-item">
							<a class="page-link disabled" href="#"><i class="fa fa-angle-right"></i></a>
						</li>
						<li class="page-item">
							<a class="page-link active" href="#">1</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">2</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">3</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">4</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">5</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">6</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">7</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">8</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">9</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">10</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#"><i class="fa fa-angle-left"></i></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">Cuối</a>
						</li>
					</ul>
				</nav>
				<!-- pagination end -->
				<div class="content">
					<div class="row title">
						<div class="col-2 col-md-1"></div>
						<div class="col-6 col-md-6">Thành phố</div>
						<div class="col-4 col-md-5">Số lượng</div>
					</div>
					<ol class="list">
						<li class="row">
							<div class="col-2 col-md-1 top"><img src="src/images/cuo-vang.png" alt=""></div>
							<div class="col-6 col-md-6 name-city">Phú Thọ</div>
							<div class="col-4 col-md-5 number">145.309</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top"><img src="src/images/cup-bac.png" alt=""></div>
							<div class="col-6 col-md-6 name-city">Thái Nguyên</div>
							<div class="col-4 col-md-5 number">51.177</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top"><img src="src/images/cup-dong.png" alt=""></div>
							<div class="col-6 col-md-6 name-city">Hà Nội</div>
							<div class="col-4 col-md-5 number">53.124</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">4</div>
							<div class="col-6 col-md-6 name-city">Tp.Hồ Chí Minh</div>
							<div class="col-4 col-md-5 number">18.672</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">5</div>
							<div class="col-6 col-md-6 name-city">Nam Định</div>
							<div class="col-4 col-md-5 number">26.975</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">6</div>
							<div class="col-6 col-md-6 name-city">Nghệ An</div>
							<div class="col-4 col-md-5 number">23.911</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">7</div>
							<div class="col-6 col-md-6 name-city">Bắc Ninh</div>
							<div class="col-4 col-md-5 number">23.463</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">8</div>
							<div class="col-6 col-md-6 name-city">Bắc Giang</div>
							<div class="col-4 col-md-5 number">22.701</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">9</div>
							<div class="col-6 col-md-6 name-city">Quảng Ninh</div>
							<div class="col-4 col-md-5 number">21.331</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">10</div>
							<div class="col-6 col-md-6 name-city">Bình Định</div>
							<div class="col-4 col-md-5 number">20.392</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">11</div>
							<div class="col-6 col-md-6 name-city">Quảng Trị</div>
							<div class="col-4 col-md-5 number">19.567</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">12</div>
							<div class="col-6 col-md-6 name-city">Quảng Bình</div>
							<div class="col-4 col-md-5 number">18.828</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">13</div>
							<div class="col-6 col-md-6 name-city">Lào Cai</div>
							<div class="col-4 col-md-5 number">14.942</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">14</div>
							<div class="col-6 col-md-6 name-city">Bình Dương</div>
							<div class="col-4 col-md-5 number">13.532</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">15</div>
							<div class="col-6 col-md-6 name-city">Sơn La</div>
							<div class="col-4 col-md-5 number">14.410</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">16</div>
							<div class="col-6 col-md-6 name-city">Đà Nẵng</div>
							<div class="col-4 col-md-5 number">10.890</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">17</div>
							<div class="col-6 col-md-6 name-city">Hà Tĩnh</div>
							<div class="col-4 col-md-5 number">11.251</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">18</div>
							<div class="col-6 col-md-6 name-city">Đắk Lắk</div>
							<div class="col-4 col-md-5 number">9.784</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">19</div>
							<div class="col-6 col-md-6 name-city">Đồng Tháp</div>
							<div class="col-4 col-md-5 number">7.514</div>
						</li>
						<li class="row">
							<div class="col-2 col-md-1 top">20</div>
							<div class="col-6 col-md-6 name-city">Quảng Nam</div>
							<div class="col-4 col-md-5 number">6.797</div>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
	<!-- ratings end -->
</main>
<!-- main end -->
@stop
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
					<a class="breadcrumb-link" href="#">Bảng xếp hạng</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- breadcrumb end -->

	<!-- ratings -->
	<section class="section ratings">
		<div class="container">
			<div class="ratings-wrapper">
			<h1 class="headline">{{ $title }}</h1>
				
				{{-- <form class="ratings-search" action="">
					<select class="form-control">
						<option>Top thành phố đã thi</option>
					</select>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form> --}}
				<div class="content">
					<h2 class="headline">Top thí sinh thi theo tỉnh</h2>
					@if(!empty($list_top_thi_sinh_da_thi_tinh))
					<div class="row title">
						<div class="col-2 col-md-1"></div>
						<div class="col-6 col-md-6">Thành phố</div>
						<div class="col-4 col-md-5">Số lượng</div>
					</div>
					<ol class="list">
						@foreach ($list_top_thi_sinh_da_thi_tinh->data as $item)
							<li class="row">
								<div class="col-2 col-md-1 top">{{ $loop->index+1 }}</div>
								<div class="col-6 col-md-6 name-city">{{ $item->name }}</div>
								<div class="col-4 col-md-5 number">{{ $item->total }}</div>
							</li>
						@endforeach
					</ol>
					@endif
					<h2 class="headline">Top thí sinh thi theo trường</h2>
					@if(!empty($list_top_thi_sinh_da_thi_truong))
					<div class="row title">
						<div class="col-2 col-md-1"></div>
						<div class="col-6 col-md-6">Trường</div>
						<div class="col-4 col-md-5">Số lượng</div>
					</div>
					<ol class="list">
						@foreach ($list_top_thi_sinh_da_thi_truong->data as $item)
							<li class="row">
								<div class="col-2 col-md-1 top">{{ $loop->index+1 }}</div>
								<div class="col-6 col-md-6 name-city">{{ $item->name }}</div>
								<div class="col-4 col-md-5 number">{{ $item->total }}</div>
							</li>
						@endforeach
					</ol>
					@endif
				</div>
			</div>
		</div>
	</section>
	<!-- ratings end -->


</main>
@stop
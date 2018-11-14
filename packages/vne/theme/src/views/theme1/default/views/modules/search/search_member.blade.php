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
						{!! $form_search !!}
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
			<div class="results">Tổng số: <span> {{$list_member->total()}}</span> lượt thi</div>
			<!-- pagination -->
			{{$list_member->links()}}
			<!-- pagination end -->
			<div class="detail">
					@if(!empty($list_member))
					@foreach ($list_member as $element)
					@if($loop->index==0)
					<ul class="detail-row title">
						<li class="detail-col-1">STT</li>
						<li class="detail-col-2">Họ tên</li>
						<li class="detail-col-3">Tên đăng nhập</li>
						<li class="detail-col-4">Lớp</li>
						<li class="detail-col-5">Trường</li>
						<li class="detail-col-6">Quận/Huyện</li>
						<li class="detail-col-7">Thành phố</li>
					</ul>
					<div class="detail-list">
						<ul class="detail-row item">
							<li class="detail-col-1">{{ (($params['page']-1)*20) + $loop->index + 1 }}</li>
							<li class="detail-col-2">{{ $element['name'] }}</li>
							<li class="detail-col-3">banhbeovodung0102</li>
							<li class="detail-col-4">Lớp A10</li>
							<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
							<li class="detail-col-6">Quận 5</li>
							<li class="detail-col-7">TP. Hồ Chí Minh</li>
						</ul>
					@else 
						<ul class="detail-row item">
							<li class="detail-col-1">{{ (($params['page']-1)*20) + $loop->index + 1 }}</li>
							<li class="detail-col-2">{{ $element['name'] }}</li>
							<li class="detail-col-3">banhbeovodung0102</li>
							<li class="detail-col-4">Lớp A10</li>
							<li class="detail-col-5">Trường Đại học Khoa học Tự nhiên - Đại học QG Tp Hồ Chí Minh</li>
							<li class="detail-col-6">Quận 5</li>
							<li class="detail-col-7">TP. Hồ Chí Minh</li>
						</ul>
					@endif
						@endforeach
						@endif
					</div>
				</div>
		</div>
	</section>
	<!-- search results end -->


</main>
@stop
@section('footer_scripts')
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form.js?t=' . time()) }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
            
            
		});
	</script>
@stop
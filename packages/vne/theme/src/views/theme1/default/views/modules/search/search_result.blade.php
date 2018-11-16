@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	<!-- search -->
	<section class="section search">
		<div class="container">
			<div class="search-wrapper">
				<div class="headline"><i class="fa fa-search"></i> Tìm kiếm kết quả</div>
				<form action="{{route('frontend.exam.list.result')}}" class="search-form" method="GET">
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
					<li class="detail-col-8">Thời gian</li>
					<li class="detail-col-9">Điểm</li>
				</ul>
				<div class="detail-list">
					<ul class="detail-row item">
						<li class="detail-col-1">{{ (($params['page']-1)*20) + $loop->index + 1 }}</li>
						<li class="detail-col-2">{{ $element['name'] }}</li>
						<li class="detail-col-3">{{ $element['u_name'] }}</li>
						<li class="detail-col-4">{{ $element['class_name'] }}</li>
						<li class="detail-col-5">{{ $element['school_name'] }}</li>
						<li class="detail-col-6">{{ $element['district_name'] }}</li>
						<li class="detail-col-7">{{ $element['province_name'] }}</li>
						<li class="detail-col-8">{{ $element['used_time'] }}</li>
						<li class="detail-col-9">{{ $element['point_real'] }} điểm</li>
					</ul>
				@else 
					<ul class="detail-row item">
						<li class="detail-col-1">{{ (($params['page']-1)*20) + $loop->index + 1 }}</li>
						<li class="detail-col-2">{{ $element['name'] }}</li>
						<li class="detail-col-3">{{ $element['u_name'] }}</li>
						<li class="detail-col-4">{{ $element['class_name'] }}</li>
						<li class="detail-col-5">{{ $element['school_name'] }}</li>
						<li class="detail-col-6">{{ $element['district_name'] }}</li>
						<li class="detail-col-7">{{ $element['province_name'] }}</li>
						<li class="detail-col-8">{{ $element['used_time'] }}</li>
						<li class="detail-col-9">{{ $element['point_real'] }} điểm</li>
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
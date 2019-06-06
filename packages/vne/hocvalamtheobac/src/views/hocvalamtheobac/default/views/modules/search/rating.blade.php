@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('title') {{ 'Xếp hạng' }} @stop
@section('content')
@section('header_styles')
	<style>
		.pagination .page-item {
			display: inline-block;
		}
	</style>
@stop
<!-- main -->
<main class="main">
	<!-- ratings -->
	<section class="section ratings">
		<div class="container">
			<div class="ratings-wrapper">
				<h1 class="headline">{{ $title}} (TOP 100)</h1>
				<form class="ratings-search" action="{{ route('frontend.get.top',$type) }}" method="GET">
					<select class="form-control" name="data_child_params">
						@if(!empty($list_top))
						@foreach ($list_top as $element)
							<option value="{{ $element->params }}" @if($element->params == $data_child_params) selected @endif>Top {{ $element->title }}</option>	
						@endforeach
						@endif
					</select>
					<select class="form-control" name="target">
						<option value="">Tất cả các bảng</option>
						<option value="group_a" @if(!empty($params['target']) && $params['target'] == 'group_a') selected @endif>Bảng A (Học sinh phổ thông)</option>
						<option value="group_b" @if(!empty($params['target']) && $params['target'] == 'group_b') selected @endif>Bảng B (Sinh viên Việt Nam trong và ngoài nước)</option>
						<option value="group_c" @if(!empty($params['target']) && $params['target'] == 'group_c') selected @endif>Bảng C (Giáo viên, giảng viên, cán bộ ... dưới 35 tuổi)</option>
					</select>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>

				<div class="content">
					<div class="row title">
						@if(!empty($data_header))
						@foreach($data_header as $element)
						@if($loop->index==0)
							<div class="col-2 col-md-1">{{ $element }}</div>
						@endif
						@if($loop->index==1)
							<div class="col-3 col-md-3">{{ $element }}</div>
						@endif
						@if($loop->index==2)
							<div class="col-2 col-md-2">{{ $element }}</div>
						@endif
						@if($loop->index==3)
							<div class="col-3 col-md-3">{{ $element }}</div>
						@endif
						@if($loop->index==4)
							<div class="col-2 col-md-3">{{ $element }}</div>
						@endif
						@endforeach
						@endif
					</div>
					<ol class="list">
						@if(!empty($data_table->data))
						@foreach($data_table->data as $element)
						@if(!empty($element))
						<li class="row">
							<div class="col-1 col-md-1 top"> {{ $element[0] }}</div>
							<div class="col-3 col-md-3 name-city">{{ $element[1] }}</div>
							<div class="col-2 col-md-2 number">{{ $element[2] }}</div>
							@if(!empty($element[3]))
							<div class="col-3 col-md-3 number">{{ $element[3] }}</div>
							@endif
							@if(!empty($element[4]))
							<div class="col-3 col-md-3 number">{{ $element[4] }}</div>
							@endif
						</li>
						@endif
						@endforeach
						@endif
					</ol>
				</div>
				{{--<!-- pagination -->--}}
				{{--@if($data_table->total_page > 1)--}}
					{{--<nav class="pagination" style="padding-left: 30%;">--}}
						{{--<ul class="">--}}
							{{--<li class="page-item">--}}
								{{--<a class="page-link" href="{{ $url_get_by_page . '&page=1'}}">Đầu</a>--}}
							{{--</li>--}}
							{{--@if($page < $data_table->total_page - 8)--}}
								{{--@for($i = $page; $i <= $page+3 ; $i++)--}}
									{{--<li class="page-item">--}}
										{{--<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>--}}
									{{--</li>--}}
								{{--@endfor--}}
								{{--...--}}
								{{--@for($i = $data_table->total_page - 3 ; $i <= $data_table->total_page ; $i++)--}}
									{{--<li class="page-item">--}}
										{{--<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>--}}
									{{--</li>--}}
								{{--@endfor--}}
							{{--@elseif($data_table->total_page - $page < 8 && $data_table->total_page < 8)--}}
								{{--@for($i = 1; $i <= $data_table->total_page ; $i++)--}}
									{{--<li class="page-item">--}}
										{{--<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>--}}
									{{--</li>--}}
								{{--@endfor--}}
							{{--@else--}}
								{{--@for($i = $data_table->total_page - 8; $i <= $data_table->total_page ; $i++)--}}
									{{--<li class="page-item">--}}
										{{--<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>--}}
									{{--</li>--}}
								{{--@endfor--}}
							{{--@endif--}}
							{{--<li class="page-item">--}}
								{{--<a class="page-link" href="{{ $url_get_by_page . '&page=' . $data_table->total_page }}">Cuối</a>--}}
							{{--</li>--}}
						{{--</ul>--}}
					{{--</nav>--}}
				{{--@endif--}}
			{{--<!-- pagination end -->--}}
			<!-- pagination -->
				@if($data_table->total_page > 1)
					@php
						$total_page = $data_table->total_page > 10 ?10:$data_table->total_page;
					@endphp
					<nav class="pagination" style="padding-left: 30%;">
						<ul class="">
							@for($i = 1; $i <= $total_page ; $i++)
								<li class="page-item">
									<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>
								</li>
							@endfor
						</ul>
					</nav>
			@endif
			<!-- pagination end -->
			</div>
		</div>
	</section>
	<!-- ratings end -->
</main>
<!-- main end -->
@stop
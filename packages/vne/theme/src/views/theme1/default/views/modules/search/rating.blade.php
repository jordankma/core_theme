@extends('VNE-THEME::layouts.master')
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
				<h1 class="headline">{{ $title}}</h1>
				<form class="ratings-search" action="{{ route('frontend.get.top',$type) }}" method="GET">
					<select class="form-control" name="data_child_params">
						@if(!empty($list_top))
						@foreach ($list_top as $element)
							<option value="{{ $element->params }}" @if($element->params == $data_child_params) selected @endif>Top {{ $element->title }}</option>	
						@endforeach
						@endif
					</select>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>
				<!-- pagination -->
				@if($data_table->total_page > 1)
				<nav class="pagination" style="padding-left: 30%;">
					<ul class="">
						<li class="page-item">
							<a class="page-link" href="{{ $url_get_by_page . '&page=1'}}">Đầu</a>
						</li>
						@if($page < $data_table->total_page - 8)
							@for($i = $page; $i <= $page+3 ; $i++)
							<li class="page-item">
								<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>
							</li>
							@endfor
							...
							@for($i = $data_table->total_page - 3 ; $i <= $data_table->total_page ; $i++)
							<li class="page-item">
								<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>
							</li>
							@endfor
						@elseif($data_table->total_page - $page < 8 && $data_table->total_page < 8)
							@for($i = 1; $i <= $data_table->total_page ; $i++)
							<li class="page-item">
								<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>
							</li>
							@endfor	
						@else 
							@for($i = $data_table->total_page - 8; $i <= $data_table->total_page ; $i++)
							<li class="page-item">
								<a class="page-link @if($i == $page) active @endif" href="{{ $url_get_by_page . '&page=' . $i }}">{{ $i }}</a>
							</li>
							@endfor
						@endif
						<li class="page-item">
							<a class="page-link" href="{{ $url_get_by_page . '&page=' . $data_table->total_page }}">Cuối</a>
						</li>
					</ul>
				</nav>
				@endif
				<!-- pagination end -->
				<div class="content">
					<div class="row title">
						@if(!empty($data_header))
						@foreach($data_header as $element)
						@if($loop->index==0)
						<div class="col-2 col-md-1">{{ $element }}</div>
						@endif
						@if($loop->index==1)
						<div class="col-6 col-md-6">{{ $element }}</div>
						@endif
						@if($loop->index==2)
						<div class="col-4 col-md-5">{{ $element }}</div>
						@endif
						@endforeach
						@endif
					</div>
					<ol class="list">
						@if(!empty($data_table->data))
						@foreach($data_table->data as $element)
						@if(!empty($element))
						<li class="row">
							<div class="col-2 col-md-1 top"> @if($loop->index ==0) <img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/src/images/cuo-vang.png'}}" alt=""> @endif {{ $element[0] }}</div>
							<div class="col-6 col-md-6 name-city">{{ $element[1] }}</div>
							<div class="col-4 col-md-5 number">{{ $element[2] }}</div>
						</li>
						@endif
						@endforeach
						@endif
					</ol>
				</div>
			</div>
		</div>
	</section>
	<!-- ratings end -->
</main>
<!-- main end -->
@stop
@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
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
			<div class="results">Tổng số: <span> {{$list_member->total()}}</span> thí sinh</div>
			<!-- pagination -->
			{{$list_member->links()}}
			<!-- pagination end -->
			<div class="detail">
				@if(!empty($headers))
				<ul class="detail-row title">
					@foreach ($headers as $key => $element)
						<li class="detail-col-{{ $loop->index+ 1 }}">{{ $element }}</li>
					@endforeach
				</ul>
				@endif
				<div class="detail-list">
					@if(!empty($list_member))
					@foreach ($list_member as $key => $element)
						<ul class="detail-row item">
							@if(!empty($element))
							@foreach ($element as $key2 => $element2)
								<li class="detail-col-{{ $loop->index+ 1 }}">{{ $element2 }}</li>
							@endforeach
							@endif
						</ul>
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form_search.js?t=' . time()) }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
            
            
		});
	</script>
@stop
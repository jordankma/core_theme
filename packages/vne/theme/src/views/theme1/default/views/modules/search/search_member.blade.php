@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	{{-- <section class="section search">
		<div class="container">
			<h3 style="color:red; margin:0 auto;margin-left:30px;margin-top:30px;margin-bottom:400px;text-transform: uppercase">
				Hệ thống đang cập nhật! Tính năng tra cứu sẽ được mở vào 15h00 ngày 17/01/2019.
			</h3>
		</div>
	</section> --}}
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
			{!!$list_member->links()!!}
			<!-- pagination end -->
			<div class="table-responsive detail">
				<table class="table">
					@if(!empty($headers))
					<thead>
						<tr>
						@foreach ($headers as $key => $element)
							<th>{{ $element }}</th>
						@endforeach
						</tr>
					</thead>
					@endif
					<tbody>
						@if(!empty($list_member))
						@foreach ($list_member as $key => $element)
							<tr>
								@if(!empty($element))
								@foreach ($element as $key2 => $element2)
									<td>{{ $element2 }}</td>
								@endforeach
								@endif
							</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- search results end -->


</main>
@stop
@section('footer_scripts')
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form_search.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = window.location.search.substring(1),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
			};
			var u_name = getUrlParameter('u_name');
			setTimeout(function(){
				$("input[name='u_name']").val(u_name); 
			}, 500);
            
		});
	</script>
@stop
@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('title') {{ 'Học và làm theo bác' }} @stop
@section('content')
<main class="main">
	<!-- hero -->
	@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._hero')
	<!-- hero end -->

	<!-- logo list -->
	@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._logo-group')
	@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._js-timeline')
	<!-- logo list end -->

	<!-- adv -->
	@if(!empty($banner_ngang_trang_chu_2))
	@foreach($banner_ngang_trang_chu_2 as $item)
	<div class="section adv">
		<div class="container">
			<a href="{{ $item->link }}" target="_blank">
				<img src="{{ config('site.url_static') . $item->image }}">
			</a>
		</div>
	</div>
	@endforeach
	@endif
	<!-- adv end -->

	<div class="container container-main">
		<div class="row">
			<div class="col-lg-8 left-main">

				<!-- notification -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._notification')
				
				<!-- notification end -->

				<!-- adv -->
				@if(!empty($banner_ngang_trang_chu_2))
				@foreach($banner_ngang_trang_chu_2 as $item)
				<div class="section adv">
					<a href="{{ $item->link }}" target="_blank">
						<img src="{{ config('site.url_static') . $item->image }}">
					</a>
				</div>
				@endforeach
				@endif
				<!-- adv end -->

				<!-- rating -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._rating')
				<!-- rating end -->

				<!-- new -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._news')
				<!-- new end -->

			</div>
			<div class="col-lg-4 right-main">

				<!-- rating right -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._rating-right')
				<!-- rating right end -->

				<!-- video right -->
				@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._video-right')
				<!-- video right end -->

				<!-- facebook right -->
				<section class="section facebook-right">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhocvalamtheobac%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=368588296958531" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
				</section>
				<!-- facebook right end -->

				<!-- advertisin right -->
				{{-- <section class="section advertising-right">
					<div class="advertising-item">
						<a href=""><img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/adv.png'}}" alt=""></a>
					</div>
				</section> --}}
				<!-- advertising right end -->

			</div>
		</div>

	</div>

	<!-- new user -->
		@include('VNE-HOCVALAMTHEOBAC::modules.index._partial._new-user')
	<!-- new user end -->

</main>	
@stop
@section('footer_scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var last_page_tin_tuc = {{$last_page_tin_tuc}};
		var page = 1;
		$('#load_more_news').click(function(event) {
			page++;
			if(last_page_tin_tuc == page){
				$.ajax({
					url: "{{ route('vne.index.news.box','tin-tuc') }}",
					type: 'GET',
					cache: false,
					data: {
						'tin-tuc': page,

					},
					success: function (data, status) {
						var data = JSON.parse(data);
						var str = '';
						for(i = 0; i<data.length; i++) {
							var alias = data[i].title_alias +'.html';
							str += '<figure class="news-item">'
								+		'<h2 class="title">'
								+			'<a href="/chi-tiet/'+ alias +'">'+data[i].title+'</a>'
								+		'</h2>'
								+		'<div class="content">'
								+			'<div class="img-cover">'
								+				'<a href="/chi-tiet/' +alias+ '" class="img-cover__wrapper">'
								+					'<img src="'+data[i].image+'" alt="">'
								+				'</a>'
								+			'</div>'
								+			'<div class="info">'
								+				'<div class="date">'+data[i].created_at+'</div>'
								+				'<div class="description">'+data[i].desc+'</div>'
								+				'<div class="copyright"><i class="ii ii-bachelor-blue"></i> '+data[i].create_by+'</div>'
								+			'</div>'
								+		'</div>'
								+	'</figure>';  
							
						}   
						$('.news-list').append(str); 
					}
				}, 'json');
				$("#load_more_news").css("display", "none");
				$("#load_more_news").css("visible", "hidden");
			} else{	
				$.ajax({
					url: "{{ route('vne.index.news.box','tin-tuc') }}",
					type: 'GET',
					cache: false,
					data: {
						'tin-tuc': page,

					},
					success: function (data, status) {
						var data = JSON.parse(data);
						var str = '';
						for(i = 0; i<data.length; i++) {
							var alias = data[i].title_alias +'.html';
							str += '<figure class="news-item">'
								+		'<h2 class="title">'
								+			'<a href="/chi-tiet/'+ alias +'">'+data[i].title+'</a>'
								+		'</h2>'
								+		'<div class="content">'
								+			'<div class="img-cover">'
								+				'<a href="/chi-tiet/' +alias+ '" class="img-cover__wrapper">'
								+					'<img src="'+data[i].image+'" alt="">'
								+				'</a>'
								+			'</div>'
								+			'<div class="info">'
								+				'<div class="date">'+data[i].created_at+'</div>'
								+				'<div class="description">'+data[i].desc+'</div>'
								+				'<div class="copyright"><i class="ii ii-bachelor-blue"></i> '+data[i].create_by+'</div>'
								+			'</div>'
								+		'</div>'
								+	'</figure>';  
							
						}   
						$('.news-list').append(str); 
					}
				}, 'json');
			}
			return false;
		});
	});
</script>
@stop
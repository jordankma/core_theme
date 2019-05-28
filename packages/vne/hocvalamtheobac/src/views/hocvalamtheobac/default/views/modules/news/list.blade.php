@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('content')
<main class="main">
	<div class="container container-main">
		<div class="row">
			<div class="col-lg-8 left-main">
				<!-- new -->
				<section class="section news">
					<div class="news-wrapper">
						<div class="news-list">
							@if(!empty($list_news))
							@foreach($list_news as $element)
							@php $alias = $element->title_alias .'.html'; @endphp
							<figure class="news-item">
								<h2 class="title">
									<a href="{{ URL::to('chi-tiet', $alias) }}">Nội dung tìm hiểu của cuộc thi: Các chủ trương, quan điểm của Đảng, Nhà nước về biển đảo Việt Nam</a>
								</h2>
								<div class="content">
									<div class="img-cover">
										<a href="{{ URL::to('chi-tiet', $alias) }}" class="img-cover__wrapper">
											<img src="{{ config('site.url_static') . $element->image }}" alt="">
										</a>
									</div>
									<div class="info">
										<div class="date"><span>{{ date_format($element->created_at,"d/m/Y H:i:s") }}</span></div>
										<div class="description">{{ $element->desc }}</div>
										{{-- <div class="copyright"><i class="ii ii-bachelor-blue"></i> {{ $element->create_by }}</div> --}}
									</div>
								</div>
							</figure>
							@endforeach
							@endif
						</div>
						<!-- pagination -->
						{{$list_news->links()}}
						<!-- pagination end -->
					</div>
				</section>
				<!-- new end -->
			</div>
			<div class="col-lg-4 right-main">
				@include('VNE-HOCVALAMTHEOBAC::layouts._sidebar')
			</div>
		</div>
	</div>
</main>	
@stop
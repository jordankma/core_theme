@extends('VNE-THEME::layouts.master')
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
								<div class="inner">
									<div class="img-cover">
										<a href="{{ URL::to('chi-tiet', $alias) }}" class="img-cover__wrapper">
											<img src="{{ $element->image }}" alt="">
										</a>
									</div>
									<div class="content">
										<h2 class="title">
											<a href="{{ URL::to('chi-tiet', $alias) }}">{{ $element->title }}</a>
										</h2>
										<div class="info">
											<span class="date">{{ date_format($element->created_at,"d/m/Y H:i:s") }}</span>
											{{-- <span class="view"><i class="fa fa-eye"></i> 1.802</span>
											<span class="commit"><i class="fa fa-chat"></i> 0</span> --}}
										</div>
										<div class="description">{{ $element->desc }}</div>
										<div class="copyright"><i class="fa fa-graduation-cap"></i> {{ $element->create_by }}</div>
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

				@include('VNE-THEME::layouts._sidebar')

			</div>

		</div>

	</div>

	</main>	
@stop
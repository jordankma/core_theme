@extends('VNE-THEME::layouts.master')
@section('content')
<!-- main -->
<main class="main">

	<!-- breadcrumb -->
	<nav class="section breadcrumb">
		<div class="container">
			<ul class="breadcrumb-list">
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Trang chủ</a>
				</li>
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="#">Tin tức</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- breadcrumb end -->

	<div class="container container-main">
		<div class="row">
			<div class="col-lg-8 left-main">

				<!-- news -->
				<section class="section news news-page">
					<div class="news-list">
						@if(!empty($list_news))
						@foreach($list_news as $element)
						@php 
							$alias = $element->title_alias . '.html';
						@endphp
						<figure class="item">
							<div class="img-cover">
								<a href="{{ URL::to('chi-tiet',$alias) }}" class="img-cover__wrapper">
									<img src="{{ $element->image }}" alt="">
								</a>
							</div>
							<div class="content">
								<h3 class="title">
									<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
								</h3>
								<div class="description">{{ $element->desc }}</div>
							</div>
						</figure>
						@endforeach
						@endif
					</div>
					<!-- pagination -->
					{{$list_news->links()}}
					<!-- pagination end -->
				</section>
				<!-- news end -->
			</div>
			
			@include('VNE-THEME::layouts._sidebar')
			
		</div>

	</div>

</main>
<!-- main end -->
@stop
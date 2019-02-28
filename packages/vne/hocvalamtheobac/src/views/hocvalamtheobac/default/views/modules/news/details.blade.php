@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('content')
<main class="main">
	<div class="container container-main">
		<div class="row">
			<div class="col-lg-8 left-main">
				<!-- news detail -->
				<section class="section news-detail">
					<div class="wrapper">
						<h1 class="title">{{ $news->title }}</h1>
						<p class="date">{{ date_format($news->created_at,"d/m/Y H:i:s") }}</p>
						<div class="content">
							{!! $news->content !!}
						</div>
					</div>
				</section>
				<!-- news detail end -->
			</div>
			<div class="col-lg-4 right-main">
				@include('VNE-HOCVALAMTHEOBAC::layouts._sidebar')
			</div>
		</div>
	</div>

</main>
@stop
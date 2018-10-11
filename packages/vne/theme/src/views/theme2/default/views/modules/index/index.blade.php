@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	<div class="container">
		<div class="row no-spacing">
			<!-- hero -->
			@include('VNE-THEME::layouts.index._banner')
			<!-- hero end -->
			<!-- sign in -->
			<section class="col-md-4 col-xl-3 no-spacing section sign-in">
				@include('VNE-THEME::layouts._login')
			</section>
			<!-- sign in end -->
		</div>
	</div>

	<div class="container container-main">

		<!-- Accordion rating -->
		@include('VNE-THEME::layouts.index._accordion_rating')
		<!-- Accordion rating -->

		<div class="row">
			@include('VNE-THEME::layouts.index._message')

			@include('VNE-THEME::layouts.index._province')

			<div class="col-12">
				<!-- adv -->
				<div class="section adv">
					<a href="" target="_blank">
						<img src="images/adv1.jpg">
					</a>
				</div>
				<!-- adv end -->
			</div>
			
			@include('VNE-THEME::layouts.index._news_left')

			@include('VNE-THEME::layouts.index._news_right')
			
		</div>

	</div>

	<!-- media -->
	@include('VNE-THEME::layouts.index._media')
	<!-- media end -->

</main>
@stop
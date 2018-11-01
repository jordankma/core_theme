@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	<!-- calendar -->
	<section class="calendar">
		<div class="container">
			<div class="inner">
				@if(!empty($schedule))
				@foreach($schedule as $element)
					@if($loop->index==0)
					<ul class="calendar-row title">
						@if(!empty($element))
						@for( $i=0 ; $i<count($element) ; $i++)
							<li class="calendar-col-2"> {{ $element[$i] }} </li>
						@endfor
						@endif
					</ul>
					@else
						@if($loop->index==1)
						<div class="calendar-list">
						@endif
							<ul class="calendar-row item">
								@if(!empty($element))
								@for( $i=0 ; $i<count($element) ; $i++)
									<li class="calendar-col-2"> {{ $element[$i] }} </li>
								@endfor
								@endif
							</ul>
						@if($loop->last)	
							</div>
						@endif
					@endif
				@endforeach	
				@endif
			</div>
		</div>
	</section>
	<!-- calendar end -->

</main>
@stop
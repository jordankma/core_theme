@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">
	<!-- calendar -->
	<section class="calendar">
		<div class="container">
			<div class="inner">
				<ul class="calendar-row title">
					@if(!empty($schedule->table_header))
						@for( $i=0 ; $i<count($schedule->table_header) ; $i++)
							<li class="calendar-col-2"> {{ $schedule->table_header[$i] }} </li>	
						@endfor
					@endif
				</ul>
				<div class="calendar-list">
					@if(!empty($schedule->data_table))
						@if(!empty($schedule->data_table))
							@foreach ($schedule->data_table as $element)
								<ul class="calendar-row item">
									@if(!empty($element))
									@for( $i=0 ; $i<count($element) ; $i++)
										<li class="calendar-col-2"> {{ $element[$i] }} </li>
									@endfor
									@endif
								</ul>	
							@endforeach
						@endif
					@endif
				</div>
			</div>
		</div>
	</section>
	<!-- calendar end -->

</main>
@stop
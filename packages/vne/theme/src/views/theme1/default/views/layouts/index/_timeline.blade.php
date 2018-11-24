<div class="col-12">
	<section class="section timeline" style="background-image:url({{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/bg-timeline.png?t=' . time()) }});">
		<h2 class="headline"><a href="">Timeline cuộc thi</a></h2>
		<ul class="timeline-list">
			@if(!empty($list_time_line))
			@foreach ($list_time_line as $element)
				@if($loop->index==0)
					@continue
				@endif
				<li class="item">
					<div class="inner">
						<div class="title"> {{ $element->titles }} </div>
						<div class="date"> 
							Từ {{ date_format(date_create($element->starttime),"d-m-Y") }} 
							đến {{ date_format( date_create($element->endtime),"d-m-Y") }}
						</div>
					</div>
				</li>
			@endforeach
			@endif
		</ul>
		<div class="info">
			<div class="user user-registration">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/cup2.png?t=' . time()) }}" alt="">
				<div class="number">{{ $count_thi_sinh_dang_ky }}</div>
				<div class="title">THÍ SINH ĐĂNG KÝ</div>
			</div>
			<div class="user user-active">
				<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/flag.png?t=' . time()) }}" alt="">
				<div class="number">{{ $count_thi_sinh_thi }}</div>
				<div class="title">THÍ SINH ĐÃ THI</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-4">
	<!-- rating -->
	<section class="section rating v1">
		<div class="rating-item">
			<div class="wrapper">
				<h2 class="headline">{{ $list_top_thi_sinh_dang_ky->title }}</h2>
				<div class="tab js-tab">
					@if(!empty($list_top_thi_sinh_dang_ky->data_child))
					@foreach ($list_top_thi_sinh_dang_ky->data_child as $element)
						<div class="tab-item @if($loop->index == 0) active @endif">
							<div class="title"> {{ $element->title }}</div>
							<ul class="list">
								@if(!empty($element->data_table))
								@foreach ($element->data_table as $element2)
								<li class="list-item">
									<div class="number">{{ $loop->index +1 }}</div>
									<div class="info">
										<div class="number-user"> {{ $element2[0] }} <span>thí sinh</span></div>
										<div class="address"> {{ $element2[1] }} </div>
									</div>
								</li>
								@endforeach
								@endif
							</ul>
						</div>
					@endforeach
					@endif
				</div>
				<a href="{{ route('frontend.get.top',$list_top_thi_sinh_dang_ky->params)}}" class="btn btn-light">Xem thêm</a>
			</div>
		</div>
	</section>
	<!-- rating end -->
</div>

<div class="col-lg-4">
	<!-- rating -->
	<section class="section rating v2">
		<div class="rating-item">
			<div class="wrapper">
				<h2 class="headline">{{ $list_top_thi_sinh_da_thi->title }}</h2>
				<div class="tab js-tab">
					@if(!empty($list_top_thi_sinh_da_thi->data_child))
					@foreach ($list_top_thi_sinh_da_thi->data_child as $element)
						<div class="tab-item @if($loop->index == 0) active @endif">
							<div class="title"> {{ $element->title }}</div>
							<ul class="list">
								@if(!empty($element->data_table))
								@foreach ($element->data_table as $element2)
								<li class="list-item">
									<div class="number">{{ $loop->index +1 }}</div>
									<div class="info">
										<div class="number-user"> {{ $element2[0] }} <span>thí sinh</span></div>
										<div class="address"> {{ $element2[1] }} </div>
									</div>
								</li>
								@endforeach
								@endif
							</ul>
						</div>
					@endforeach
					@endif
				</div>
				<a href="{{ route('frontend.get.top',$list_top_thi_sinh_da_thi->params) }}" class="btn btn-light">Xem thêm</a>
			</div>
		</div>
	</section>
	<!-- rating end -->
</div>

<div class="col-lg-4">
	<!-- rating right -->
	<section class="section rating-right">
		<h2 class="headline">{{ $list_thi_sinh_dan_dau_tuan->title}}</h2>
		<div class="list">
			@if(!empty($list_thi_sinh_dan_dau_tuan->data_table ))
			@foreach($list_thi_sinh_dan_dau_tuan->data_table as $element)
			<div class="list-item">
				<div class="number"> {{ $loop->index+1 }} </div>
				<div class="img">
					<div class="img-cover">
						<a href="#" class="img-cover__wrapper">
							<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/images/user.jpg?t=' . time()) }}" alt="">
						</a>
					</div>
				</div>
				<div class="info">
					<h4 class="title">{{ $element[2] }}</h4>
					<p class="date">{{ $element[3] }} - {{ $element[4] }}</p>
					<p class="name-school">{{ $element[5] }} - {{ $element[6] }} - {{ $element[7] }}</p>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</section>
	<!-- rating right end -->
</div>
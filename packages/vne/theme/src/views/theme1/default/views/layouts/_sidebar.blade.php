<!-- rating -->
	@if(!empty($list_top_thi_sinh_dang_ky))
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
								@if(!empty($element2))
								<li class="list-item">
									<div class="number">{{ $loop->index +1 }}</div>
									<div class="info">
										<div class="number-user"> {{ $element2[2] }} <span>thí sinh</span></div>
										<div class="address"> {{ $element2[1] }} </div>
									</div>
								</li>
								@endif
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
	@endif
	<!-- rating end -->

	<!-- rating -->
	@if(!empty($list_top_thi_sinh_da_thi))
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
								@if(!empty($element2))
								<li class="list-item">
									<div class="number">{{ $loop->index +1 }}</div>
									<div class="info">
										<div class="number-user"> {{ $element2[2] }} <span>thí sinh</span></div>
										<div class="address"> {{ $element2[1] }} </div>
									</div>
								</li>
								@endif
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
	@endif
	<!-- rating end -->

	<!-- rating right -->
	@if($list_thi_sinh_dan_dau_tuan)
	<section class="section rating-right">
		<h2 class="headline">{{$list_thi_sinh_dan_dau_tuan->title}}</h2>
		<div class="list">
			@if(!empty($list_thi_sinh_dan_dau_tuan->data[0]->data_table ))
			@foreach($list_thi_sinh_dan_dau_tuan->data[0]->data_table as $element)
			<div class="list-item" style="padding-top:10px">
				<div class="number"> {{ $loop->index+1 }} </div>
				<div class="img">
					<div class="img-cover">
						<a href="#" class="img-cover__wrapper">
							<img src="{{ config('site.url_static') .'/vendor/' . $group_name . '/' . $skin . '/images/user.jpg' }}" alt="">
						</a>
					</div>
				</div>
				<div class="info">
					<h4 class="title">{{ $element[1] }}</h4>
					<p class="date">{{ $element[2] }}</p>
					<p class="name-school">{{ $element[3] }} - {{ $element[4] }}</p>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</section>
	@endif
	<!-- rating right end -->
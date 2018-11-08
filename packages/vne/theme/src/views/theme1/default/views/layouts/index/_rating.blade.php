<div class="col-lg-4">
	<!-- rating -->
	<section class="section rating v1">
		<div class="rating-item">
			<div class="wrapper">
				<h2 class="headline">Top thí sinh đăng ký</h2>
				<div class="tab js-tab">
					<div class="tab-item active">
						<div class="title">Sở GD & ĐT Tỉnh/TP</div>
						<ul class="list">
							@if(!empty($list_top_thi_sinh_dang_ky_tinh))
							@foreach ($list_top_thi_sinh_dang_ky_tinh->data as $element)
							<li class="list-item">
								<div class="number">{{$loop->index +1 }}</div>
								<div class="info">
									<div class="number-user"> {{ $element->total }} <span>thí sinh</span></div>
									<div class="address"> {{ $element->name }} </div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
					<div class="tab-item">
						<div class="title">Trường</div>
						<ul class="list">
							@if(!empty($list_top_thi_sinh_dang_ky_truong))
							@foreach ($list_top_thi_sinh_dang_ky_truong->data as $element)
							<li class="list-item">
								<div class="number">{{$loop->index +1 }}</div>
								<div class="info">
									<div class="number-user"> {{ $element->total }} <span>thí sinh</span></div>
									<div class="address"> {{ $element->name }} </div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
				</div>
				<a href="{{ route('frontend.get.top.register')}}" class="btn btn-light">Xem thêm</a>
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
				<h2 class="headline">TOP THÍ SINH ĐÃ THI</h2>
				<div class="tab js-tab">
					<div class="tab-item active">
						<div class="title">Sở GD & ĐT Tỉnh/TP</div>
						<ul class="list">
							@if(!empty($list_top_thi_sinh_da_thi_tinh))
							@foreach ($list_top_thi_sinh_da_thi_tinh->data as $element)
							<li class="list-item">
								<div class="number">{{$loop->index +1 }}</div>
								<div class="info">
									<div class="number-user"> {{ $element->total }} <span>thí sinh</span></div>
									<div class="address"> {{ $element->name }} </div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
					<div class="tab-item">
						<div class="title">Trường</div>
						<ul class="list">
							@if(!empty($list_top_thi_sinh_da_thi_truong))
							@foreach ($list_top_thi_sinh_da_thi_truong->data as $element)
							<li class="list-item">
								<div class="number">{{$loop->index +1 }}</div>
								<div class="info">
									<div class="number-user"> {{ $element->total }} <span>thí sinh</span></div>
									<div class="address"> {{ $element->name }} </div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
				</div>
				<a href="{{ route('frontend.get.top.result') }}" class="btn btn-light">Xem thêm</a>
			</div>
		</div>
	</section>
	<!-- rating end -->
</div>

<div class="col-lg-4">
	<!-- rating right -->
	<section class="section rating-right">
		<h2 class="headline">TOP Thí sinh dẫn đầu tuần</h2>
		<div class="list">
			@if(!empty($list_thi_sinh_dan_dau_tuan))
			@foreach($list_thi_sinh_dan_dau_tuan->data as $element)
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
					<h4 class="title">{{ $element->name }}</h4>
					<p class="date">{{ $element->point_real }} - {{ $element->used_time }}</p>
					{{-- <p class="name-school">{{ $element->school_name }}</p> --}}
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</section>
	<!-- rating right end -->
</div>
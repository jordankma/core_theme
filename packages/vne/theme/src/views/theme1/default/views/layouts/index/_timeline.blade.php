<div class="col-12">
				<section class="section timeline">
					<h2 class="headline"><a href="">Timeline cuộc thi</a></h2>
					<ul class="timeline-list">
						@if(!empty($list_time_line))
						@foreach ($list_time_line as $element)
							<li class="item">
								<div class="inner">
									<div class="title"> {{ $element->title }} </div>
									<div class="date"> {{ $element->starttime }} -> {{ $element->endtime }}</div>
								</div>
							</li>
						@endforeach
						@endif
					</ul>
					<div class="info">
						<div class="user user-registration">
							<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/cup2.png?t=' . time()) }}" alt="">
							<div class="number">233.657</div>
							<div class="title">THÍ SINH ĐĂNG KÝ</div>
						</div>
						<div class="user user-active">
							<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/flag.png?t=' . time()) }}" alt="">
							<div class="number">197.998</div>
							<div class="title">THÍ SINH ĐÃ THI</div>
						</div>
					</div>
				</section>
			</div>
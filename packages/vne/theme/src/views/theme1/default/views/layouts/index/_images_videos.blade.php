<div class="col-12">
	<!-- images videos -->
	<section class="section images-videos">
		<h2 class="headline"><a href="http://">HÌNH ẢNH - VIDEO NỔI BẬT</a></h2>
		<div class="accordion js-accordion">
			<ul class="buttons js-accordion-buttons">
				<li class="active">Video Nổi bật</li>
				<li>Hình ảnh</li>
			</ul>
			<div class="blocks js-accordion-bodys">
				<div class="block active">
					<div class="inner">
						@if(!empty($list_news_anh_video_1))
						@foreach ($list_news_anh_video_1 as $element)
							<figure class="news-item">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="{{ $element->image }}" alt="">
									</a>
								</div>
								<div class="content">
									<h3 class="title">
										<a href="">{{ $element->title }}</a>
									</h3>
									<div class="info">
										<span class="date">{{ $element->created_at }}</span>
										<span class="view"><i class="fa fa-eye"></i> 1.802</span>
										<span class="commit"><i class="fa fa-chat"></i> 0</span>
									</div>
									<div class="description">{{ $element->desc }}</div>
								</div>
							</figure>
						@endforeach
						@endif
					</div>
				</div>
				<div class="block">
					<div class="inner">
						@if(!empty($list_news_anh_video_2))
						@foreach ($list_news_anh_video_2 as $element)
							<figure class="news-item">
								<div class="img-cover">
									<a href="#" class="img-cover__wrapper">
										<img src="{{ $element->image }}" alt="">
									</a>
								</div>
								<div class="content">
									<h3 class="title">
										<a href="">{{ $element->title }}</a>
									</h3>
									<div class="info">
										<span class="date">{{ $element->created_at }}</span>
										<span class="view"><i class="fa fa-eye"></i> 1.802</span>
										<span class="commit"><i class="fa fa-chat"></i> 0</span>
									</div>
									<div class="description">{{ $element->desc }}</div>
								</div>
							</figure>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- images videos end -->
</div>
<div class="col-12">
				<!-- group news -->
				<section class="section news-group">
					<h2 class="headline"><a href="http://">HÀNH TRÌNH GIAO THÔNG HỌC ĐƯỜNG</a></h2>
					<div class="accordion js-accordion">
						<ul class="buttons js-accordion-buttons">
							<li class="active">Vòng cấp trường</li>
							<li>Vòng cấp tỉnh</li>
							<li>Vòng toàn quốc</li>
							<li>tin tức khác</li>
						</ul>
						<div class="blocks js-accordion-bodys">
							<div class="block active">
								<div class="inner">
									@if(!empty($list_news_hanh_trinh_truong))
									@foreach ($list_news_hanh_trinh_truong as $element)
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
									@if(!empty($list_news_hanh_trinh_tinh))
									@foreach ($list_news_hanh_trinh_tinh as $element)
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
									@if(!empty($list_news_hanh_trinh_toanquoc))
									@foreach ($list_news_hanh_trinh_toanquoc as $element)
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
									@if(!empty($list_news_hanh_trinh_khac))
									@foreach ($list_news_hanh_trinh_khac as $element)
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
				<!-- group news end -->
			</div>
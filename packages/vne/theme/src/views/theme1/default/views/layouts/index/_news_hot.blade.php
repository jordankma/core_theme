<div class="col-lg-6">
	<!-- news hot -->
	<section class="section news-hot">
		<h2 class="headline"><a href="http://">Tin Nóng</a></h2>
		<div class="inner">
			@if(!empty($list_news_hot))
			@foreach($list_news_hot as $element)
			@php 
				$alias = $element->title_alias . '.html';
			@endphp
			@if($loop->index==0)
			<figure class="news-item">
				<h3 class="title">
					<a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a>
				</h3>
				<div class="content">
					<div class="img-cover">
						<a href="#" class="img-cover__wrapper">
							<img src="{{ $element->image }}" alt="">
						</a>
					</div>
					<div class="wrapper">
						<div class="info">
							<span class="date">{{ $element->created_at }}</span>
							<span class="view"><i class="fa fa-eye"></i> 1.802</span>
							<span class="commit"><i class="fa fa-chat"></i> 0</span>
						</div>
						<div class="description">{{ $element->desc }}</div>
					</div>
				</div>
			</figure>
			@else

			@if($loop->index==1)
			<ul class="list">
			@endif
				<li class="item">
					<h4 class="title"><a href="{{ URL::to('chi-tiet',$alias) }}">{{ $element->title }}</a></h4>
					<div class="info">
						<span class="date">{{ $element->created_at }}</span>
						<span class="view"><i class="fa fa-eye"></i> 1.802</span>
						<span class="commit"><i class="fa fa-chat"></i> 0</span>
					</div>
				</li>
			@endif
			@endforeach
			</ul>
			@endif
		</div>
	</section>
	<!-- news hot end -->
</div>
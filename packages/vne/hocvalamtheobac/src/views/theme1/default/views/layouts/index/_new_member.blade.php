<div class="col-lg-4">
	<!-- new user -->
	<section class="section new-user">
		<h2 class="headline">Thành viên mới nhất</h2>
		<div class="list-item">
			@if(!empty($list_thi_sinh_moi->data))
			@foreach ($list_thi_sinh_moi->data as $element)
			<div class="user-item" style="margin-top:30px">
				<div class="wrapper">
					<div class="img-cover avatar">
						<span class="img-cover__wrapper">
							<img src="{{ config('site.url_static') . '/vendor/' . $group_name . '/' . $skin . '/images/user.jpg'}}" alt="">
						</span>
					</div>
					<div class="info">
						<h3 class="name">{{ $element->name }}</h3>
					<p class="address">{{ (isset($element->class_name) && $element->class_name != '') ? $element->class_name : ''  }} 
									- {{ (isset($element->school_name) && $element->school_name != '') ? $element->school_name : '' }} 
									- {{ (isset($element->province_name) && $element->province_name != '') ? $element->province_name : '' }}
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</section>
	<!-- new user end -->
</div>
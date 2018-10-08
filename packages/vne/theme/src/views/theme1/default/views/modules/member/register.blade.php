@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<form action="" method="" id="form-register-member">
					<div class="form-group">
						<label>Họ tên</label>
						<div class="input">
							<input class="form-control" type="text" name="name">
							<small class="form-text">(Chú ý: Họ tên phải là tiếng Việt có dấu, không viết liền, không chứa ký tự đặc biệt)</small>
							<small class="text-muted">*</small>
						</div>
					</div>
					<div class="form-group">
						<label>Giới tính</label>
						<div class="input">
							<div class="item">
								<input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="male">
								<label class="form-check-label" for="exampleRadios1">Nam</label>
							</div>
							<div class="item">
								<input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="female">
								<label class="form-check-label" for="exampleRadios2">Nữ</label>
							</div>
						</div>
						<small class="text-muted">*</small>
					</div>
					<div class="form-group">
						<label>Ngày sinh</label>
						<div class="input">
							<select class="form-control date" name="day"> 
								<option></option>
								@for($i=1;$i<=31;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
							<span>/</span>
							<select class="form-control date" name="month">
								<option></option>
								@for($i=1;$i<=12;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
							<span>/</span>
							<select class="form-control date year" name="year">
								<option></option>
								@for($i=1950;$i<=2018;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
							<small class="text-muted">*</small>
						</div>
					</div>
					<div class="form-group">
						<label>Điện thoại</label>
						<div class="input">
							<input class="form-control" type="name">
							<small class="form-text form-text-01">(Chú ý: Họ tên phải là tiếng Việt có dấu, không viết liền, không chứa ký
								tự đặc biệt)</small>
							<small class="form-eror">Điện thoại không được để trống.</small>
							<small class="text-muted">*</small>
						</div>
					</div>
					<div class="form-group">
						<label>Bạn là đối tượng</label>
						<div class="input">
							<select class="form-control" id="object" name="object_id">
								<option></option>
								@if(!empty($list_object))
								@foreach ($list_object as $element)
								<option value="{{ $element->object_id }}">{{ $element->name }}</option>
								@endforeach
								@endif
							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="object_name" value="">
						</div>
					</div>
					<div class="class00">Thông tin nơi học tập, công tác</div>
					<div class="form-group">
						<label>Thành phố</label>
						<div class="input">
							<select class="form-control" id="city" name="city_id">
								<option></option>
								@if(!empty($list_city))
								@foreach ($list_city as $element)
									<option value="{{ $element->city_id }}">{{ $element->name }}</option>
								@endforeach
								@endif
							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="city_name" value="">
						</div>
					</div>
					<div class="form-group">
						<label>Quận/Huyện</label>
						<div class="input">
							<select class="form-control" id="district" name="district_id">
								<option>Chọn quận/huyện</option>

							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="district_name" value="">
						</div>
					</div>
					<div class="form-group">
						<label>Trường</label>
						<div class="input">
							<select class="form-control" id="school" name="school_id">
								
							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="school_name" value="">
						</div>
					</div>
					<div class="form-group">
						<label>Lớp</label>
						<div class="input">
							<select class="form-control" id="classes" name="class_id">
							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="class_name" value="">
						</div>
					</div>
					{{-- <div class="class01">Xác thực *</div> --}}
					{{-- <div class="form-group">
						<label>Email</label>
						<div class="input">
							<input class="form-control" type="email" placeholder="nguyenvana@gmail.com">
						</div>
					</div> --}}
					<div class="btn-group">
						<button type="submit" class="btn btn-save">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!-- registration end -->

</main>
@stop
@section('footer_scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").on('change', '#city', function () {
                var city_id = $(this).val();
                var city_name = $("#city option:selected").text();
                $('input[name=city_name]').val(city_name);
                $.ajax({
                    url: "{{ route('vne.get.district') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'city_id' : city_id,
                        'city_name' : city_name
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn trường</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].district_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#district').html('');
                        $('#district').append(str);
                    }
                }, 'json');
            });

            $("body").on('change', '#district', function () {
                var district_id = $(this).val();
                var district_name = $("#district option:selected").text();
                $('input[name=district_name]').val(district_name);
                $.ajax({
                    url: "{{ route('vne.get.school') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'district_id': district_id,
                        'district_name' : district_name
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn trường</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].school_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#school').html('');
                        $('#school').append(str);
                    }
                }, 'json');
            });

            $("body").on('change', '#school', function () {
                var school_id = $(this).val();
                var school_name = $("#school option:selected").text();
                $('input[name=school_name]').val(school_name);
                $.ajax({
                    url: "{{ route('vne.get.class') }}",
                    type: 'GET',
                    cache: false,
                    data: {
                        'school_id' : school_id,
                        'school_name' : school_name
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn trường</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i].class_id + '" >' + data[i].name + '</option>';
                        }   
                        $('#class').html('');
                        $('#class').append(str);
                    }
                }, 'json');
            });
		});
	</script>
@stop
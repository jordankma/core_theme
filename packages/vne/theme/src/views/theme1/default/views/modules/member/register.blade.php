@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<form action="" method="" id="form-register-member">
					<div class="form-group">
						<label>Bạn là đối tượng</label>
						<div class="input">
							<select class="form-control" id="object" name="object_id">
								<option></option>
								@if(!empty($list_target))
								@foreach ($list_target as $element)
								<option value="{{ $element['target_id'] }}">{{ $element['target_name'] }}</option>
								@endforeach
								@endif
							</select>
							<small class="text-muted">*</small>
							<input type="hidden" name="object_name" value="">
						</div>
					</div>
					
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
	{{-- <script type="text/javascript">
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
	</script> --}}
@stop
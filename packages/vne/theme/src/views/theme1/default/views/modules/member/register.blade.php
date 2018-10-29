@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<form action="{{ route('frontend.member.register.update') }}" method="post" id="form-register-member">
                    <input type="hidden" name="member_id" id="member_id">
                    @foreach ($form_data_default as $element)
                        @if($element['type_view'] == 0)
                        <div class="form-group">
                            <label> {{ $element['title'] }} </label>
                            <div class="input">
                                <input type="{{ $element['type'] }}" name="{{ $element['params'] }}" class="form-control {{ $element['class'] }}" placeholder="{{ $element['hint_text'] }}" @if($element['is_require'] == true) required="" @endif id="{{ $element['id'] }}">
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 1)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                <select class="form-control {{ $element['class'] }}" name="{{ $element['params'] }}" @if($element['is_require'] == true) required="" @endif id="{{ $element['id'] }}" data-api="{{ $element['api'] }}">
                                    <option>{{ $element['title'] }}</option>
                                    @foreach ($element['data_view'] as $element2)
                                        <option value="{{ $element2['id'] }}">{{ $element2['title'] }}</option>
                                    @endforeach
                                </select>
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 2)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                @foreach ($element['data_view'] as $element3)
                                    <label><input type="radio" class="{{ $element['class'] }}" name="{{ $element['params'] }}" value="{{$element3['id']}}" id="{{ $element['id'] }}">{{ $element3['title'] }}</label>
                                @endforeach
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 3)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                @foreach ($element['data_view'] as $element4)
                                    <label><input type="checkbox" class="{{ $element['class'] }}" name="{{ $element['params'] }}[]" value="{{$element4['id']}}" id="{{ $element['id'] }}">{{ $element4['title'] }}</label>
                                @endforeach
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
					<div class="form-group">
						<label>Bạn là đối tượng</label>
						<div class="input">
							<select class="form-control" id="object" name="object_id">
								<option>Chọn đối tượng</option>
								@if(!empty($list_object))
								@foreach ($list_object as $element)
								    <option value="{{ $element['id'] }}">{{ $element['title'] }}</option>
								@endforeach
								@endif
							</select>
							<input type="hidden" name="object_name" value="">
						</div>
					</div>
					<p style="text-align: center;"> Thông tin nơi học tập, công tác </p>
                    <div id="info-member">
                        
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
	<script type="text/javascript">
		$(document).ready(function() {
			$("body").on('change', '#object', function () {
                var object_id = $(this).val();
                var object_name = $("#object option:selected").text();
                $('input[name=object_name]').val(object_name);
                $.get("/get-form-register?object_id="+object_id , function(data, status){
                    $('#info-member').html('');
                    $('#info-member').append(data.str);
                });
            });
            $("body").on('change', '#city', function () {
                var city_id = $(this).val();
                var city_name = $("#city option:selected").text();
                $('input[name=city_name]').val(city_name);
                var url = $(this).data("api") + '?city_id=' + city_id;
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    cache: false,
                    data: {
                        'city_id' : city_id,
                        'city_name' : city_name,
                        'url' : url
                    },
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        var str = '<option value="0" >Chọn quận huyện</option>';
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
                var url = $(this).data("api") + '?district_id=' + district_id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    cache: false,
                    data: {
                        'district_id': district_id,
                        'district_name' : district_name,
                        'url' : url
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
            
		});
	</script>
@stop
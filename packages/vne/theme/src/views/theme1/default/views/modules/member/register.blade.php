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
                                <input type="{{ $element['type'] }}" name="{{ $element['params'] }}" class="form-control" placeholder="{{ $element['hint_text'] }}" @if($element['is_require'] == true) required="" @endif>
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 1)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                <select class="form-control" id="{{ $element['params'] }}" name="{{ $element['params'] }}" @if($element['is_require'] == true) required="" @endif>
                                    <option></option>
                                    @if(!empty($element['data_view']))
                                    @foreach ($element['data_view'] as $element2)
                                        <option value="{{ $element2['key'] }}">{{ $element2['value'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 2)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                @if(!empty($element['data_view']))
                                @foreach ($element['data_view'] as $element3)
                                    <label><input type="radio" name="{{ $element['params'] }}" value="{{$element3['key']}}">{{ $element3['value'] }}</label>
                                @endforeach
                                @endif
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 3)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                @if(!empty($element['data_view']))
                                    @foreach ($element['data_view'] as $element4)
                                        <label><input type="checkbox" name="{{ $element['params'] }}[]" value="{{$element4['key']}}">{{ $element4['value'] }}</label>
                                    @endforeach
                                @endif
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if(!empty($autoload))
                    @foreach ($autoload as $key => $item)
                    <div class="form-group">
                        <label> {{ $item['title'] }}</label>
						<div class="input">
                            <select class="form-control autoload" data-key="{{$key}}" @if($element['is_require'] == true) required @endif>
								<option></option>
								@if(!empty($item['form_data']))
								@foreach ($item['form_data'] as $key2 => $item2)
                                    <option value="{{ $item2['key'] }}" data-key="{{$key}}" data-key2="{{$key2}}">{{ $item2['value'] }}</option>
								@endforeach
								@endif
							</select>
							<input type="hidden" name="object_name" value="">
						</div>
                    </div>
                    <div id="area-type-{{$key}}">
                        
                    </div>     
                    @endforeach
                    @endif
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
            var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getprovince/';
            $.ajax({
                url: url,
                type: 'GET',
                cache: false,
                success: function (data, status) {
                    var data = JSON.parse(data);
                    console.log(data);
                    var str = '<option></option>';
                    for(i = 0; i<data.data.length; i++) {
                        str += '<option value="' + data.data[i]._id + '" >' + data.data[i].province + '</option>';
                    }   
                    $('#province').html('');
                    $('#province').append(str);
                }
            }, 'json');
			$("body").on('change', '#object', function () {
                var object_id = $(this).val();
                var object_name = $("#object option:selected").text();
                $('input[name=object_name]').val(object_name);
                $.get("/get-form-register?object_id="+object_id , function(data, status){
                    $('#info-member').html('');
                    setTimeout(function() {
                      $('#info-member').append(data.str);
                    }, 500);
                });
            });
            
			$("body").on('change', '.autoload', function () {
                var key = $(this).data('key');
                var key2 = $(".autoload option:selected").data('key2');
                var id_area_append = 'area-type-' + key;
                $.get("/get-form-register?key="+key +"&key2="+key2 , function(data, status){
                    $(id_area_append).html('');
                    setTimeout(function() {
                        console.log(id_area_append);
                      $('#' + id_area_append).append(data.str);
                    }, 500);
                });
            });


            $("body").on('change', '#city', function () {
                var city_id = $(this).val();
                var city_name = $("#city option:selected").text();
                $('input[name=city_name]').val(city_name);
                // var url = $(this).data("api") + '?city_id=' + city_id;
                var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistricts/'+ city_id;
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    cache: false,
                    success: function (data, status) {
                        var data = JSON.parse(data);
                        console.log(data);
                        var str = '<option value="0">Chọn quận huyện</option>';
                        for(i = 0; i<data.length; i++) {
                            str += '<option value="' + data[i]._id + '" >' + data[i].district + '</option>';
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
                // var url = $(this).data("api") + '?district_id=' + district_id;
                var url = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschools/'+ district_id;
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
                            str += '<option value="' + data[i]._id + '" >' + data[i].schoolname + '</option>';
                        }   
                        $('#school').html('');
                        $('#school').append(str);
                    }
                }, 'json');
            });
            
		});
	</script>
@stop
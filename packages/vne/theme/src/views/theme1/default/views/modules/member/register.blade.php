@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<form action="" method="" id="form-register-member">
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
                                <select class="form-control" name="{{ $element['params'] }}" @if($element['is_require'] == true) required="" @endif>
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
                                    <label><input type="radio" name="{{ $element['params'] }}" value="{{$element3['id']}}">{{ $element3['title'] }}</label>
                                @endforeach
                                @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
                            </div>
                        </div>
                        @elseif($element['type_view'] == 3)
                        <div class="form-group">
                            <label>{{ $element['title'] }}</label>
                            <div class="input">
                                @foreach ($element['data_view'] as $element4)
                                    <label><input type="checkbox" name="{{ $element['params'] }}" value="{{$element4['id']}}">{{ $element4['title'] }}</label>
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

            
		});
	</script>
@stop
@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('title') {{ 'Danh sách thí sinh' }} @stop
@section('content')
<main class="main">
	@if($open_search == 'on')
	<section class="section search">
		<div class="container">
			<h3 style="color:red; margin:0 auto;margin-left:30px;margin-top:30px;margin-bottom:400px;text-transform: uppercase">
				Hệ thống đang cập nhật! Tính năng tra cứu sẽ được mở khi hệ thống cập nhật hoàn thành!
			</h3>
		</div>
	</section>
	@else
	<!-- search -->
	<section class="section search">
		<div class="container">
			<div class="search-wrapper">
				<div class="headline"><i class="fa fa-search"></i> Tra cứu danh sách thí sinh</div>
				<form action="" class="search-form">
					<div class="wrapper">
						{!! $form_search !!}
						@if(!empty($target_data))
							<div class="form-group col-md-4">
								<label>Chọn Bảng</label>
								<select name="target" class="form-control auto" id="target">
									<option value="">Chọn bảng</option>
									@foreach($target_data as $key => $value)
										<option value="{{ $value['id'] }}" @if(!empty($params['target']) && $params['target'] == $value['id']) selected @endif>{{ $value['title'] }}</option>
									@endforeach
								</select>
							</div>
						@endif
					</div>
					<div class="wrapper" id="auto_area">

					</div>
					<div class="wrapper" id="sub_area">

					</div>
					<button class="btn btn-primary" type="submit">Tìm kiếm</button>
				</form>
			</div>
		</div>
	</section>
	<!-- search end -->

	<!-- search results -->
	<section class="section search-results">
		<div class="container">
			<div class="results">Tổng số: <span> {{$paginator->total()}}</span> thí sinh</div>
			<!-- pagination -->

		@include('VNE-HOCVALAMTHEOBAC::modules.search._paginator')
		<!-- pagination end -->
			<!-- pagination end -->
			<div class="table-responsive detail">
				<table class="table" style="text-align: left; background: #ccc;">
					@if(!empty($headers))
					<thead>
						<tr>
						@foreach ($headers as $key => $element)
							<th>{{ $element }}</th>
						@endforeach
						</tr>
					</thead>
					@endif
					<tbody>
						@if(!empty($paginator))
						@foreach ($paginator as $key => $element)
							<tr>
								@if(!empty($element))
								@foreach ($element as $key2 => $element2)
									<td>{{ $element2 }}</td>
								@endforeach
								@endif
							</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- search results end -->
	@endif

</main>
@stop
@section('footer_scripts')
	{{-- <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form_search.js') }}"></script> --}}
	<script src="{{ config('site.url_static').'vendor/' . $group_name . '/' . $skin . '/src/js/js_form_search.js?v=5' }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = window.location.search.substring(1),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
			};
			var u_name = getUrlParameter('u_name');
			setTimeout(function(){
				$("input[name='u_name']").val(u_name); 
			}, 500);
            var target_data = @json($target_data);
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = window.location.search.substring(1),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
			};
			var u_name = getUrlParameter('u_name');
			setTimeout(function(){
				$("input[name='u_name']").val(u_name); 
			}, 500);
            $('body').on('change','.auto', function () {
                var param = $('option:selected',this).val();
                if($(this).attr('id') == 'target'){
                    $('#auto_area').html('');
                    $('#sub_area').html('');
                }
                if($(this).attr('parent-param')){
                    var parent_param = $(this).attr('parent-param');
                    var target_param = $(this).attr('target-param');
                    $.each(target_data, function (key, item) {
                        if(item.id == target_param){
                            if(item.form_data){
                                var form_data = item.form_data;
                                $.each(form_data, function (key1, item1) {
                                    if(item1.params == parent_param){
                                        $.each(item1.data_view, function (key2, item2) {
                                            if(key2 == param){
                                                if(item2.field){
                                                    $('#sub_area').html('');
                                                    $.each(item2.field, function (key3, item3) {
                                                        var html1 =  genInput(item3);
                                                        $('#sub_area').append(html1);
                                                    });
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    });
                }
                else{
                    $.each(target_data, function (key, item) {
                        if(item.id == param){
                            if(item.field){
                                $('#auto_area').html('');
                                $.each(item.field, function (key1, item1) {
                                    if(item1.type == 'auto'){
                                        if(item1.data_view){
                                            var html = '<div class="form-group col-md-4">' +
                                                '<select class="form-control auto" id="'+ item1.params +'" data-params="'+ item1.params +'" parent-field="'+ item1.parent_field +'" data-api="'+ item1.api +'" target-param="'+ param +'" parent-param="'+ item1.params +'" name="'+ item1.params +'">' +
                                                '<option value="">'+ item1.title +'</option>';
                                            $.each(item1.data_view, function (key2, item2) {
                                                html += '<option value="'+ key2 +'">'+ item2.title +'</option>';
                                            });
                                            html += '</select></div>';
                                            $('#auto_area').append(html);
                                        }
                                    }
                                });
                            }
							else if(item.form_data.length==4){
                                $('#auto_area').html('');
								console.log(item.form_data);
                                $.each(item.form_data, function (key1, item1) {
									var html1 =  genInput(item1);
									$('#auto_area').append(html1);
                                });
                            }
                            else if(item.form_data){
								console.log('12');
                                $('#auto_area').html('');
                                $.each(item.form_data, function (key1, item1) {
                                    if(item1.type == 'auto'){
                                        if(item1.data_view){
                                            var html = '<div class="form-group col-md-4">' +
                                                '<select class="form-control auto" id="'+ item1.params +'" data-params="'+ item1.params +'" parent-field="'+ item1.parent_field +'" data-api="'+ item1.api +'" target-param="'+ param +'" parent-param="'+ item1.params +'" name="'+ item1.params +'">' +
                                                '<option value="">'+ item1.title +'</option>';
                                            $.each(item1.data_view, function (key2, item2) {
                                                html += '<option value="'+ key2 +'">'+ item2.title +'</option>';
                                            });
                                            html += '</select></div>';

                                            $('#auto_area').append(html);
                                        }
                                    }
                                });
							}
                        } 
                    });
                }

            });
            function genInput(data) {
                var html = '';
                if(data) {
                    if (data.type_id == 1) {
                        html = '<div class="form-group col-md-4"><label>' + data.title + '</label>';
                        if(data.type == 'api'){
                            html += '<select name="' + data.params + '" data-params="' + data.params + '" data-type="'+ data.type +'" class="form-control select-box" id="'+ data.params +'" data-api="'+ data.api +'" parent_param="'+ data.parent_field +'" data-parent-field="'+ data.parent_field +'">';
                        }
						else if(data.type == 'auto'){
                            html += '<select name="' + data.params + '" data-params="' + data.params + '" data-type="'+ data.type +'" class="form-control auto" id="'+ data.params +'" data-api="'+ data.api +'" parent_param="'+ data.parent_field +'">';
                        }
                        else{
                            html += '<select name="' + data.params + '" data-params="' + data.params + '" data-type="'+ data.type +'" class="form-control" id="'+ data.params +'" data-api="'+ data.api +'" parent_param="'+ data.parent_field +'">';

                        }
                        if (data.is_search == true) {

                        }


                        if (data.data_view) {
                            $.each(data.data_view, function (key, item) {
                                html += '<option value="' + item.key + '">' + item.value + '</option>';
                            })
                        }
                        else if (data.api) {
                            if (data.parent_field) {

                            }
                            else {
                                $.get(data.api, function (res) {
                                    if (res.data) {

                                    }
                                });
                            }

                        }
                        html += '</select>';
                    }
                    else if (data.type_id == 2) {

                    }
                    html += '</div>';
                }
                else {

                }
                return html;
            }
		});
	</script>
@stop
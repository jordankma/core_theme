@extends('VNE-THEME::layouts.master')
@section('content')
<main class="main">

	<!-- registration -->
	<section class="registration">
		<div class="container">
			<div class="inner">
				<form action="{{ route('frontend.member.register.update') }}" method="post" id="form-register-member">
                    <input type="hidden" name="member_id" id="member_id">
                    <input type="hidden" name="u_name" id="u_name">
                    {!! $form_data_default !!}
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
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/js/js_form.js?t=' . time()) }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
            
            
		});
	</script>
@stop
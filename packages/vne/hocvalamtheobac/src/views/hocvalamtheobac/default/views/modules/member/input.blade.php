@foreach ($form_data as $element)
    @if($element['type_view'] == 0)
        @if($element['params'] == 'phone')
            @if(!empty($autoload))
                @foreach ($autoload as $key => $item)
                        <div class="form-group">
                            <label> {{ $item['title'] }} <small class="text-muted" style="color:red">*</small></label>
                            <div class="input">
                                <select class="form-control autoload" data-key="{{$key}}" required name="{{ $item['params'] }}" id="{{ $item['params'] }}">
                                    <option></option>
                                    @if(!empty($item['form_data']))
                                        @foreach ($item['form_data'] as $key2 => $item2)
                                            <option value="{{ $item2['id'] }}" data-key="{{$key}}" data-key2="{{$key2}}">{{ $item2['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="target_name" value="">
                            </div>
                        </div>
                        <div id="area-type-{{$key}}" style="margin-top:20px">

                        </div>
                @endforeach
            @endif
        @endif
        <div class="form-group">
            <label> {{ $element['title'] }} @if($element['is_require'] == true) <small class="text-muted" style="color:red">*</small> @endif </label>
            <div class="input">
                <input type="{{ $element['type'] }}" name="{{ $element['params'] }}"
                       class="form-control" placeholder="{{ $element['hint_text'] }}"
                       @if($element['is_require'] == true) required="" @endif
                       @if($element['type'] == 'date') min="1983-01-01" max="2001-31-12" @endif>
                @if($element['params_hidden'] !=null)
                    <input type="hidden" name="{{ $element['params_hidden'] }}">
                @endif
            </div>
        </div>
        {{--@if($element['params'] == 'facebook')--}}
            {{--<p style="font-weight: bold">Bước 2: Đăng ký thông tin nhận thưởng của thí sinh. </p>--}}
            {{--<p style="color:red">Giải thưởng tiền mặt của thí sinh sẽ được BTC gửi về theo--}}
                {{--tài khoản ngân hàng hoặc địa chỉ nhà riêng, người đại diện nhận thưởng của thí sinh.--}}
                {{--BTC không chịu trách nhiệm khi thí sinh cung cấp sai những thông tin đã khai báo </p>--}}
        {{--@endif--}}

    @elseif($element['type_view'] == 1)
        <div class="form-group">
            <label>{{ $element['title'] }} @if(!empty($element['is_require']) &&($element['is_require'] == true) ) <small class="text-muted" style="color:red">*</small>
                @elseif(empty($element['is_require']))
                    <small class="text-muted" style="color:red">*</small>
                @endif </label>
            <div class="input">
                @if($element['type'] == 'auto')
                    <select class="form-control auto-load-2" id="{{ $element['params'] }}" name="{{ $element['params'] }}" @if(!empty($element['is_require']) &&($element['is_require'] == true) ) required="" @endif >
                        <option></option>
                        @if(!empty($element['data_view']))
                            @foreach ($element['data_view'] as $key4 => $element2)
                                <option value="{{ $element2['params'] }}" data-key-3="{{$key4}}">{{ $element2['title'] }}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <select class="form-control select-box" data-params-hidden="{{ !empty($element['params_hidden'])?$element['params_hidden']:'' }} required"
                            data-api="{{ !empty($element['api'])?$element['api']:'' }}" data-type="{{ $element['type'] }}" data-parent-field="{{!empty($element['parent_field'])?$element['parent_field']:''}}" data-params="{{ $element['params'] }}" id="{{ $element['params'] }}" name="{{ $element['params'] }}" @if(!empty($element['is_require']) &&($element['is_require'] == true) ) required="" @endif >
                        <option></option>
                        @if(!empty($element['data_view']))
                            @foreach ($element['data_view'] as $element2)
                                <option value="{{ $element2['key'] }}" >{{ $element2['value'] }}</option>
                            @endforeach
                        @endif
                    </select>
                @endif
                @if($element['params_hidden'] !=null)
                    <input type="hidden" name="{{ $element['params_hidden'] }}">
                @endif
            </div>
        </div>
        @if($element['type'] == 'auto')
        <div id="area-auto-load-2" style="margin-top:20px">

        </div>
        @endif
    @elseif($element['type_view'] == 2)
        <div class="form-group">
            <label>{{ $element['title'] }} @if($element['is_require'] == true) <small class="text-muted" style="color:red">*</small> @endif</label>
            <div class="input">
                @if(!empty($element['data_view']))
                    @foreach ($element['data_view'] as $element3)
                        <label><input type="radio" name="{{ $element['params'] }}" value="{{$element3['key']}}" @if($loop->index==0) checked @endif>{{ $element3['value'] }}</label>
                    @endforeach
                @endif
                @if($element['params_hidden'] !=null)
                    <input type="hidden" name="{{ $element['params_hidden'] }}">
                @endif
            </div>
        </div>
    @elseif($element['type_view'] == 3)
        @if($element['params'] == 'accept_rule')
            {{--<p style="font-weight: bold">Bước 3: Xác nhận đăng ký: </p>--}}
            <p style="color:red">
                - Tôi cam đoan thông tin tài khoản vừa đăng ký là chính xác. <br>
                - Tôi đồng ý nhận giải thưởng của cuộc thi thông qua tài khoản trên và chịu hoàn toàn trách nhiệm nếu cung cấp sai thông tin tài khoản nhận thưởng. <br>
                - Nếu quá thời gian quy định mà thí sinh chưa cập nhật hoặc đính chính thông tin tài khoản nhận thưởng thì giải thưởng của thí sinh sẽ bị hủy. <br>
            </p>
        @endif
        <div class="form-group">
            <label>{{ $element['title'] }} @if($element['is_require'] == true) <small class="text-muted" style="color:red">*</small> @endif </label>
            <div class="input">
                @if(!empty($element['data_view']))
                    @foreach ($element['data_view'] as $element4)
                        <label><input type="checkbox" @if($element['is_require'] == true) required="" @endif @if(count($element['data_view']) == 1) name="{{ $element['params'] }}" @else name="{{ $element['params'] }}[]" @endif value="{{$element4['key']}}">{{ $element4['value'] }}</label>
                    @endforeach
                @endif
                @if($element['params_hidden'] !=null)
                    <input type="hidden" name="{{ $element['params_hidden'] }}">
                @endif
            </div>
        </div>
    @endif
@endforeach
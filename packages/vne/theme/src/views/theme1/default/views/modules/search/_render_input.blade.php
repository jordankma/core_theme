@foreach ($form_data as $element)
    @if($element['type_view'] == 0)
    <div class="form-group col-md-4">
        <label> {{ $element['title'] }} </label>
        <div class="input">
            <input type="{{ $element['type'] }}" name="{{ $element['params'] }}" class="form-control" placeholder="{{ $element['hint_text'] }}" @if($element['is_require'] == true) required="" @endif>
        </div>
    </div>
    @elseif($element['type_view'] == 1)
    <div class="form-group col-md-4">
        <label>{{ $element['title'] }}</label>
        <div class="input">
            <select class="form-control select-box" data-params-hidden="{{ $element['params_hidden'] }}" @if(isset($element['api'])) data-api="{{ $element['api'] }}" @endif
            data-params="{{ $element['params'] }}" data-type="{{ $element['type'] }}" 
            data-parent-field="{{ $element['parent_field'] }}"  id="{{ $element['params'] }}" 
            name="{{ $element['params'] }}" 
            @if($element['is_require'] == true) required="" @endif >
                <option>{{ $element['title'] }}</option>
                @if(!empty($element['data_view']))
                @foreach ($element['data_view'] as $element2)
                    <option value="{{ $element2['key'] }}">{{ $element2['value'] }}</option>
                @endforeach
                @endif
            </select>
            @if($element['params_hidden'] != null)
                <input type="hidden" name="{{ $element['params_hidden'] }}">    
            @endif
        </div>
    </div>
    @elseif($element['type_view'] == 2)
    <div class="form-group col-md-4">
        <label>{{ $element['title'] }}</label>
        <div class="input">
            @if(!empty($element['data_view']))
            @foreach ($element['data_view'] as $element3)
                <label style="display:inline-block"><input type="radio" name="{{ $element['params'] }}" value="{{$element3['key']}}" @if($loop->index==0) checked @endif>{{ $element3['value'] }}</label>
            @endforeach
            @endif
        </div>
    </div>
    @elseif($element['type_view'] == 3)
    <div class="form-group col-md-4">
        <label>{{ $element['title'] }}</label>
        <div class="input">
            @if(!empty($element['data_view']))
            @foreach ($element['data_view'] as $element4)
                <label><input type="checkbox" name="{{ $element['params'] }}[]" value="{{$element4['key']}}">{{ $element4['value'] }}</label>
            @endforeach
            @endif
        </div>
    </div>
    @endif
@endforeach
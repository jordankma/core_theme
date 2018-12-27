@foreach ($form_data as $element)
    @if($element['type_view'] == 0)
    <div class="form-group">
        <label> {{ $element['title'] }} </label>
        <div class="input">
            <input type="{{ $element['type'] }}" name="{{ $element['params'] }}" 
            class="form-control" placeholder="{{ $element['hint_text'] }}" 
            @if($element['is_require'] == true) required="" @endif
            @if($element['type'] == 'date') min="1995-01-01" max="2008-31-12" @endif>
            @if($element['params_hidden'] !=null)
                <input type="hidden" name="{{ $element['params_hidden'] }}">    
            @endif
            @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
        </div>
    </div>
    @elseif($element['type_view'] == 1)
    <div class="form-group">
        <label>{{ $element['title'] }}</label>
        <div class="input">
            <select class="form-control" id="{{ $element['params'] }}" name="{{ $element['params'] }}" @if($element['is_require'] == true) required="" @endif >
                <option></option>
                @if(!empty($element['data_view']))
                @foreach ($element['data_view'] as $element2)
                    <option value="{{ $element2['key'] }}">{{ $element2['value'] }}</option>
                @endforeach
                @endif
            </select>
            @if($element['params_hidden'] !=null)
                <input type="hidden" name="{{ $element['params_hidden'] }}">    
            @endif
            @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
        </div>
    </div>
    @elseif($element['type_view'] == 2)
    <div class="form-group">
        <label>{{ $element['title'] }}</label>
        <div class="input">
            @if(!empty($element['data_view']))
            @foreach ($element['data_view'] as $element3)
                <label><input type="radio" name="{{ $element['params'] }}" value="{{$element3['key']}}" @if($loop->index==0) checked @endif>{{ $element3['value'] }}</label>
            @endforeach
            @endif
            @if($element['params_hidden'] !=null)
                <input type="hidden" name="{{ $element['params_hidden'] }}">    
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
                <label><input type="checkbox" @if($element['is_require'] == true) required="" @endif @if(count($element['data_view']) == 1) name="{{ $element['params'] }}" @else name="{{ $element['params'] }}[]" @endif value="{{$element4['key']}}">{{ $element4['value'] }}</label>
            @endforeach
            <p style="color:red">{{ $element['hint_text'] }}</p>
            @endif
            @if($element['params_hidden'] !=null)
                <input type="hidden" name="{{ $element['params_hidden'] }}">    
            @endif
            @if($element['is_require'] == true) <small class="text-muted">*</small> @endif
        </div>
    </div>
    @endif
@endforeach
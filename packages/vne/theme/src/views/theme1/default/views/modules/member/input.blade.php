@foreach ($form_data as $element)
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
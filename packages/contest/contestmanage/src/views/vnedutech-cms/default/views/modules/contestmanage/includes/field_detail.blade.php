<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="panel panel-primary ">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left"><i class="livicon" data-name="users" data-size="16"
                                                 data-loop="true" data-c="#fff" data-hc="white"></i>
                Chi tiết trường thông tin
            </h4>
        </div>
        <br/>
        <div class="panel-body">
            {!! Form::open(array('url' => route('contest.contestmanage.contest_target.update_field'), 'method' => 'post', 'class' => 'bf', 'id' => 'contestForm', 'files'=> true)) !!}
            {!! Form::hidden('id',$id) !!}
            {!! Form::hidden('target_type',$target_type) !!}
            {!! Form::hidden('key',$key) !!}
            <div class="row">
                <div class="col-md-6">
                    <label>Tên trường thông tin (label) (*)</label>
                    <div class="form-group {{ $errors->first('label', 'has-error') }}">
                        {!! Form::text('label', $field['title'], array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                        <span class="help-block">{{ $errors->first('label', ':message') }}</span>
                    </div>
                    <label>Tên biến (*)</label>
                    <div class="form-group {{ $errors->first('varible', 'has-error') }}">
                        {!! Form::text('varible', $field['params'], array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                        <span class="help-block">{{ $errors->first('varible', ':message') }}</span>
                    </div>
                    <label>Hint text (placeholder)</label>
                    <div class="form-group {{ $errors->first('hint_text', 'has-error') }}">
                        {!! Form::text('hint_text', $field['hint_text'], array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}
                        <span class="help-block">{{ $errors->first('hint_text', ':message') }}</span>
                    </div>


                </div>
                <div class="col-md-6">
                    <label>Loại view html (*)</label>
                    <div class="form-group {{ $errors->first('type_id', 'has-error') }}">
                        {!! Form::select('type_id',$html_type_list, $type_id, array('class' => 'form-control type_id', 'placeholder'=> trans('contest-contest::language.placeholder.contest.type'))) !!}
                        <span class="help-block">{{ $errors->first('type_id', ':message') }}</span>
                    </div>
                    {!! Form::hidden('type_name',$field['type_view'], array('class' => 'type_name')) !!}
                    <div id="type">

                    </div>
                    <div id="param_hidden">

                    </div>
                    <div id="api">

                    </div>
                    <div id="data_view">
                        @php
                            $idx =0;
                        @endphp
                        @if(!empty($field['data_view']))
                            <div class="panel panel-primary">
                                '<div class="panel-body">
                                    <p class="text-on-pannel text-primary"><strong> Data view </strong></p>
                                    <div id="data_list">
                                        @foreach($field['data_view'] as $key => $item)
                                            @php
                                                $num = $idx++;
                                            @endphp
                                            <div class="form-group" id="dataview-{{ $num }}">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="dataview[key][]" value="{{ $item['key'] }}" placeholder="Nhập key">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="dataview[value][]" value="{{ $item['value'] }}" placeholder="Nhập giá trị">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:void(0)" class="remove" c-data="{{ $num }}" style="color:red">x</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-default" id="more_data"><span class="glyphicon glyphicon-plus-sign"></span> Thêm</a>
                                    </div>
                                </div>

                        @endif
                    </div>
                    {{--<label>Link api</label>--}}
                    {{--<div class="form-group {{ $errors->first('api', 'has-error') }}">--}}
                    {{--{!! Form::text('api', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}--}}
                    {{--<span class="help-block">{{ $errors->first('api', ':message') }}</span>--}}
                    {{--</div>--}}

                    {{--<label>Data view</label>--}}
                    {{--<div class="form-group {{ $errors->first('data_view', 'has-error') }}">--}}
                    {{--{!! Form::text('data_view', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> trans('contest-contest::language.placeholder.contest.name_here'))) !!}--}}
                    {{--<span class="help-block">{{ $errors->first('data_view', ':message') }}</span>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Bắt buộc nhập?</label>
                    <div class="form-group">
                        <input type="checkbox" name="is_require" class="allow_permission" data-size="mini"
                               @if($field['is_require'] == 1)
                               checked
                               @endif
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Trường mặc định?</label>
                    <div class="form-group">
                        <input type="checkbox" name="is_default" class="allow_permission" data-size="mini"
                               @if($field['is_require'] == 1)
                               checked
                                @endif
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Cho phép lọc trong tra cứu?</label>
                    <div class="form-group">
                        <input type="checkbox" name="is_search" class="allow_permission" data-size="mini"
                               @if($field['is_search'] == 1)
                               checked
                                @endif
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Hiển thị trong thông tin thí sinh?</label>
                    <div class="form-group">
                        <input type="checkbox" name="show_on_info" class="allow_permission" data-size="mini"
                               @if($field['show_on_info'] == 1)
                               checked
                                @endif
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Hiển thị trong tra cứu kết quả?</label>
                    <div class="form-group">
                        <input type="checkbox" name="show_on_result" class="allow_permission" data-size="mini"
                               @if($field['show_on_result'] == 1)
                               checked
                                @endif
                        >
                    </div>
                </div>

            </div>
            <div class="row">
                <button type="submit" class="btn btn-success update_field">Cập nhật</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<!--end of page js-->
<script>
    $(function () {
        $("[name='permission_locked']").bootstrapSwitch();
        $('input[type="checkbox"].allow_permission').bootstrapSwitch({
            onSwitchChange:function(event, state) {
            }
        });
    });

    $('body').on('change','.type_id', function () {
        $('#param_hidden').html('');
        $('.type_name').val($('option:selected', this).text());
        $('#type').html('');
        $('#data_view').html('');
        var type_id = $('option:selected', this).val();
        if(type_id == 1){
            var html = ' <label>Tên biến nhận giá trị select (param hidden)</label>' +
                '<div class="form-group {{ $errors->first('data_type', 'has-error') }}">' +
                '{!! Form::text('params_hidden', null, array('class' => 'form-control', 'autofocus'=>'autofocus')) !!}' +
                '<span class="help-block">{{ $errors->first('data_type', ':message') }}</span></div>';

            $('#param_hidden').html(html);
        }
        var type_list = @json($type);
        if(type_list[type_id]){
            var html = ' <label>Loại data</label>' +
                '<div class="form-group {{ $errors->first('type', 'has-error') }}">' +
                '<select class="form-control type" name="type">' +
                '<option value="">Chọn loại</option>';
            $.each(type_list[type_id], function(key, item){
                html += '<option value ="' + key + '">' + item + '</option>';
            });

            html += '</select>' +
                '<span class="help-block">{{ $errors->first('type', ':message') }}</span>' +
                '</div>';

            $('#type').html(html);
        }
        else{
            showDataView();
        }
    });

    $('body').on('change', '.type', function () {
        $('#data_view').html('');
        var type = $('option:selected', this).val();
        if(type == 'data'){
            showDataView();
        }
        else if(type == 'api'){
            $('#data_view').html('<label>Link api</label>' +
                '<div class="form-group {{ $errors->first('api', 'has-error') }}">' +
                '{!! Form::text('api', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> 'Nhập link api')) !!}' +
                '<span class="help-block">{{ $errors->first('api', ':message') }}</span>' +
                '</div>' +
                '<label>Field cha (Nhận value từ field cha truyền vào api)</label>' +
                '<div class="form-group {{ $errors->first('parent_field', 'has-error') }}">' +
                '{!! Form::text('parent_field', null, array('class' => 'form-control', 'autofocus'=>'autofocus','placeholder'=> 'Nhập param field cha')) !!}' +
                '<span class="help-block">{{ $errors->first('parent_field', ':message') }}</span>' +
                '</div>');
        }
        else if(type == 'data_api'){
            $('#api').html('<label>Link api</label>' +
                '<div class="form-group {{ $errors->first('api', 'has-error') }}">' +
                '{!! Form::text('api', null, array('class' => 'form-control api', 'autofocus'=>'autofocus','placeholder'=> 'Nhập link api')) !!}' +
                '<span class="help-block">{{ $errors->first('api', ':message') }}</span></div>' +
                '<div class="form-group">' +
                '<div class="col-md-6">' +
                '<input type="text" class="form-control row key" placeholder="Nhập param key">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" class="form-control row value" placeholder="Nhập param value">' +
                '</div>' +
                '</div>' +
                '<div class="form-group"><button type="button" class="btn btn-primary get_data">Nhận data</button></div>');
            showDataView();
        }
    });

    $('body').on('click', '#more_data', function () {
        $('#data_list').append(genDataInput());
    });

    $('body').on('click', '.get_data', function () {
        var url = $('.api').val();
        var key_param = $('.key').val();
        var value_param = $('.value').val();
        $.get(url, function (data) {
            if(data){
                genDataViewFromApi(data, key_param, value_param)
            }
        });
    });

    function genDataViewFromApi(data, key_param, value_param) {
        var html = '';
        $.each(data.data, function (key, item) {
            html += '<div class="form-group" id="dataview-'+ key +'">' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[key][]" value="'+ item[key_param] +'" placeholder="Nhập key"></div> ' +
                '<div class="col-md-5"><input type="text" class="form-control" name="dataview[value][]" value="'+ item[value_param] +'" placeholder="Nhập giá trị"></div> ' +
                '<div class="col-md-2"><a href="javascript:void(0)" class="remove" c-data="'+ key +'" style="color:red">x</a></div> ' +
                '</div>'
        });
        $('#data_list').html(html);
    }

    function showDataView() {
        var html = '<div class="panel panel-primary">' +
            '<div class="panel-body">' +
            '<p class="text-on-pannel text-primary"><strong> Data view </strong></p>' +
            '<div id="data_list">' +

            '</div>' +
            '<a href="javascript:void(0)" class="btn btn-default" id="more_data"><span class="glyphicon glyphicon-plus-sign"></span> Thêm</a>' +
            '</div>' +
            '</div>';
        $('#data_view').html(html);
    }

    function genDataInput() {
        var idx = $('#data_view').find('.form-group').length;
        idx = idx +1;
        var html = '<div class="form-group" id="dataview-'+ idx +'">' +
            '<div class="col-md-5"><input type="text" class="form-control" name="dataview[key][]" placeholder="Nhập key"></div> ' +
            '<div class="col-md-5"><input type="text" class="form-control" name="dataview[value][]" placeholder="Nhập giá trị"></div> ' +
            '<div class="col-md-2"><a href="javascript:void(0)" class="remove" c-data="'+ idx +'" style="color:red">x</a></div> ' +
            '</div>';
        return html;
    }

</script>


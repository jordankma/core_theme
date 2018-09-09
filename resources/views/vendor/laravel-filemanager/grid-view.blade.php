@if((sizeof($files) > 0) || (sizeof($directories) > 0))
<div class="row">

    @foreach($items as $item)

        <?php
        foreach($item as $key => $value) {
            $item->$key = str_replace('http://dhcd-release.vnedutech.vn', 'http://files.dhcd.vnedutech.vn', $value);
        }
        ?>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 img-row">
        <?php $item_name = $item->name; ?>
        <?php $thumb_src = $item->thumb; ?>
        <?php $item_path = $item->is_file ? $item->url : $item->path; ?>
       
        <div class="square clickable {{ $item->is_file ? '' : 'folder-item' }}" data-type="{{$item->type}}" title="{{$item->name}}" data-id="{{ $item_path }}"
             @if($item->is_file && $thumb_src && Request::input('type') != 'file') onclick="useFile('{{ $item_path }}', '{{ $item->updated }}')"
             @elseif($item->is_file) onclick="download('{{ $item_name }}')" @endif >
             @if($thumb_src)
             <img src="{{ $thumb_src }}">
            @else
            <i class="fa {{ $item->icon }} fa-5x"></i>
            @endif
        </div>

        <div class="caption text-center">
            <div class="btn-group">
                <button type="button"  data-id="{{ $item_path }}"
                        class="item_name btn btn-default btn-xs {{ $item->is_file ? '' : 'folder-item'}}"
                        @if($item->is_file && $thumb_src && Request::input('type') != 'file') onclick="useFile('{{ $item_path }}', '{{ $item->updated }}')"
                        @elseif($item->is_file) onclick="download('{{ $item_name }}')" @endif >
                        {{ $item_name }}
            </button>
            <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:rename('{{ $item_name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-rename') }}</a></li>
                @if($item->is_file)
                <li><a href="javascript:download('{{ $item_name }}')"><i class="fa fa-download fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-download') }}</a></li>
                <li class="divider"></li>
                @if($thumb_src)
                <li><a href="javascript:fileView('{{ $item_path }}', '{{ $item->updated }}')"><i class="fa fa-image fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-view') }}</a></li>
                <li><a href="javascript:resizeImage('{{ $item_name }}')"><i class="fa fa-arrows fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-resize') }}</a></li>
                <li><a href="javascript:cropImage('{{ $item_name }}')"><i class="fa fa-crop fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-crop') }}</a></li>
                <li class="divider"></li>
                @endif
                @endif
                <li><a href="javascript:trash('{{ $item_name }}')"><i class="fa fa-trash fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-delete') }}</a></li>
            </ul>
        </div>
    </div>

</div>
@endforeach

</div>

@else
<p>{{ Lang::get('laravel-filemanager::lfm.message-empty') }}</p>
@endif
<script>
    $(document).ready(function () {
        var type_upload = $("input[name='type_upload']", opener.window.document).val();
        if(type_upload != "import_member") {
            $('body').on('click', 'div.clickable', function (e) {
                
                var type = $(this).attr('data-type');
                var typeParent = $("input[name='document_type_id']:checked", opener.window.document).attr("data-types"); 
                var type_upload = $("input[name='type_upload']", opener.window.document).val();                                   
                var isIcon = $("input[name='isIcon']", opener.window.document).val();                       
                if(isIcon == 2){               
                  return true;
                }
                
                if(typeParent!=null){
                    var obj = $.parseJSON(typeParent);
                }                     
                var title = $(this).attr('title');
                var alerted = localStorage.getItem('alerted') || '';
                if(type === "Thư mục"){
                    return true;
                }
                if(type_upload=="add_news"){
                    if (type === "image/jpeg" || type === "image/jpg" || type === "image/png" || type === "image/gif") {
                        var type_file = 'img';
                    } else {
                        var type_file = 'file'
                    }
                    var src = $(this).attr('data-id');
                    
                    var data = {
                        src: src,
                        type: type,
                        title: title,
                        type_file: type_file
                    };              
                    window.opener.setData(data);
                    
                    if(alerted != title){
                        localStorage.setItem('alerted',title);
                    }
                } 
                else if(type_upload=="import_member"){
                    
                }
                else{
                    if ($.inArray(type, obj) != -1) {
                        if (type === "image/jpeg" || type === "image/jpg" || type === "image/png" || type === "image/gif") {
                            var type_file = 'img';
                        } else {
                            var type_file = 'file'
                        }
                        var src = $(this).attr('data-id');
                        
                        var data = {
                            src: src,
                            type: type,
                            title: title,
                            type_file: type_file
                        };              
                        window.opener.setData(data);
                        if(alerted != title){
                            swal({
                                title: "Đã chọn",
                                text: '',
                                html: true,
                                confirmButtonColor: "#DD6B55"
                            });
                            localStorage.setItem('alerted',title);
                        }
                    } else {
                        if(alerted != title){
                            swal({
                                title: "File chọn không phù hợp với kiểu file bạn chọn",
                                text: '',
                                html: true,
                                confirmButtonColor: "#DD6B55"
                            });
                            localStorage.setItem('alerted',title);
                        }
                                        
                    }
                }
                return false;
            });
        }
        
    });
    function getParameterByName(name, url) {
        if (!url)
            url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
</script>


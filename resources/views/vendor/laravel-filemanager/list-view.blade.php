@if((sizeof($files) > 0) || (sizeof($directories) > 0))
<table class="table table-responsive table-condensed table-striped hidden-xs table-list-view">
  <thead>
    <th style='width:50%;'>{{ Lang::get('laravel-filemanager::lfm.title-item') }}</th>
    <th>{{ Lang::get('laravel-filemanager::lfm.title-size') }}</th>
    <th>{{ Lang::get('laravel-filemanager::lfm.title-type') }}</th>
    <th>{{ Lang::get('laravel-filemanager::lfm.title-modified') }}</th>
    <th>{{ Lang::get('laravel-filemanager::lfm.title-action') }}</th>
  </thead>
  <tbody>
    @foreach($items as $item)
        <?php
        foreach($item as $key => $value) {
            $item->$key = str_replace('http://dhcd-release.vnedutech.vn', 'http://files.dhcd.vnedutech.vn', $value);
        }
        ?>
    <tr>
      <td>
        <i class="fa {{ $item->icon }}"></i>
        <a class="{{ $item->is_file ? 'file' : 'folder'}}-item clickable" data-type="{{$item->type}}" data-id="{{ $item->is_file ? $item->url : $item->path }}" title="{{$item->name}}">
          {{ str_limit($item->name, $limit = 40, $end = '...') }}
        </a>
      </td>
      <td>{{ $item->size }}</td>
      <td>{{ $item->type }}</td>
      <td>{{ $item->time }}</td>
      <td class="actions">
        @if($item->is_file)
          <a href="javascript:download('{{ $item->name }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-download') }}">
            <i class="fa fa-download fa-fw"></i>
          </a>
          @if($item->thumb)
            <a href="javascript:fileView('{{ $item->url }}', '{{ $item->updated }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-view') }}">
              <i class="fa fa-image fa-fw"></i>
            </a>
            <a href="javascript:cropImage('{{ $item->name }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-crop') }}">
              <i class="fa fa-crop fa-fw"></i>
            </a>
            <a href="javascript:resizeImage('{{ $item->name }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-resize') }}">
              <i class="fa fa-arrows fa-fw"></i>
            </a>
          @endif
        @endif
        <a href="javascript:rename('{{ $item->name }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-rename') }}">
          <i class="fa fa-edit fa-fw"></i>
        </a>
        <a href="javascript:trash('{{ $item->name }}')" title="{{ Lang::get('laravel-filemanager::lfm.menu-delete') }}">
          <i class="fa fa-trash fa-fw"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<table class="table visible-xs">
  <tbody>
    @foreach($items as $item)
    <tr>
      <td>
        <div class="media" style="height: 70px;">
          <div class="media-left">
            <div class="square {{ $item->is_file ? 'file' : 'folder'}}-item clickable" data-type="{{ $item->type }}"  data-id="{{ $item->is_file ? $item->url : $item->path }}">
              @if($item->thumb)
              <img src="{{ $item->thumb }}">
              @else
              <i class="fa {{ $item->icon }} fa-5x"></i>
              @endif
            </div>
          </div>
          <div class="media-body" style="padding-top: 10px;">
            <div class="media-heading">
              <p>
                <a class="{{ $item->is_file ? 'file' : 'folder'}}-item clickable" data-type="{{ $item->type }}" data-id="{{ $item->is_file ? $item->url : $item->path }}">
                  {{ str_limit($item->name, $limit = 20, $end = '...') }}
                </a>
                &nbsp;&nbsp;
                {{-- <a href="javascript:rename('{{ $item->name }}')">
                  <i class="fa fa-edit"></i>
                </a> --}}
              </p>
            </div>
            <p style="color: #aaa;font-weight: 400">{{ $item->time }}</p>
          </div>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@else
<p>{{ trans('laravel-filemanager::lfm.message-empty') }}</p>
@endif
<script> 
    $('body').on('click','td a.clickable',function(){
    var type = $(this).attr('data-type');
	var typeParent = $("input[name='document_type_id']:checked", opener.window.document).attr("data-types");
	var obj =  $.parseJSON(typeParent);
	var title = $(this).attr('title');
    var alerted = localStorage.getItem('alerted') || '';
        console.log(obj);
	if(type === "Thư mục"){
		return true;
	}
	
	if($.inArray(type,obj) != -1){
		if(type === "image/jpeg" || type === "image/jpg" || type === "image/png" || type === "image/gif"){
			var	type_file = 'img';	
		}
		else{
			var	type_file = 'file'
		}
		var src = $(this).attr('data-id'); 							
		var data = {
			src : src,
			type : type,
			title : title,
            type_file : type_file
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
		return false;	
			
	}
	else{					
		if(alerted != title){            
			swal({
                    title: "File chọn không phù hợp với kiểu file bạn chọn",
                    text: '',
                    html: true,
                    confirmButtonColor: "#DD6B55"
            });
            localStorage.setItem('alerted',title);
        }
		return false;
	}
		return true;		      
});
</script>
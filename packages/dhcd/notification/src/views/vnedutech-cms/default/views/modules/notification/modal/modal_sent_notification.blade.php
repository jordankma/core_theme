<form action="{{ $confirm_route }}" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="user_delete_confirm_title">{{ trans('dhcd-notification::confirm.' . $model .'.'.$type. '.title') }}</h4>
  </div>
  <div class="modal-body row">
      @if($error)
          <div>{!! $error !!}</div>
      @else
          <div class="col-md-8">
            <label>{{trans('dhcd-notification::language.label.group_sent') }}</label>
            <div class="form-group">
                <select class="form-control" id="group_id" name="group_id" required="">
                @if(!empty($groups))
                @foreach($groups as $group)
                    <option value="{{$group->group_id}}">{{$group->name}} </option>
                @endforeach
                @endif
                </select>
            </div>
            <label>{{trans('dhcd-notification::language.label.time_sent') }}</label>
             <div class="form-group">
                <div class='input-group date'>
                    <input type='text' class="form-control" name="time_sent" id="time_sent" placeholder="{{trans('dhcd-notification::language.placeholder.notification.time_sent_here') }}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <p style="color: red">Không chọn mặc định là gửi luôn</p>
            </div>
            </div>
          </div>
      @endif
  </div>
  <div class="modal-footer" style="padding: 15px 240px;">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('dhcd-notification::confirm.cancel') }}</button>
    <button type="submit" class="btn btn-danger">{{ trans('dhcd-notification::confirm.sent') }}</button>
  </div>
</form> 
<script type="text/javascript">
  $('#time_sent').datetimepicker({
      format: 'DD-MM-YYYY',
      minDate: new Date()
  });
</script>   

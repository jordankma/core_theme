<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">{{ trans('vne-newsrldv::confirm.' . $model .'.'.$type. '.title') }}</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        {{ trans('vne-newsrldv::confirm.' . $model . '.' . $type . '.body') }}
    @endif
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('vne-newsrldv::confirm.cancel') }}</button>
  @if(!$error)
    <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">{{ trans('vne-newsrldv::confirm.confirm') }}</a>
  @endif
</div>
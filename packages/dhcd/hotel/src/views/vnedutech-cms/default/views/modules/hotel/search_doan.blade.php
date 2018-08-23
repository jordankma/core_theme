<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="user_delete_confirm_title">{{ trans('dhcd-seat::language.namepro') }}</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        {{ trans('dhcd-seat::language.titles.seat.delete_seat').$model->name.' ?' }}
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('adtech-core::confirm.cancel') }}</button>
    @if(!$error)
        <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">{{ trans('adtech-core::confirm.confirm') }}</a>
    @endif
</div>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="user_delete_confirm_title">{{ trans('vne-schools::language.titles.province') }}</h4>
</div>
<div class="modal-body">
    <p>Bạn có chắc chắn muốn xóa không?</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('adtech-core::confirm.cancel') }}</button>
    <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">{{ trans('adtech-core::confirm.confirm') }}</a>
</div>

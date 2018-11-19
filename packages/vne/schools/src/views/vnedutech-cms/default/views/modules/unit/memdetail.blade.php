<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <center><h4 class="modal-title" id="memdetail"> Người phụ trách </h4></center>
</div>
<div class="modal-body">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>{{ trans('vne-schools::language.mem.name') }}</td>
            <td>{{ trans('vne-schools::language.mem.phone') }}</td>
            <td>{{ trans('vne-schools::language.mem.email') }}</td>
            <td>{{ trans('vne-schools::language.mem.pos') }}</td>
        </tr>
        </thead>
        <tbody>

        @if(isset($memdetail))

            @foreach($memdetail as $key=>$value)
                <tr>
                    <td>  {{ $value['memname'] }} </td>
                    <td>  {{ $value['memphone'] }} </td>
                    <td>  {{ $value['mememail']}} </td>
                    <td>  {{ $value['mempos']}} </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
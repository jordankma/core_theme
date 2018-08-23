<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <center><h4 class="modal-title" id="event_detail"> Danh Sách Hoạt Động </h4></center>
</div>
<div class="modal-body">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>Bắt Đầu</td>
            <td>Kết Thúc</td>
            <td>Nội Dung</td>
        </tr>
        </thead>
        <tbody>
        @if(isset($event_detail))
        @foreach($event_detail as $key=>$value)
            <tr>
                <td>  {{ $value->start_time }} </td>
                <td>  {{ $value->end_time }} </td>
                <td>  {{ $value->content}} </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>
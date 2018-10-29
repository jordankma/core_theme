<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <center><h4 class="modal-title" id="edit"> Time Line </h4></center>
</div>
<div class="modal-body">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {!! Form::model($timeline,array('url' => route('vne.timeline.update'), 'method' => 'put', 'class' => 'bf', 'id' => 'timelineForm', 'files'=> true)) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12 my-3">
            <div class="card panel-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 col-lg-3 col-12 control-label" for="titles">Titles :</label>
                            <div class="col-md-9 col-lg-9 col-12{{ $errors->first('titles', 'has-error') }} ">
                                <input name="titles" id="titles"type="text"
                                       placeholder="{{ trans('vne-timeline::language.placeholder.titles') }}"
                                       class="form-control" value="{{$timeline->titles}}" autofocus required>
                                <span class="help-block">{{ $errors->first('titles', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 col-lg-3 col-12 control-label" for="time">Time :</label>
                            <div class="col-md-9 col-lg-9 col-12{{ $errors->first('time', 'has-error') }} ">
                                <input name="time" id="time" type="text" class="form-control" value="{{$starttime}}-{{$endtime}}"required>
                                <span class="help-block">{{ $errors->first('time', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label"
                                       for="note">Note :</label>
                                <div class="col-md-9 col-lg-9 col-12{{ $errors->first('note', 'has-error') }} ">
                                    {!! Form::textarea('note', $timeline->note, array('id'=>'note','class' => 'form-control','rows'=>'5','placeholder'=> trans('vne-timeline::language.placeholder.note'))) !!}
                                    <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-sm-push-4">
                            <div class="form-group form-actions">
                                <button type="button"
                                        class="btn btn-success" id="btn-update">{{ trans('vne-timeline::language.buttons.update') }}</button>
                                <a href="{!! route('vne.timeline.create') !!}"
                                   class="btn btn-danger">{{ trans('vne-timeline::language.buttons.discard') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="{{$timeline->id}}" id='h_v' class='h_v'>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input[name="time"]').daterangepicker();
            $('body').on('click','#btn-update', function () {
                var token = '{{ Session::token() }}';
                var id = $('#h_v').val();
                var titles = $('#titles').val();
                var time = $('#time').val().trim();
                console.log( $('#time').val());
                var note = $('#note').val();
                $.ajax({
                    type:'post',
                    url:'{{route('vne.timeline.update')}}',
                    data:{
                        'id':id,
                        'titles':titles,
                        'time':time.trim(),
                        'note':note,
                        '_token':token
                    },
                    success:function (data) {
                        if(data.status == true){
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
</div>


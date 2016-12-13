<div class="row">
    <div class="pull-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="/home" class="btn btn-default">Done</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('url', 'Item URL:', ['class' => 'control-label']) !!}
            {!! Form::text('url', (isset($url) && $url != '' ? $url : null), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('location', 'Location:', ['class' => 'control-label']) !!}
            {!! Form::text('location', (isset($loc) && $loc != '' ? $loc : null), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('datetime', 'Ends:', ['class' => 'control-label']) !!}
            {!! Form::text('datetime', (isset($edate) && $edate != '' ? $edate : null), ['class' => 'form-control', 'id' => 'datetimepicker'])  !!}
        </div>
        <div class="form-group">
            {!! Form::label('pickup', 'Pickup Details:', ['class' => 'control-label']) !!}
            {!! Form::text('pickup', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
            {!! Form::text('name', (isset($name) && $name != '' ? $name : null), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cur_bid', 'Current Bid:', ['class' => 'control-label']) !!}
            {!! Form::text('cur_bid', (isset($cbid) && is_numeric($cbid) ? $cbid : '0.00'), ['class' => 'form-control money-input']) !!}
        </div>
        <div id="grpMbid" class="form-group">
            {!! Form::label('max_bid', 'Max Bid:', ['class' => 'control-label']) !!}
            {!! Form::text('max_bid', '0.00', ['class' => 'form-control money-input']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('notes', 'Extra Information:', ['class' => 'control-label']) !!}
            {!! Form::textarea('notes', (isset($notes) && $notes != '' ? $notes : null), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="pull-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="/home" class="btn btn-default">Done</a>
    </div>
</div>
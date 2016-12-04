<div class="row">
    <div class="pull-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="/home" class="btn btn-default">Done</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('location', 'Location:', ['class' => 'control-label']) !!}
            {!! Form::text('location', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('url', 'Item URL:', ['class' => 'control-label']) !!}
            {!! Form::text('url', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('datetime', 'Ends:', ['class' => 'control-label']) !!}
            {!! Form::text('datetime', null, ['class' => 'form-control', 'id' => 'datetimepicker'])  !!}
        </div>
        <div class="form-group">
            {!! Form::label('pickup', 'Pickup Details:', ['class' => 'control-label']) !!}
            {!! Form::text('pickup', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cur_bid', 'Current Bid:', ['class' => 'control-label']) !!}
            {!! Form::text('cur_bid', null, ['class' => 'form-control money-input']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('max_bid', 'Max Bid:', ['class' => 'control-label']) !!}
            {!! Form::text('max_bid', null, ['class' => 'form-control money-input']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('notes', 'Extra Information:', ['class' => 'control-label']) !!}
            {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="pull-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="/home" class="btn btn-default">Done</a>
    </div>
</div>
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if(isset($csrf_error))
    <div class="alert alert-danger">
        <p>{{ $csrf_error }}</p>
    </div>
@endif
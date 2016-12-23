
<div class="row">
    <div class="col-xs-12">
        <div class="row text-center">
            <div class="col-xs-2">
                <a href="{{$bid->url}}" target="_blank" class="btn btn-xs btn-info" id="btnView{{$bid->id}}">
                    <i class="glyphicon glyphicon-globe"></i>
                    <span class="hidden-xs">View</span>
                </a>
            </div>
            <div class="col-xs-2">
                <form method="POST" action="bid/{{$bid->id}}/won" accept-charset="UTF-8" id="frmWon{{$bid->id}}">
                    <input name="_method" type="hidden" value="PATCH">
                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                    <input name="won" type="hidden" value="1">
                    <button type="submit" class="btn btn-xs btn-success" id="btnWon{{$bid->id}}" {{($ended) ? 'disabled':null}}>
                        <i class="glyphicon glyphicon-check"></i>
                        <span class="hidden-xs">Won</span>
                    </button>
                </form>
            </div>
            <div class="col-xs-2">
                <a href="bids/{{$bid->id}}/edit" class="btn btn-xs btn-primary" id="btnEdit{{$bid->id}}">
                    <i class="glyphicon glyphicon-pencil"></i>
                    <span class="hidden-xs">Edit</span>
                </a>
            </div>
            <div class="col-xs-2">
                <form method="POST" action="bids/{{$bid->id}}" accept-charset="UTF-8" id="frmDelete{{$bid->id}}">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-xs btn-danger" id="btnDelete{{$bid->id}}">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span class="hidden-xs">Delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
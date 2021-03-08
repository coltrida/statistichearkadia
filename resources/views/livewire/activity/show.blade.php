<div>
    <div class="alert alert-danger mt-5 flex justify-content-between p-2" role="alert">

        <div class="col-3">Attività</div>
        <div class="col-3">Costo</div>
        <div class="col-3">Tipologia</div>
        <div class="col-3">Azioni</div>

    </div>

    @foreach($attivita as $item)
        <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0" role="alert" id="ass{{$item->id}}">

            <div class="col-3">{{$item->name}}</div>
            <div class="col-3">{{$item->cost}}</div>
            <div class="col-3">{{$item->tipo}}</div>
            <div class="col-3 azion">
                <a title="Elimina" href="{{route('elimina_attivita', $item->id)}}" class="btn btn-danger mr-1" id="{{$item->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>

        </div>
    @endforeach
</div>


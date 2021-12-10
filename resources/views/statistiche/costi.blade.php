@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Costi Ragazzi</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('home')}}">Indietro</a>
            </div>
        </div>

        <div class="alert alert-danger mt-5 flex justify-content-between p-1" role="alert">
            <div class="col">Ragazzo</div>
            <div class="col">Mese</div>
            <div class="col">Anno</div>
            <div class="col">Costo Tot</div>
            <div class="col">Contributo</div>
            <div class="col">Saldo</div>
        </div>

        @foreach($ragazzi as $itemCosti)
            @foreach($itemCosti->costi as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center pl-1" role="alert" id="ass{{$item->id}}">
                <div class="col">{{$itemCosti->name}}</div>
                <div class="col">{{$item->mese}}</div>
                <div class="col">{{$item->anno}}</div>
                <div class="col">{{$item->totale}}</div>
                <div class="col">{{$item->contributo}}</div>
                <div class="col">{{$item->saldo}}</div>
            </div>
            @endforeach
        @endforeach
        <div class="alert alert-success mt-2 flex justify-content-between align-items-center pl-1" role="alert">
            <div class="col">TOTALE</div>
            <div class="col">&nbsp;</div>
            <div class="col">&nbsp;</div>
            <div class="col">{{$totale}}</div>
            <div class="col">{{$contributo}}</div>
            <div class="col">{{$saldo}}</div>
        </div>
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$ragazzi->links()}}
        </div>
    </div>

@endsection

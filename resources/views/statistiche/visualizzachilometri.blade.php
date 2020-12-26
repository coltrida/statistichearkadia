@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Statistiche Chilometri - {{$nomecar}} {{$mese}}/{{$anno}}</h1>
        </div>

        @include('statistiche.partial.formkmvettura')

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Giorno</div>
            <div class="col">Km percorsi</div>
            <div class="col">Operatore</div>
            <div class="col">Passeggeri</div>
        </div>

        @foreach($viaggi as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert">
                <div class="col">{{$item->giorno}}</div>
                <div class="col">{{$item->kmPercorsi}}</div>
                <div class="col">{{$item->user->name}}</div>
                <div class="col">
                    @foreach($item->clienttrip as $passeggero)
                        <div>{{$passeggero->ragazzi[0]->name}}</div>
                    @endforeach
                </div>

            </div>
        @endforeach

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div>Km Totale</div>
            <div>{{$totkm}}</div>
        </div>

    </div>

@endsection

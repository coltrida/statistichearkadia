@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Statistiche Chilometri - {{$nomeragazzo}} {{$mese}}/{{$anno}}</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        @include('statistiche.partial.formkmragazzi')

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Giorno</div>
            <div class="col">Km percorsi</div>
            <div class="col">Operatore</div>
        </div>

        @foreach($viaggi as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert">
                <div class="col">{{$item->trip[0]->giorno}}</div>
                <div class="col">{{$item->trip[0]->kmPercorsi}}</div>
                <div class="col">{{$item->trip[0]->user->name}}</div>

            </div>
        @endforeach

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div>Km Totale</div>
            <div>{{$totkm}}</div>
        </div>
        <div class="alert alert-danger flex justify-content-between" role="alert">
            <div>Costo Totale</div>
            <div>€ {{$totkm*0.45}}</div>
        </div>

    </div>

@endsection

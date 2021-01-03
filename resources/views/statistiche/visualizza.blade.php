@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Presenze {{$nome}} {{$mese}}/{{$anno}}</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        @include('statistiche.partial.formpresenze')
    </div>

    @foreach($items as $item)
        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Attività</div>
            <div class="col">Giorno</div>
            <div class="col">Quantita'</div>
        </div>
        @foreach($item as $ele)
            <div class="alert alert-primary mt-2 flex justify-content-between" role="alert">
                <div class="col">{{$ele->activity->name}}</div>
                <div class="col">{{$ele->giorno}}</div>
                <div class="col">{{$ele->quantita}}</div>

            </div>
        @endforeach
    @endforeach

    <div class="alert alert-warning mt-5 flex justify-content-between" role="alert">
        <div>Costo Totale</div>
        <div>{{$totale}}</div>
    </div>
    <div class="alert alert-warning flex justify-content-between" role="alert">
        <div>Saldo Voucher</div>
        <div>{{$client->voucher}}</div>
    </div>

@endsection

@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Saldo Mese <span class="alert small alert-primary">{{$items[2]}} / {{$items[1]}}</span> </h1>
            </div>
            <div>
                <a title="Indietro" href="{{route('saldo_mese', $direzione-1)}}" class="btn btn-success">
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
                <a title="Avanti" href="{{route('saldo_mese', $direzione+1)}}" class="btn btn-success">
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('home')}}">Indietro</a>
            </div>
        </div>

        <div class="alert alert-danger mt-5 flex justify-content-between p-0" role="alert">
            <div class="col-3">Causale</div>
            <div class="col-4">Entrate</div>
            <div class="col-4">Uscite</div>
            <div class="col-1"></div>
        </div>

        @foreach($items[0] as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0" role="alert">

                <div class="col-3">{{$item->causale}}</div>
                <div class="col-4">{{$item->tipo === 'entrata' ? $item->importo : null}}</div>
                <div class="col-4">{{$item->tipo === 'uscita' ? $item->importo : null}}</div>

                <div class="col-1">
                    @if($item->tipo === 'entrata')
                        <a title="Ricevuta" target="_blank" href="{{route('ricevuta', $item->id)}}" class="btn btn-success">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </a>
                    @endif
                </div>


            </div>
        @endforeach
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$items[0]->links()}}
        </div>

    </div>

@endsection

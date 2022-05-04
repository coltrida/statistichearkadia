@extends('layouts.stile')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{session()->get('message')}}
        </div>
    @endif
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex row justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-xs-12 mt-2">
                <h3>Saldo Mese <span class="alert small">{{$items[2]}} / {{$items[1]}}</span> </h3>
            </div>
            <div class="row col-lg-4 col-xl-4 col-md-12 col-sm-12 col-xs-12 mt-2">
                <div class="col-6">
                    <a title="Indietro" href="{{route('saldo_mese', $direzione-1)}}" class="btn btn-success btn-block">
                        <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
                <div class="col-6">
                    <a title="Avanti" href="{{route('saldo_mese', $direzione+1)}}" class="btn btn-success btn-block">
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col mt-2">
                <a class="btn btn-primary btn-block" href="{{route('home')}}">Indietro</a>
            </div>
        </div>

        <div class="alert alert-danger mt-5 flex justify-content-between p-0" role="alert">
            <div class="col-1 py-2">Data</div>
            <div class="col-3 py-2">Causale</div>
            <div class="col-2 py-2">Entrate</div>
            <div class="col-2 py-2">Uscite</div>
            <div class="col-2 py-2">Eseguito</div>
            <div class="col-2 py-2"></div>
        </div>

        @foreach($items[0] as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0" role="alert">

                <div class="col-1 py-2">{{$item->giorno ? \Carbon\Carbon::make($item->giorno)->format('d/m') : null}}</div>
                <div class="col-3 py-2">{{$item->causale}}</div>
                <div class="col-2 py-2">{{$item->tipo === 'entrata' ? $item->importo : null}}</div>
                <div class="col-2 py-2">{{$item->tipo === 'uscita' ? $item->importo : null}}</div>
                <div class="col-2 py-2">{{$item->fornitore}}</div>

                <div class="col-2 py-2">
                    @if($item->tipo === 'entrata' && $item->user_id)
                        <a title="Ricevuta" target="_blank" href="{{route('ricevuta', $item->id)}}" class="btn btn-success">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </a>
                    @endif
                    @if($item->causale !== 'Saldo mese precedente')
                        <a title="Elimina" href="{{route('eliminaPrimanota', $item->id)}}" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                    @endif
                </div>


            </div>
        @endforeach
        <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0 font-weight-bold" role="alert">
            <div class="col-2 py-2"></div>
            <div class="col-3 py-2">TOTALI</div>
            <div class="col-2 py-2">{{$items[3]}}</div>
            <div class="col-2 py-2">{{$items[4]}}</div>
            <div class="col-3 py-2">
            </div>
        </div>
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$items[0]->links()}}
        </div>

        <div class="alert alert-success mt-2 flex justify-content-between align-items-center p-0" role="alert">
            <div class="p-2">
                Saldo {{$items[5]}} euro
            </div>
        </div>

    </div>

@endsection

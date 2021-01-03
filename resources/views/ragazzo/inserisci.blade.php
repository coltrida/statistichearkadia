@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Inserisci Ragazzo</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('home')}}">Indietro</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('inserisci_ragazzo')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Nome</label>
                <input type="text" required class="form-control" id="nomeragazzo" name="nomeragazzo" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Voucher</label>
                <input type="number" step=0.5 class="form-control" id="voucher" name="voucher" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Schadenza</label>
                <input type="date" class="form-control" id="scadenza" name="scadenza" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            <div class="col-3">Nome</div>
            <div class="col-3">Voucher</div>
            <div class="col-3">Scadenza</div>
            <div class="col-3">Azioni</div>
        </div>

        @foreach($ragazzi as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert">
                <div class="col-3">{{$item->name}}</div>
                <div class="col-3">€ {{$item->voucher}}</div>
                <div class="col-3">{{$item->scadenza}}</div>
                <div class="col-3">
                    <div>
                        <a title="Modifica" href="{{route('edit_ragazzo', $item->id)}}" class="btn btn-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    {{--<div>
                        <a title="Delete Album" href="{{route('delete_ragazzo', $item->id)}}" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>--}}
                </div>

            </div>
        @endforeach
    </div>

@endsection

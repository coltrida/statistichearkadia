@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Modifica Ragazzo</h1>
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

        <form action="{{route('update_ragazzo', $client->id)}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Nome</label>
                <input type="text"
                       value="{{$client->name}}"
                       required
                       class="form-control"
                       id="nomeragazzo"
                       name="nomeragazzo"
                       aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Voucher</label>
                <input type="number" class="form-control" value="{{$client->voucher}}" id="voucher" name="voucher" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Schadenza</label>
                <input type="date" value="{{$client->scadenza}}" class="form-control" id="scadenza" name="scadenza" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Modifica</button>
        </form>


    </div>

@endsection

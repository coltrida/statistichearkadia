@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Inserisci Vettura</h1>
        </div>

        <form action="{{route('inserisci_vettura')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nomevettura" class="text-white">Vettura</label>
                <input type="text" required class="form-control" id="nomevettura" name="nomevettura" aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            <div>Vettura</div>
        </div>

        @foreach($vetture as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between" role="alert">
                <div>{{$item->name}}</div>
            </div>
        @endforeach
    </div>

@endsection

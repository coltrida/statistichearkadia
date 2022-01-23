@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Inserisci Entrata</h1>
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

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
        @endif

        <form action="{{route('inserisci_entrata')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="row ">
                <div class="col-lg-3 col-xl-3 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="importo" class="text-white">Importo</label>
                    <input type="number" step=".1" required class="form-control" id="importo" name="importo" aria-describedby="emailHelp">
                </div>
                <div class="col-lg-3 col-xl-3 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="tipo" class="text-white">Causale</label>
                    <select required class="custom-select" name="causale">
                        <option value=""></option>
                        <option>Quota Sociale</option>
                        <option>Donazione</option>
                        <option>Altro</option>
                    </select>
                </div>
                <div class="col-lg-3 col-xl-3 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="nominativo" class="text-white">Nominativo</label>
                    <input type="text" required class="form-control" id="nominativo" name="fornitore" aria-describedby="emailHelp">
                </div>
                <div class="col-lg-3 col-xl-3 col-md-12 col-sm-12 col-xs-12 pt-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
                </div>
            </div>

        </form>
    </div>

@endsection

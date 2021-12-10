@extends('layouts.stile')

@section('content')
    <div class="bg-white p-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        Ricevuta nr. {{$primanota->progressivo}} / {{$primanota->anno}}
                    </div>
                    <div class="col">
                        Del {{$primanota->created_at->format('d-m-Y')}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">{{$primanota->fornitore}}</h3>
                <br>
                <p class="card-text">Importo fornito: {{$primanota->importo}} euro</p>
                <p class="card-text">Causale: {{$primanota->causale}}</p>
            </div>
        </div>

    </div>

@endsection

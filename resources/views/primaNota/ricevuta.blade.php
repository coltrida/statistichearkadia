@extends('layouts.ricevutaStile')

@section('content')
    <div class="bg-white p-6" style="height: 600px">
        <h3>Arkadia Onlus</h3>
        <h5>via G. La Pira, 24</h5>
        <h5>52028 Terranuova Bracciolini (AR)</h5>
        <h5>Cod. Fisc. e P. iva 90025750515</h5>
        <h5>pec: arkadiaonlus@pec.it</h5>
        <br><br>
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

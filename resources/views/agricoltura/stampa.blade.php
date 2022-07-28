@extends('layouts.stile')

@section('testa')
    <link href="{{ asset('css/agricoltura.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div style="background-color: white; color: black">

        <h2 >{{$utente->name}}</h2>
        <h3 >Dalle 09:00 Alle 14:00 del mese: {{$mese}}</h3>
    <table class="table">
        <thead>
        <tr style="background-color: #206fc0">
            <th scope="col">Data</th>
            <th scope="col">Stato</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($utente->agricoltura as $giorniselezioanati)
            <tr>
                <th scope="row">{{$giorniselezioanati->giorno}}</th>
                <td>{{$giorniselezioanati->presenza}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
        <br>
        <h3>Totale Settimane lavorate: {{$totaleSettimaneLavorate}}</h3>
        <br><br>
        <div class="row">
            <div class="col-md-8 push-2">
                <h4 >Firma:      _______________________________</h4>
                <br>
                <h4 >Firma Tutor:__________________________</h4>
            </div>
        </div>
    </div>
@endsection


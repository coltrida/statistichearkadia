@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Statistiche Presenze Operatori - {{$user->name}}</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        <form action="{{route('visualizza_presenze_operatore')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6 form-group">
                    <label for="operatore" class="text-white">Operatore</label>
                    <select required class="custom-select" name="operatore" id="operatore">
                        <option value=""></option>
                        @foreach($operatori as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>


            <div class="col-6 form-group">
                <label for="operatore" class="text-white">Settimana</label>
                <select required class="custom-select" name="settimana" id="settimana">
                    @for($i=1; $i<=count($settimane); $i++)
                        <option {{$i==$settimana?'selected':''}} value={{$i}}>{{$settimane[$i]}}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Cerca</button>
        </form>
    </div>

    @foreach($presenze as $key => $value)
        <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert">
            <div class="col">giorno: {{$value->giorno}}</div>
            <div class="col">Ore: {{$value->ore}}</div>
        </div>
    @endforeach
    <div class="alert alert-warning mt-2 flex justify-content-between align-items-center" role="alert">
        Totale: {{$totale}} - Saldo ore: {{$user->oresaldo}}
    </div>

@endsection

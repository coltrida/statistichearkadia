@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Associa Operatore - Ore settimanali</h1>
        </div>

        <form action="{{route('eseguiassociaoperatoreore')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col form-group">
                    <label for="attivita" class="text-white">Operatore</label>
                    <select required class="custom-select" name="operatore" id="operatore">
                        <option value=""></option>
                        @foreach($operatori as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="nomeragazzo" class="text-white">Ore Settimanali</label>
                <input type="number" step=0.5 class="form-control" id="ore" name="ore" aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Associa</button>
        </form>


        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Nome</div>
            <div class="col">Ore Settimanali</div>
            <div class="col">Ore Saldo</div>
        </div>

        @foreach($operatori as $elemento)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert">
                <div class="col">{{$elemento->name}}</div>
                <div class="col">{{$elemento->oresettimanali}}</div>
                <div class="col">{{$elemento->oresaldo}}</div>

            </div>
        @endforeach

    </div>

@endsection


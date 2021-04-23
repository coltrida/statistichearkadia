@extends('layouts.stile')



@section('testa')
    <link href="{{ asset('css/agricoltura.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div style="color: white; display: flex; justify-content: center; align-items: center">
        <a href="{{route('agricoltura', $precedente)}}" class="btn btn-primary">Indietro</a>
        <h2 style="margin: 0 20px">{{$mese}} / {{$anno}}</h2>
        <a href="{{route('agricoltura', $successivo)}}" class="btn btn-primary">Avanti</a>
    </div>

    <form action="{{route('postagricoltura')}}" method="post">
        @csrf
        <select name="persona" class="form-control" id="exampleFormControlSelect1" style="width: 40%; margin: 40px">
            @foreach($persone as $persona)
                <option value="{{$persona->id}}">{{$persona->name}}</option>
            @endforeach
        </select>
        <div style="display: flex; justify-content: space-between; align-items: center">

            @foreach($settimana as $giornosettimana)
                <div
                    style="background-color: #4f550c; color: white; border: 1px solid white; width: 14%; height: 50px; padding: 10px 0 0 30px">
                    {{$giornosettimana}}
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center">
            @for($z = 1; $z <= 7; $z++)
                @if($z < $numerodispazi)
                    <div
                        style="color: white; border: 1px solid white; width: 14%; height: 70px; padding: 10px 0 0 30px">
                        &nbsp;
                    </div>
                @else
                    <div
                        style="color: white; border: 1px solid white; width: 14%; height: 70px; padding: 10px 0 0 30px">
                        <div style="display: flex; justify-content: space-between">
                            <div>{{$gg = $z - $numerodispazi + 1}}</div>
                            <div style="margin-right: 10px">
                                <input name="switch[{{$gg}}/1]" value="P" id="one{{$gg}}" type="radio"/>
                                <label for="one{{$gg}}" class="switch__label">P</label>
                                <input name="switch[{{$gg}}/1]" value="A" id="two{{$gg}}" type="radio"/>
                                <label for="two{{$gg}}" class="switch__label">A</label>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>

        @for($i = 1; $i <= $nrsettimane; $i++)
            <div style="display: flex; justify-content: space-between; align-items: center">
                @for($j = $giornoInizioSecondaSettimana + ($i-1) * 7; $j <= $giornoInizioSecondaSettimana + ($i * 7) - 1; $j++)
                    @if($j <= $lastDay)
                        <div
                            style="color: white; border: 1px solid white; width: 14%; height: 70px; padding: 10px 0 0 30px">
                            <div style="display: flex; justify-content: space-between">
                                <div>{{$gg = $j}}</div>
                                <div style="margin-right: 10px">
                                    <input name="switch[{{$gg}}/{{$i+1}}]" value="P" id="one{{$gg}}" type="radio"/>
                                    <label for="one{{$gg}}" class="switch__label">P</label>
                                    <input name="switch[{{$gg}}/{{$i+1}}]" value="A" id="two{{$gg}}" type="radio"/>
                                    <label for="two{{$gg}}" class="switch__label">A</label>
                                </div>
                            </div>
                        </div>

                    @else
                        <div
                            style="color: white; border: 1px solid white; width: 14%; height: 70px; padding: 10px 0 0 30px">
                            &nbsp;
                        </div>
                    @endif
                @endfor
            </div>
        @endfor
        <input type="hidden" name="mese" value="{{$mesenumero}}">
        <input type="hidden" name="anno" value="{{$anno}}">
        <input type="hidden" name="giorno" value="{{$giorno}}">
        <button type="submit" class="btn btn-primary m-3">Invia</button>
    </form>
    <br>
    @if(isset($utente))
        <h2 style="color: white;">{{$utente->name}}</h2>
        <h3 style="color: white;">Dalle 09:00 Alle 14:00 del mese: {{$mese}}</h3>
    <table class="table" style="color: white">
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
                <td><a href="{{route('eliminaagricola', $giorniselezioanati->id)}}" class="btn btn-danger">Elimina</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
        <br>
        <h3 style="color: white">Totale Settimane lavorate: {{$totaleSettimaneLavorate}}</h3>
        <br><br>
        <div class="row">
            <div class="col-md-8 push-2">
                <h4 style="color: white">Firma:      _______________________________</h4>
                <br>
                <h4 style="color: white">Firma Tutor:__________________________</h4>
            </div>
        </div>


    @endif
@endsection

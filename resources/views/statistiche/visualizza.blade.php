@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Presenze {{$nome}} {{$mese}}/{{$anno}}</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        @include('statistiche.partial.formpresenze')
    </div>

    @foreach($items as $item)
        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Attività</div>
            <div class="col">Giorno</div>
            <div class="col">Quantita'</div>
            <div class="col"></div>
        </div>
        @foreach($item as $ele)
            <div class="alert alert-primary mt-2 flex justify-content-between" role="alert" id="ass{{$ele->id}}">
                <div class="col">{{$ele->activity->name}}</div>
                <div class="col">{{$ele->giorno}}</div>
                <div class="col">{{$ele->quantita}}</div>
                <div class="col">
                    <a title="Elimina" href="{{route('elimina_dati', $ele->id)}}" class="btn btn-danger" id="{{$ele->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>

            </div>
        @endforeach
    @endforeach

    <div class="alert alert-warning mt-5 flex justify-content-between" role="alert">
        <div>Costo Totale</div>
        <div>{{$totale}}</div>
    </div>
    {{--<div class="alert alert-warning flex justify-content-between" role="alert">
        <div>Saldo Voucher</div>
        <div>{{$client->voucher}}</div>
    </div>--}}

@endsection

@section('footer')
    @parent
    <script>
        $('document').ready(function () {

            /*-------------- Elimina attivita cliente ----------------*/
            $('a.btn-danger').on('click', function (ele) {  //è consigliato mettere il listener su ul e non sui li
                ele.preventDefault();
                var url = ($(this).attr('href'));  //QUESTO è UN ALTRO MODO PER CATTURARE IL LINK (con jQuery)
                var id = 'ass'+($(this).attr('id'));
                //alert(url);
                $.ajax(url,
                    {
                        data : {
                            '_token' : $('#_token').val()
                        },
                        complete : function (resp) {
                            console.log(resp);        //COSì POSSIAMO VEDERE IL VALORE ( = 1) NELLA CONSOLE DEL BROWSER
                            if(resp.responseText == 1){
                                //alert(resp.responseText);
                                $( "#"+id ).remove();
                            }else{
                                alert('problemi');
                            }
                        }
                    })
            })


        });
    </script>
@endsection

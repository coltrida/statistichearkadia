@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Statistiche Chilometri - {{$nomecar}} {{$mese}}/{{$anno}}</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        @include('statistiche.partial.formkmvettura')

        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Giorno</div>
            <div class="col">Km percorsi</div>
            <div class="col">Operatore</div>
            <div class="col">Passeggeri</div>
            <div class="col">Azioni</div>
        </div>

        @foreach($viaggi as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert" id="ass{{$item->id}}">
                <div class="col">{{$item->giorno}}</div>
                <div class="col">{{$item->kmPercorsi}}</div>
                <div class="col">{{$item->user->name}}</div>
                <div class="col">
                    @foreach($item->clienttrip as $passeggero)
                        <div>{{$passeggero->ragazzi[0]->name}}</div>
                    @endforeach
                </div>
                <div class="col-2 azion">
                    <a title="Elimina" href="{{route('elimina_chilometri', $item->id)}}" class="btn btn-danger" id="{{$item->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </div>
        @endforeach

        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div>Km Totale</div>
            <div>{{$totkm}}</div>
        </div>

    </div>
@endsection

@section('footer')
    @parent
    <script>
        $('document').ready(function () {

            $('.azion').on('click', 'a.btn-danger', function (ele) {  //è consigliato mettere il listener su ul e non sui li
                ele.preventDefault();

                // ele.target.href = $(this).attr('href')
                //alert(ele.target.href);               //QUESTO è L'ALERT DEL TARGET LINK
                var url = ($(this).attr('href'));  //QUESTO è UN ALTRO MODO PER CATTURARE IL LINK (con jQuery)
                var id = 'ass'+($(this).attr('id'));
                // alert(li);
                $.ajax(url,
                    {
                        method: 'DELETE',
                        data : {
                            '_token' : $('#_token').val()
                        },
                        complete : function (resp) {
                            //console.log(resp);        //COSì POSSIAMO VEDERE IL VALORE ( = 1) NELLA CONSOLE DEL BROWSER
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

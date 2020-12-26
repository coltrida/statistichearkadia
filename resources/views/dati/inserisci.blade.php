@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Inserisci Dati</h1>
        </div>

        <form action="{{route('inserisci_dati')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div >
                <div class="col form-group">
                    <label for="attivita" class="text-white">Attività</label>
                    <select required class="custom-select" name="attivita" id="attivita">
                        <option value=""></option>
                        @foreach($attivita as $ele)
                            <option value="{{$ele->id}}" data-foo="{{$ele->tipo}}" data-cos="{{$ele->cost}}">{{$ele->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col form-group">
                    <ul class="list-group" style="max-height: 100px;
                            margin-bottom: 10px;
                            overflow:scroll;
                            -webkit-overflow-scrolling: touch;">
                        @foreach($ragazzi as $ragazzo)
                            <li class="list-group-item">
                                <input class="form-check-input ml-1" type="checkbox" name="raga[]" value="{{$ragazzo->id}}" id="{{"raga".$ragazzo->id}}">
                                <label class="form-check-label ml-4" for="defaultCheck1">
                                    {{$ragazzo->name}}
                                </label>

                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col form-group">
                    <label for="giorno" class="text-white">Giorno</label>
                    <input type="date" required class="form-control" id="giorno" name="giorno">
                </div>

                <div class="col form-group">
                    <label for="quantita" class="text-white">Quantità</label>
                    <input type="number" step=0.5 readonly class="form-control" id="quantita" value="1" name="quantita" aria-describedby="emailHelp">
                </div>

                    <input type="hidden" readonly class="form-control" id="costo" name="costo" aria-describedby="emailHelp">

                <div class="col form-group">
                    <label for="note" class="text-white">Note</label>
                    <input type="text" class="form-control" id="note" name="note" aria-describedby="emailHelp">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-5 flex justify-content-between p-1" role="alert">
            <div class="col">Nome</div>
            <div class="col">Giorno</div>
            <div class="col">Attività</div>
            <div class="col">Quantita'</div>
            <div class="col">Azioni</div>
        </div>

        @foreach($items as $item)
            <div class="alert alert-primary mt-2 container justify-content-between align-items-center pl-1" role="alert" id="ass{{$item->id}}">
                <div class="row">
                    <div class="col">{{$item->client->name}}</div>
                    <div class="col">{{$item->giorno}}</div>
                    <div class="col">{{$item->activity->name}}</div>
                    <div class="col">{{$item->quantita}}</div>
                    <div class="col azion">
                        <a title="Elimina" href="{{route('elimina_dati', $item->id)}}" class="btn btn-danger mr-1" id="{{$item->id}}">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>

            </div>
        @endforeach
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$items->links()}}
        </div>
    </div>

@endsection

@section('footer')
    @parent
    <script>
        $('document').ready(function () {

            /*-------------- seleziono attivita e attivo la quantita in base al tipo di costo ----------------*/
            $('#attivita').change(function() {
                var selected = $(this).find('option:selected');
                var extra = selected.data('foo');
                var extracosto = selected.data('cos');
                $('#costo').val(extracosto);
                if (extra == 'orario'){
                    $('#quantita').attr('readonly', false)
                }else {
                    $('#quantita').val(1);
                    $('#quantita').attr('readonly', true)
                }

                $('#quantita').change(function() {
                    var qta = $('#quantita').val();
                    $('#costo').val(qta * extracosto);
                });

                /*-------------- valorizzazione check dei ragazzi del corso selezionato ----------------*/
                var idattivita = selected.val();
                var url = "{{route('attivitaragazzi', ":id")}}";
                url = url.replace(':id', idattivita);

                $.ajax(url,
                    {
                        complete : function (resp) {
                            resp.responseJSON.forEach(element => {
                                //console.log(element.client_id)
                                id='#raga'+element.client_id;
                                $(id).prop( "checked", true );
                            });
                        }
                    })
            });

            /*-------------- Elimina attivita cliente ----------------*/
            $('.azion').on('click', 'a.btn-danger', function (ele) {  //è consigliato mettere il listener su ul e non sui li
                ele.preventDefault();

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

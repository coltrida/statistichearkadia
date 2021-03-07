@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Inserisci Attività</h1>
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

        <form action="{{route('inserisci_attivita')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="form-group">
                <label for="nomeattivita" class="text-white">Nome attività</label>
                <input type="text" required class="form-control" id="nomeattivita" name="nomeattivita" aria-describedby="emailHelp">
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="costo" class="text-white">Costo</label>
                    <input type="number" step=0.5 required class="form-control" id="costo" name="costo">
                </div>
                <div class="col form-group">
                    <label for="tipo" class="text-white">Tipo</label>
                    <select class="custom-select" name="tipo">
                        <option value="mensile">Mensile</option>
                        <option value="orario">Orario</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-5 flex justify-content-between p-0" role="alert">

                <div class="col-3">Attività</div>
                <div class="col-3">Costo</div>
                <div class="col-3">Tipologia</div>
                <div class="col-3">Azioni</div>

        </div>

        @foreach($attivita as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0" role="alert" id="ass{{$item->id}}">

                    <div class="col-3">{{$item->name}}</div>
                    <div class="col-3">{{$item->cost}}</div>
                    <div class="col-3">{{$item->tipo}}</div>
                    <div class="col-3 azion">
                        <a title="Elimina" href="{{route('elimina_attivita', $item->id)}}" class="btn btn-danger mr-1" id="{{$item->id}}">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>

            </div>
        @endforeach
    </div>

@endsection
{{--

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

--}}


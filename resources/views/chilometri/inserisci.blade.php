@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Inserisci Chilometri</h1>
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

        <form action="{{route('inserisci_chilometri')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div>
                <div class="col form-group">
                    <label for="car" class="text-white">Vettura</label>
                    <select required class="custom-select" name="car" id="car">
                        <option value=""></option>
                        @foreach($vetture as $car)
                            <option {{$car->id==old('car') ? 'selected' : ''}}
                                    value={{$car->id}}>{{$car->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col form-group">
                    <label for="kminiziali" class="text-white">km iniziali</label>
                    <input type="number" required min="0" class="form-control" id="kminiziali" name="kminiziali" value="{{old('kminiziali')}}">
                </div>
                <div class="col form-group">
                    <label for="kmfinali" class="text-white">km finali</label>
                    <input type="number" required min="0" class="form-control" id="kmfinali" name="kmfinali" value="{{old('kmfinali')}}">
                </div>
                <div class="col form-group">
                    <label for="utente" class="text-white">Operatore</label>
                    <select required class="custom-select" name="utente" id="utente">
                        <option value=""></option>
                        @foreach($users as $user)
                            <option {{$user->id==old('utente') ? 'selected' : ''}}
                                    value={{$user->id}}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col form-group">
                    <label for="giorno" class="text-white">Giorno</label>
                    <input type="date" required class="form-control" id="giorno" name="giorno" value="{{old('giorno')}}">
                </div>

                <div class="col form-group">
                    <ul class="list-group" style="max-height: 100px;
                            margin-bottom: 10px;
                            overflow:scroll;
                            -webkit-overflow-scrolling: touch;">
                        @foreach($ragazzi as $ragazzo)
                            <li class="list-group-item">
                                <input class="form-check-input ml-1" type="checkbox" name="raga[]" value="{{$ragazzo->id}}" id="defaultCheck1">
                                <label class="form-check-label ml-4" for="defaultCheck1">
                                    {{$ragazzo->name}}
                                </label>

                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-5 flex justify-content-between p-0" role="alert">

                <div class="col-2 ml-1">Vettura</div>
                <div class="col-1">Km</div>
                <div class="col-2">Operatore</div>
                <div class="col-2">Giorno</div>
                <div class="col-3">Pass.</div>
                <div class="col-2">Azioni</div>


        </div>

        @foreach($items as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center p-0" role="alert" id="ass{{$item->id}}">

                    <div class="col-2 ml-1">{{$item->car->name}}</div>
                    <div class="col-1">{{$item->kmPercorsi}}</div>
                    <div class="col-2">{{$item->user->name}}</div>
                    <div class="col-2">{{$item->giorno}}</div>
                    {{--<div class="col">{{$item->clienttrip->count()}}</div>--}}
                    <div class="col-3">
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
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$items->links()}}
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

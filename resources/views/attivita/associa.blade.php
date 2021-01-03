@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Associa Attività - Ragazzo</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('associaindex')}}">Indietro</a>
            </div>
        </div>

        <form action="{{route('associa')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col form-group">
                    <label for="attivita" class="text-white">Attività</label>
                    <select required class="custom-select" name="attivita" id="attivita">
                        <option value=""></option>
                        @foreach($attivita as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
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

            <button type="submit" class="btn btn-primary btn-lg btn-block">Associa</button>
        </form>


        <div class="alert alert-danger mt-5 flex justify-content-between" role="alert">
            <div class="col">Attività</div>
            <div class="col">Ragazzi</div>
            <div class="col">Azioni</div>
        </div>

        @foreach($associazioni as $associazione)
            <div class="alert alert-primary mt-2 flex justify-content-between align-items-center" role="alert" id="ass{{$associazione->id}}">
                <div class="col">{{$associazione->activity->name}}</div>
                <div class="col">{{$associazione->client->name}}</div>
                <div class="col azion">
                    <a title="Dissocia" href="{{route('dissocia', $associazione->id)}}" class="btn btn-danger mr-1" id="{{$associazione->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>

            </div>
        @endforeach

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
                var urlassocia = ($(this).attr('href'));  //QUESTO è UN ALTRO MODO PER CATTURARE IL LINK (con jQuery)
                var id = 'ass'+($(this).attr('id'));
                // alert(li);
                $.ajax(urlassocia,
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

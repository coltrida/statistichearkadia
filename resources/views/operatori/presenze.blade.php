@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Inserisci Presenze</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('home')}}">Indietro</a>
            </div>
        </div>

        <form action="{{route('inserisci_presenze')}}" method="POST">
            @csrf
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col form-group">
                    <label for="giorno" class="text-white">Giorno</label>
                    <input type="date" required class="form-control" id="giorno" name="giorno">
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="ore" class="text-white">Ore</label>
                    <input required type="number" min="0" step="0.5" class="form-control" id="ore" name="ore">
                </div>

            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
        </form>

        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            <div class="col">Giorno</div>
            <div class="col">Ore</div>
            <div class="col">Azioni</div>
        </div>

        @foreach($presenze as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between" role="alert" id="ass{{$item->id}}">
                <div class="col">{{$item->giorno}}</div>
                <div class="col">{{$item->ore}}</div>
                <div class="col azion">
                    <a title="Elimina" href="{{route('elimina_presenza', $item->id)}}" class="btn btn-danger mr-1" id="{{$item->id}}">
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

            $('.azion').on('click', 'a.btn-danger', function (ele) {
                ele.preventDefault();

                var url = ($(this).attr('href'));
                var id = 'ass'+($(this).attr('id'));
                //alert(url);
                $.ajax(url,
                    {
                        method: 'DELETE',
                        data : {
                            '_token' : $('#_token').val()
                        },
                        complete : function (resp) {
                            console.log(resp);
                            if(resp.responseText == 1){
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

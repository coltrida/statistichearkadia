@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Log</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('associaindex')}}">Indietro</a>
            </div>
        </div>

        @foreach($logs as $item)
            <div class="alert alert-primary mt-2 flex justify-content-between" role="alert">
                <div class="col-2">{{$item->created_at->format('d/m/Y')}}</div>
                <div class="col-3">{{$item->log_name}}</div>
                <div class="col-7">{{$item->description}}</div>
            </div>
        @endforeach
        <div class="alert alert-danger mt-2 flex justify-content-between" role="alert">
            {{$logs->links()}}
        </div>
    </div>

@endsection

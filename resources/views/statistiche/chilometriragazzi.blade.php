@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-content-between pt-8 sm:pt-0 dark:text-white">
            <div>
                <h1>Statistiche Chilometri Ragazzi</h1>
            </div>
            <div>
                <a class="btn btn-primary" href="{{route('statistiche')}}">Indietro</a>
            </div>
        </div>

        @include('statistiche.partial.formkmragazzi')
    </div>

@endsection

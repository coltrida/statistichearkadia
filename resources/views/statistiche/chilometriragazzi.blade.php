@extends('layouts.stile')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 dark:text-white">
            <h1>Statistiche Chilometri Ragazzi</h1>
        </div>

        @include('statistiche.partial.formkmragazzi')
    </div>

@endsection

@extends('layouts.admin')

@section('title')
    Analytics
@endsection

@section('content')
    <div class="container py-4">
        <h1 class="pb-5">Analytics</h1>
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Apartments</h2>
                <div class="list-group">
                    @foreach ($apartments as $apartment)
                        <a href="#" class=" p-4 card mb-3 apartment-title" data-id="{{ $apartment->id }}">
                            <h5 class="mb-1">{{ $apartment->title }}</h5>
                            <span class="mb-1 fw-normal">{{ $apartment->address }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8">
                <h2 class="text-center mb-4">Analytics</h2>
                @foreach ($apartments as $apartment)
                    <div class="apartment-{{ $apartment->id }} apartment-analytics">
                        <span>{{ count($apartment->visits) }} - totale visual</span>
                        @foreach ($apartment->visits as $visit)
                            <span>{{ $visit->date }}</span> <!-- Visualizza la data della visita -->
                            @php
                                $visitsCount = $apartment->visits->where('date', $visit->date)->count();
                            @endphp
                            <span>{{ $visitsCount }}</span> <!-- Visualizza il conteggio delle visite per quella data -->
                        @endforeach
                        <span>{{ count($apartment->messages) }} - totale messaggi</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

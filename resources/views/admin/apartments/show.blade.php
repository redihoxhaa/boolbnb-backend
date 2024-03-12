@extends('layouts.admin')

@section('title')
    Apartment Details - {{ $apartment->title }}
@endsection

@section('content')

    <div class="col-auto">
        @if (session('success'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto"><i class="fa-solid fa-check me-1"></i>Success!</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-success-subtle text-emphasis-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if (session('message'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto"><i class="fa-solid fa-check me-2"></i>Success!</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-success-subtle text-emphasis-success">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="m-0"><i class="fas fa-info-circle"></i> Apartment Details: {{ $apartment->title }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $apartment->title }}</h5>
                        <p class="card-text"><strong>Description:</strong> {{ $apartment->description }}</p>
                        <p class="card-text"><strong>Rooms:</strong> {{ $apartment->rooms }}</p>
                        <p class="card-text"><strong>Beds:</strong> {{ $apartment->beds }}</p>
                        <p class="card-text"><strong>Bathrooms:</strong> {{ $apartment->bathrooms }}</p>
                        <p class="card-text"><strong>Square Meters:</strong> {{ $apartment->square_meters }}</p>
                        <p class="card-text"><strong>Address:</strong> {{ $apartment->address }}</p>
                        <p class="card-text"><strong>Visibility:</strong>
                            {{ $apartment->is_visible ? 'Public' : 'Private' }}</p>
                        <p class="card-text"><strong>Services:</strong>
                            @foreach ($apartment->services as $service)
                                {{ $service->name }},
                            @endforeach
                        </p>
                        @if ($apartment->images)
                            <p class="card-text"><strong>Images:</strong></p>
                            <div class="row">
                                @foreach (explode(',', $apartment->images) as $image)
                                    <div class="col-md-3">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Apartment Image"
                                            class="img-fluid mb-2">

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4"><i
                                class="fas fa-arrow-left"></i> Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

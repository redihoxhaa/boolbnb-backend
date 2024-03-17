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
    {{-- <div class="container py-3">
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
    </div> --}}

    <div class="container edit">

        <h2 class="mb-5 text-center">Apartment Details - {{ $apartment->title }}</h2>

        <div class="row">
            <div class="col-md-7">
                <h6 class="fw-bold mb-4 text-uppercase">Info</h6>
                <!-- Campo per il titolo dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <h4>{{ $apartment->title }}</h4>


                <!-- Campo per la descrizione dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->

                <p class="mt-4">{{ $apartment->description }}</p>
                <div class="row mt-3">
                    <div class="p-2 col-3">
                        <div class="d-flex flex-column align-items-center card-icon">
                            <div><img class="pb-1 me-2" src="{{ asset('assets/images/cottage.svg') }}" alt="Rooms">Rooms
                            </div>
                            <div class="room-counter mt-3">

                                <div class="room-number" id="roomsNumber">{{ $apartment->rooms }}</div>


                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-3">
                        <div class="d-flex flex-column align-items-center card-icon">
                            <div><img class="me-2" src="{{ asset('assets/images/bed.svg') }}" alt="Beds"> Beds
                            </div>
                            <div class="room-counter mt-3">

                                <div class="room-number" id="bedsNumber">{{ $apartment->beds }}</div>


                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-3">
                        <div class="d-flex flex-column align-items-center card-icon">
                            <div><img class="pb-1 me-2" src="{{ asset('assets/images/bathtub.svg') }}"
                                    alt="Bathrooms">Bathrooms</div>
                            <div class="room-counter mt-3">

                                <div class="room-number" id="bathroomsNumber">
                                    {{ $apartment->bathrooms }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 col-3">
                        <div class="d-flex flex-column align-items-center card-icon">
                            <div><img class="pb-1 me-2" src="{{ asset('assets/images/area.svg') }}" alt="Area">Area
                            </div>
                            <div class="room-counter mt-3">

                                <div class="room-number" id="areaNumber">{{ $apartment->square_meters }}
                                    <span class="sqm">sqm</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 position-relative">
                        <h5 class="fw-bold">Location</h5>
                        <div>{{ $apartment->address }}</div>
                        <div class="mt-3">
                            <img class="w-100" src="{{ asset('assets/images/Group256.png') }}" alt="img">
                        </div>


                        <div id="suggestionsMenu" class="card position-absolute w-100 radius d-none">
                            <ul class="suggestions-list"></ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold">Service</h5>
                            <span>{{ count(old('services', $apartment->services->pluck('id')->toArray())) }} services
                                selected</span>
                        </div>
                        <div class="input-container">
                            <input type="text" class="form-control" id="service" name="service" autocomplete="off"
                                placeholder="Search for service..." value="{{ old('service') }}">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="mt-3">
                            <ul>
                                <li>
                                    @foreach ($apartment->services as $service)
                                        <label
                                            class="service-label service-list m-1{{ $loop->index >= 10 ? ' extra' : '' }}"
                                            for="service{{ $service->id }}">
                                            <input type="checkbox" id="service{{ $service->id }}" name="services[]"
                                                value="{{ $service->id }}" style="display: none;"
                                                {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <span>{{ $service->name }}</span>
                                        </label>
                                    @endforeach
                                    <div class="show-more mt-3 ms-2 text-decoration-underline">Show More</div>
                                </li>
                            </ul>

                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-5">
                <div>
                    <h6 class="fw-bold mb-4 text-uppercase">Photo</h6>
                    <div class="col-md-12">

                        @if ($apartment->images)
                            <div class="row">
                                @foreach (explode(',', $apartment->images) as $image)
                                    <div class="col-md-3">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Apartment Image"
                                                class="img-fluid img-edit mb-2">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row" id="preview-images-container">
                                    <!-- Qui verranno visualizzate le miniature delle immagini -->
                                </div>
                            </div>
                        @endif

                        @error('images')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                        @enderror

                    </div>

                </div>

                <div>
                    <h5 class="fw-bold mt-5 mb-3 text-uppercase">Sponsor your apartment</h5>

                    <div class="row">
                        <div class="p-2">
                            <div class="no-sponsor d-flex">
                                <div class="d-flex gap-3 align-items-center">
                                    <div><img class="pb-1 me-2 img-rocket" src="{{ asset('assets/images/rocket.svg') }}">
                                    </div>
                                    <div>
                                        <div class="d-flex felx-column">
                                            <p class="m-0 fw-bold">Sponsor your apartment and boost your visibility
                                                with
                                                our
                                                sponsorship opportunities!"</p>
                                        </div>
                                        <div>
                                            <div class="span-no-boost text-decoration-underline" role="button">Choose
                                                your plan</div>
                                        </div>
                                    </div>
                                    <div><img class="pb-1 me-2" role="button"
                                            src="{{ asset('assets/images/Group 179.svg') }}">
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>


                <div>
                    <h6 class="fw-bold text-uppercase mt-1 mb-2">Available</h6>

                    <label class="switch mt-2">
                        <input type="checkbox" name="is_visible" id="visibility_switch"
                            {{ old('is_visible', $apartment->is_visible) == 1 ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <div id="visibility_options"
                        style="display: {{ old('is_visible', $apartment->is_visible) == 1 ? 'block' : 'none' }}">
                    </div>
                </div>
                <span class="span-payment">It will not appear in the search engine</span>

            </div>
            <div class="text-end me-5">
                <button type="submit" class="btn btn-create"><a
                        href="{{ route('admin.apartments.edit', $apartment) }}">Go to
                        edit</a></button>
            </div>


        </div>

    </div>



    </form>
    </div>
@endsection

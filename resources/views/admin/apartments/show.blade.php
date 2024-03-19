@extends('layouts.admin')

@section('title')
    Apartment Details - {{ $apartment->title }}
@endsection

@section('content')
    <div class="col-auto">
        @if (session('success'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header custom-toaster">
                        <strong class="me-auto"><i class="fa-solid fa-check me-1"></i>Success!</strong>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="toast"
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
                    <div class="toast-header custom-toaster">
                        <strong class="me-auto"><i class="fa-solid fa-check me-2"></i>Success!</strong>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-success-subtle text-emphasis-success">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="px-3 px-lg-5 py-4 show container">

        {{-- Path Page --}}
        <div class="path-page">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.apartments.index') }}">Apartments</a>
            <span>/</span>
            <span>{{ $apartment->title }}</span>
        </div>

        <div class="header mb-4 mt-3 d-flex justify-content-between align-items-center">
            <h2 class="">Apartment Details</h2>

            <div class="buttons gap-3 d-none d-lg-flex">
                <a role="button" class="btn-tool border border-dark bg-white text-black border-"
                    href="{{ route('admin.apartments.edit', $apartment) }}">
                    Edit
                </a>

                <a role='button' class="btn-tool bg-danger text-white" data-bs-toggle="modal"
                    data-bs-target="#my-dialog-{{ $apartment->id }}">
                    Delete apartment
                </a>
            </div>
        </div>



        {{-- Modale --}}
        <div class="modal" id="my-dialog-{{ $apartment->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content card-custom">

                    {{-- Messaggio di alert --}}
                    <div class="modal-header ">
                        <h3 class="d-block w-100 text-center">Are you sure?</h3>
                    </div>

                    {{-- Informazione operazione --}}
                    <div class="modal-body text-center">
                        You are about to delete <br><span class="fw-bold">
                            {{ $apartment->title }}</span>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">


                        {{-- Pulsante annulla --}}
                        <button class="btn-tool border border-dark bg-white text-black border mb-4 mt-3"
                            data-bs-dismiss="modal">Dismiss
                        </button>

                        {{-- Pulsante elimina --}}
                        <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-tool bg-danger text-white mb-4 mt-3" type="submit" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @php
            $images = explode(',', $apartment->images);
            $count = count($images);
        @endphp

        @if ($apartment->images)
            {{-- Carosello --}}
            <div id="carouselExampleIndicators" class="carousel slide d-lg-none">
                <div class="carousel-inner">
                    @foreach ($images as $key => $image)
                        <div class="carousel-item @if ($key === 0) active @endif">
                            <div class="parent d-flex justify-content-center">
                                <img class="d-block w-100" src="{{ asset('storage/' . $image) }}" alt="ApartmentImage">
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            {{-- Images to grid --}}
            <div class="image-gallery d-none d-lg-block">

                <!-- Modal -->
                <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <img src="" alt="Apartment image" id="modalImage">
                    </div>
                </div>

                @if (count($images) === 1)
                    <div class="with-1-foto">
                        <div class="parent">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" class="w-100"
                                data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(0)">
                        </div>

                    </div>
                @elseif (count($images) === 2)
                    <div class="with-2-foto d-flex gap-4">
                        <div class="w-50-custom">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" data-bs-toggle="modal"
                                data-bs-target="#modal1" onclick="openModal(0)">
                        </div>
                        <div class="w-50-custom">
                            <img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image" data-bs-toggle="modal"
                                data-bs-target="#modal1" onclick="openModal(1)">
                        </div>
                    </div>
                @elseif (count($images) === 3)
                    <div class="with-3-foto d-flex gap-4">
                        <div class="w-50-custom">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" data-bs-toggle="modal"
                                data-bs-target="#modal1" onclick="openModal(0)">
                        </div>
                        <div class="w-50 d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(1)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                        </div>
                    </div>
                @elseif (count($images) === 4)
                    <div class="with-4-foto d-flex gap-4">
                        <div class="w-50-custom">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" data-bs-toggle="modal"
                                data-bs-target="#modal1" onclick="openModal(0)">
                        </div>
                        <div class="w-50 d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                            </div>
                            <div class="h-50-custom">
                                <div class="w-100-custom"><img src="{{ asset('storage/' . $images[3]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(3)"></div>
                            </div>
                        </div>
                    </div>
                @elseif (count($images) === 5)
                    <div class="with-5-foto d-flex gap-4">
                        <div class="w-50-custom">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" data-bs-toggle="modal"
                                data-bs-target="#modal1" onclick="openModal(0)">
                        </div>
                        <div class="w-50 d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(1)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                            </div>
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(3)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(4)"></div>
                            </div>
                        </div>
                    </div>
                @elseif (count($images) === 6)
                    <div class="with-6-foto d-flex gap-4">
                        <div class="w-50-custom d-flex flex-column gap-4">
                            <div class="h-50-custom"><img src="{{ asset('storage/' . $images[1]) }}"
                                    alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                    onclick="openModal(1)"></div>
                            <div class="h-50-custom"><img src="{{ asset('storage/' . $images[0]) }}"
                                    alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                    onclick="openModal(0)"></div>
                        </div>
                        <div class="w-50 d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(3)"></div>
                            </div>
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(4)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(5)"></div>
                            </div>
                        </div>
                    </div>
                @elseif (count($images) === 7)
                    <div class="with-7-foto d-flex gap-4">
                        <div class="w-50-custom d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(1)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                            </div>
                            <div class="h-50-custom"><img src="{{ asset('storage/' . $images[0]) }}"
                                    alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                    onclick="openModal(0)"></div>
                        </div>
                        <div class="w-50 d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(3)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(4)"></div>
                            </div>
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(5)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[6]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(6)"></div>
                            </div>
                        </div>
                    </div>
                @elseif (count($images) === 8)
                    <div class="with-8-foto d-flex gap-4">
                        <div class="w-50-custom d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(2)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(3)"></div>
                            </div>
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[0]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(0)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(1)"></div>
                            </div>
                        </div>
                        <div class="w-50 d-flex flex-column gap-4">
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(4)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(5)"></div>
                            </div>
                            <div class="h-50-custom d-flex gap-4">
                                <div class="w-50"><img src="{{ asset('storage/' . $images[6]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(6)"></div>
                                <div class="w-50"><img src="{{ asset('storage/' . $images[7]) }}"
                                        alt="Apartment image" data-bs-toggle="modal" data-bs-target="#modal1"
                                        onclick="openModal(7)"></div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h6 class="fw-bold mb-4 mt-4 text-uppercase">Info</h6>

                <h3>{{ $apartment->title }}</h3>
                <div class="pt-3 pb-4">{{ $apartment->description }}</div>



                <div class="row">
                    <div class="p-2 col-6 col-xl-3">
                        <div class="text-center card-icon">
                            <div class="counter-name">
                                <img class="pb-1 me-1" src="{{ asset('assets/images/cottage.svg') }}" alt="Rooms">
                                Rooms
                            </div>
                            <div class="counter-counter mt-3">
                                <div class="custom-input">{{ $apartment->rooms }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-xl-3">
                        <div class="text-center card-icon">
                            <div class="counter-name">
                                <img class="me-1" src="{{ asset('assets/images/bed.svg') }}" alt="Beds"> Beds
                            </div>
                            <div class="counter-counter mt-3">
                                <div class="custom-input">{{ $apartment->beds }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-xl-3">
                        <div class="text-center card-icon">
                            <div class="counter-name">
                                <img class="pb-1 me-1" src="{{ asset('assets/images/bathtub.svg') }}" alt="Bathrooms">
                                Bathrooms
                            </div>
                            <div class="counter-counter mt-3">
                                <div class="custom-input">{{ $apartment->bathrooms }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 col-6 col-xl-3">
                        <div class="text-center card-icon">
                            <div class="counter-name">
                                <img class="pb-1 me-1" src="{{ asset('assets/images/area.svg') }}" alt="Area">
                                Area
                                /<span class="sqm">sqm</span>
                            </div>
                            <div class="counter-counter mt-3">
                                <div class="custom-input">{{ $apartment->square_meters }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-5">


            <div class="col-lg-6">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">Services</h5>
                </div>

                <ul class="list-service mt-3 d-flex gap-3 flex-wrap">
                    @foreach ($apartment->services as $service)
                        <li class="d-flex align-items-center gap-2">
                            @switch($service->name)
                                @case('Private Bathroom')
                                    <img class="service-icon" src="{{ asset('assets/images/bathrooms_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Wifi')
                                    <img class="service-icon" src="{{ asset('assets/images/wifi_icon.svg') }}" alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Parking')
                                    <img class="service-icon" src="{{ asset('assets/images/parking_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Breakfast included')
                                    <img class="service-icon" src="{{ asset('assets/images/breakfast_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Swimming Pool')
                                    <img class="service-icon" src="{{ asset('assets/images/swimmingpool_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Cable TV')
                                    <img class="service-icon" src="{{ asset('assets/images/tv_icon.svg') }}" alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Air Conditioning')
                                    <img class="service-icon" src="{{ asset('assets/images/air_conditioning_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Heating')
                                    <img class="service-icon" src="{{ asset('assets/images/heating_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Gym')
                                    <img class="service-icon" src="{{ asset('assets/images/gym_icon.svg') }}" alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Pets Allowed')
                                    <img class="service-icon" src="{{ asset('assets/images/pets_icon.svg') }}" alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Room Service')
                                    <img class="service-icon" src="{{ asset('assets/images/room_service_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Laundry Service')
                                    <img class="service-icon" src="{{ asset('assets/images/laundry_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Concierge')
                                    <img class="service-icon" src="{{ asset('assets/images/concierge_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Meeting Facilities')
                                    <img class="service-icon" src="{{ asset('assets/images/meeting_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Airport Shuttle')
                                    <img class="service-icon" src="{{ asset('assets/images/airport_shuttle_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('24-hour Front Desk')
                                    <img class="service-icon" src="{{ asset('assets/images/front_desk_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Restaurant')
                                    <img class="service-icon" src="{{ asset('assets/images/restaurant_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Bar/Lounge')
                                    <img class="service-icon" src="{{ asset('assets/images/bar_icon.svg') }}" alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Business Center')
                                    <img class="service-icon" src="{{ asset('assets/images/business_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @case('Childcare Services')
                                    <img class="service-icon" src="{{ asset('assets/images/childcare_icon.svg') }}"
                                        alt="">
                                    <span class="service-tag">{{ $service->name }}</span>
                                @break

                                @default
                                    <!-- Se il servizio non corrisponde a nessun caso precedente, mostra solo il nome del servizio -->
                                    <span class="service-tag">{{ $service->name }}</span>
                            @endswitch
                        </li>
                    @endforeach
                </ul>

            </div>

            <div class="col-lg-6 mt-5 mt-lg-0">
                <h5 class="fw-bold text-uppercase">Sponsor your apartment</h5>

                <a class="row " href="{{ route('admin.apartments.sponsorship', $apartment) }}">
                    <div class="p-2">
                        <div class="no-sponsor d-flex justify-content-center align-items-center">
                            <div class="d-flex gap-3 justify-content-center align-items-center">
                                <div><img class="pb-1 me-2 img-rocket sponsor-icon"
                                        src="{{ asset('assets/images/rocket.svg') }}">
                                </div>
                                <div class="">
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
                                <div><img class="pb-1" role="button"
                                        src="{{ asset('assets/images/Group 179.svg') }}">
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>

        <div class="position-relative mt-4 pb-lg-5">
            <h5 class="fw-bold">Location</h5>
            <div class="pt-1">{{ $apartment->address }}</div>

            <div id="map" class="mt-3 mb-4" style="width: 100%; height: 412px;" class='map'>
            </div>

        </div>

        <div class="buttons d-flex gap-3 d-lg-none justify-content-end pt-3 pb-4">
            <a role="button" class="btn-tool border border-dark bg-white text-black border-"
                href="{{ route('admin.apartments.edit', $apartment) }}">
                Edit
            </a>

            <a role='button' class="btn-tool bg-danger text-white" data-bs-toggle="modal"
                data-bs-target="#my-dialog-{{ $apartment->id }}">
                Delete apartment
            </a>
        </div>



    </div>






    <script>
        function simulateResize(width, height) {
            // Imposta la larghezza e l'altezza dello schermo
            Object.defineProperty(window, 'innerWidth', {
                writable: true,
                configurable: true,
                value: width
            });

            Object.defineProperty(window, 'innerHeight', {
                writable: true,
                configurable: true,
                value: height
            });

            // Crea e scatena l'evento resize
            var event = new Event('resize');
            window.dispatchEvent(event);
        }

        window.onload = function() {
            const initialCenter = [{{ $apartment->lon }}, {{ $apartment->lat }}];
            const map = tt.map({
                key: "CGrCXRtpRKgwQl1fo2NZ0mOC3k7CHzUX",
                container: "map",
                center: initialCenter,
                zoom: 14
            });
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());

            // Aggiungi il marker per l'appartamento
            const markerElement = document.createElement('img');
            markerElement.src = 'https://svgshare.com/i/14RK.svg';
            markerElement.style.width = '52px';
            markerElement.style.height = '52px';

            const marker = new tt.Marker({
                element: markerElement,
                anchor: 'bottom'
            }).setLngLat(initialCenter);

            marker.addTo(map);

            // Simula il ridimensionamento della finestra
            simulateResize(window.innerWidth, window.innerHeight);
        };

        // Funzione per aprire la modale
        function openModal(index) {
            const images = {!! json_encode($images) !!};
            const modalIndex = index; // Set modalIndex to the clicked image index

            // Seleziona l'elemento dell'immagine nella modale
            const modalImage = document.getElementById('modalImage');

            // Assicurati che l'elemento dell'immagine sia stato trovato prima di provare ad aggiornare la src
            if (modalImage) {
                // Aggiorna la src dell'elemento dell'immagine
                modalImage.src = "{{ asset('storage/') }}" + "/" + images[index];
            }

            // Aggiorna il paragrafo con l'indice dell'immagine
            const imageIndexParagraph = document.getElementById('imageIndex');
            if (imageIndexParagraph) {
                imageIndexParagraph.innerText = "Image Index: " + index;
            }
        }
    </script>
@endsection

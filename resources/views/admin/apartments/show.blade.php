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


    <div class="px-5 py-4 show container">

        <h2 class="mb-5 text-center">Apartment Details - {{ $apartment->title }}</h2>

        @php
            $images = explode(',', $apartment->images);
            $count = count($images);
        @endphp


        <div id="carouselExampleIndicators" class="carousel slide mb-4 d-lg-none">
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

        <div class="image-gallery d-none d-lg-block">

            <!-- Modal -->
            <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <img src="" alt="Apartment image" id="modalImage">
                </div>
            </div>

            @if (count($images) === 1)
                <div class="with-1-foto">
                    <img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image" class="w-100"
                        data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(0)">

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
                            <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
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
                            <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(1)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                        </div>
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(3)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(4)"></div>
                        </div>
                    </div>
                </div>
            @elseif (count($images) === 6)
                <div class="with-6-foto d-flex gap-4">
                    <div class="w-50-custom d-flex flex-column gap-4">
                        <div class="h-50-custom"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(1)"></div>
                        <div class="h-50-custom"><img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image"
                                data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(0)"></div>
                    </div>
                    <div class="w-50 d-flex flex-column gap-4">
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(3)"></div>
                        </div>
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(4)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(5)"></div>
                        </div>
                    </div>
                </div>
            @elseif (count($images) === 7)
                <div class="with-7-foto d-flex gap-4">
                    <div class="w-50-custom d-flex flex-column gap-4">
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(1)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                        </div>
                        <div class="h-50-custom"><img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image"
                                data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(0)"></div>
                    </div>
                    <div class="w-50 d-flex flex-column gap-4">
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(3)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(4)"></div>
                        </div>
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(5)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[6]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(6)"></div>
                        </div>
                    </div>
                </div>
            @elseif (count($images) === 8)
                <div class="with-8-foto d-flex gap-4">
                    <div class="w-50-custom d-flex flex-column gap-4">
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[2]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(2)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[3]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(3)"></div>
                        </div>
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[0]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(0)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[1]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(1)"></div>
                        </div>
                    </div>
                    <div class="w-50 d-flex flex-column gap-4">
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[4]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(4)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[5]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(5)"></div>
                        </div>
                        <div class="h-50-custom d-flex gap-4">
                            <div class="w-50"><img src="{{ asset('storage/' . $images[6]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(6)"></div>
                            <div class="w-50"><img src="{{ asset('storage/' . $images[7]) }}" alt="Apartment image"
                                    data-bs-toggle="modal" data-bs-target="#modal1" onclick="openModal(7)"></div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="row">
            <div class="col-12">
                <h6 class="fw-bold mb-4 text-uppercase">Info</h6>

                <div>{{ $apartment->title }}</div>
                <div>{{ $apartment->description }}</div>



                <div class="row mt-3">
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
                </div>

                <div class="p-2 col-6 col-xl-3">
                    <div class="text-center card-icon">
                        <div class="counter-name">
                            <img class="pb-1 me-1" src="{{ asset('assets/images/area.svg') }}" alt="Area"> Area
                            /<span class="sqm">sqm</span>
                        </div>
                        <div class="counter-counter mt-3">
                            <div class="custom-input">{{ $apartment->square_meters }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">

            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">Services</h5>
                </div>

                <div class="mt-3">

                    @foreach ($apartment->services as $service)
                        <span>{{ $service->name }}</span>
                    @endforeach

                </div>

            </div>

            <div class="col-12 position-relative mt-4">
                <h5 class="fw-bold">Location</h5>
                <span>{{ $apartment->address }}</span>

                <div id="map" class="mt-3 mb-4" style="width: 100%; height: 412px;" class='map'>
                </div>

            </div>


        </div>

        <div class="col-lg-5">



            <div>
                <h6 class="fw-bold text-uppercase mt-4 mb-2">Visibility *</h6>
                <label class="switch mt-2">
                    <input type="checkbox" value="1" name='is_visible'
                        @if (old('is_visible') == 1) checked @endif>
                    <span class="slider"></span>
                </label>
            </div>
            <span class="span-payment">It will not appear in the search engine</span>
        </div>

    </div>
    <div class="text-end mt-5 me-5">
        <button type="submit" class="btn btn-create">Save apartment</button>
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

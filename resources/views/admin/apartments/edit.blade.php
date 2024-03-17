@extends('layouts.admin')

@section('title', 'Edit Apartment')
@section('content')

    <div class="container py-4 px-5 edit">

        {{-- Path Page --}}
        <div class="path-page">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.apartments.index') }}">Apartments</a>
            <span>/</span>
            <span>Edit</span>
        </div>

        <h1 class="mb-5">Edit Apartment</h1>
        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
            <!-- Form per modificare l'appartamento esistente -->
            @csrf <!-- Token CSRF -->
            @method('PUT') <!-- Metodo di submit -->


            <div class="row">
                <div class="col-md-7">
                    <h6 class="fw-bold mb-4 text-uppercase">Info</h6>
                    <!-- Campo per il titolo dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255"
                        value="{{ old('title', $apartment->title) }}">

                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                    <!-- Campo per la descrizione dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->

                    <label for="description" class="form-label mt-3">Description *</label>
                    <textarea class="form-control" id="description" name="description" required>{{ old('description', $apartment->description) }}</textarea>

                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                    <div class="row mt-3">
                        <div class="p-2 col-3">
                            <div class=" text-center card-icon">
                                <div><img class="pb-1 me-2" src="{{ asset('assets/images/cottage.svg') }}"
                                        alt="Rooms">Rooms</div>
                                <div class="room-counter mt-3">
                                    <div class="room-control" role="button" onclick="decreaseValue('rooms')">-</div>
                                    <div class="room-number" id="roomsNumber">{{ old('rooms', $apartment->rooms) }}</div>
                                    <div class="room-control" role="button" onclick="increaseValue('rooms')">+</div>
                                    @error('rooms')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="p-2 col-3">
                            <div class=" text-center card-icon">
                                <div><img class="me-2" src="{{ asset('assets/images/bed.svg') }}" alt="Beds"> Beds
                                </div>
                                <div class="room-counter mt-3">
                                    <div class="room-control" role="button" onclick="decreaseValue('beds')">-</div>
                                    <div class="room-number" id="bedsNumber">{{ old('beds', $apartment->beds) }}</div>
                                    <div class="room-control" role="button" onclick="increaseValue('beds')">+</div>
                                    @error('beds')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="p-2 col-3">
                            <div class=" text-center card-icon">
                                <div><img class="pb-1 me-2" src="{{ asset('assets/images/bathtub.svg') }}"
                                        alt="Bathrooms">Bathrooms</div>
                                <div class="room-counter mt-3">
                                    <div class="room-control" role="button" onclick="decreaseValue('bathrooms')">-</div>
                                    <div class="room-number" id="bathroomsNumber">
                                        {{ old('bathrooms', $apartment->bathrooms) }}</div>
                                    <div class="room-control" role="button" onclick="increaseValue('bathrooms')">+</div>
                                    @error('bathrooms')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="p-2 col-3">
                            <div class=" text-center card-icon">
                                <div><img class="pb-1 me-2" src="{{ asset('assets/images/area.svg') }}" alt="Area">Area
                                </div>
                                <div class="room-counter mt-3">
                                    <div class="room-control" role="button" onclick="decreaseValue('area')">-</div>
                                    <div class="room-number" id="areaNumber">{{ old('area', $apartment->square_meters) }}
                                        <span class="sqm">sqm</span>
                                    </div>
                                    <div class="room-control" role="button" onclick="increaseValue('area', 50000)">+</div>
                                    @error('area')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 position-relative">
                            <h5 class="fw-bold">Location</h5>
                            <div class="input-container">
                                <input type="text" class="form-control" id="address" name="address" autocomplete="off"
                                    placeholder="Type your address..." value="{{ old('address', $apartment->address) }}">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="mt-3">
                                <img class="w-100" src="{{ asset('assets/images/Group256.png') }}" alt="img">
                            </div>

                            @error('address')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

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
                                <input type="text" class="form-control" id="service" name="service"
                                    autocomplete="off" placeholder="Search for service..." value="{{ old('service') }}">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="mt-3">
                                <ul>
                                    <li>
                                        @foreach ($services as $service)
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
                                @error('services')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    <!-- Messaggio di errore -->
                                @enderror
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
                                                <div class="position-absolute div-delete-img">X</div>
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
                        <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                    <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                    <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill=""
                                            d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="text">
                                <span>Click to upload image</span>
                            </div>
                            <input type="file" id="file">
                        </label>
                    </div>

                    <div>
                        <h5 class="fw-bold mt-5 mb-3 text-uppercase">Sponsor your apartment</h5>

                        <div class="row">
                            <div class="p-2">
                                <div class="no-sponsor d-flex">
                                    <div class="d-flex gap-3 align-items-center">
                                        <div><img class="pb-1 me-2 img-rocket"
                                                src="{{ asset('assets/images/rocket.svg') }}">
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
            </div>
            <div class="text-end mt-5 me-5">
                <button type="submit" class="btn btn-create">Save changes</button>
            </div>
    </div>



    </form>
    </div>


    {{-- <div class="container">

        <h1 class="my-5 text-black">Edit Apartment</h1> <!-- Titolo principale -->



        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
            <!-- Form per modificare l'appartamento esistente -->
            @csrf <!-- Token CSRF -->
            @method('PUT') <!-- Metodo di submit -->


            <div class="row mb-3">

                <!-- Campo per il titolo dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-6">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255"
                        value="{{ old('title', $apartment->title) }}">

                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per la descrizione dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-6">

                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" name="description" required>{{ old('description', $apartment->description) }}</textarea>

                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>
            </div>


            <!-- Campo per il numero di stanze dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="rooms" class="form-label">Rooms *</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" required min="1"
                        value="{{ old('rooms', $apartment->rooms) }}">

                    @error('rooms')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per il numero di letti dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="beds" class="form-label">Beds *</label>
                    <input type="number" class="form-control" id="beds" name="beds" required min="1"
                        value="{{ old('beds', $apartment->beds) }}">

                    @error('beds')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per il numero di bagni dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="bathrooms" class="form-label">Bathrooms *</label>
                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" required min="1"
                        value="{{ old('bathrooms', $apartment->bathrooms) }}">

                    @error('bathrooms')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>
            </div>


            <div class="row mb-3">

                <!-- Campo per i metri quadrati dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="square_meters" class="form-label">Square Meters *</label>
                    <input type="number" class="form-control" id="square_meters" name="square_meters" required
                        min="1" value="{{ old('square_meters', $apartment->square_meters) }}">

                    @error('square_meters')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per l'indirizzo dell'appartamento, con suggerimenti, coordinate nascoste e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-8">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" autocomplete="off"
                        placeholder="Type your address..." value="{{ old('address', $apartment->address) }}">

                    <div id="suggestionsMenu" class="card position-absolute w-100 radius d-none">
                        <ul class="suggestions-list"></ul>
                    </div>
                </div>
            </div>


            <div class="row mb-3">

                <!-- Campo per caricare le immagini dell'appartamento, con possibilità di aggiungere più immagini -->
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="images" class="form-label">Images</label>
                            <div id="image-container">
                                <input type="file" name="images[]"
                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/avif"
                                    onchange="checkFileSizeAndNumber(this); previewImages(this)" multiple>
                                <div id="file-size-error" class="text-danger"></div>
                            </div>


                            @if ($apartment->images)
                                <p class="card-text"><strong>Images:</strong></p>
                                <div class="row">
                                    @foreach (explode(',', $apartment->images) as $image)
                                        <div class="col-md-3">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Apartment Image"
                                                class="img-fluid mb-2">
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
                </div>

                <!-- Campo per selezionare i servizi disponibili nell'appartamento -->
                <div class="col-md-6">
                    <label for="services" class="form-label">Services *</label><br>
                    @foreach ($services as $service)
                        <input type="checkbox" id="service{{ $service->id }}" name="services[]"
                            value="{{ $service->id }}"
                            {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label for="service{{ $service->id }}">{{ $service->name }}</label><br>
                    @endforeach

                    @error('services')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>
            </div>


            <div class="row mb-3">
                <!-- Campo per la visibilità dell'appartamento -->
                <div class="col-md-6">
                    <label class="form-label">Visibility *</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_visible" id="visibility_private"
                            value="0" @if (old('is_visible', $apartment->is_visible) == 0) checked @endif>
                        <label class="form-check-label" for="visibility_private">Private</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_visible" id="visibility_public"
                            value="1" @if (old('is_visible', $apartment->is_visible) == 1) checked @endif>
                        <label class="form-check-label" for="visibility_public">Public</label>
                    </div>
                </div>
            </div>

            <!-- Bottone di submit -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div> --}}


    <!-- Script per la ricerca dell'indirizzo -->
    <script>
        const keyApi = '{{ env('TOMTOM_API_KEY') }}';
        const search = document.getElementById('address');
        const suggestionsMenu = document.getElementById('suggestionsMenu');
        const suggestionsList = suggestionsMenu.querySelector('.suggestions-list');

        search.addEventListener('input', function() {
            if (search.value.trim() !== '') {
                getAddresses(search.value.trim());
                suggestionsMenu.classList.remove('d-none');
            } else {
                suggestionsMenu.classList.add('d-none');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const showMoreBtn = document.querySelector('.show-more');
            const extraServices = document.querySelectorAll('.service-list.extra');

            // Nascondi gli elementi extra inizialmente
            extraServices.forEach(service => {
                service.style.display = 'none';
            });

            // Aggiungi un gestore per il clic sul pulsante "Show More"
            showMoreBtn.addEventListener('click', function() {
                extraServices.forEach(service => {
                    service.style.display = 'inline-block';
                });
                // Nascondi il pulsante "Show More" dopo il clic
                this.style.display = 'none';
            });
        });

        function increaseValue(field, maxValue) {
            const element = document.getElementById(field + 'Number');
            const currentValue = parseInt(element.innerText);
            maxValue = maxValue || 1000; // Set the maximum value to 1000 if not specified

            if (currentValue < maxValue) {
                element.innerText = currentValue + 1;
            }
        }

        function decreaseValue(field) {
            const element = document.getElementById(field + 'Number');
            const currentValue = parseInt(element.innerText);
            const minValue = 1; // Set the minimum value

            if (currentValue > minValue) {
                element.innerText = currentValue - 1;
            }
        }

        function getAddresses(address) {
            fetch(`https://api.tomtom.com/search/2/search/${encodeURIComponent(address)}.json?key=${keyApi}`)
                .then(response => {
                    if (!response.ok) throw new Error('The research was unsuccessful');
                    return response.json();
                })
                .then(data => {
                    suggestionsList.innerHTML = '';
                    if (data.results) {
                        data.results.forEach(result => {
                            const li = document.createElement('li');
                            li.textContent = result.address.freeformAddress;
                            li.addEventListener('click', () => {
                                search.value = result.address.freeformAddress;
                                suggestionsMenu.classList.add('d-none');
                            });
                            suggestionsList.appendChild(li);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        // Funzione per gestire il cambiamento del file di input e visualizzare le anteprime delle immagini
        function handleFileSelect(event) {
            const files = event.target.files;
            const imageContainer = document.getElementById('image-preview-container');
            imageContainer.innerHTML = ''; // Rimuovi anteprime precedenti

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) {
                    continue;
                }

                const reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                        const img = document.createElement('img');
                        img.className = 'image-preview';
                        img.src = e.target.result;
                        img.title = theFile.name;
                        imageContainer.appendChild(img);
                    };
                })(file);

                reader.readAsDataURL(file);
            }
        }

        // Funzione per fare il check sulla dimensione dell'immagine
        function checkFileSize(input) {
            const files = input.files;
            const maxSize = 1024 * 1024; // 1024 KB in bytes
            const errorDiv = document.getElementById('file-size-error');

            // Resetta il contenuto del div
            errorDiv.textContent = '';

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    errorDiv.textContent = 'The image has to weight 1MB max.' + files[i].name;
                    input.value = ''; // Cancella il valore dell'input per consentire la selezione di altri file
                    return;
                }
            }
        }

        // Funzione per visualizzare immagini prima di caricarle

        function checkFileSizeAndNumber(input) {
            const files = input.files;
            const maxSize = 1024 * 1024; // 1024 KB in bytes
            const maxFiles = 8;
            const errorDiv = document.getElementById('file-size-error');

            // Resetta il contenuto del div
            errorDiv.textContent = '';

            // Controlla il numero di file selezionati
            if (files.length > maxFiles) {
                errorDiv.textContent = `You can select up to ${maxFiles} images.`;
                input.value = ''; // Cancella il valore dell'input per consentire la selezione di altri file
                return;
            }

            // Controlla la dimensione dei file
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    errorDiv.textContent = `The image ${files[i].name} has to weight 1MB max.`;
                    input.value = ''; // Cancella il valore dell'input per consentire la selezione di altri file
                    return;
                }
            }
        }
    </script>
@endsection

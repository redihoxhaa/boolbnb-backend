@extends('layouts.admin')

@section('title', 'Create New Apartment')

@section('content')

    <div class=" px-3 px-lg-5 py-4 create container">

        {{-- Path Page --}}
        <div class="path-page">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.apartments.index') }}">Apartments</a>
            <span>/</span>
            <span>Create</span>
        </div>

        {{-- Title Page --}}
        <h1 class="page-title my-4">Create Apartment</h1>

        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            <!-- Form per creare un nuovo appartamento -->
            @csrf <!-- Token CSRF -->


            <div class="row g-5">
                <div class="col-lg-7">
                    <h6 class="fw-bold mb-4 text-uppercase">Info</h6>

                    <input placeholder="* Title..." type="text" class="form-control" id="title" name="title"
                        required maxlength="255" value="{{ old('title') }}">

                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                    <textarea class="form-control mt-3" placeholder="* Describe your apartament...." id="description" name="description"
                        required>{{ old('description') }}</textarea>

                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                    <div class="row mt-3">
                        <div class="p-2 col-6 col-xl-3">
                            <div class="text-center card-icon">
                                <div class="counter-name">
                                    <img class="pb-1 me-1" src="{{ asset('assets/images/cottage.svg') }}" alt="Rooms">
                                    Rooms
                                </div>
                                <div class="counter-counter mt-3">
                                    <div class="counter-control-minus">
                                        -
                                    </div>
                                    <input type="number" value="{{ old('rooms', 1) }}" class="custom-input" name="rooms">
                                    <div class="counter-control-plus">
                                        +
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 col-6 col-xl-3">
                            <div class="text-center card-icon">
                                <div class="counter-name">
                                    <img class="me-1" src="{{ asset('assets/images/bed.svg') }}" alt="Beds"> Beds
                                </div>
                                <div class="counter-counter mt-3">
                                    <div class="counter-control-minus">
                                        -
                                    </div>
                                    <input type="number" value="{{ old('beds', 1) }}" class="custom-input" name="beds">
                                    <div class="counter-control-plus">
                                        +
                                    </div>
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
                                    <div class="counter-control-minus">
                                        -
                                    </div>
                                    <input type="number" value="{{ old('bathrooms', 1) }}" class="custom-input"
                                        name="bathrooms">
                                    <div class="counter-control-plus">
                                        +
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
                                    <div class="counter-control-minus">
                                        -
                                    </div>
                                    <input type="number" value="{{ old('square_meters', 1) }}" class="custom-input"
                                        name="square_meters">
                                    <div class="counter-control-plus">
                                        +
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">

                        <div class="col-12 position-relative mt-4">
                            <h5 class="fw-bold">Location *</h5>
                            <div class="input-container">
                                <input type="text" class="form-control" id="address" name="address" autocomplete="off"
                                    placeholder="Select address..." value="{{ old('address') }}">
                                <i class="fas fa-search"></i>
                            </div>
                            <div id="map" class="mt-3 mb-4" style="width: 100%; height: 412px;" class='map'>
                            </div>

                            @error('address')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                            <div id="suggestionsMenu"
                                class="card bg-white border-secondary position-absolute radius d-none">
                                <ul class="suggestions-list"></ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="fw-bold">Services *</h5>
                                <span class="selected-services">18 services selected </span>
                            </div>
                            <div class="input-container">
                                <input type="text" class="form-control" id="service" autocomplete="off"
                                    placeholder="Search for service..." value="{{ old('service') }}">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="mt-3">
                                <ul>
                                    <li>
                                        @foreach ($services as $key => $service)
                                            <label role="button"
                                                class="service-label service-list m-1{{ $key >= 10 ? ' extra' : '' }}"
                                                for="service{{ $service->id }}">
                                                <input type="checkbox" id="service{{ $service->id }}" name="services[]"
                                                    value="{{ $service->id }}" style="display: none;"
                                                    @if (is_array(old('services')) && in_array($service->id, old('services'))) checked @endif>
                                                <span class="checkmark">
                                                    <img src="{{ asset('assets/images/white-check.svg') }}"
                                                        alt="">
                                                </span>
                                                <span class="ps-1">{{ $service->name }}</span>
                                            </label>
                                        @endforeach
                                        <div class="show-more mt-3 ms-2 text-decoration-underline text-center">Show More
                                        </div>
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

                <div class="col-lg-5">

                    <h6 class="fw-bold mb-4 text-uppercase">Photo</h6>
                    <div class="custum-file-upload">
                        <div class="preview-row row justify-content-center align-items-center">
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
                        </div>
                        <div class="preview-text">
                            <span>Preview your images</span>
                        </div>
                        <div id="image-container">
                            <input type="file" id="file" name="images[]"
                                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/avif"
                                onchange="checkFileSizeAndNumber(this), previewImages(this)" multiple>
                            <div id="file-size-error" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <label class="add-photo" for="file" role="button">+</label>
                        <div class="add-text d-flex align-items-center justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 me-1">
                                <img src="{{ asset('assets/images/bolt.svg') }}" alt="bolt">
                                <div class="image-call m-0 text-center">Adding images increase your booking chances!</div>
                            </div>
                        </div>
                    </div>


                    <div>
                        <h5 class="fw-bold mt-5 mb-3 text-uppercase">Select your sponsorship *</h5>
                        <div class="row">
                            <div class="p-2 col-12 col-md-4 col-lg-12 col-xl-4">
                                <div class="d-flex flex-column" onclick="selectSponsor('gold')">
                                    <div class="card-sponsor plan">
                                        <div class="mb-1">
                                            <input class="d-none" type="radio" name="sponsor" id="gold"
                                                value="Gold">
                                            <label for="gold"><img class=sponsor-icon
                                                    src="{{ asset('assets/images/gold.svg') }}" alt="Bathrooms"></label>
                                        </div>
                                        <div class="fw-bold">Gold<br>Plan</div>
                                        <span class="span-sponsor">1 days</span>
                                        <div class="price">
                                            <div class="fw-bold">€2.99</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 col-12 col-md-4 col-lg-12 col-xl-4">
                                <div class="d-flex flex-column gap-2" onclick="selectSponsor('diamond')">
                                    <div class="card-sponsor plan">
                                        <div class="mb-1">
                                            <input class="d-none" type="radio" name="sponsor" id="diamond"
                                                value="Diamond">
                                            <label for="diamond"><img class=sponsor-icon
                                                    src="{{ asset('assets/images/diamond.svg') }}"
                                                    alt="diamond"></label>
                                        </div>
                                        <div class="fw-bold">Diamond<br>Plan</div>
                                        <span class="span-sponsor">3 days</span>
                                        <div class="price">
                                            <div class="fw-bold">€5.99</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 col-12 col-md-4 col-lg-12 col-xl-4">
                                <div class="d-flex flex-column gap-2" onclick="selectSponsor('emerald')">
                                    <div class="card-sponsor plan">
                                        <div class="mb-1">
                                            <input class="d-none" type="radio" name="sponsor" id="emerald"
                                                value="Emerald">
                                            <label for="emerald"><img class=sponsor-icon
                                                    src="{{ asset('assets/images/emerald.svg') }}"
                                                    alt="emerald"></label>
                                        </div>
                                        <div class="fw-bold">Emerald<br>Plan</div>
                                        <span class="span-sponsor">6 days</span>
                                        <div class="price">
                                            <div class="save text-uppercase">save 10%</div>
                                            <div class="fw-bold">€9.99</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="no-sponsor plan d-flex" onclick="selectSponsor('no-boost')">
                                    <div class="d-flex gap-2">
                                        <div>
                                            <input type="radio" name="sponsor" id="no-boost" value="no-boost"
                                                checked>
                                            <label for="no-boost"></label>
                                            <!-- Aggiunto questo label per rendere cliccabile l'intera card -->
                                        </div>
                                        <div>
                                            <p class="m-0 fw-bold">I don’t want to boost my listing</p>
                                            <span class="span-no-boost">(Boosting your listing will increase your
                                                visibility!)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="span-payment">You will be redirected to the payment page</div>
                    </div>
                    <div class="visibility-radio">
                        <h6 class="fw-bold text-uppercase mt-5 mb-2">Visibility *</h6>


                        <div class="radio-button-container d-flex flex-row-reverse justify-content-end">
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio1" value="0"
                                    name="is_visible" @if (old('is_visible') == 0) checked @endif>
                                <label class="radio-button__label" for="radio1">
                                    <span class="radio-button__custom"></span>
                                    Hidden
                                </label>
                            </div>
                            <div class="radio-button">
                                <input type="radio" class="radio-button__input" id="radio2" value="1"
                                    name="is_visible" @if (old('is_visible') == 1) checked @endif checked>
                                <label class="radio-button__label" for="radio2">
                                    <span class="radio-button__custom"></span>
                                    Available
                                </label>
                            </div>


                        </div>
                    </div>
                    <span class="span-payment" id="payment-span" style="display: none;">It will not appear in the search
                        engine</span>
                </div>
            </div>
            <div class="text-end mt-5">
                <button type="submit" class="btn btn-create">Save apartment</button>
            </div>

        </form>
    </div>


    <!-- Script per la ricerca dell'indirizzo -->
    <script>
        const keyApi = '{{ env('TOMTOM_API_KEY') }}';
        const search = document.getElementById('address');
        const suggestionsMenu = document.getElementById('suggestionsMenu');
        const suggestionsList = suggestionsMenu.querySelector('.suggestions-list');

        // Aggiungi un gestore di eventi di click al documento
        document.addEventListener('click', function(event) {
            // Verifica se l'elemento cliccato non è l'input o il menu delle suggerimenti
            if (event.target !== search && event.target !== suggestionsMenu) {
                // Nascondi il menu delle suggerimenti
                suggestionsMenu.classList.add('d-none');
            }
        });

        // Codice originale per gestire l'input
        search.addEventListener('input', function() {
            if (search.value.trim() !== '') {
                getAddresses(search.value.trim());
                suggestionsMenu.classList.remove('d-none');
            } else {
                suggestionsMenu.classList.add('d-none');
            }
        });

        // Inizializza la mappa al caricamento della pagina

        const initialCenter = [12.49130000, 41.89020000];
        const map = tt.map({
            key: "CGrCXRtpRKgwQl1fo2NZ0mOC3k7CHzUX",
            container: "map",
            center: initialCenter,
            zoom: 14
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());

        let marker = null;

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

                                // Chiamata all'API di geocodifica per ottenere latitudine e longitudine
                                fetch(
                                        `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(result.address.freeformAddress)}.json?key=${keyApi}`
                                    )
                                    .then(response => {
                                        if (!response.ok) throw new Error('Geocoding failed');
                                        return response.json();
                                    })
                                    .then(geoData => {
                                        if (geoData.results && geoData.results.length > 0) {
                                            let latitude = geoData.results[0].position.lat;
                                            let longitude = geoData.results[0].position.lon;



                                            map.setCenter([longitude, latitude]);

                                            // Rimuovi il marker esistente se presente
                                            if (marker) {
                                                marker.remove();
                                            }


                                            // Aggiungi il marker alla mappa
                                            const markerElement = document.createElement('img');
                                            markerElement.src = 'https://svgshare.com/i/14RK.svg';
                                            markerElement.style.width = '52px';
                                            markerElement.style.height = '52px';



                                            marker = new tt.Marker({
                                                element: markerElement,
                                                anchor: 'bottom'
                                            }).setLngLat([longitude, latitude]);

                                            marker.addTo(map);
                                            simulateResize(window.innerWidth, window.innerHeight);


                                            // Centro la mappa sul nuovo marker
                                        } else {
                                            console.error('No geocoding results found');
                                        }




                                    })
                                    .catch(error => console.error('Error during geocoding:', error));

                                suggestionsMenu.classList.add('d-none');
                            });
                            suggestionsList.appendChild(li);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        // Funzione per gestire i servizi
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreBtn = document.querySelector('.show-more');
            const extraServices = document.querySelectorAll('.service-list.extra');
            const selectedServicesSpan = document.querySelector('.selected-services');
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            // Nascondi gli elementi extra inizialmente
            extraServices.forEach(service => {
                service.style.display = 'none';
            });

            // Aggiorna il conteggio dei servizi selezionati
            function updateSelectedServicesCount() {
                const selectedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
                selectedServicesSpan.textContent = selectedCount + ' services selected';
            }

            // Aggiungi un gestore per il clic sul pulsante "Show More" / "Hide"
            let showMore = true; // Flag per tenere traccia dello stato del pulsante
            showMoreBtn.addEventListener('click', function() {
                extraServices.forEach(service => {
                    if (showMore) {
                        service.style.display = 'inline-block';
                    } else {
                        service.style.display = 'none';
                    }
                });
                // Cambia il testo del pulsante e aggiorna lo stato
                if (showMore) {
                    this.textContent = 'Hide';
                } else {
                    this.textContent = 'Show More';
                }
                showMore = !showMore; // Inverti lo stato
            });

            // Aggiungi un gestore per il cambio di stato delle checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedServicesCount();
                });
            });

            // Aggiorna il conteggio dei servizi selezionati all'avvio
            updateSelectedServicesCount();
        });

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

        // Aggiungi un listener per l'evento 'change' su tutti i campi di input
        document.querySelectorAll('.custom-input').forEach(function(inputField) {
            inputField.addEventListener('change', function(event) {
                let currentValue = parseInt(event.target.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    event.target.value = 1; // Imposta il valore a 1 se è negativo o non valido
                }
            });
        });

        // Aggiorna la funzione updateCounter per utilizzare il valore corrente dal campo di input
        function updateCounter(operation, fieldName) {
            let inputField = document.querySelector('input[name="' + fieldName + '"]');
            if (inputField) {
                let currentValue = parseInt(inputField.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    currentValue = 1; // Imposta il valore predefinito a 1 se è negativo o non valido
                }
                if (operation === 'plus') {
                    inputField.value = currentValue + 1;
                } else if (operation === 'minus') {
                    inputField.value = Math.max(currentValue - 1, 1);
                }
            }
        }

        // Rimuovi l'event listener dal vecchio script di aggiornamento
        document.removeEventListener('click', handleCounterUpdate);
        document.removeEventListener('mousedown', handleCounterMouseDown);

        // Definisci la funzione per gestire l'aggiornamento del contatore
        function handleCounterUpdate(event) {
            if (event.target.classList.contains('counter-control-plus')) {
                updateCounter('plus', event.target.parentNode.querySelector('input').getAttribute('name'));
            } else if (event.target.classList.contains('counter-control-minus')) {
                updateCounter('minus', event.target.parentNode.querySelector('input').getAttribute('name'));
            }
        }

        // Definisci la funzione per gestire il mousedown
        function handleCounterMouseDown(event) {
            if (event.target.classList.contains('counter-control-plus')) {
                // Imposta un timeout per avviare l'aggiornamento dopo 1 secondo
                updateCounterTimeout = setTimeout(function() {
                    // Imposta un intervallo per chiamare continuamente la funzione di aggiornamento
                    updateCounterInterval = setInterval(function() {
                        updateCounter('plus', event.target.parentNode.querySelector('input').getAttribute(
                            'name'));
                    }, 40); // Modifica la frequenza dell'aggiornamento se necessario
                }, 400); // 1000 millisecondi corrispondono a 1 secondo
            } else if (event.target.classList.contains('counter-control-minus')) {
                // Imposta un timeout per avviare l'aggiornamento dopo 1 secondo
                updateCounterTimeout = setTimeout(function() {
                    // Imposta un intervallo per chiamare continuamente la funzione di aggiornamento
                    updateCounterInterval = setInterval(function() {
                        updateCounter('minus', event.target.parentNode.querySelector('input').getAttribute(
                            'name'));
                    }, 40); // Modifica la frequenza dell'aggiornamento se necessario
                }, 400); // 1000 millisecondi corrispondono a 1 secondo
            }
        }

        // Aggiungi gli event listener agli elementi di controllo (+/-)
        document.addEventListener('click', handleCounterUpdate);
        document.addEventListener('mousedown', handleCounterMouseDown);

        // Rimuovi l'event listener al rilascio del mouse
        document.addEventListener('mouseup', function() {
            clearTimeout(updateCounterTimeout);
            clearInterval(updateCounterInterval);
        });

        // Ricerca servizi
        document.addEventListener('DOMContentLoaded', function() {
            let searchInput = document.getElementById('service');
            let serviceLabels = document.querySelectorAll('.service-label');
            let showMore = document.querySelector('.show-more');

            searchInput.addEventListener('input', function() {
                let searchText = searchInput.value.trim().toLowerCase();

                serviceLabels.forEach(function(label) {
                    let labelName = label.textContent.trim().toLowerCase();
                    let checkbox = label.querySelector('input[type="checkbox"]');

                    if (labelName.includes(searchText)) {
                        label.style.display = 'inline-block';
                        checkbox.style.display = 'none';
                    } else {
                        label.style.display = 'none';
                        checkbox.style.display = 'none';
                    }

                    // Show selected checkboxes if they match the search text
                    if (checkbox.checked && !labelName.includes(searchText)) {
                        label.style.display = 'inline-block';
                    }
                });

                // Hide "Show More" button during search
                showMore.style.display = 'none';
            });
        });

        // Gestione sponsor
        function selectSponsor(sponsor) {
            // Rimuove la classe active-sponsor da tutte le card-sponsor con la classe "plan"
            const cards = document.querySelectorAll('.plan');
            cards.forEach(card => {
                card.classList.remove('active-sponsor');
            });

            // Seleziona il radio button corrispondente al sponsor cliccato
            const radio = document.getElementById(sponsor);
            if (radio) {
                radio.checked = true;
            }

            // Aggiunge la classe active-sponsor alla card-sponsor cliccata, se esiste
            const selectedCard = document.querySelector(`#${sponsor}`);
            if (selectedCard) {
                const parentCard = selectedCard.closest('.plan');
                if (parentCard) {
                    parentCard.classList.add('active-sponsor');
                }
            }
        }

        // Funzione per gestire la visibilità dello span in base alla selezione del radio button
        document.querySelectorAll('input[name="is_visible"]').forEach(function(input) {
            input.addEventListener('change', function() {
                var spanPayment = document.getElementById('payment-span');
                if (this.value === '0') {
                    spanPayment.style.display =
                        'inline'; // Mostra lo span se l'opzione "Hidden" è selezionata
                } else {
                    spanPayment.style.display = 'none'; // Nasconde lo span altrimenti
                }
            });
        });

        // Preview immagini
        function previewImages(input) {
            let previewContainer = document.querySelector('.preview-row');
            previewContainer.innerHTML = ''; // Pulisce la preview
            const previewText = document.querySelector('.preview-text');

            if (input.files) {
                let filesAmount = input.files.length;
                for (let i = 0; i < filesAmount; i++) {
                    let reader = new FileReader();

                    reader.onload = function(event) {
                        let divCol = document.createElement('div');
                        divCol.className = 'col-6 col-sm-3 col-lg-3 parent-image';

                        let img = document.createElement('img');
                        img.className = 'preview-single-image img-fluid';
                        img.src = event.target.result;

                        divCol.appendChild(img);
                        previewContainer.appendChild(divCol);
                    }

                    reader.readAsDataURL(input.files[i]);
                }

                previewText.classList.add('d-none');
            }
        }
    </script>
@endsection

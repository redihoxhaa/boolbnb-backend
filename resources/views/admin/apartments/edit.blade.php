@extends('layouts.admin') <!-- Estende il layout dell'area amministrativa -->

@section('title', 'Edit Apartment') <!-- Imposta il titolo della pagina -->

@section('content') <!-- Inizio della sezione del contenuto -->

    <div class="container"> <!-- Container principale -->

        <h1 class="my-5 text-white">Edit Apartment</h1> <!-- Titolo principale -->



        <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
            <!-- Form per modificare l'appartamento esistente -->
            @csrf <!-- Token CSRF -->
            @method('PUT') <!-- Metodo di submit -->

            <!-- Prima riga di input -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255"
                        value="{{ old('title', $apartment->title) }}">
                    <!-- Campo per il titolo dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" name="description" required>{{ old('description', $apartment->description) }}</textarea>
                    <!-- Campo per la descrizione dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
            </div>

            <!-- Seconda riga di input -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="rooms" class="form-label">Rooms *</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" required min="1"
                        value="{{ old('rooms', $apartment->rooms) }}">
                    <!-- Campo per il numero di stanze dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('rooms')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="beds" class="form-label">Beds *</label>
                    <input type="number" class="form-control" id="beds" name="beds" required min="1"
                        value="{{ old('beds', $apartment->beds) }}">
                    <!-- Campo per il numero di letti dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('beds')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="bathrooms" class="form-label">Bathrooms *</label>
                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" required min="1"
                        value="{{ old('bathrooms', $apartment->bathrooms) }}">
                    <!-- Campo per il numero di bagni dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('bathrooms')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
            </div>

            <!-- Terza riga di input -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="square_meters" class="form-label">Square Meters *</label>
                    <input type="number" class="form-control" id="square_meters" name="square_meters" required
                        min="1" value="{{ old('square_meters', $apartment->square_meters) }}">
                    <!-- Campo per i metri quadrati dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('square_meters')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" autocomplete="off"
                        placeholder="Type your address..." value="{{ old('address', $apartment->address) }}">
                    <!-- Campo per l'indirizzo dell'appartamento, con suggerimenti, coordinate nascoste e ripristino dei dati precedenti in caso di errore -->
                    <div id="suggestionsMenu" class="card position-absolute w-100 radius d-none">
                        <ul class="suggestions-list"></ul>
                    </div>
                    <input type="hidden" id="latitude" name="latitude"
                        value="{{ old('latitude', $apartment->latitude) }}">
                    <input type="hidden" id="longitude" name="longitude"
                        value="{{ old('longitude', $apartment->longitude) }}">
                </div>
            </div>

            <!-- Quarta riga di input -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Campo per caricare le immagini dell'appartamento, con possibilità di aggiungere più immagini -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="images" class="form-label">Images</label>
                            <div id="image-container">
                                <input type="file" id="images" name="images[]"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" multiple>
                            </div>
                            <button type="button" id="add-image" class="btn btn-secondary mt-2">Add Image</button>
                            <!-- Campo per il caricamento delle immagini dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                            @error('images')
                                <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Campo per selezionare i servizi disponibili nell'appartamento -->
                    <label for="services" class="form-label">Services *</label><br>
                    @foreach ($services as $service)
                        <input type="checkbox" id="service{{ $service->id }}" name="services[]"
                            value="{{ $service->id }}"
                            {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label for="service{{ $service->id }}">{{ $service->name }}</label><br>
                    @endforeach
                    <!-- Campo per la selezione dei servizi, con validazione e ripristino dei dati precedenti in caso di errore -->
                    @error('services')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror
                </div>
            </div>

            <!-- Quinta riga di input -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Campo per la visibilità dell'appartamento -->
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
    </div>


    <!-- Script per la ricerca dell'indirizzo -->
    <script>
        const keyApi = '{{ env('TOMTOM_API_KEY') }}';
        const search = document.getElementById('address');
        const suggestionsMenu = document.getElementById('suggestionsMenu');
        const suggestionsList = suggestionsMenu.querySelector('.suggestions-list');
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');

        search.addEventListener('input', function() {
            if (search.value.trim() !== '') {
                getAddresses(search.value.trim());
                suggestionsMenu.classList.remove('d-none');
            } else {
                suggestionsMenu.classList.add('d-none');
            }
        });

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
                                latitude.value = result.position.lat;
                                longitude.value = result.position.lon;
                            });
                            suggestionsList.appendChild(li);
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        // Aggiungi un'event listener per il click sul pulsante per aggiungere immagini
        document.getElementById('add-image').addEventListener('click', function() {
            const imageContainer = document.getElementById('image-container');
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'images[]';
            input.accept = 'image/jpeg,image/png,image/jpg,image/gif,image/webp';
            input.multiple = true;
            input.addEventListener('change', handleFileSelect);
            imageContainer.appendChild(input);
        });

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
    </script>
@endsection

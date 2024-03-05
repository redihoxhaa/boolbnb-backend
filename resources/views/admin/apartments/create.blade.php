@extends('layouts.admin')

@section('title', 'Create New Apartment')

@section('content')

    <div class="container">

        <h1 class="mb-5">Create New Apartment</h1>

        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            <!-- Form per creare un nuovo appartamento -->
            @csrf <!-- Token CSRF -->


            <div class="row mb-3">

                <!-- Campo per il titolo dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-6">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255"
                        value="{{ old('title') }}">

                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per la descrizione dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-6">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>

                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

            </div>


            <div class="row mb-3">

                <!-- Campo per il numero di stanze dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="rooms" class="form-label">Rooms *</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" required min="1"
                        value="{{ old('rooms') }}">

                    @error('rooms')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per il numero di letti dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="beds" class="form-label">Beds *</label>
                    <input type="number" class="form-control" id="beds" name="beds" required min="1"
                        value="{{ old('beds') }}">

                    @error('beds')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per il numero di bagni dell'appartamento, con validazione e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-4">
                    <label for="bathrooms" class="form-label">Bathrooms *</label>
                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" required min="1"
                        value="{{ old('bathrooms') }}">

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
                        min="1" value="{{ old('square_meters') }}">

                    @error('square_meters')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> <!-- Messaggio di errore -->
                    @enderror

                </div>

                <!-- Campo per l'indirizzo dell'appartamento, con suggerimenti, coordinate nascoste e ripristino dei dati precedenti in caso di errore -->
                <div class="col-md-8">
                    <label for="address" class="form-label">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" autocomplete="off"
                        placeholder="Type your address..." value="{{ old('address') }}">

                    @error('address')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

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
                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp"
                                    onchange="checkFileSize(this)" multiple>
                                <div id="file-size-error" class="text-danger"></div>
                            </div>
                            <button type="button" id="add-image" class="btn btn-secondary mt-2">Add Image</button>

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
                            value="{{ $service->id }}" @if (is_array(old('services')) && in_array($service->id, old('services'))) checked @endif>
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
                            value="0" @if (old('is_visible') == 0) checked @endif>
                        <label class="form-check-label" for="visibility_private">Private</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_visible" id="visibility_public"
                            value="1" @if (old('is_visible') == 1) checked @endif>
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
    </script>
@endsection

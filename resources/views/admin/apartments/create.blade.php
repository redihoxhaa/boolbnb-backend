@extends('layouts.admin')

@section('title', 'Create New Apartment')

@section('content')
    <h1>Autocomplete Example</h1>

    <!-- Form per la ricerca con autocompletamento -->

    <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required maxlength="255">

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="rooms">Rooms:</label>
        <input type="number" id="rooms" name="rooms" required min="1">

        <label for="beds">Beds:</label>
        <input type="number" id="beds" name="beds" required min="1">

        <label for="bathrooms">Bathrooms:</label>
        <input type="number" id="bathrooms" name="bathrooms" required min="1">

        <label for="square_meters">Square Meters:</label>
        <input type="number" id="square_meters" name="square_meters" required min="1">

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" autocomplete="off" placeholder="Type your address...">
        <div id="suggestionsMenu" class="card position-absolute w-100 radius d-none">
            <ul class="suggestions-list"></ul>
        </div>
        <input type="text" id="latitude" name="latitude">
        <input type="text" id="longitude" name="longitude">

        <label for="images">Images:</label>

        <!-- Area per caricare le immagini -->
        <div id="image-container">
            <input type="file" id="images" name="images[]"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" multiple>
        </div>

        <button type="button" id="add-image">Add Image</button>



        <label for="services">Services:</label><br>
        @foreach ($services as $service)
            <input type="checkbox" id="service{{ $service->id }}" name="services[]" value="{{ $service->id }}">
            <label for="service{{ $service->id }}">{{ $service->name }}</label><br>
        @endforeach

        <div>
            <label>
                <input type="radio" name="is_visible" value="0">
                Private
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="is_visible" value="1">
                Public
            </label>
        </div>

        <button type="submit">Submit</button>
    </form>


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

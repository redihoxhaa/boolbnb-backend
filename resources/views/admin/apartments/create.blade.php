@extends('layouts.admin')

@section('title', 'Create New Apartment')

@section('content')
    <h1>Autocomplete Example</h1>

    <!-- Form per la ricerca con autocompletamento -->
    <form>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" autocomplete="off" placeholder="Type your address...">
        <div id="suggestionsMenu" class="card position-absolute w-100 radius d-none">
            <ul class="suggestions-list"></ul>
        </div>
        <input type="text" id="latitude" name="latitude">
        <input type="text" id="longitude" name="longitude">
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


        document.addEventListener('click', event => {
            if (!suggestionsMenu.contains(event.target) && event.target !== search) {
                suggestionsMenu.classList.add('d-none');
            }
        });
    </script>

@endsection

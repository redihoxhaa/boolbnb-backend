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



@endsection

@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')


    <div class="container py-3">

        <div>{{ $apartment->title }}</div>
        <div>{{ $sponsorship->package_name }}</div>
        <div>{{ $endDate }}</div>
    </div>
@endsection

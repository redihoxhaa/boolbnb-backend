@extends('layouts.admin')

@section('title', 'Sponsor Apartment')

@section('content')


    <div class="container py-3">

        <div class="text-center mb-5">Buy a sponsorhip for {{ $apartment->title }}</div>

        <ul class="row">
            @foreach ($sponsorships as $sponsorship)
                <li class="d-flex flex-column col-4 text-center">
                    <h5>{{ $sponsorship->package_name }}</h5>
                    <span>€{{ $sponsorship->package_price }}</span>
                    <span>{{ $sponsorship->package_duration }}h</span>
                </li>
            @endforeach
        </ul>

        <div class="mt-3 text-center">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm mb-4"><i
                    class="fas fa-arrow-left"></i> Go Back</a>
        </div>

    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Congratulations!')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Congratulations!</h2>
                    </div>
                    <div class="card-body pt-5">
                        <p class="lead text-center mb-4">Your payment was successful.</p>
                        <div class="text-center mb-4">
                            <p><strong>Apartment Title:</strong> {{ $apartment->title }}</p>
                            <p><strong>Sponsorship Package:</strong> {{ $sponsorship->package_name }}</p>
                            <p><strong>End Date:</strong> {{ $endDate }}</p>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

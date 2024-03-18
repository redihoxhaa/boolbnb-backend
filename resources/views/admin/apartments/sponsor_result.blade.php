@extends('layouts.admin')

@section('title', 'Congratulations!')

@section('content')
    <div class="sponsor-result container py-4 px-3 px-lg-5">

        <div class="row">

            <div class="col-12 col-xl-6">

                {{-- Title Page --}}
                <img class="mt-4" src="{{ asset('assets/images/sponsor_result_icon.svg') }}" alt="">
                <h1 class="page-title title-dashboard mb-3">Your payment <br>was successful.<h1>

                        <h6 class="text-start text-uppercase title-group mt-4">Apartment Title</h6>
                        <span class="text-dashboard">{{ $apartment->title }}</span>

                        <h6 class="text-start text-uppercase title-group mt-4">Sponsorship Package</h6>
                        <span class="text-dashboard">{{ $sponsorship->package_name }}</span>

                        <h6 class="text-start text-uppercase title-group  mt-4">End Date</h6>
                        <span class="text-dashboard">{{ $endDate }}</span>

                        <div class="text-start mt-4">
                            <a href="{{ route('admin.apartments.index') }}" class="btn custom-button">Continue</a>
                        </div>

            </div>
        </div>
    </div>
@endsection

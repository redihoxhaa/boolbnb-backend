@extends('layouts.admin')

@section('title', 'MalHome - Dashboard')

@section('content')
    <div class="dashboard py-4 px-5">

        <div class="row">

            <div class="col-12 col-xl-6">
                {{-- Path Page --}}
                <div>
                    <span>Admin</span>
                    <span>/</span>
                    <span>Apartments</span>
                </div>

                {{-- Title Page --}}
                <h1 class="page-title title-dashboard mb-3">Welcome
                    <span class="title-user">{{ Auth::user()->name }}</span><br>Good Morning!<h1>
                        <p class="text-dashboard">Here are three simple steps to get you started. We suggest starting from
                            creating a
                            candidate.
                        </p>

                        {{-- Summon icon --}}
                        <div class="mb-4">
                            <h6 class="text-start text-uppercase title-group">About your apartments</h6>
                            <div class="d-flex flex-wrap g-2">
                                <div class="col-12 col-sm-4 p-1">
                                    <div class="summary-container py-4">
                                        <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                            <img src="{{ asset('assets/images/house_icon.svg') }}" alt="">
                                            <span class="summary-title">Apartments</span>
                                        </div>
                                        <div>
                                            <span class="summary-number">{{ $totalApartments }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 p-1">
                                    <div class="summary-container py-4">
                                        <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                            <img src="{{ asset('assets/images/views_icon.svg') }}" alt="">
                                            <span class="summary-title">Visits</span>
                                        </div>
                                        <div>
                                            <span class="summary-number">{{ $totalVisits }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 p-1">
                                    <div class="summary-container py-4">
                                        <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                            <img src="{{ asset('assets/images/message_icon.svg') }}" alt="">
                                            <span class="summary-title">Messages</span>
                                        </div>
                                        <div>
                                            <span class="summary-number">{{ $totalMessages }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        <div>
                            <h6 class="text-start text-uppercase title-group mb-3">Common Action</h6>

                            {{-- Create Apartment --}}
                            <div class="button-action rounded mb-4">
                                <a class="col-12 d-flex p-4" href="{{ route('admin.apartments.create') }}">
                                    <img class="me-4" src="{{ asset('assets/images/new_apartment_icon.svg') }}"
                                        alt="">
                                    <div class="flex-grow-1 d-flex flex-column text-start">
                                        <h4 class="summary-number">Create Apartment</h4>
                                        <span class="summary-title">Add new apartment now</span>
                                    </div>
                                    <img class="arrow-icon-button" src="{{ asset('assets/images/arrow_icon.svg') }}"
                                        alt="">
                                </a>
                            </div>

                            {{-- Messages --}}
                            <div class="button-action rounded">
                                <a class="col-12 d-flex p-4 mb-4" href="{{ route('admin.messages.index') }}">
                                    <img class="me-4 w-33-custom" src="{{ asset('assets/images/messages_icon.svg') }}"
                                        alt="">
                                    <div class="flex-grow-1 d-flex flex-column text-start">
                                        <h4 class="summary-number">Incoming messages</h4>
                                        <span class="summary-title">Respond to potential customers</span>
                                    </div>
                                    <img class="arrow-icon-button" src="{{ asset('assets/images/arrow_icon.svg') }}"
                                        alt="">
                                </a>
                            </div>
                        </div>
            </div>
            <div class="d-none d-xl-block col-xl-6">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="ad-sponsor p-4 pb-5">
                        <img class="icon-rocket" src="{{ asset('assets/images/rocket.svg') }}" alt="">
                        <h1 class="ad-sponsor-title"><b>Increase visits</b> to your apartments, try our <b>sponsored
                                plan!</b></h1>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <img class="pt-1" src="{{ asset('assets/images/star_icon.svg') }}" alt="">
                            <p>your apartment will appear among the first results</p>
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-2">
                            <img class="pt-1" src="{{ asset('assets/images/bolt.svg') }}" alt="">
                            <p>Boost your visibility increase visits from interested people</p>
                        </div>
                        <div class="arrow-icon">
                            <a href="{{ route('admin.apartments.index') }}">
                                <img src="{{ asset('assets/images/arrow_icon.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

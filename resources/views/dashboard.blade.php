@extends('layouts.admin')

@section('title', 'MalHome - Dashboard')

@section('content')
    <div class="dashboard container py-4 px-5">

        <div class="row g-5">

            <div class="col-12 col-xl-6">
                {{-- Path Page --}}
                <div class="path-page">
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                    <span>/</span>

                    <span>Dashboard</span>
                </div>

                <?php
                
                use Illuminate\Support\Facades\Auth;
                use Carbon\Carbon;
                
                // Ottieni l'ora corrente usando Carbon
                $current_time = Carbon::now();
                
                // Ottieni l'ora corrente in formato 24 ore
                $current_hour = $current_time->format('H');
                
                // Definisci i messaggi per ogni periodo della giornata
                if ($current_hour >= 1 && $current_hour < 12) {
                    $greeting = 'Good morning!';
                } elseif ($current_hour >= 12 && $current_hour < 18) {
                    $greeting = 'Good afternoon!';
                } else {
                    $greeting = 'Good evening!';
                }
                
                ?>


                {{-- Title Page --}}
                <h1 class="page-title title-dashboard mb-3">Welcome
                    <span class="title-user text-capitalize">
                        {{ trim(explode(' ', Auth::user()->name)[0]) }}</span>,<br>{{ $greeting }}
                </h1>

                <p class="text-dashboard">How are you doing today? In this dashboard you have an overview of how your account
                    is performing.
                </p>

                {{-- Summon icon --}}
                <div class="mb-4 py-4">
                    <h6 class="text-start text-uppercase title-group">About your apartments</h6>
                    <div class="d-flex flex-wrap g-2">
                        <a class="col-12 col-sm-4 p-1" href="{{ route('admin.apartments.index') }}">
                            <div class="summary-container py-4">
                                <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                    <img src="{{ asset('assets/images/house_icon.svg') }}" alt="">
                                    <span class="summary-title">Apartments</span>
                                </div>
                                <div>
                                    <div class="summary-number w-100 text-center">{{ $totalApartments }}</div>
                                </div>
                            </div>
                        </a>
                        <a class="col-12 col-sm-4 p-1" href="{{ route('admin.analytics.index') }}">
                            <div class="summary-container py-4">
                                <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                    <img src="{{ asset('assets/images/views_icon.svg') }}" alt="">
                                    <span class="summary-title">Visits</span>
                                </div>
                                <div>
                                    <div class="summary-number w-100 text-center">{{ $totalVisits }}</div>
                                </div>
                            </div>
                        </a>
                        <a class="col-12 col-sm-4 p-1"href="{{ route('admin.messages.index') }}">
                            <div class="summary-container py-4">
                                <div class="d-flex justify-content-center gap-1 align-items-bottom mb-3">
                                    <img src="{{ asset('assets/images/message_icon.svg') }}" alt="">
                                    <span class="summary-title">Messages</span>
                                </div>
                                <div>
                                    <div class="summary-number w-100 text-center">{{ $totalMessages }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Action --}}
                <div>
                    <h6 class="text-start text-uppercase title-group mb-3">Common Actions</h6>

                    {{-- Create Apartment --}}
                    <div class="button-action rounded mb-4">
                        <a class="col-12 d-flex p-4" href="{{ route('admin.apartments.create') }}">
                            <img class="me-4" src="{{ asset('assets/images/new_apartment_icon.svg') }}" alt="">
                            <div class="flex-grow-1 d-flex flex-column text-start">
                                <h4 class="summary-number">List new apartment</h4>
                                <span class="summary-title">List your apartment now</span>
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
                                <span class="summary-title">Get in touch with potential customers</span>
                            </div>
                            <img class="arrow-icon-button" src="{{ asset('assets/images/arrow_icon.svg') }}"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="d-none d-xl-block col-xl-6">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="ad-sponsor">
                        <img class="icon-rocket" src="{{ asset('assets/images/rocket.svg') }}" alt="">
                        <h1 class="ad-sponsor-title"><b>Increase visits</b> to your apartments, try our <b>sponsored
                                plan!</b></h1>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <img class="pt-1" src="{{ asset('assets/images/star_icon.svg') }}" alt="">
                            <p>Your apartment will appear among the first results</p>
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

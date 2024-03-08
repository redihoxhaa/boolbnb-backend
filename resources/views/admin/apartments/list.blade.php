@php
    use Carbon\Carbon;

@endphp

@extends('layouts.admin')

@section('title', 'Manage Apartments')

@section('content')
    <div class="mt-4 me-5 mb-5">

        {{-- Path Page --}}
        <div>
            <span>Admin</span>
            <span>/</span>
            <span>Apartments</span>
        </div>

        {{-- Title Page --}}
        <h1 class="page-title">Listed Properties</h1>

        {{-- Button --}}
        <div class="my-4">
            <a class="button-black" href="{{ route('admin.apartments.create') }}">
                <i class="fa-solid fa-plus me-1"></i>New Apartment
            </a>
        </div>

        {{-- Toast --}}
        <div>
            <div class="col-auto">

                {{-- Toast Success --}}
                @if (session('success'))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-success text-white">
                                <strong class="me-auto"><i class="fa-solid fa-check me-1"></i>Success!</strong>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body bg-success-subtle text-emphasis-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Toast Error --}}
                @if (session('message'))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-danger text-white">
                                <strong class="me-auto"><i class="fa-solid fa-trash-can me-1"></i>Deleted!</strong>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body bg-danger-subtle text-emphasis-danger">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>

        {{-- Table Properites --}}
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">TITLE</th>
                                <th scope="col" class="d-none d-lg-table-cell">ADDRESS</th>
                                <th scope="col" class="d-none d-sm-table-cell">STATUS</th>
                                <th scope="col" class="d-none d-xl-table-cell">VIEWS</th>
                                <th scope="col" class="d-none d-xl-table-cell">MESSAGES</th>
                                <th scope="col" class="d-none d-xxl-table-cell">LISTED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr class="properties-table">

                                    {{-- Title --}}
                                    <td>
                                        <a class="d-flex align-items-center"
                                            href="{{ route('admin.apartments.show', $apartment) }}">
                                            <div>
                                                @if ($apartment->images)
                                                    <img class="apartment-img"
                                                        src="{{ asset('storage/' . explode(',', $apartment->images)[0]) }}"
                                                        alt="apartment-image">
                                                @else
                                                    <img class="apartment-img"
                                                        src="https://saterdesign.com/cdn/shop/products/property-placeholder_a9ec7710-1f1e-4654-9893-28c34e3b6399_600x.jpg?v=1500393334"
                                                        alt="apartment-image">
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="apartment-title">{{ Str::limit($apartment->title, 18, '...') }}
                                                </span>
                                            </div>
                                        </a>
                                    </td>

                                    {{-- Address --}}
                                    <td class="center d-none d-lg-table-cell">
                                        {{ Str::limit($apartment->address, 20, '...') }}</td>

                                    {{-- Status --}}
                                    <td class="d-none d-sm-table-cell">
                                        @if (
                                            $apartment->sponsorships->count() &&
                                                $apartment->sponsorships[count($apartment->sponsorships) - 1]->pivot->end_date > Carbon::now())
                                            <div class="status-tag tag-sponsored d-inline">
                                                <span>Sponsored</span>
                                            </div>
                                        @elseif (!$apartment->is_visible)
                                            <div class="status-tag tag-hidden d-inline">
                                                <img class="me-1" src="{{ asset('assets/images/' . 'hidden_icon.svg') }}"
                                                    alt="">
                                                <span>Hidden</span>
                                            </div>
                                        @endif

                                    </td>

                                    {{-- Visits --}}
                                    <td class="d-none d-xl-table-cell">
                                        <img class="me-2" src="{{ asset('assets/images/' . 'visit_icon.svg') }}"
                                            alt="">{{ $apartment->visits->count() }}
                                    </td>

                                    {{-- Messages --}}
                                    <td class="d-none d-xl-table-cell"><img class="me-2"
                                            src="{{ asset('assets/images/' . 'messages_icon.svg') }}"
                                            alt="">{{ $apartment->messages->count() }}</td>

                                    {{-- Created at --}}
                                    <td class="d-none d-xxl-table-cell">
                                        {{ Carbon::parse($apartment->created_at)->toDateString() }}</td>

                                    {{-- Button --}}
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                                <img class="icon" src="{{ asset('assets/images/' . 'edit_icon.svg') }}">
                                            </a>
                                            <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                                <img src="{{ asset('assets/images/' . 'sponsor_icon.svg') }}">
                                            </a>

                                            <a role='button' data-bs-toggle="modal"
                                                data-bs-target="#my-dialog-{{ $apartment->id }}">
                                                <img src="{{ asset('assets/images/' . 'delete_icon.svg') }}">
                                            </a>

                                            {{-- Modale --}}
                                            <div class="modal" id="my-dialog-{{ $apartment->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content card-custom">

                                                        {{-- Messaggio di alert --}}
                                                        <div class="modal-header text-center">
                                                            <h3>Are you sure?</h3>
                                                        </div>

                                                        {{-- Informazione operazione --}}
                                                        <div class="modal-body text-center">
                                                            You are about to delete <br> {{ $apartment->title }}</span>
                                                        </div>

                                                        <div class="modal-footer">

                                                            {{-- Pulsante annulla --}}
                                                            <button class="btn btn-success text-uppercase mb-4 mt-5 fw-bold"
                                                                data-bs-dismiss="modal">Dismiss
                                                            </button>

                                                            {{-- Pulsante elimina --}}
                                                            <form
                                                                action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input
                                                                    class="btn btn-danger text-uppercase mb-4 mt-5 fw-bold"
                                                                    type="submit" value="DELETE">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

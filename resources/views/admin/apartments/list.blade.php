@php
    use Carbon\Carbon;

@endphp

@extends('layouts.admin')

@section('title', 'Manage Apartments')

@section('content')
    <div class="listed-properties container py-4 px-3 px-lg-5">

        {{-- Path Page --}}
        <div class="path-page">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
            <span>/</span>
            <span>Apartments</span>
        </div>

        {{-- Title Page --}}
        <h1 class="page-title">{{ count($apartments) }} Listed Properties</h1>

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
                            <div class="toast-header custom-toaster">
                                <strong class="me-auto"><i class="fa-solid fa-check me-1"></i>Success!</strong>
                                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="toast"
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
        @if (count($apartments))


            {{-- Table Properites --}}
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">TITLE</th>
                                    <th scope="col" class="d-none d-lg-table-cell">ADDRESS</th>
                                    <th scope="col" class="d-none d-md-table-cell text-center">STATUS</th>
                                    <th scope="col" class="d-none d-xxl-table-cell text-nowrap text-center">LISTED ON
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartments as $apartment)
                                    <tr class="properties-table">

                                        {{-- Title --}}
                                        <td class="ps-3">
                                            <a class="d-flex align-items-center"
                                                href="{{ route('admin.apartments.show', $apartment) }}">
                                                <div class="">
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
                                                    <span class="apartment-title">{{ $apartment->title }}
                                                    </span>
                                                </div>
                                            </a>
                                        </td>



                                        {{-- Address --}}
                                        <td class="center d-none d-lg-table-cell">
                                            {{ $apartment->address }}</td>

                                        <td class="d-md-none ps-sm-1 pe-sm-4 text-center">
                                            @if (
                                                $apartment->sponsorships->count() &&
                                                    $apartment->is_visible == 1 &&
                                                    $apartment->sponsorships[count($apartment->sponsorships) - 1]->pivot->end_date > Carbon::now())
                                                <div class="d-inline mobile-icon-size sponsored-color-icon">
                                                    <i class="fa-solid fa-bolt"></i>
                                                </div>
                                            @elseif (!$apartment->is_visible)
                                                <div class="d-inline mobile-icon-size text-nowrap text-secondary">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </div>
                                            @else
                                                <div class="d-inline mobile-icon-size active-color-icon">
                                                    <i class="fa-solid fa-earth-americas"></i>
                                                </div>
                                            @endif

                                        </td>

                                        {{-- Status --}}
                                        <td class="d-none d-md-table-cell text-center text-nowrap">
                                            @if (
                                                $apartment->sponsorships->count() &&
                                                    $apartment->is_visible == 1 &&
                                                    $apartment->sponsorships[count($apartment->sponsorships) - 1]->pivot->end_date > Carbon::now())
                                                <div class="status-tag tag-sponsored d-inline">
                                                    <i class="fa-solid fa-bolt pe-1 icon-opacity-color"></i>
                                                    <span>Sponsored</span>
                                                </div>
                                            @elseif (!$apartment->is_visible)
                                                <div class="status-tag tag-hidden d-inline text-nowrap">
                                                    <i class="fa-solid fa-eye-slash pe-1 icon-opacity-color"></i>
                                                    <span>Hidden</span>
                                                </div>
                                            @else
                                                <div class="status-tag tag-active d-inline ">
                                                    <i class="fa-solid fa-earth-americas pe-1 icon-opacity-color"></i>
                                                    <span>Active</span>
                                                </div>
                                            @endif

                                        </td>


                                        {{-- Created at --}}
                                        <td class="d-none d-xxl-table-cell text-center text-nowrap">
                                            {{ Carbon::parse($apartment->created_at)->toDateString() }}</td>

                                        {{-- Button --}}
                                        <td class="text-center">

                                            <button class="btn border-0 d-sm-none" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $apartment->id }}" aria-expanded="false"
                                                aria-controls="collapse-{{ $apartment->id }}">
                                                <i class="fa-solid fa-ellipsis-v"></i>
                                            </button>

                                            <div class="collapse" id="collapse-{{ $apartment->id }}">
                                                <div
                                                    class="d-flex py-2 flex-column gap-2 align-items-center justify-content-center">
                                                    {{-- Pulsanti mobile --}}
                                                    <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                                        <img class="icon"
                                                            src="{{ asset('assets/images/' . 'edit_icon.svg') }}">
                                                    </a>
                                                    <a href="{{ route('admin.apartments.sponsorship', $apartment) }}">
                                                        <img src="{{ asset('assets/images/' . 'sponsor_icon.svg') }}">
                                                    </a>
                                                    <a role='button' data-bs-toggle="modal"
                                                        data-bs-target="#my-dialog-{{ $apartment->id }}">
                                                        <img src="{{ asset('assets/images/' . 'delete_icon.svg') }}">
                                                    </a>
                                                </div>
                                            </div>



                                            {{-- Pulsanti desktop --}}
                                            <div class="btn-group d-none d-sm-flex pe-1" role="group">
                                                <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                                    <img class="icon"
                                                        src="{{ asset('assets/images/' . 'edit_icon.svg') }}">
                                                </a>
                                                <a href="{{ route('admin.apartments.sponsorship', $apartment) }}">
                                                    <img src="{{ asset('assets/images/' . 'sponsor_icon.svg') }}">
                                                </a>

                                                <a role='button' data-bs-toggle="modal"
                                                    data-bs-target="#my-dialog-{{ $apartment->id }}">
                                                    <img src="{{ asset('assets/images/' . 'delete_icon.svg') }}">
                                                </a>
                                            </div>


                                            {{-- Modale --}}
                                            <div class="modal" id="my-dialog-{{ $apartment->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content card-custom">

                                                        {{-- Messaggio di alert --}}
                                                        <div class="modal-header ">
                                                            <h3 class="d-block w-100 text-center">Are you sure?</h3>
                                                        </div>

                                                        {{-- Informazione operazione --}}
                                                        <div class="modal-body text-center">
                                                            You are about to delete <br><span class="fw-bold">
                                                                {{ $apartment->title }}</span>
                                                        </div>

                                                        <div class="modal-footer d-flex justify-content-center">


                                                            {{-- Pulsante annulla --}}
                                                            <button
                                                                class="btn-tool border border-dark bg-white text-black border mb-4 mt-3"
                                                                data-bs-dismiss="modal">Dismiss
                                                            </button>

                                                            {{-- Pulsante elimina --}}
                                                            <form
                                                                action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input class="btn btn-tool bg-danger text-white mb-4 mt-3"
                                                                    type="submit" value="Delete">
                                                            </form>
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
        @endif
    </div>
@endsection

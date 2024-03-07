@php
    use Carbon\Carbon;

@endphp

@extends('layouts.admin')

@section('title', 'Manage Apartments')

@section('content')
    <div class="container mt-4">

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
                                <th scope="col">ADDRESS</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">VIEWS</th>
                                <th scope="col">MESSAGES</th>
                                <th scope="col">LISTED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr class="properties-table">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img class="apartment-img" src="{{ $apartment->images }}" alt="">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="apartment-title">{{ Str::limit($apartment->title, 18, '...') }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="center">{{ Str::limit($apartment->address, 20, '...') }}</td>
                                    <td>
                                        @if (count($apartment->sponsorships))
                                            <div>
                                                <span class="status-tag">Sponsored</span>
                                            </div>
                                        @endif

                                    </td>
                                    <td>{{ $apartment->visits->count() }}</td>
                                    <td>{{ $apartment->messages->count() }}</td>
                                    <td>{{ Carbon::parse($apartment->created_at)->toDateString() }}</td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary"
                                                href="{{ route('admin.apartments.show', $apartment) }}">
                                                <i class="fas fa-info-circle me-2"></i>Info
                                            </a>

                                            <a class="btn btn-secondary"
                                                href="{{ route('admin.apartments.edit', $apartment) }}">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>

                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#my-dialog-{{ $apartment->id }}">
                                                <i class="fas fa-trash-alt me-2"></i>
                                                Delete
                                            </button>


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
                                                            <button
                                                                class="btn custom-btn white text-uppercase mb-4 mt-5 fw-bold"
                                                                data-bs-dismiss="modal">Dismiss
                                                            </button>

                                                            {{-- Pulsante elimina --}}
                                                            <form
                                                                action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input
                                                                    class="btn custom-btn white text-uppercase mb-4 mt-5 fw-bold"
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

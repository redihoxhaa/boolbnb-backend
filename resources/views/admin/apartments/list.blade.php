@extends('layouts.admin')

@section('title', 'Manage Apartments')

@section('content')
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.apartments.create') }}">
                    <i class="fa-solid fa-plus me-1"></i>New Apartment
                </a>
            </div>

            <div class="col-auto">
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
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Beds</th>
                                <th scope="col">Bathrooms</th>
                                <th scope="col">Square Meters</th>
                                <th scope="col">Address</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr>
                                    <td>{{ $apartment->title }}</td>
                                    <td>{{ $apartment->beds }}</td>
                                    <td>{{ $apartment->bathrooms }}</td>
                                    <td>{{ $apartment->square_meters }}</td>
                                    <td>{{ $apartment->address }}</td>
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
                                            <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mc-delete">
                                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                                </button>
                                            </form>
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

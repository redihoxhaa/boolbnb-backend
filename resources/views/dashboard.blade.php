@extends('layouts.admin')

@section('title', 'BoolBnB - Dashboard')

@section('content')
    <div class="welcome container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4 d-flex flex-column align-items-center">
                <h1 class="p-3 text-black">
                    Welcome to your dashboard <span class="text-capitalize">{{ Auth::user()->name }}</span>!
                </h1>

                <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary">Aggiungi appartamento</a>

            </div>
        </div>
    </div>
@endsection

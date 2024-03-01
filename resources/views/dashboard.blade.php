@extends('layouts.admin')

@section('content')
    <div class="welcome container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <h1 class="p-3">
                    Welcome to my portfolio, {{ Auth::user()->name }}!
                </h1>



            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="row forgot-password">

        {{-- Background --}}
        <div class="col-6 d-none d-md-block login-background">
            <div class="text-container">
                <div class="arrow-icon">
                    <a href="">
                        <img src="{{ asset('assets/images/arrow_icon.svg') }}" alt="">
                    </a>
                </div>
                <h1 class="z-3">Redefining <b>tourist</b> lifestyles through our premium apartments</h1>
            </div>
            <img class="img-background" draggable="false" src="{{ asset('assets/images/login-background.png') }}"
                alt="">
        </div>

        {{-- Empty --}}
        <div class="col-6 d-none d-md-block">
        </div>

        {{-- Form --}}
        <div
            class="col-12 justify-content-center pt-4 align-items-center col-md-6 justify-content-md-start d-flex padding-desktop-custom custom-height-desktop">
            <div>
                {{-- Logo --}}
                <img class="login-logo" src="{{ asset('assets/images/malhome_logo.svg') }}" alt="">

                {{-- Title --}}
                <h1 class="login-title">Reset your password</h1>
                <span class="login-welcome">You will receive a reset email</span>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="mt-4">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email"
                                class="custom-label col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 mb-0">
                            <div>
                                <button type="submit" class="btn custom-button">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

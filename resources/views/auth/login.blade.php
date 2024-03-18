@extends('layouts.app')

@section('content')
    <div class="row login">

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

        <div class="col-6 d-none d-md-block">
        </div>

        {{-- Form --}}
        <div
            class="col-12 justify-content-center pt-4 align-items-center col-md-6 justify-content-md-start d-flex padding-desktop-custom custom-height-desktop">
            <div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Logo --}}
                    <img class="login-logo" src="{{ asset('assets/images/malhome_logo.svg') }}" alt="">

                    {{-- Title --}}
                    <h1 class="login-title">Login in to your Account</h1>
                    <span class="login-welcome">Welcome back!</span>

                    {{-- Email --}}
                    <div class="my-2">
                        <label for="email"
                            class="col-form-label text-md-right custom-label">{{ __('E-Mail Address') }}</label>

                        <div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-2">
                        <label for="password"
                            class="col-md-4 col-form-label text-md-right custom-label">{{ __('Password') }}</label>

                        <div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-4 row">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mb-4 mb-0">
                        <div class="col-md-8">
                            <button type="submit" class="btn custom-button">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link d-block link-custom" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Vecchio Form --}}
    {{-- <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
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

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

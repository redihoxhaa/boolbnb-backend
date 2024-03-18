@extends('layouts.app')

@section('content')
    <div class="row register py-4 py-sm-0">

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

        <div class="col-6 d-none d-md-block"></div>

        {{-- Form --}}
        <div
            class="col-12 justify-content-center align-items-center col-md-6 justify-content-md-start d-flex padding-desktop-custom custom-height-desktop">
            <div>
                <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Logo --}}
                    <img class="login-logo" src="{{ asset('assets/images/malhome_logo.svg') }}" alt="">

                    {{-- Title --}}
                    <h1 class="login-title">Create your Account</h1>

                    {{-- Mandatory --}}
                    <div class="mb-3">
                        <span>
                            Fields marked with * are mandatory.
                        </span>
                    </div>

                    {{-- Name --}}
                    <div class="mb-2">
                        <label for="name" class="col-md-4 col-form-label text-md-right custom-label">{{ __('Name') }}
                            *</label>

                        <div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-2">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}
                            *</label>

                        <div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-2">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                            *</label>

                        <div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" onkeyup="checkPasswords()">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password Confirm --}}
                    <div class="mb-2">
                        <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}
                            *</label>

                        <div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" onkeyup="checkPasswords()">
                            <div id="passwordError" class="d-none text-danger">
                                Passwords do not match.
                            </div>
                        </div>

                    </div>

                    {{-- Image --}}
                    <div class="mb-2">
                        <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('User photo') }}
                        </label>
                        <div>
                            <input type="file" name="image"
                                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/avif"
                                onchange="checkFileSizeAndNumber(this)">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-4 my-2 mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn custom-button">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        function checkPasswords() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password-confirm');
            const passwordError = document.getElementById('passwordError');

            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordError.classList.remove('d-none');
            } else {
                passwordError.classList.add('d-none');
            }
        }

        function checkFileSizeAndNumber(input) {
            const files = input.files;
            const maxSize = 1024 * 1024; // 1024 KB in bytes
            const maxFiles = 1;
            const errorDiv = document.getElementById('file-size-error');

            // Resetta il contenuto del div
            errorDiv.textContent = '';

            // Controlla il numero di file selezionati
            if (files.length > maxFiles) {
                errorDiv.textContent = `You can select up to ${maxFiles} image.`;
                input.value = ''; // Cancella il valore dell'input per consentire la selezione di altri file
                return;
            }

            // Controlla la dimensione dei file
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    errorDiv.textContent = `The image ${files[i].name} has to weight 1MB max.`;
                    input.value = ''; // Cancella il valore dell'input per consentire la selezione di altri file
                    return;
                }
            }
        }
    </script>
@endsection

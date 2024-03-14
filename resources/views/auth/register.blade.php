@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mt-2 mb-4 row text-center">
                                <div>
                                    Fields marked with * are mandatory.
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}
                                    *</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} *</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                    *</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" onkeyup="checkPasswords()">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} *</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        onkeyup="checkPasswords()">
                                    <div id="passwordError" class="d-none text-danger">
                                        Passwords do not match.
                                    </div>
                                </div>

                            </div>
                            <div class="mb-4 row">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Profile pic:') }} </label>
                                <div class="col-md-6">
                                    <input type="file" name="image"
                                        accept="image/jpeg, image/png, image/jpg, image/gif, image/webp, image/avif"
                                        onchange="checkFileSizeAndNumber(this)">
                                </div>
                            </div>
                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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

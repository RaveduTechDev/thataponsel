@extends('layouts.guest')

@section('login')
    <div class="d-block d-lg-none mx-auto text-center my-4">
        <img src={{ asset('logo-thata-png-col.png') }} alt="Logo Thata Ponsel"
            style="pointer-events:none;user-select:none; width: 100%; max-width: 200px; height: auto;" class="img-fluid">
    </div>
    <div id="auth" class="d-flex justify-content-center align-items-center">
        <div class="card overflow-hidden shadow-lg" style="width: 100%; max-width: 900px;">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div id="auth-left" class="p-4">
                        <h2 class="text-danger">Log in</h2>
                        <form action="{{ route('login') }}" method="POST" class="mt-10" id="formSubmit">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" id="username"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    placeholder="Username" required autocomplete="username" autofocus name="username"
                                    value="{{ old('username') }}">

                                <div class="form-control-icon" style="margin-top: -2px;">
                                    <i class="bi bi-person-vcard"></i>
                                </div>
                                <small id="username-error" class="text-danger"></small>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __($message) }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    placeholder="Password" required autocomplete="current-password" name="password">

                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>

                                <div class="position-absolute"
                                    style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __($message) }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check form-check-lg d-flex align-items-end">
                                <input id="remember" class="form-check-input me-2" type="checkbox" id="flexCheckDefault"
                                    name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    style="cursor: pointer">

                                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                    Ingat Saya
                                </label>
                            </div>

                            <button type="submit" class="btn btn-danger btn-block btn-md shadow-md mt-10" id="submitBtn">
                                {{ __('Log in') }}
                            </button>
                        </form>
                        {{-- <div class="mt-2 fs-6">
                            <p>
                                <a class="font-bold text-danger link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                    href="">Lupa Password ?
                                </a>.
                            </p>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src={{ asset('logo-thata-putih.png') }} alt="Logo Thata Ponsel"
                                style="pointer-events:none;user-select:none;" class="img-fluid w-50">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('components.ui.loading.button')

    <script type="module">
        const usernameInput = document.getElementById("username");
        usernameInput.addEventListener("input", function() {
            const invalidChars = /[^a-z0-9_]/g;
            if (invalidChars.test(this.value)) {
                const usernameError = document.getElementById("username-error");
                usernameError.textContent =
                    "Username hanya boleh mengandung huruf kecil, angka, dan garis bawah.";
                setTimeout(() => {
                    usernameError.textContent = "";
                }, 4000);
            }

            this.value = this.value.toLowerCase().replace(invalidChars, "");
        });

        const togglePasswordIcon = document.getElementById("togglePasswordIcon");
        const passwordInput = document.getElementById("password");
        togglePasswordIcon.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            }
        });
    </script>
@endpush

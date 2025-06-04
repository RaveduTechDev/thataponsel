@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('build/assets/telInput-D9_xf1bf.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">{{ $title }}</h2>
            <a href={{ route('master-data.agent.index') }} style="margin:-8px 0 0 0;"
                class="d-inline-flex align-items-center btn btn-secondary btn-md">
                <span>Kembali</span>
            </a>
        </div>
        <section id="multiple-column-form">
            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession

            <div class="row">
                <div class="col-12">
                    <form action={{ route('master-data.agent.store') }} method="POST" class="form" id="formSubmit">
                        @csrf
                        <div class="row">
                            <div class=" col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <li>Kolom yang ditandai dengan <span class="text-danger">*</span> wajib diisi.</li>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <h5 class="mb-3 text-secondary">Informasi Pengguna</h5>

                                                <div class=" col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="nama-agen" class="form-label">
                                                            Nama
                                                        </label>
                                                        <input type="text" id="nama-agen"
                                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Agen" name="name"
                                                            value="{{ @old('name') }}" required>
                                                        @error('name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class=" col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="username" class="form-label">
                                                            Username
                                                        </label>
                                                        <input type="text" id="username"
                                                            class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                                            placeholder="Nama Agen" name="username"
                                                            value="{{ @old('username') }}" required>
                                                        <small id="username-error" class="text-danger"></small>
                                                        @error('username')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class=" col-lg-4 col-12">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label">
                                                            Email
                                                        </label>
                                                        <input type="email" id="email"
                                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                            placeholder="Email" name="email" value="{{ @old('email') }}">
                                                        @error('email')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group position-relative mandatory">
                                                        <label for="new_password" class="form-label">
                                                            Password
                                                        </label>

                                                        <div class="position-relative">
                                                            <input type="password" id="password"
                                                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                                placeholder="Password" name="password"
                                                                value="{{ @old('password') }}" required>

                                                            <div class="position-absolute"
                                                                style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                                            </div>
                                                        </div>
                                                        <small id="password-error" class="text-danger"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="password_confirmation" class="form-label">
                                                            Konfirmasi Password
                                                        </label>

                                                        <div class="position-relative">
                                                            <input type="password" id="password_confirmation"
                                                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                                placeholder="Konfirmasi Password"
                                                                name="password_confirmation"
                                                                value="{{ @old('password_confirmation') }}" required>

                                                            <div class="position-absolute"
                                                                style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                                                <i class="bi bi-eye-slash"
                                                                    id="togglePasswordConfirmationIcon"></i>
                                                            </div>
                                                        </div>
                                                        <small id="password_confirmation-error" class="text-danger"></small>
                                                        @error('password')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <h5 class="mb-3 text-secondary">Informasi Lainnya</h5>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory d-flex flex-column">
                                                        <label for="phone" class="form-label">Nomor HP/WhatsApp</label>
                                                        <input type="tel" value="{{ old('nomor_wa') }}"
                                                            id="phone"
                                                            class="form-control {{ $errors->has('no_wa') ? 'is-invalid' : '' }}"
                                                            name="nomor_wa" required>
                                                    </div>
                                                    @error('nomor_wa')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12">
                                                    <div class="form-group mandatory">
                                                        <label for="select-toko_cabangs" class="form-label">
                                                            Toko Cabang
                                                        </label>
                                                        <select class="select-data form-select choice"
                                                            style="cursor:pointer;" name="toko_cabang_id"
                                                            id="select-toko_cabangs"
                                                            data-placeholder="-- Pilih Toko Cabang --"
                                                            data-check-selected="false" required>
                                                            @foreach ($toko_cabangs as $toko_cabang)
                                                                <option value="{{ $toko_cabang->id }}"
                                                                    {{ old('toko_cabang_id') === $toko_cabang->id ? 'selected' : '' }}>
                                                                    {{ $toko_cabang->nama_toko_cabang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('toko_cabang_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                @if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('super_admin'))
                                                    <div class="col-md-6 col-lg-4 col-12">
                                                        <div class="form-group mandatory">
                                                            <label for="level-akses" class="form-label ">Level
                                                                Akses</label>
                                                            <select class="form-select" style="cursor: pointer;"
                                                                id="level-akses" name="level" name="level" required>
                                                                <option value="" disabled selected>
                                                                    -- Pilih Level Akses --
                                                                </option>
                                                                <option value="admin"
                                                                    {{ old('level') === 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="agen"
                                                                    {{ old('level') === 'agen' ? 'selected' : '' }}>
                                                                    Agen/Sales
                                                                </option>
                                                            </select>
                                                            @error('level')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-success me-3 mb-1"
                                                        id="submitBtn">
                                                        Tambah
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>


@endsection

@push('scripts')
    {{-- @vite(['resources/js/telInput.js', 'resources/js/choices.js']) --}}

    <script type="module" src="{{ asset('build/assets/telInput-CYg8gn6C.js') }}" referrerpolicy="no-referrer"></script>
    <script type="module" src="{{ asset('build/assets/choices-CDTFh5hp.js') }}"></script>

    @include('components.ui.loading.button')

    <script type="module">
        const usernameInput = document.getElementById("username");
        const togglePasswordIcon = document.getElementById("togglePasswordIcon");
        const togglePasswordConfirmationIcon = document.getElementById("togglePasswordConfirmationIcon");

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

        togglePasswordIcon.addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const isPasswordVisible = passwordInput.type === "text";

            passwordInput.type = isPasswordVisible ? "password" : "text";
            this.classList.toggle("bi-eye", !isPasswordVisible);
            this.classList.toggle("bi-eye-slash", isPasswordVisible);
        });

        togglePasswordConfirmationIcon.addEventListener("click", function() {
            const passwordConfirmationInput = document.getElementById("password_confirmation");
            const isPasswordVisible = passwordConfirmationInput.type === "text";

            passwordConfirmationInput.type = isPasswordVisible ? "password" : "text";
            this.classList.toggle("bi-eye", !isPasswordVisible);
            this.classList.toggle("bi-eye-slash", isPasswordVisible);
        });

        const passwordInput = document.getElementById("password");
        const passwordConfirmationInput = document.getElementById("password_confirmation");
        const passwordError = document.getElementById("password-error");
        const passwordConfirmationError = document.getElementById("password_confirmation-error");

        passwordInput.addEventListener("input", function() {
            this.value = this.value.replace(/\s/g, "");
            if (/\s/.test(this.value)) {
                passwordError.textContent = "Password tidak boleh mengandung spasi.";
            } else if (this.value.length < 8) {
                passwordError.textContent = "Password minimal 8 karakter.";
            } else {
                passwordError.textContent = "";
            }
        });

        passwordConfirmationInput.addEventListener("input", function() {
            this.value = this.value.replace(/\s/g, "");
            if (/\s/.test(this.value)) {
                passwordConfirmationError.textContent = "Password konfirmasi tidak boleh mengandung spasi.";
            } else if (this.value.length < 8) {
                passwordConfirmationError.textContent = "Password konfirmasi minimal 8 karakter.";
            } else if (this.value !== passwordInput.value) {
                passwordConfirmationError.textContent = "Password konfirmasi tidak cocok.";
            } else {
                passwordConfirmationError.textContent = "";
            }
        });
    </script>
@endpush

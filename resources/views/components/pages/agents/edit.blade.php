@extends('layouts.app')

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
                    <form action={{ route('master-data.agent.update', $agent->id) }} method="POST" class="form"
                        id="formSubmit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class=" col-12">
                                <div class="card">
                                    <div class="card-header">
                                        {{-- informasi mandatory --}}
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
                                                            value="{{ old('name', $agent->name) }}" required>
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
                                                            placeholder="Username" name="username"
                                                            value="{{ old('username', $agent->username) }}" required>
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
                                                            placeholder="Email" name="email"
                                                            value="{{ old('email', $agent->email) }}">
                                                        @error('email')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <h5 class="text-secondary">Ubah Kata Sandi</h5>
                                                <small class="mb-2">
                                                    <span class="text-danger">*</span>
                                                    Kosongkan kolom di bawah ini jika
                                                    <span class="text-danger">
                                                        tidak ingin mengubah
                                                    </span>
                                                    kata sandi.
                                                </small>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6 col-lg-4 col-12 pass">
                                                    <div class="form-group">
                                                        <label for="current_password " class="form-label">
                                                            Kata Sandi Saat Ini
                                                        </label>
                                                        <div class="position-relative ">
                                                            <input type="password" name="current_password"
                                                                id="currentPassword"
                                                                class="form-control passwordValidation @error('current_password', 'updatePassword') is-invalid @enderror">
                                                            <div class="position-absolute"
                                                                style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                                                <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger passwordError"></small>

                                                        @error('current_password')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12 pass">
                                                    <div class="form-group">
                                                        <label class="form-label">Kata Sandi Baru</label>
                                                        <div class="position-relative ">
                                                            <input type="password" name="password" id="password"
                                                                class="form-control passwordValidation @error('password', 'updatePassword') is-invalid @enderror">
                                                            <div class="position-absolute"
                                                                style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                                                <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger passwordError"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-12 pass">
                                                    <div class="form-group">
                                                        <label class="form-label">Konfirmasi Kata Sandi</label>
                                                        <div class="position-relative ">
                                                            <input type="password" name="password_confirmation"
                                                                id="password_confirmation"
                                                                class="form-control passwordValidation">
                                                            <div class="position-absolute"
                                                                style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                                                <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger passwordError"></small>

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
                                                        <input type="tel"
                                                            value="{{ old('nomor_wa', $agent->nomor_wa) }}"
                                                            id="phone"
                                                            class="form-control {{ $errors->has('nomor_wa') ? 'is-invalid' : '' }}"
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
                                                            data-check-selected="true" required>
                                                            @foreach ($toko_cabangs as $toko_cabang)
                                                                <option value="{{ $toko_cabang->id }}"
                                                                    {{ old('toko_cabang_id', $agent->toko_cabang_id) == $toko_cabang->id ? 'selected' : '' }}>
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
                                                                id="level-akses" name="level" required>
                                                                <option value="" disabled>
                                                                    -- Pilih Level Akses --
                                                                </option>
                                                                <option value="admin"
                                                                    {{ $agent->hasRole('admin') ? 'selected' : '' }}>
                                                                    Admin
                                                                </option>
                                                                <option value="agen"
                                                                    {{ $agent->hasRole('agen') ? 'selected' : '' }}>
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
                                                    <button type="submit" class="btn btn-primary me-3 mb-1"
                                                        id="submitBtn">
                                                        Ubah
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
    @vite(['resources/js/telInput.js', 'resources/js/choices.js'])
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

        const togglePasswordIcons = document.querySelectorAll('.togglePasswordValidation');
        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.position-relative').querySelector(
                    '.passwordValidation');
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                }
            });
        });

        const passwordInputs = document.querySelectorAll('.passwordValidation');
        passwordInputs.forEach(input => {
            input.addEventListener('input', function() {
                const passwordError = this.closest('.pass').querySelector('.passwordError');
                if (this.value.includes(' ')) {
                    passwordError.textContent = "Kata sandi tidak boleh mengandung spasi.";
                    this.value = this.value.replace(/\s/g, '');
                } else if (this.value.length < 8) {
                    passwordError.textContent =
                        "Kata sandi harus terdiri dari minimal 8 karakter.";
                } else {
                    passwordError.textContent = "";
                }
            });
        });

        const passwordConfirmationInput = document.getElementById('password_confirmation');
        passwordConfirmationInput.addEventListener('input', function() {
            const passwordError = this.closest('.pass').querySelector('.passwordError');
            const passwordInput = document.getElementById('password');
            if (this.value !== passwordInput.value) {
                passwordError.textContent = "Kata sandi konfirmasi tidak cocok.";
            } else {
                passwordError.textContent = "";
            }
        });
    </script>
@endpush

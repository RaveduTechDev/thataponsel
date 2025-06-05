@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <h5 class="section-title">Informasi Profil</h5>
            <p class="section-desc">Perbarui informasi akun Anda. {{ Session::get('ip') }}</p>
        </div>
        <div class="col-md-8">
            <div class="card p-4">
                <form action="{{ route('profile.upload', ['user' => Auth::user()->username]) }}" method="post"
                    enctype="multipart/form-data" class="formSubmit">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="profile-photo me-3">
                            <div id="profile-photo-preview-content"
                                class="rounded-circle overflow-hidden {{ Auth::user()->getFirstMediaUrl('profile_photo') ? 'd-block' : 'd-none' }}"
                                style="width: 80px; height: 80px; position: relative; border: 2px solid #ccc;">
                                <img src="{{ Auth::user()->getFirstMediaUrl('profile_photo') }}"
                                    alt="{{ Auth::user()->name }}" class="img-fluid rounded-circle"
                                    id="profile-photo-preview" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div id="profile-avatar-preview-content"
                                style="width: 80px; height: 80px; border: 2px solid #ccc; overflow: hidden;"
                                class="{{ Auth::user()->getFirstMediaUrl('profile_photo') == '' ? 'd-block' : 'd-none' }} rounded-circle ">
                                {!! Avatar::create(strtoupper(Auth::user()->name))->setDimension(76, 76)->setFontSize(24)->toSvg() !!}
                            </div>
                        </div>
                        @csrf
                        <label for="profile-photo"
                            class="btn btn-secondary d-inline-flex justify-content-center align-items-center mb-0 buttonSubmit">
                            <i class="bi bi-upload" style="margin: -10px 6px 0 0"></i>
                            Pilih Foto Baru
                        </label>
                        <input type="file" id="profile-photo" name="profile_photo" class="d-none"
                            onchange="this.form.submit()">
                    </div>
                </form>
                @error('profile_photo')
                    <small class="text-danger mt-2">{{ $message }}</small>
                    @endsession
                </div>

                <div class="card p-4">
                    <form action="{{ route('user-profile-information.update') }}" method="post" class="formSubmit">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                value="{{ auth()->user()->username }}">
                            <small id="username-error" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                value="{{ auth()->user()->email }}">
                        </div>

                        <div class="mb-3">
                            <div class="form-group d-flex flex-column">
                                <label for="phone" class="form-label">Nomor HP/WhatsApp</label>
                                <input type="tel" value="{{ old('nomor_wa', Auth::user()->nomor_wa) }}" id="phone"
                                    class="form-control {{ $errors->has('nomor_wa') ? 'is-invalid' : '' }}" name="nomor_wa"
                                    required>
                            </div>
                            @error('nomor_wa')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit"
                            class="btn btn-success d-inline-flex justify-content-center align-items-center buttonSubmit">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="row mb-4">
            <div class="col-md-4">
                <h5 class="section-title">Perbarui Kata Sandi</h5>
                <p class="section-desc">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                    <form action="{{ route('user-password.update') }}" method="post" class="formSubmit">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Saat Ini</label>
                            <div class="position-relative">
                                <input type="password" name="current_password" id="currentPassword"
                                    class="form-control passwordValidation @error('current_password', 'updatePassword') is-invalid @enderror">
                                <div class="position-absolute"
                                    style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                    <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                </div>
                            </div>
                            <small class="text-danger passwordError"></small>

                            @error('current_password', 'updatePassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password"
                                    class="form-control passwordValidation @error('password', 'updatePassword') is-invalid @enderror">
                                <div class="position-absolute"
                                    style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                    <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                </div>
                            </div>
                            <small class="text-danger passwordError"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control passwordValidation">
                                <div class="position-absolute"
                                    style="background: white; padding-left: 10px; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                    <i class="bi bi-eye-slash togglePasswordValidation"></i>
                                </div>
                            </div>
                            <small class="text-danger passwordError"></small>

                            @error('password', 'updatePassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-success d-inline-flex justify-content-center align-items-center buttonSubmit">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    @endsection

    @push('scripts')
        <script type="module" src="{{ asset('build/assets/telInput-qKZFCzb-.js') }}"></script>
        @include('components.sweetalert2.alert')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profilePhotoInput = document.getElementById('profile-photo');
                const profilePhotoPreview = document.getElementById('profile-photo-preview');
                const profilePhotoPreviewContent = document.getElementById('profile-photo-preview-content');
                const profileAvatarPreviewContent = document.getElementById('profile-avatar-preview-content');

                const forms = document.querySelectorAll('.formSubmit');
                const submitButtons = document.querySelectorAll('.buttonSubmit');

                const usernameInput = document.getElementById('username');

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
                        const passwordError = this.closest('.mb-3').querySelector('.passwordError');
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
                    const passwordError = this.closest('.mb-3').querySelector('.passwordError');
                    const passwordInput = document.getElementById('password');
                    if (this.value !== passwordInput.value) {
                        passwordError.textContent = "Kata sandi konfirmasi tidak cocok.";
                    } else {
                        passwordError.textContent = "";
                    }
                });

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

                profilePhotoInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePhotoPreview.src = e.target.result;
                            profilePhotoPreviewContent.classList.remove('d-none');
                            profileAvatarPreviewContent.classList.add('d-none');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        profilePhotoPreviewContent.classList.add('d-none');
                        profileAvatarPreviewContent.classList.remove('d-none');
                    }
                });

                forms.forEach(form => {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        const button = this.querySelector('.buttonSubmit');
                        button.disabled = true;
                        button.innerHTML = `
                            <span class="spinner-border spinner-border-sm" style="margin: -2px 2px 0 0;" role="status" aria-hidden="true"></span>
                            Loading...`;
                        this.submit();
                    });
                });
            });
        </script>
    @endpush

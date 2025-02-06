{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

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

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

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

                            <div class="row mb-3">
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

                            <div class="row mb-0">
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
    </div>
@endsection --}}

@extends('layouts.guest')

@section('login')
    <div id="auth" class="d-flex justify-content-center align-items-center">
        <div class="card overflow-hidden shadow-lg" style="width: 100%; max-width: 900px;">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div id="auth-left" class="p-4">
                        <h2 class="text-danger">Log in</h2>
                        <form action="{{ route('login') }}" method="POST" class="mt-10">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="email" id="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    placeholder="Email" required autocomplete="email" autofocus name="email"
                                    value="{{ old('email') }}">

                                <div class="form-control-icon" style="margin-top: -2px;">
                                    <i class="bi bi-envelope"></i>
                                </div>

                                @error('email')
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

                            <button type="submit" class="btn btn-danger btn-block btn-md shadow-md mt-10">
                                {{ __('Log in') }}
                            </button>
                        </form>
                        <div class="mt-2 fs-6">
                            <p><a class="font-bold text-danger link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                    href="">Lupa Passowrd ?</a>.</p>
                        </div>
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

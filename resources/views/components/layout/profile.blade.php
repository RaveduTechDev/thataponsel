@extends('layout.app')

@section('content')
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pengaturan</h4>
                        </div>
                        <div class="card-body">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link profile-tab-hover active" id="informasi-profil-tab" data-bs-toggle="pill"
                                    href={{ url('#informasi-profil') }} role="tab" aria-controls="informasi-profil"
                                    aria-selected="true">
                                    Informasi Profil
                                </a>
                                <a class="nav-link profile-tab-hover" id="passowrd-tab" data-bs-toggle="pill"
                                    href={{ url('#ubah-kata-sandi') }} role="tab" aria-controls="ubah-kata-sandi"
                                    aria-selected="false" tabindex="-1">
                                    Ubah Kata Sandi
                                </a>
                                <a class="nav-link profile-tab-hover" id="sesi-browser-tab" data-bs-toggle="pill"
                                    href={{ url('#sesi-browser') }} role="tab" aria-controls="sesi-browser"
                                    aria-selected="false" tabindex="-1">
                                    Sesi Browser
                                </a>
                                <a class="nav-link profile-tab-hover" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    href={{ url('/dashboard/pengaturan') }} role="tab" aria-controls="v-pills-settings"
                                    aria-selected="false" tabindex="-1">
                                    Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-9">
                    <div class=" tab-content" id="v-pills-tabContent">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="card tab-pane fade active show" id="informasi-profil" role="tabpanel"
                                aria-labelledby="informasi-profil-tab">
                                <div class="card-header">
                                    <h4>Informasi Profil</h4>
                                </div>
                                <div class="card-body">
                                    Test
                                </div>
                            </div>
                            <div class="card tab-pane fade" id="ubah-kata-sandi" role="tabpanel"
                                aria-labelledby="passowrd-tab">
                                <div class="card-header">
                                    <h4>Profile</h4>
                                </div>
                                <div class="card-body">
                                    Test Profile
                                </div>
                            </div>
                            <div class="card tab-pane fade" id="sesi-browser" role="tabpanel"
                                aria-labelledby="sesi-browser-tab">
                                <div class="card-header">
                                    <h4>Profile</h4>
                                </div>
                                <div class="card-body">
                                    Test Profile
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                Sed lacus quam, convallis quis condimentum ut, accumsan congue
                                massa.
                                Pellentesque et quam vel massa pretium ullamcorper
                                vitae eu tortor.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

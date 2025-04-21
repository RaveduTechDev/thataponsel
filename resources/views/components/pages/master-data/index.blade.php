@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="text-danger">Master Data</h2>
        </div>

        <div class="row mb-5">
            <div class="col-6 col-lg-3 col-md-6">
                <a href={{ route('master-data.pelanggan.index') }} class="text-decoration-none">
                    <div class="card card-hover-border-danger">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="mb-1 fs-1 text-danger">
                                <i class="bi bi-person-hearts fs-1"></i>
                            </div>
                            <h5 class="text-danger font-extrabold">Client</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <a href={{ route('master-data.agent.index') }} class="text-decoration-none">
                    <div class="card card-hover-border-danger">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="mb-1 fs-1 text-danger">
                                <i class="bi bi-person-vcard fs-1"></i>
                            </div>
                            <h5 class="text-danger font-extrabold">Agent</h5>
                        </div>
                    </div>
                </a>
            </div>

            @if (Auth::user()->hasRole(['super_admin', 'admin']))
                <div class="col-6 col-lg-3 col-md-6">
                    <a href={{ route('master-data.toko-cabang.index') }} class="text-decoration-none">
                        <div class="card card-hover-border-danger">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="mb-1 fs-1 text-danger">
                                    <i class="bi bi-shop fs-1"></i>
                                </div>
                                <h5 class="text-danger font-extrabold">Toko Cabang</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <div class="col-6 col-lg-3 col-md-6">
                <a href={{ route('master-data.barang.index') }} class="text-decoration-none">
                    <div class="card card-hover-border-danger">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="mb-1 fs-1 text-danger">
                                <i class="bi bi-phone fs-1"></i>
                            </div>
                            <h5 class="text-danger font-extrabold">Data HP</h5>
                        </div>
                    </div>
                </a>
            </div>
    </section>
@endsection

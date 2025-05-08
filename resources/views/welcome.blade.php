@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="text-danger">Cari Berdasarkan Tanggal</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('dashboard') }}" method="GET" id="formSubmit" class="row g-3">
                        <div
                            class="col-12 col-md-6 {{ request('start_date') || request('end_date') ? 'col-lg-4' : 'col-lg-5' }} form-group mandatory">
                            <label for="start_date" class="form-label">Mulai Tanggal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ request('start_date') }}" required>
                        </div>
                        <div
                            class="col-12 col-md-6 {{ request('start_date') || request('end_date') ? 'col-lg-4' : 'col-lg-5' }} form-group">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-12 col-md-4  col-lg-2 d-flex form-group align-items-end">
                            <button type="submit" id="submitBtn"
                                class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-search me-1" style="margin-top: -12px"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                        @if (request('start_date') || request('end_date'))
                            <div class="col-12 col-md-2 d-flex form-group align-items-end">
                                <a href="{{ url()->current() }}"
                                    class="btn btn-secondary w-100 d-flex align-items-center justify-content-center">
                                    Reset
                                </a>
                            </div>
                        @endif
                    </form>

                    <p class="mt-3 mb-0">
                        <span class="text-danger">*</span>
                        Diagram berdasarkan

                        @if (request('start_date') && request('end_date'))
                            {{ \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') }} -
                            {{ \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') }}
                        @elseif (request('start_date'))
                            {{ \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') }}
                        @else
                            6 bulan terakhir
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 pe-xxl-0 d-flex justify-content-start">
                                    <div class="stats-icon mb-2" style="background: #910707">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 px-xxl-0 ">
                                    <h6 class="text-muted font-semibold">Unit Terjual</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalUnitTerjual }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 pe-xxl-0 d-flex justify-content-start">
                                    <div class="stats-icon mb-2" style="background: #dc3545">
                                        <i class="bi bi-upc-scan d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 px-xxl-0">
                                    <h6 class="text-muted font-semibold">Layanan IMEI</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalLayananImei }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 pe-xxl-0 d-flex justify-content-start">
                                    <div class="stats-icon mb-2" style="background: #dc584b">
                                        <i class="bi bi-coin d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 px-xxl-0">
                                    <h6 class="text-muted font-semibold">Penjualan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $formatHumanNumber }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 pe-xxl-0 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i
                                            class="bi bi-graph-up-arrow d-flex align-items-center justify-content-center"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 px-xxl-0">
                                    <h6 class="text-muted font-semibold">Keuntungan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $formatKeuntungan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-penjualan" class="chart-style"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="performance-sales" class="chart-style"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="top-5-item" class="chart-style"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-imei" class="chart-style"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body py-4 px-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md2">
                            <img src="" alt="Face 1" class="select-none" />
                        </div>
                        <div class="ms-3 name flex-grow-1">
                            <h5 class=" font-bold text-secondary" style="font-size:16px;margin-bottom:2px">
                                {{ Auth::user()->shortName() }}
                            </h5>
                            <h6 class="text-muted mb-0" style="font-size:12px">
                                {{ '@' . Auth::user()->shortUsername() }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky-md-top sidebar-top">
                <div class="card">
                    <div class="card-body">
                        <div id="cashflow-penjualan" class="pie-chart-style"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div id="jumlah-unit" class="pie-chart-style"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div id="cashflow-imei" class="pie-chart-style"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/chart.js')
    <script type="module">
        // Buatkan pesan tanggal untuk ditampilkan di grafik secara dinamis
        let deskripsiTanggal = '';

        @if (request('start_date') && request('end_date'))
            deskripsiTanggal =
                `{{ \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->isoFormat('D MMMM Y') }}`;
        @elseif (request('start_date'))
            deskripsiTanggal = `{{ \Carbon\Carbon::parse(request('start_date'))->isoFormat('D MMMM Y') }}`;
        @else
            deskripsiTanggal = '6 bulan terakhir';
        @endif

        let chartPenjualan = echarts.init(document.getElementById('chart-penjualan'));
        chartPenjualan.setOption({
            title: {
                text: `Grafik Penjualan HP ${deskripsiTanggal}`,
                left: 'center',
                top: '10px',
                textStyle: {
                    fontSize: 18,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        show: true,
                        title: 'Lihat Data',
                        readOnly: true,
                        lang: ['Data', 'Tutup'],
                    },
                    magicType: {
                        show: true,
                        title: {
                            line: 'Garis',
                            bar: 'Batang',
                        },
                        type: ['line', 'bar']
                    },
                    saveAsImage: {
                        type: 'png',
                        name: 'Grafik-Penjualan-6-Bulan-Terakhir',
                        title: 'Simpan Gambar',
                        backgroundColor: '#fff',
                    },
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                data: @json($months),
                axisTick: {
                    alignWithLabel: true
                }
            }],
            yAxis: [{
                type: 'value',
            }],
            series: [{
                name: 'Penjualan',
                type: 'bar',
                barWidth: '40%',
                data: @json($data),
                itemStyle: {
                    color: '#a93540'
                },
            }],

        });

        let performanceSales = echarts.init(document.getElementById('performance-sales'));
        performanceSales.setOption({
            title: {
                text: 'Kinerja Agen/Sales (Penjualan per agen/sales)',
                left: 'center',
                top: '10px',
                textStyle: {
                    fontSize: 18,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        show: true,
                        title: 'Lihat Data',
                        readOnly: true,
                        lang: ['Data', 'Tutup'],
                    },
                    saveAsImage: {
                        type: 'png',
                        name: 'Kinerja-Agen-Sales-Penjualan-per-agen-sales',
                        title: 'Simpan Gambar',
                        backgroundColor: '#fff',
                    },
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            yAxis: [{
                type: 'category',
                data: @json($dataAgen),
                axisTick: {
                    alignWithLabel: true
                }
            }],
            xAxis: [{
                type: 'value'
            }],
            series: [{
                name: 'Penjualan',
                type: 'bar',
                barWidth: '60%',
                data: @json($totalPenjualan),
                itemStyle: {
                    color: '#BF3131'
                },
                label: {
                    show: true
                }
            }]

        });

        let top5Item = echarts.init(document.getElementById('top-5-item'));
        top5Item.setOption({
            title: {
                text: 'Top 5 Barang Terlaris',
                left: 'center',
                top: '10px',
                textStyle: {
                    fontSize: 18,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            yAxis: [{
                type: 'category',
                data: @json($barangLabel),
                inverse: true,
                axisTick: {
                    alignWithLabel: true
                }
            }],
            xAxis: [{
                type: 'value',
            }],
            series: [{
                name: 'Penjualan',
                type: 'bar',
                barWidth: '60%',
                data: @json($jumlahBarang),
                realtimeSort: true,
                label: {
                    show: true
                }
            }]
        });

        let cashflowPenjualan = echarts.init(document.getElementById('cashflow-penjualan'));
        cashflowPenjualan.setOption({
            title: {
                text: 'Cashflow Penjualan HP',
                left: 'left',
                textStyle: {
                    fontSize: 16,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'item',
                valueFormatter: value => Number(value).toLocaleString('id-ID')
            },
            legend: {
                orient: 'vertical',
                left: 'right',
            },
            series: [{
                name: 'Jumlah dalam Rp',
                type: 'pie',
                radius: '50%',
                data: [{
                    name: 'Modal',
                    value: @json($totalHargaModal),
                    itemStyle: {
                        color: '#D84040',
                    }
                }, {
                    name: 'Penjualan',
                    value: @json($totalHargaPenjualan),
                    itemStyle: {
                        color: '#a93540'
                    }
                }],

                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        let jumlahUnit = echarts.init(document.getElementById('jumlah-unit'));
        jumlahUnit.setOption({
            title: {
                text: 'Cashflow Jumlah Unit',
                left: 'left',
                textStyle: {
                    fontSize: 16,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                orient: 'vertical',
                left: 'right'
            },
            series: [{
                name: 'Jumlah Unit',
                type: 'pie',
                radius: '50%',
                data: [{
                        value: @json($totalUnitMasuk),
                        name: 'Unit Masuk',
                        itemStyle: {
                            color: '#5f0200'
                        }
                    },
                    {
                        value: @json($totalUnitKeluar),
                        name: 'Unit Keluar',
                        itemStyle: {
                            color: '#ac2f2d'
                        }
                    },
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]

        });

        let cashflowImei = echarts.init(document.getElementById('cashflow-imei'));
        cashflowImei.setOption({
            title: {
                text: 'Cashflow IMEI',
                left: 'left',
                textStyle: {
                    fontSize: 16,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'item',
                valueFormatter: value => Number(value).toLocaleString('id-ID')
            },
            legend: {
                orient: 'vertical',
                left: 'right',
            },
            series: [{
                name: 'Jumlah dalam Rp',
                type: 'pie',
                radius: '50%',
                data: [{
                    name: 'Modal IMEI',
                    value: @json($modalImei),
                    itemStyle: {
                        color: '#D84040',
                    }
                }, {
                    name: 'Biaya IMEI',
                    value: @json($totalBiayaImei),
                    itemStyle: {
                        color: '#a93540'
                    }
                }],

                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        let chartImei = echarts.init(document.getElementById('chart-imei'));
        chartImei.setOption({
            title: {
                text: `Grafik Jasa IMEI ${deskripsiTanggal}`,
                left: 'center',
                top: '10px',
                textStyle: {
                    fontSize: 18,
                    fontWeight: 'bold',
                    color: '#495057',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        show: true,
                        title: 'Lihat Data',
                        readOnly: true,
                        lang: ['Data', 'Tutup'],
                    },
                    magicType: {
                        show: true,
                        title: {
                            line: 'Garis',
                            bar: 'Batang',
                        },
                        type: ['line', 'bar']
                    },
                    saveAsImage: {
                        type: 'png',
                        name: 'Grafik-Penjualan-6-Bulan-Terakhir',
                        title: 'Simpan Gambar',
                        backgroundColor: '#fff',
                    },
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                data: @json($imeiMonths),
                axisTick: {
                    alignWithLabel: true
                }
            }],
            yAxis: [{
                type: 'value',
            }],
            series: [{
                name: 'Penjualan',
                type: 'bar',
                barWidth: '40%',
                data: @json($imeiData),
                itemStyle: {
                    color: '#a93540'
                },
            }],

        });

        window.addEventListener('resize', () => {
            chartPenjualan.resize();
            performanceSales.resize();
            top5Item.resize();
            cashflowPenjualan.resize();
            jumlahUnit.resize();
            cashflowImei.resize();
        });
    </script>
@endpush

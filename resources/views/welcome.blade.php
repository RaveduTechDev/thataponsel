@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12 col-lg-9">
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
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticky-md-top sidebar-top">
                <div class="card-body py-3 px-3">
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
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/chart.js')
    <script type="module">
        let chartPenjualan = echarts.init(document.getElementById('chart-penjualan'));
        chartPenjualan.setOption({
            title: {
                text: 'Grafik Penjualan (6 Bulan Terakhir)',
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
                data: @json($jumlahBarang),
                label: {
                    show: true
                }
            }]

        });

        window.addEventListener('resize', () => {
            chartPenjualan.resize();
            performanceSales.resize();
            top5Item.resize();
        });
    </script>
@endpush

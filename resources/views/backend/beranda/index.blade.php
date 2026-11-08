@extends('backend.layout.app')

@section('content')

<div class="container-fluid p-0">

    <!-- HEADER -->
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark text-white border-0 shadow-lg">
                <div class="card-body text-center d-flex flex-column flex-sm-row justify-content-between align-items-center py-4 px-4 gap-3">
                    <div class="text-center text-sm-start">
                        <h2 class="fw-bold text-white mb-1">
                            Dashboard Penjualan ☕
                        </h2>
                        <p class="mb-0 text-white-50">
                            Coffee & Resto Serendipity
                        </p>
                    </div>
                    <div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-3 mt-1">

        <!-- TOTAL PRODUK -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Produk</h6>
                            <h2 class="fw-bold text-white mb-0">
                                {{ $totalProduk }}
                            </h2>
                        </div>
                        <i class="fas fa-box fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL TRANSAKSI -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Transaksi</h6>
                            <h2 class="fw-bold text-white mb-0">
                                {{ $totalTransaksi }}
                            </h2>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL PENDAPATAN -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Pendapatan</h6>
                            <h3 class="fw-bold text-white mb-0">
                                Rp {{ number_format($totalPendapatan,0,',','.') }}
                            </h3>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- GRAFIK -->
    <div class="row mt-4">

        <div class="col-md-8">

            <div class="card border-0 shadow">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Grafik Pendapatan
                    </h5>
                </div>

                <div class="card-body">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>

            </div>

        </div>

        <!-- PRODUK TERLARIS -->
        <div class="col-md-4">

            <div class="card border-0 shadow">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Produk Terlaris
                    </h5>
                </div>

                <div class="card-body">

                    @foreach($produkTerlaris as $item)

                    <div class="d-flex justify-content-between mb-3">

                        <div>
                            <strong>{{ $item->nama_produk }}</strong>
                        </div>

                        <span class="badge bg-primary">
                            {{ $item->total_qty }} Terjual
                        </span>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <!-- TRANSAKSI TERBARU -->
    <div class="row mt-4">

        <div class="col-md-12">

            <div class="card border-0 shadow">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Transaksi Terbaru
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead style="background-color: #1e293b !important; color: #ffffff !important;">
                                <tr>
                                    <th style="color: #ffffff !important; font-weight: 600;">Kode</th>
                                    <th style="color: #ffffff !important; font-weight: 600;">Tanggal</th>
                                    <th style="color: #ffffff !important; font-weight: 600;">Total</th>
                                    <th style="color: #ffffff !important; font-weight: 600;">Total Item</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($latestTransaksi as $trx)

                                <tr>

                                    <td>{{ $trx->kode_transaksi }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($trx->tanggal)->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($trx->total,0,',','.') }}
                                    </td>

                                    <td>
                                        {{ $trx->total_item }}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('incomeChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($bulan) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode($pendapatanBulanan) !!},
            backgroundColor: 'rgba(58, 87, 232, 0.85)',
            borderColor: '#3a57e8',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + Number(context.raw).toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + Number(value).toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>

@endsection
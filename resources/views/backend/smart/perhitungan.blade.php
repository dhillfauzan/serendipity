@extends('backend.layout.app')

@section('content')

<div class="container-fluid">

    <style>
        .table-smart thead th {
            background-color: #1e293b !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 13.5px !important;
            text-align: center !important;
            vertical-align: middle !important;
            border: 1px solid #334155 !important;
            padding: 10px 8px !important;
        }
        .table-smart tbody td {
            vertical-align: middle !important;
            font-size: 13px !important;
            color: #0f172a !important;
        }
        @media (max-width: 768px) {
            .table-smart thead th, .table-smart tbody td {
                padding: 6px 4px !important;
                font-size: 11.5px !important;
            }
        }
    </style>

    <!-- HEADER -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h4 class="text-white mb-1 fs-5 fs-md-4"><i class="fas fa-calculator me-2"></i>Perhitungan Matriks & Nilai Utility SMART</h4>
                <p class="mb-0 text-white-50 small">Langkah-langkah pembentukan matriks keputusan, normalisasi utility (Benefit & Cost), dan perhitungan nilai akhir SMART</p>
            </div>
            <a href="{{ route('smart.hasil') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 shadow-sm text-nowrap align-self-start align-self-md-auto">
                Lihat Ranking & Menu Terbaik <i class="fas fa-trophy ms-1"></i>
            </a>
        </div>
    </div>

    <!-- 1. TABEL NILAI MIN, MAX & BOBOT KRITERIA -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white py-2">
            <h5 class="text-white mb-0 fs-6"><i class="fas fa-sliders-h me-2"></i>1. Parameter Kriteria (Min, Max, Sifat & Bobot)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center mb-0 align-middle table-smart">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>C1: Kategori</th>
                            <th>C2: Harga</th>
                            <th>C3: Penjualan</th>
                            <th>C4: Waktu Penyajian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold bg-light">Sifat Kriteria</td>
                            <td><span class="badge bg-primary">Benefit</span></td>
                            <td><span class="badge bg-danger">Cost</span></td>
                            <td><span class="badge bg-success">Benefit</span></td>
                            <td><span class="badge bg-info text-white">Benefit</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Bobot Normalisasi</td>
                            <td class="fw-bold text-dark">{{ $minMax['kategori']['bobot'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['harga']['bobot'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['penjualan']['bobot'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['estimasi']['bobot'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Nilai Min ($C_{min}$)</td>
                            <td class="fw-bold text-dark">{{ $minMax['kategori']['min'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['harga']['min'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['penjualan']['min'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['estimasi']['min'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold bg-light">Nilai Max ($C_{max}$)</td>
                            <td class="fw-bold text-dark">{{ $minMax['kategori']['max'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['harga']['max'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['penjualan']['max'] }}</td>
                            <td class="fw-bold text-dark">{{ $minMax['estimasi']['max'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. TABEL MATRIKS KEPUTUSAN AWAL -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-secondary text-white py-2 d-flex justify-content-between align-items-center">
            <h5 class="text-white mb-0 fs-6"><i class="fas fa-table me-2"></i>2. Matriks Keputusan Awal ($X$)</h5>
            <small class="text-white-50">Total: {{ count($data) }} Alternatif Menu</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-bordered table-striped table-hover text-center align-middle mb-0 table-smart">
                    <thead class="sticky-top">
                        <tr>
                            <th style="width: 80px;">Alternatif</th>
                            <th class="text-start">Nama Menu</th>
                            <th>C1: Kategori</th>
                            <th>C2: Harga</th>
                            <th>C3: Penjualan</th>
                            <th>C4: Penyajian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $item)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $item['kode_alternatif'] ?? 'A' . ($index + 1) }}</span></td>
                            <td class="text-start fw-bold text-dark">{{ $item['nama'] }}</td>
                            <td class="fw-bold text-dark">{{ $item['kategori'] }}</td>
                            <td class="fw-bold text-dark">{{ $item['harga'] }}</td>
                            <td class="fw-bold text-dark">{{ $item['penjualan'] }}</td>
                            <td class="fw-bold text-dark">{{ $item['estimasi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. TABEL NILAI UTILITY SMART -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-info text-white py-2">
            <h5 class="text-white mb-0 fs-6"><i class="fas fa-chart-bar me-2"></i>3. Matriks Normalisasi Nilai Utility ($U_i$)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 400px;">
                <table class="table table-bordered table-striped table-hover text-center align-middle mb-0 table-smart">
                    <thead class="sticky-top">
                        <tr>
                            <th style="width: 80px;">Alternatif</th>
                            <th class="text-start">Nama Menu</th>
                            <th>U Kategori (C1)</th>
                            <th>U Harga (C2)</th>
                            <th>U Penjualan (C3)</th>
                            <th>U Estimasi (C4)</th>
                            <th class="bg-primary text-white">Nilai Akhir SMART</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $item)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $item['kode_alternatif'] ?? 'A' . ($index + 1) }}</span></td>
                            <td class="text-start fw-bold text-dark">{{ $item['nama'] }}</td>
                            <td>{{ number_format($item['u_kategori'], 4) }}</td>
                            <td>{{ number_format($item['u_harga'], 4) }}</td>
                            <td>{{ number_format($item['u_penjualan'], 4) }}</td>
                            <td>{{ number_format($item['u_estimasi'], 4) }}</td>
                            <td class="bg-light fw-bold text-primary fs-6">
                                {{ number_format($item['nilai'], 4) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BUTTONS -->
    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-4">
        <a href="{{ route('smart.bobot') }}" class="btn btn-secondary px-4 order-2 order-sm-1">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Pembobotan
        </a>

        <a href="{{ route('smart.hasil') }}" class="btn btn-success btn-lg px-4 shadow order-1 order-sm-2">
            Lihat Hasil Perankingan (Step 4) <i class="fas fa-trophy ms-2"></i>
        </a>
    </div>

</div>

@endsection

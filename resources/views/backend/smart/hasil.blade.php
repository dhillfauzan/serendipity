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
            padding: 12px 10px !important;
        }
        .table-smart tbody td {
            vertical-align: middle !important;
            font-size: 13px !important;
            color: #0f172a !important;
        }
    </style>

    <!-- ================= JUARA 1 / MENU TERBAIK ================= -->
    @if(count($data) > 0)
    <div class="card mb-4 border-0 shadow-lg text-center overflow-hidden position-relative" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="card-body py-5 text-white position-relative">
            <div class="mb-3">
                <span class="badge bg-warning text-dark fs-5 px-4 py-2 rounded-pill shadow">
                    🏆 JUARA 1 - MENU TERBAIK TAHUN 2025
                </span>
            </div>

            <h1 class="display-4 fw-bold text-white mb-2" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                {{ $data[0]['nama'] }}
            </h1>

            <p class="fs-5 text-white-50 mb-4">
                Kategori: <strong class="text-white">{{ $data[0]['kategori_nama'] ?? 'Minuman / Makanan' }}</strong> |
                Nilai Akhir SMART: <strong class="text-warning fs-4">{{ number_format($data[0]['nilai'], 4) }}</strong>
            </p>

            <div class="d-inline-flex gap-3">
                <button type="button" class="btn btn-warning btn-lg fw-bold px-4" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> Cetak Hasil Ranking
                </button>
            </div>
        </div>
    </div>

    <!-- TOP 3 PODIUM (JIKA LEBIH DARI 2 DATA) -->
    @if(count($data) >= 3)
    <div class="row g-3 mb-4">
        <!-- RANK 2 -->
        <div class="col-md-4 order-2 order-md-1">
            <div class="card border-0 shadow-sm h-100 text-center" style="border-top: 4px solid #adb5bd !important;">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2 fs-6">🥈 Ranking 2</span>
                    <h5 class="fw-bold mb-1 text-dark">{{ $data[1]['nama'] }}</h5>
                    <p class="text-muted small mb-2">{{ $data[1]['kategori_nama'] ?? 'Menu' }}</p>
                    <span class="badge bg-light text-primary fs-6 px-3 py-1 border">
                        Skor: {{ number_format($data[1]['nilai'], 4) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RANK 1 -->
        <div class="col-md-4 order-1 order-md-2">
            <div class="card border-0 shadow-sm h-100 text-center" style="border-top: 4px solid #ffc107 !important; background: #fffdf5;">
                <div class="card-body">
                    <span class="badge bg-warning text-dark mb-2 fs-6">🥇 Ranking 1 (Terbaik)</span>
                    <h4 class="fw-bold mb-1 text-primary">{{ $data[0]['nama'] }}</h4>
                    <p class="text-muted small mb-2">{{ $data[0]['kategori_nama'] ?? 'Menu' }}</p>
                    <span class="badge bg-warning text-dark fs-5 px-3 py-1">
                        Skor: {{ number_format($data[0]['nilai'], 4) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RANK 3 -->
        <div class="col-md-4 order-3 order-md-3">
            <div class="card border-0 shadow-sm h-100 text-center" style="border-top: 4px solid #cd7f32 !important;">
                <div class="card-body">
                    <span class="badge bg-dark mb-2 fs-6">🥉 Ranking 3</span>
                    <h5 class="fw-bold mb-1 text-dark">{{ $data[2]['nama'] }}</h5>
                    <p class="text-muted small mb-2">{{ $data[2]['kategori_nama'] ?? 'Menu' }}</p>
                    <span class="badge bg-light text-primary fs-6 px-3 py-1 border">
                        Skor: {{ number_format($data[2]['nilai'], 4) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif


    <!-- ================= TABEL RANKING LENGKAP ================= -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h5 class="text-white mb-0 fs-6 fs-md-5"><i class="fas fa-list-ol me-2"></i>Daftar Lengkap Ranking Menu Berdasarkan Metode SMART</h5>
                <small class="text-white-50">Urutan menu dari prioritas tertinggi ke terendah</small>
            </div>
            <button class="btn btn-sm btn-outline-light text-nowrap align-self-start align-self-md-auto" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Print / Cetak
            </button>
        </div>

        <div class="card-body p-0">
            <div class="d-md-none text-muted small p-2 fst-italic">
                <i class="fas fa-arrows-alt-h me-1 text-primary"></i> Geser ke samping untuk melihat detail ranking
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center align-middle mb-0 table-smart">

                    <thead>
                        <tr>
                            <th style="width: 80px;">Ranking</th>
                            <th style="width: 80px;">Kode</th>
                            <th class="text-start">Nama Menu</th>
                            <th>Kategori</th>
                            <th>Nilai SMART</th>
                            <th>Status Rekomendasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $index => $item)
                        <tr class="{{ $index == 0 ? 'table-warning fw-bold' : ($index < 3 ? 'table-light' : '') }}">

                            <td>
                                @if($index == 0)
                                <span class="badge bg-warning text-dark fs-6">🏆 1</span>
                                @elseif($index == 1)
                                <span class="badge bg-secondary fs-6">🥈 2</span>
                                @elseif($index == 2)
                                <span class="badge bg-dark fs-6">🥉 3</span>
                                @else
                                <span class="badge bg-light text-dark border">{{ $index + 1 }}</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-secondary">{{ $item['kode_alternatif'] ?? 'A' . ($index + 1) }}</span>
                            </td>

                            <td class="text-start">
                                <span class="fw-bold fs-6">{{ $item['nama'] }}</span>
                            </td>

                            <td>
                                <span class="badge bg-primary px-2 py-1">{{ $item['kategori_nama'] ?? '-' }}</span>
                            </td>

                            <td>
                                <strong class="fs-6 text-primary">
                                    {{ number_format($item['nilai'], 4) }}
                                </strong>
                            </td>

                            <td>
                                @if($index == 0)
                                <span class="badge bg-success px-3 py-2">⭐ Rekomendasi Terbaik</span>
                                @elseif($index < 5)
                                <span class="badge bg-info text-white px-2 py-1">Sangat Direkomendasikan</span>
                                @elseif($index < 15)
                                <span class="badge bg-primary px-2 py-1">Direkomendasikan</span>
                                @else
                                <span class="badge bg-secondary px-2 py-1">Cukup Baik</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- BUTTON NAVIGASI -->
            <div class="d-flex justify-content-between p-3 border-top bg-light">
                <a href="{{ route('smart.perhitungan') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Perhitungan
                </a>

                <a href="{{ route('smart.kriteria') }}" class="btn btn-primary px-4 shadow">
                    <i class="fas fa-edit me-1"></i> Input / Kelola Data Kriteria Baru
                </a>
            </div>

        </div>
    </div>

</div>

@endsection

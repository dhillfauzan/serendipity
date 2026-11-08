@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3 mb-0">Laporan Transaksi Kasir</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end mt-3 mt-md-0 gap-2">
                        <button type="submit" class="btn btn-primary fw-bold shadow-sm">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.cetak') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" target="_blank" class="btn btn-success fw-bold shadow-sm">
                            <i class="fas fa-print me-1"></i> Cetak
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3 shadow-sm border-0">
        <div class="card-header bg-info text-white py-3">
            <h5 class="mb-0 text-white"><i class="fas fa-chart-pie me-2"></i>Ringkasan Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title text-muted small fw-bold">TOTAL PENDAPATAN</h6>
                            <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title text-muted small fw-bold">TOTAL TRANSAKSI</h6>
                            <h4 class="text-success fw-bold mb-0">{{ $totalTransaksi }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card bg-light border-0 shadow-sm h-100">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title text-muted small fw-bold">TOTAL ITEM TERJUAL</h6>
                            <h4 class="text-warning fw-bold mb-0">{{ $totalItemTerjual }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3 shadow-sm border-0 mb-4">
        <div class="card-header bg-secondary py-3">
            <h5 class="mb-0 text-white"><i class="fas fa-list me-2"></i>Detail Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="d-md-none text-muted small mb-2 fst-italic">
                <i class="fas fa-arrows-alt-h me-1 text-primary"></i> Geser tabel ke samping untuk melihat detail transaksi
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead style="background-color: #1e293b !important; color: #ffffff !important;">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $key => $transaksi)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><span class="badge bg-secondary">{{ $transaksi->kode_transaksi }}</span></td>
                            <td class="small">{{ $transaksi->tanggal ? $transaksi->tanggal->format('d/m/Y H:i') : '-' }}</td>
                            <td class="fw-bold">{{ $transaksi->user ? $transaksi->user->name : '-' }}</td>
                            <td><span class="badge bg-success">{{ $transaksi->total_item }} Item</span></td>
                            <td class="fw-bold text-primary">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('laporan.show', $transaksi->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Tidak ada data transaksi kasir pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

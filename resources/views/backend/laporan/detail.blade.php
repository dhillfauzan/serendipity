@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Detail Transaksi</h1>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
                    <p><strong>Tanggal:</strong> {{ $transaksi->tanggal->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kasir:</strong> {{ $transaksi->user->name }}</p>
                    <p><strong>Total Item:</strong> {{ $transaksi->total_item }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detail Produk Terjual</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="40%">Nama Produk</th>
                            <th width="15%" class="text-center">Qty</th>
                            <th width="20%" class="text-end">Harga Satuan</th>
                            <th width="25%" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->items as $item)
                        @php
                        // Handle both array and object formats
                        $namaProduk = is_array($item) ? ($item['nama_produk'] ?? '') : ($item->nama_produk ?? '');
                        $quantity = is_array($item) ? ($item['quantity'] ?? 0) : ($item->quantity ?? 0);
                        $harga = is_array($item) ? ($item['harga'] ?? $item['price'] ?? 0) : ($item->harga ??
                        $item->price ?? 0);
                        $subtotal = is_array($item) ? ($item['subtotal'] ?? $harga * $quantity) : ($item->subtotal ??
                        $harga * $quantity);
                        @endphp
                        <tr>
                            <td>{{ $namaProduk }}</td>
                            <td class="text-center">{{ $quantity }}</td>
                            <td class="text-end">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <form action="{{ route('laporan.destroy', $transaksi->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                <i class="fas fa-trash"></i> Hapus Transaksi
            </button>
        </form>
    </div>
</div>
@endsection

@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Detail Pesanan #{{ $order->order_number }}</h1>
                <a href="{{ route('backend.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                    <p><strong>Nomor Meja:</strong> {{ $order->table_number }}</p>
                    <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p><strong>Status Pembayaran:</strong>
                        @if($order->payment_status === 'paid')
                        <span class="badge bg-success">Terverifikasi</span>
                        @elseif($order->payment_status === 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                        @else
                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                        @endif
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
                    <p><strong>Waktu Pesanan:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h5>Bukti Pembayaran:</h5>
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded" style="max-height: 300px;" alt="Bukti Pembayaran">
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detail Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($order->payment_status === 'pending_verification')
    <div class="mt-3">
        <form action="{{ route('orders.verify', $order) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" name="status" value="verified" class="btn btn-success">
                <i class="fas fa-check"></i> Verifikasi Pembayaran
            </button>
            <button type="submit" name="status" value="rejected" class="btn btn-danger">
                <i class="fas fa-times"></i> Tolak Pembayaran
            </button>
        </form>
    </div>
    @endif
</div>
@endsection

@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3 mb-0">Daftar Pesanan Pelanggan</h1>
        </div>
    </div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('backend.orders.index') }}">Menunggu Verifikasi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backend.orders.verified') }}">Terverifikasi</a>
        </li>
    </ul>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Pesanan Menunggu Verifikasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Pesanan</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->table_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" width="100" alt="Bukti Pembayaran">
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye">Detail</i>
                                    </a>
                                    <form action="{{ route('orders.verify', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" name="status" value="verified" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Terima
                                        </button>
                                        <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

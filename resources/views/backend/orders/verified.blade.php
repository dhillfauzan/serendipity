@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1 class="h3 mb-0">Pesanan Terverifikasi</h1>
        </div>
    </div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backend.orders.index') }}">Menunggu Verifikasi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('backend.orders.verified') }}">Terverifikasi</a>
        </li>
    </ul>
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Daftar Pesanan Terverifikasi</h5>
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
                            <th>Waktu Verifikasi</th>
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
                            <td>{{ $order->payment_verified->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail </a>
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

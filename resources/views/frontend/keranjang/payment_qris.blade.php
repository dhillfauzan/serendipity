@extends('frontend.layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Pembayaran QRIS</h3>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/qris-static.jpg') }}" alt="QRIS" class="img-fluid" style="max-height: 300px;">
                    </div>

                    <div class="order-summary">
                        <h5>Detail Pesanan:</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nomor Pesanan</th>
                                <td>{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Total Pembayaran</th>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="alert alert-success mt-4">
                        <h5>Langkah Pembayaran:</h5>
                        <ol>
                            <li>Scan QR code di atas</li>
                            <li>Verifikasi nominal pembayaran</li>
                            <li>Selesaikan transaksi</li>
                            <li>Upload bukti pembayaran di halaman berikutnya</li>
                        </ol>
                    </div>

                    <a href="{{ route('order.success', $order->order_number) }}" class="btn btn-primary btn-block">
                        Saya Sudah Bayar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

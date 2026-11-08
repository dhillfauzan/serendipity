@extends('frontend.layout.app')

@section('content')
<div class="container d-flex justify-content-center" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="card shadow-sm w-100" style="max-width: 700px;">
        <div class="card-body text-center">
            <h1 class="text-success mb-4">Pesanan Berhasil!</h1>

            <p>Nomor Pesanan: <strong>{{ $order->order_number }}</strong></p>
            <p>Total Pembayaran: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
            <p>Status Pembayaran:
                @if($order->payment_status === 'paid')
                <span class="badge bg-success">Terverifikasi</span>
                @elseif($order->payment_status === 'rejected')
                <span class="badge bg-danger">Ditolak</span>
                @else
                <span class="badge bg-warning">Menunggu Verifikasi</span>
                @endif
            </p>

            @if($order->payment_status === 'pending_verification')
            <div class="alert alert-info mt-4">
                <p class="mb-1">Bukti pembayaran Anda telah kami terima. Kasir akan memverifikasi pembayaran Anda
                    segera.</p>
                <p>Anda dapat menunjukkan nomor pesanan ini ke staf kami.</p>
            </div>
            @endif

            <a href="{{ route('frontend.beranda') }}" class="btn btn-warning mt-3">
                Beranda
            </a>
        </div>
    </div>
</div>
@endsection

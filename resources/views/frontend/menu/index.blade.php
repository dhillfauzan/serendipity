@extends('frontend.layout.app')

@section('hero')
<div class="compact-order-banner text-center text-white">
    <div class="container px-3">
        <span class="badge bg-primary px-3 py-1 rounded-pill text-white shadow-sm small mb-2">
            <i class="fas fa-utensils me-1"></i> Katalog Menu Resto & Cafe
        </span>
        <h1 class="display-6 fw-bold text-white mb-1">Pilihan Menu Serendipity</h1>
        <p class="text-white-50 mb-0 small mx-auto" style="max-width: 500px;">
            Jelajahi menu berdasarkan kategori atau langsung pesan hidangan favorit Anda.
        </p>
    </div>
</div>
@endsection

@section('content')
<div class="container py-4 px-3 px-md-4">
    <!-- Category Cards -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <a href="{{ route('menu.makanan') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 bg-white" style="border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                    <i class="fa fa-hamburger fa-2x text-primary mb-2"></i>
                    <h6 class="fw-bold text-dark mb-1">Makanan</h6>
                    <small class="text-muted">{{ count($makanan) }} Pilihan Menu</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('menu.minuman') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 bg-white" style="border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                    <i class="fa fa-coffee fa-2x text-danger mb-2"></i>
                    <h6 class="fw-bold text-dark mb-1">Minuman</h6>
                    <small class="text-muted">{{ count($minuman) }} Pilihan Menu</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('menu.snack') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 bg-white" style="border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                    <i class="fa fa-cookie-bite fa-2x text-info mb-2"></i>
                    <h6 class="fw-bold text-dark mb-1">Cemilan</h6>
                    <small class="text-muted">{{ count($snack) }} Pilihan Menu</small>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('menu.best') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 bg-white" style="border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                    <i class="fa fa-trophy fa-2x text-warning mb-2"></i>
                    <h6 class="fw-bold text-dark mb-1">Menu Terbaik</h6>
                    <small class="text-muted">{{ count($best) }} Menu Unggulan</small>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Link Back to Full Ordering Home -->
    <div class="text-center">
        <a href="{{ route('frontend.beranda') }}" class="btn btn-warning btn-lg px-4 rounded-pill fw-bold text-dark shadow-sm">
            <i class="fa fa-shopping-bag me-2"></i> Buka Halaman Pemesanan Lengkap
        </a>
    </div>
</div>
@endsection

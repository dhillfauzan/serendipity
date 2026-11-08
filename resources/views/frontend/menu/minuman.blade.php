@extends('frontend.layout.app')

@section('hero')
<div class="compact-order-banner text-center text-white">
    <div class="container px-3">
        <span class="badge bg-danger px-3 py-1 rounded-pill text-white shadow-sm small mb-2">
            <i class="fas fa-mug-hot me-1"></i> Kategori Coffee, Tea & Mocktail
        </span>
        <h1 class="display-6 fw-bold text-white mb-1">Menu Minuman</h1>
        <p class="text-white-50 mb-0 small mx-auto" style="max-width: 500px;">
            Segarnya aneka racikan kopi premium, mocktail buah segar, dan teh aromatik pilihan.
        </p>
    </div>
</div>
@endsection

@section('content')
<div class="container py-4 px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <h5 class="fw-bold mb-0 text-dark">Daftar Menu Minuman ({{ count($minuman) }})</h5>
        <a href="{{ route('frontend.beranda') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="fa fa-arrow-left me-1"></i> Semua Menu
        </a>
    </div>

    <div class="row g-3 g-md-4">
        @forelse($minuman as $idx => $item)
        @php
            $fotoPath = $item->foto ? asset('storage/img-produk/' . $item->foto) : asset('template2/img/menu-' . (($idx % 8) + 1) . '.jpg');
        @endphp
        <div class="col-6 col-md-4 col-lg-3">
            <div class="menu-card h-100">
                <div class="menu-card-img-wrap">
                    <img src="{{ $fotoPath }}" alt="{{ $item->nama_produk }}" class="menu-card-img" onerror="this.onerror=null;this.src='{{ asset('template2/img/menu-1.jpg') }}';">
                    <span class="menu-badge-category">Minuman</span>
                </div>
                <div class="menu-card-body">
                    <h5 class="menu-title">{{ $item->nama_produk }}</h5>
                    <p class="menu-desc">{{ $item->detail ?: 'Minuman segar favorit diracik barista profesional Serendipity.' }}</p>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                        <span class="menu-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <form action="{{ route('add.to.cart') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-order-add" title="Tambah ke keranjang">
                                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Pesan</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            Belum ada menu minuman tersedia.
        </div>
        @endforelse
    </div>
</div>
@endsection

@extends('frontend.layout.app')

@section('hero')
<div class="compact-order-banner text-center text-white">
    <div class="container px-3">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill shadow-sm small mb-2 fw-bold">
            <i class="fas fa-trophy me-1"></i> Rekomendasi Menu Unggulan
        </span>
        <h1 class="display-6 fw-bold text-white mb-1">Rekomendasi Menu Terbaik</h1>
        <p class="text-white-50 mb-0 small mx-auto" style="max-width: 500px;">
            Daftar menu terpopuler dan paling diminati pelanggan dengan cita rasa terbaik di Serendipity.
        </p>
    </div>
</div>
@endsection

@section('content')
<div class="container py-4 px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <h5 class="fw-bold mb-0 text-dark">Rekomendasi Menu Terbaik ({{ count($best) }})</h5>
        <a href="{{ route('frontend.beranda') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="fa fa-arrow-left me-1"></i> Semua Menu
        </a>
    </div>

    <div class="row g-3 g-md-4">
        @forelse($best as $idx => $item)
        @php
            $fotoPath = $item->foto ? asset('storage/img-produk/' . $item->foto) : asset('template2/img/menu-' . (($idx % 8) + 1) . '.jpg');
        @endphp
        <div class="col-6 col-md-4 col-lg-3">
            <div class="menu-card h-100 position-relative" style="border: 2px solid #FEA116;">
                <div class="menu-badge-smart">
                    ⭐ Pilihan Terbaik #{{ $idx + 1 }}
                </div>
                <div class="menu-card-img-wrap">
                    <img src="{{ $fotoPath }}" alt="{{ $item->nama_produk }}" class="menu-card-img" onerror="this.onerror=null;this.src='{{ asset('template2/img/menu-1.jpg') }}';">
                    <span class="menu-badge-category">Terbaik</span>
                </div>
                <div class="menu-card-body">
                    <h5 class="menu-title">{{ $item->nama_produk }}</h5>
                    <p class="menu-desc">{{ $item->detail ?: 'Menu paling direkomendasikan dengan tingkat kepuasan pelanggan tertinggi.' }}</p>

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
            Belum ada menu terbaik tersedia.
        </div>
        @endforelse
    </div>
</div>
@endsection

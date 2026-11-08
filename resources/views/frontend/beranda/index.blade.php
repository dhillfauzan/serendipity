@extends('frontend.layout.app')

@section('hero')
<!-- Header Banner Minimalis untuk Pemesanan Resto -->
<div class="compact-order-banner text-center text-white">
    <div class="container px-3">
        <div class="d-inline-flex align-items-center mb-2">
            <span class="badge bg-success px-3 py-1 rounded-pill text-white shadow-sm small">
                <i class="fas fa-circle text-white me-1" style="font-size: 8px;"></i> Buka • Siap Menerima Pesanan
            </span>
            <span class="text-white-50 ms-2 small d-none d-sm-inline">Dine In & Takeaway</span>
        </div>

        <h1 class="display-6 fw-bold text-white mb-1">
            Menu Pemesanan Serendipity
        </h1>
        <p class="text-white-50 mb-3 small mx-auto" style="max-width: 550px;">
            Pilih menu makanan & minuman favorit Anda di bawah ini dan tambahkan ke keranjang untuk proses pemesanan yang cepat.
        </p>

        <!-- Kotak Pencarian Menu Interaktif -->
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            <div class="input-group shadow-sm bg-white rounded-pill overflow-hidden p-1 border">
                <span class="input-group-text bg-transparent border-0 ps-3 text-muted">
                    <i class="fa fa-search text-warning"></i>
                </span>
                <input type="text" id="liveSearchInput" class="form-control border-0 shadow-none ps-2" placeholder="Cari makanan, kopi, teh, cemilan..." onkeyup="filterMenuSearch()">
                <button class="btn btn-warning rounded-pill px-3 py-1 fw-bold text-dark d-none d-sm-block" type="button" onclick="filterMenuSearch()">
                    Cari
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container py-4 px-3 px-md-4">

    <!-- ================= 1. REKOMENDASI MENU TERBAIK ================= -->
    @if(isset($menuTerbaikSmart) && count($menuTerbaikSmart) > 0)
    <section class="mb-5" id="section-smart-best">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h4 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <span class="fs-4 me-2">🏆</span> Rekomendasi Menu Terbaik
                </h4>
                <p class="text-muted small mb-0">Menu pilihan terfavorit dan paling banyak dipesan di Serendipity</p>
            </div>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm mt-2 mt-sm-0">
                ⭐ Rekomendasi Teratas
            </span>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($menuTerbaikSmart->take(4) as $idx => $item)
            @php
                $fotoPath = $item->foto ? asset('storage/img-produk/' . $item->foto) : asset('template2/img/menu-' . (($idx % 8) + 1) . '.jpg');
                $rank = $item->smart_rank ?? ($idx + 1);
            @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <div class="menu-card h-100 position-relative" style="border: 2px solid #FEA116;">
                    <!-- Badge Ranking -->
                    <div class="menu-badge-smart">
                        @if($rank == 1)
                        🥇 Pilihan Terbaik #1
                        @elseif($rank == 2)
                        🥈 Pilihan Terbaik #2
                        @elseif($rank == 3)
                        🥉 Pilihan Terbaik #3
                        @else
                        ⭐ Pilihan Terbaik #{{ $rank }}
                        @endif
                    </div>

                    <!-- Foto Menu -->
                    <div class="menu-card-img-wrap">
                        <img src="{{ $fotoPath }}" alt="{{ $item->nama_produk }}" class="menu-card-img" onerror="this.onerror=null;this.src='{{ asset('template2/img/menu-1.jpg') }}';">
                    </div>

                    <!-- Isi Card -->
                    <div class="menu-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-light text-primary border" style="font-size: 0.68rem;">
                                {{ $item->katagori ? $item->katagori->nama_katagori : 'Menu Terbaik' }}
                            </span>
                            <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.68rem;">
                                ⭐ Terfavorit
                            </span>
                        </div>

                        <h5 class="menu-title">{{ $item->nama_produk }}</h5>
                        <p class="menu-desc">{{ $item->detail ?: 'Menu pilihan terbaik dengan cita rasa khas Serendipity.' }}</p>

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
            @endforeach
        </div>
    </section>
    @endif

    <!-- ================= 2. KATALOG LENGKAP SEMUA MENU PEMESANAN ================= -->
    <section id="section-katalog-menu">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="fas fa-utensils text-primary me-2"></i>Daftar Menu Pemesanan
                </h4>
                <p class="text-muted small mb-0">Sentuh kategori untuk memfilter menu makanan dan minuman</p>
            </div>
            <div id="item-count-badge" class="badge bg-light text-dark border px-3 py-2 rounded-pill small mt-2 mt-sm-0">
                Menampilkan <span id="filtered-count">{{ count($allProduk) }}</span> Menu
            </div>
        </div>

        <!-- Sticky Horizontal Category Chips / Pills -->
        <div class="category-nav-scroll mb-4 sticky-top bg-light py-2" style="top: 56px; z-index: 1020;">
            <button class="category-chip active" onclick="filterCategory('all', this)">
                <i class="fas fa-th-large"></i> Semua Menu
            </button>
            <button class="category-chip" onclick="filterCategory('best', this)">
                <i class="fas fa-star text-warning"></i> Menu Terbaik
            </button>
            <button class="category-chip" onclick="filterCategory('minuman', this)">
                <i class="fas fa-mug-hot text-danger"></i> Minuman
            </button>
            <button class="category-chip" onclick="filterCategory('makanan', this)">
                <i class="fas fa-hamburger text-primary"></i> Makanan
            </button>
            <button class="category-chip" onclick="filterCategory('snack', this)">
                <i class="fas fa-cookie-bite text-info"></i> Cemilan
            </button>
        </div>

        <!-- Grid Menu Produk Responsive -->
        <div class="row g-3 g-md-4" id="menu-grid-container">
            @forelse($allProduk as $idx => $item)
            @php
                $fotoPath = $item->foto ? asset('storage/img-produk/' . $item->foto) : asset('template2/img/menu-' . (($idx % 8) + 1) . '.jpg');
                $kategoriClass = 'all';
                $kategoriLabel = 'Menu';

                if ($item->katagori_id == 1) {
                    $kategoriClass .= ' makanan';
                    $kategoriLabel = 'Makanan';
                } elseif ($item->katagori_id == 2) {
                    $kategoriClass .= ' minuman';
                    $kategoriLabel = 'Minuman';
                } elseif ($item->katagori_id == 3) {
                    $kategoriClass .= ' snack';
                    $kategoriLabel = 'Cemilan';
                } elseif ($item->katagori_id == 4) {
                    $kategoriClass .= ' best minuman';
                    $kategoriLabel = 'Terbaik';
                }
            @endphp
            <div class="col-6 col-md-4 col-lg-3 menu-item-card {{ $kategoriClass }}" data-name="{{ strtolower($item->nama_produk) }}" data-category="{{ $kategoriClass }}">
                <div class="menu-card">
                    <!-- Foto Menu -->
                    <div class="menu-card-img-wrap">
                        <img src="{{ $fotoPath }}" alt="{{ $item->nama_produk }}" class="menu-card-img" onerror="this.onerror=null;this.src='{{ asset('template2/img/menu-1.jpg') }}';">
                        <span class="menu-badge-category">{{ $kategoriLabel }}</span>
                        @if($item->katagori_id == 4)
                        <span class="menu-badge-smart">⭐ Best</span>
                        @endif
                    </div>

                    <!-- Konten Menu -->
                    <div class="menu-card-body">
                        <h5 class="menu-title">{{ $item->nama_produk }}</h5>
                        <p class="menu-desc">{{ $item->detail ?: 'Menu pilihan dengan bahan berkualitas dan racikan terbaik.' }}</p>

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
            <div class="col-12 text-center py-5">
                <i class="fas fa-utensils fa-3x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada menu tersedia saat ini.</h5>
            </div>
            @endforelse
        </div>

        <!-- Pesan Jika Hasil Pencarian Kosong -->
        <div id="empty-search-message" class="text-center py-5 d-none">
            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
            <h5 class="text-dark fw-bold">Menu tidak ditemukan</h5>
            <p class="text-muted small">Coba cari dengan kata kunci lain (misal: "kopi", "teh", "nasi", "steak").</p>
            <button class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="resetSearch()">
                Tampilkan Semua Menu
            </button>
        </div>
    </section>

</div>

@endsection

@section('scripts')
<script>
let currentCategory = 'all';

// ================= FILTER BERDASARKAN KATEGORI =================
function filterCategory(category, buttonElement) {
    currentCategory = category;

    // Update active class pada tombol chip
    document.querySelectorAll('.category-chip').forEach(btn => {
        btn.classList.remove('active');
    });
    if (buttonElement) {
        buttonElement.classList.add('active');
    }

    applyFilters();
}

// ================= PENCARIAN LIVE DI MENU =================
function filterMenuSearch() {
    applyFilters();
}

// ================= GABUNGKAN FILTER KATEGORI & SEARCH =================
function applyFilters() {
    let searchVal = document.getElementById('liveSearchInput').value.toLowerCase().trim();
    let cards = document.querySelectorAll('.menu-item-card');
    let visibleCount = 0;

    cards.forEach(card => {
        let name = card.getAttribute('data-name') || '';
        let categories = card.getAttribute('data-category') || '';

        let matchCategory = (currentCategory === 'all') || categories.includes(currentCategory);
        let matchSearch = (searchVal === '') || name.includes(searchVal);

        if (matchCategory && matchSearch) {
            card.classList.remove('d-none');
            visibleCount++;
        } else {
            card.classList.add('d-none');
        }
    });

    // Update badge jumlah item
    document.getElementById('filtered-count').innerText = visibleCount;

    // Tampilkan pesan jika kosong
    let emptyMsg = document.getElementById('empty-search-message');
    if (visibleCount === 0) {
        emptyMsg.classList.remove('d-none');
    } else {
        emptyMsg.classList.add('d-none');
    }
}

function resetSearch() {
    document.getElementById('liveSearchInput').value = '';
    filterCategory('all', document.querySelector('.category-chip'));
}
</script>
@endsection

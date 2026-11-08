<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Coffee & Resto Serendipity - Pemesanan Menu Online</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Pemesanan Makanan dan Minuman Cafe & Resto Serendipity" name="description">

    <!-- Favicon -->
    <link href="{{ asset('template2/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template2/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template2/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template2/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template2/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template2/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
            --primary-color: #FEA116;
            --dark-color: #0F172B;
        }

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        main {
            flex: 1 0 auto;
            width: 100%;
        }

        /* Footer Sticky & Responsif */
        .frontend-footer {
            flex-shrink: 0;
            margin-top: auto !important;
            background-color: #0F172B !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 2.5rem 0 1.5rem 0;
            width: 100%;
        }

        .frontend-footer a.hover-warning {
            color: #94a3b8 !important;
            transition: color 0.2s ease;
        }

        .frontend-footer a.hover-warning:hover {
            color: #FEA116 !important;
        }

        /* Navbar Styling */
        .navbar-ordering {
            background-color: #0F172B !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .navbar-brand-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #FEA116 !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.92rem;
            color: #cbd5e1 !important;
            transition: color 0.2s;
            padding: 0.5rem 0.9rem !important;
        }

        .nav-link:hover, .nav-link.active {
            color: #FEA116 !important;
        }

        /* Compact Header / Ordering Banner */
        .compact-order-banner {
            background: linear-gradient(135deg, rgba(15, 23, 43, 0.95), rgba(15, 23, 43, 0.88)), url('{{ asset('template2/img/bg-hero.jpg') }}');
            background-size: cover;
            background-position: center;
            border-bottom: 3px solid #FEA116;
            padding: 2.2rem 0 2rem 0;
        }

        /* Modern Food Menu Card */
        .menu-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .menu-card-img-wrap {
            position: relative;
            width: 100%;
            padding-top: 75%; /* 4:3 Aspect Ratio */
            overflow: hidden;
            background: #f1f5f9;
        }

        .menu-card-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .menu-card:hover .menu-card-img {
            transform: scale(1.06);
        }

        .menu-badge-smart {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #FEA116 0%, #e67e22 100%);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 2;
        }

        .menu-badge-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(15, 23, 43, 0.75);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            z-index: 2;
        }

        .menu-card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .menu-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.35rem;
            line-height: 1.3;
        }

        .menu-desc {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            flex-grow: 1;
        }

        .menu-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: #d97706;
        }

        .btn-order-add {
            background-color: #FEA116;
            color: #0F172B;
            font-weight: 700;
            font-size: 0.85rem;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            transition: all 0.2s ease;
        }

        .btn-order-add:hover {
            background-color: #e6900f;
            color: #000;
            transform: scale(1.03);
        }

        /* Category Filter Chips / Pills */
        .category-nav-scroll {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            white-space: nowrap;
            padding: 4px 2px 10px 2px;
            scrollbar-width: none;
        }

        .category-nav-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-chip {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 8px 18px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .category-chip:hover, .category-chip.active {
            background: #FEA116;
            border-color: #FEA116;
            color: #0F172B;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(254, 161, 22, 0.3);
        }

        /* Floating Mobile Cart Bar */
        .mobile-floating-cart {
            position: fixed;
            bottom: 16px;
            left: 16px;
            right: 16px;
            z-index: 1040;
        }

        @media (max-width: 576px) {
            .menu-title {
                font-size: 0.95rem;
            }
            .menu-price {
                font-size: 1rem;
            }
            .menu-card-body {
                padding: 0.75rem;
            }
            .btn-order-add {
                padding: 5px 10px;
                font-size: 0.78rem;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Flash Toast Notifikasi Berhasil Ditambahkan -->
    @if(session('success'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; max-width: 90%;">
        <div class="alert alert-success alert-dismissible shadow-lg fade show d-flex align-items-center py-2 px-4 rounded-pill" role="alert">
            <i class="fa fa-check-circle me-2 text-success fs-5"></i>
            <span class="small fw-bold">{{ session('success') }}</span>
            <a href="{{ route('cart') }}" class="btn btn-sm btn-dark rounded-pill ms-3 py-1 px-3 fw-bold small">Lihat Keranjang</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding: 12px;"></button>
        </div>
    </div>
    @endif

    <!-- Navbar Pemesanan Resto (Sticky & Minimalis) -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-ordering sticky-top px-3 px-lg-5 py-2">
        <div class="container-fluid px-0">
            <a href="{{ route('frontend.beranda') }}" class="navbar-brand d-flex align-items-center p-0">
                <i class="fa fa-utensils text-primary fs-3 me-2"></i>
                <div>
                    <span class="navbar-brand-title d-block lh-1">Serendipity</span>
                    <small class="text-white-50" style="font-size: 0.68rem; letter-spacing: 0.5px;">COFFEE & RESTO</small>
                </div>
            </a>

            <!-- Tombol Keranjang Cepat di Mobile -->
            <a href="{{ route('cart') }}" class="btn btn-warning btn-sm d-lg-none position-relative rounded-pill px-3 py-1 fw-bold text-dark me-2">
                <i class="fa fa-shopping-cart"></i>
                @if(session('cart') && count(session('cart')) > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                    {{ count(session('cart')) }}
                </span>
                @endif
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOrderingCollapse">
                <span class="fa fa-bars text-white"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarOrderingCollapse">
                <ul class="navbar-nav mx-auto py-2 py-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('frontend.beranda') }}" class="nav-link {{ request()->routeIs('frontend.beranda') ? 'active' : '' }}">
                            <i class="fa fa-home me-1"></i> Beranda Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu.makanan') }}" class="nav-link {{ request()->routeIs('menu.makanan') ? 'active' : '' }}">
                            <i class="fa fa-hamburger me-1"></i> Makanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu.minuman') }}" class="nav-link {{ request()->routeIs('menu.minuman') ? 'active' : '' }}">
                            <i class="fa fa-coffee me-1"></i> Minuman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu.snack') }}" class="nav-link {{ request()->routeIs('menu.snack') ? 'active' : '' }}">
                            <i class="fa fa-cookie-bite me-1"></i> Cemilan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu.best') }}" class="nav-link {{ request()->routeIs('menu.best') ? 'active' : '' }}">
                            <i class="fa fa-star text-warning me-1"></i> Rekomendasi Menu Terbaik
                        </a>
                    </li>
                </ul>

                <!-- Tombol Keranjang di Desktop -->
                <div class="d-none d-lg-flex align-items-center">
                    <a href="{{ route('cart') }}" class="btn btn-warning position-relative px-4 py-2 fw-bold text-dark rounded-pill shadow-sm">
                        <i class="fa fa-shopping-cart me-2"></i>
                        <span>Keranjang Pesanan</span>
                        @if(session('cart') && count(session('cart')) > 0)
                        <span class="badge bg-danger rounded-pill ms-2">
                            {{ count(session('cart')) }}
                        </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header / Banner Section -->
    @yield('hero')

    <!-- Main Content Section -->
    <main>
        @yield('content')
    </main>

    <!-- Floating Mobile Cart Bar (Smartphone & Tablet) -->
    @if(session('cart') && count(session('cart')) > 0)
    @php
        $cartCount = 0;
        $cartTotal = 0;
        foreach(session('cart') as $c) {
            $cartCount += $c['quantity'];
            $cartTotal += $c['price'] * $c['quantity'];
        }
    @endphp
    <div class="mobile-floating-cart d-lg-none">
        <a href="{{ route('cart') }}" class="btn btn-warning text-dark w-100 py-2 px-3 rounded-pill shadow-lg d-flex justify-content-between align-items-center" style="border: 2px solid #fff;">
            <div class="d-flex align-items-center">
                <div class="bg-dark text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                    <i class="fa fa-shopping-cart" style="font-size: 14px;"></i>
                </div>
                <div class="text-start">
                    <span class="fw-bold d-block lh-1" style="font-size: 13px;">{{ $cartCount }} Menu Dipilih</span>
                    <small class="text-dark fw-extrabold" style="font-size: 11px;">Total: Rp {{ number_format($cartTotal, 0, ',', '.') }}</small>
                </div>
            </div>
            <span class="badge bg-dark text-white rounded-pill px-3 py-2 fw-bold" style="font-size: 12px;">
                Lihat Keranjang <i class="fa fa-arrow-right ms-1"></i>
            </span>
        </a>
    </div>
    @endif

    <!-- Footer Sticky & Responsif untuk Semua Device -->
    <footer class="frontend-footer bg-dark text-light">
        <div class="container px-3 px-md-4">
            <div class="row g-4 justify-content-between align-items-center pb-3 border-bottom border-secondary border-opacity-25">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2">
                        <i class="fa fa-utensils text-warning fs-5 me-2"></i>
                        <h5 class="text-warning mb-0 fw-bold">Serendipity</h5>
                        <span class="text-white-50 ms-2 small" style="font-size: 0.72rem; letter-spacing: 0.5px;">COFFEE & RESTO</span>
                    </div>
                    <p class="text-white-50 small mb-0 mx-auto mx-md-0" style="max-width: 420px; font-size: 0.82rem;">
                        Menyajikan aneka kopi khas, teh segar, hidangan lezat, dan cemilan favorit dengan cita rasa terbaik untuk menemani hari Anda.
                    </p>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-3 mb-2 small fw-semibold">
                        <a href="{{ route('frontend.beranda') }}" class="hover-warning text-decoration-none">Beranda</a>
                        <a href="{{ route('menu.makanan') }}" class="hover-warning text-decoration-none">Makanan</a>
                        <a href="{{ route('menu.minuman') }}" class="hover-warning text-decoration-none">Minuman</a>
                        <a href="{{ route('menu.snack') }}" class="hover-warning text-decoration-none">Cemilan</a>
                        <a href="{{ route('menu.best') }}" class="text-warning text-decoration-none fw-bold">Menu Terbaik</a>
                        <a href="{{ route('cart') }}" class="hover-warning text-decoration-none">Keranjang</a>
                    </div>
                    <div class="text-white-50 small" style="font-size: 0.78rem;">
                        <i class="fas fa-clock text-warning me-1"></i> Buka Setiap Hari: 09:00 - 23:00 WIB
                    </div>
                </div>
            </div>
            <div class="pt-3 text-center text-white-50 small" style="font-size: 0.75rem;">
                &copy; 2026 Coffee & Resto Serendipity. Layanan Pemesanan Meja & Online. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template2/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('template2/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template2/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('template2/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('template2/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    @yield('scripts')
</body>

</html>

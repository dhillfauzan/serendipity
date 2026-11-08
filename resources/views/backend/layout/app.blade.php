<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Coffee & Resto Serendipity</title>


    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template/html/assets/images/favicon.ico') }}">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('template/html/assets/css/core/libs.min.css') }}">

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('template/html/assets/css/hope-ui.min.css?v=5.0.0') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('template/html/assets/css/custom.min.css?v=5.0.0') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('template/html/assets/css/customizer.min.css?v=5.0.0') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('template/html/assets/css/rtl.min.css?v=5.0.0') }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- High-Contrast Table Styling & Responsive Enhancements -->
    <style>
        .table thead th,
        .table thead.table-dark th,
        table thead.table-dark th,
        .table-dark th {
            background-color: #1e293b !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-color: #334155 !important;
            vertical-align: middle !important;
        }
        .table tbody td {
            color: #1e293b;
            vertical-align: middle;
        }

        /* Layout & Sticky Footer Setup */
        .main-content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f6fa;
        }

        .main-body-container {
            flex: 1 0 auto;
            width: 100%;
        }

        .main-content .footer {
            margin-top: auto !important;
            padding: 1rem 1.5rem !important;
            background-color: #ffffff !important;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }

        /* Navbar Layout & Toggle Button (Fix Tabrakan Logo Rumah) */
        .iq-navbar .navbar-inner {
            padding: 0.6rem 1rem !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .iq-navbar .sidebar-toggle {
            position: static !important;
            left: auto !important;
            top: auto !important;
            right: auto !important;
            transform: none !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
            padding: 0 !important;
            margin: 0 10px 0 0 !important;
            border-radius: 50% !important;
            background-color: #3a57e8 !important;
            color: #ffffff !important;
            flex-shrink: 0 !important;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(58, 87, 232, 0.3);
        }

        @media (min-width: 1200px) {
            .iq-navbar .sidebar-toggle {
                display: none !important;
            }
        }

        .iq-navbar .navbar-brand {
            display: inline-flex !important;
            align-items: center !important;
            margin: 0 !important;
            padding: 0 !important;
            text-decoration: none !important;
            flex-shrink: 1;
            overflow: hidden;
        }

        .iq-navbar .navbar-brand .logo-main {
            display: inline-flex !important;
            align-items: center;
            margin-right: 8px !important;
            flex-shrink: 0;
        }

        .iq-navbar .navbar-brand .logo-title {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            white-space: nowrap !important;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            margin: 0 !important;
        }

        /* Responsive Mobile & Tablet Backend Enhancements */
        @media (max-width: 991.98px) {
            .iq-navbar .navbar-inner {
                padding: 0.5rem 0.75rem !important;
            }
            .iq-navbar .navbar-brand .logo-title {
                font-size: 1.05rem !important;
            }
            .iq-navbar .navbar-toggler {
                flex-shrink: 0;
                padding: 4px 8px;
            }
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            .card-header {
                padding: 12px 14px !important;
            }
            .card-body {
                padding: 14px 10px !important;
            }
        }

        /* Responsive Table Horizontal Scrolling */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }
    </style>
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
            </div>
        </div>
    </div>
    <!-- loader END -->

    <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ route('backend.beranda') }}" class="navbar-brand">
                <div class="logo-main">
                    <!-- Logo Normal -->
                    <div class="logo-normal">
                        <svg class="icon-30" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Atap rumah -->
                            <polygon points="32,10 10,28 54,28" fill="none" stroke="currentColor" stroke-width="2" />

                            <!-- Dinding rumah -->
                            <rect x="16" y="28" width="32" height="26" fill="none" stroke="currentColor" stroke-width="2" />

                            <!-- Garpu (di kiri) -->
                            <line x1="22" y1="32" x2="22" y2="48" stroke="currentColor" stroke-width="2" />
                            <line x1="20.5" y1="32" x2="20.5" y2="38" stroke="currentColor" stroke-width="1.5" />
                            <line x1="22" y1="32" x2="22" y2="38" stroke="currentColor" stroke-width="1.5" />
                            <line x1="23.5" y1="32" x2="23.5" y2="38" stroke="currentColor" stroke-width="1.5" />

                            <!-- Sendok (di kanan) -->
                            <path d="M42 32 C44 32, 44 36, 42 36 C40 36, 40 32, 42 32 Z" fill="currentColor" />
                            <line x1="42" y1="36" x2="42" y2="48" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>

                </div>
                <h5 class="logo-title"> Serendipity</h5>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>

        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.beranda') }}">
                            <i class="icon">📊</i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>

                    <!-- User Management (Hanya Admin) -->
                    @if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.user.index') }}">
                            <i class="icon">👥</i>
                            <span class="item-name">User</span>
                        </a>
                    </li>
                    @endif

                    <!-- Produk (Tampilkan untuk semua, tapi beda isi dropdown) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="produkDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon">🍔</i>
                            <span class="item-name">Produk</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="produkDropdown">
                            @if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                            <!-- Tampilkan Kategori hanya untuk Admin -->
                            <li><a class="dropdown-item" href="{{ route('backend.katagori.index') }}">Kategori</a></li>
                            @endif
                            <!-- Tampilkan Produk untuk semua role -->
                            <li><a class="dropdown-item" href="{{ route('backend.produk.index') }}">Produk</a></li>
                        </ul>
                    </li>

                    <!-- Laporan (Hanya Admin) -->
                    @if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon">📋</i>
                            <span class="item-name">Laporan</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="laporanDropdown">
                            <li><a class="dropdown-item" href="{{ route('backend.laporan.formuser') }}">User</a></li>
                            <li><a class="dropdown-item" href="{{ route('backend.laporan.formproduk') }}">Produk</a></li>
                        </ul>
                    </li>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 2)
                    <!-- Kasir -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kasir.index') }}">
                            <i class="icon">💵</i>
                            <span class="item-name">Kasir</span>
                        </a>
                    </li>

                    <!-- Order Item -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.orders.index') }}">
                            <i class="icon">🛒</i>
                            <span class="item-name">Order Item</span>
                            @if($pendingOrdersCount > 0)
                            <span class="badge bg-danger">{{ $pendingOrdersCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif

                    <! SPK SMART !>
                    @if(Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#spkMenu" role="button" aria-expanded="false">
                            <i class="icon">🧠</i>
                            <span class="item-name">SPK SMART</span>
                        </a>

                        <ul class="sub-nav collapse" id="spkMenu">

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('smart.kriteria') }}">
                                    <i class="icon">📋</i>
                                    <span class="item-name">Input Kriteria</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('smart.bobot') }}">
                                    <i class="icon">⚖️</i>
                                    <span class="item-name">Bobot</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('smart.perhitungan') }}">
                                    <i class="icon">🧮</i>
                                    <span class="item-name">Perhitungan</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('smart.hasil') }}">
                                    <i class="icon">🏆</i>
                                    <span class="item-name">Hasil</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    <!-- Laporan Kasir -->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.index') }}">
                            <i class="icon">📈</i>
                            <span class="item-name">Laporan Kasir</span>
                        </a>
                    </li>


                    <!-- Logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon">🚪</i>
                            <span class="item-name">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('backend.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                <!-- Sidebar Menu End -->
            </div>
        </div>

        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <!--Nav Start-->
        <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar">
            <div class="container-fluid navbar-inner">
                <div class="d-flex align-items-center flex-shrink-1 overflow-hidden">
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true" title="Toggle Sidebar">
                        <i class="icon">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <a href="{{ route('backend.beranda') }}" class="navbar-brand">
                        <div class="logo-main">
                            <!-- Logo Normal -->
                            <div class="logo-normal">
                                <svg class="icon-30" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Atap rumah -->
                                    <polygon points="32,10 10,28 54,28" fill="none" stroke="currentColor" stroke-width="2" />

                                    <!-- Dinding rumah -->
                                    <rect x="16" y="28" width="32" height="26" fill="none" stroke="currentColor" stroke-width="2" />

                                    <!-- Garpu (di kiri) -->
                                    <line x1="22" y1="32" x2="22" y2="48" stroke="currentColor" stroke-width="2" />
                                    <line x1="20.5" y1="32" x2="20.5" y2="38" stroke="currentColor" stroke-width="1.5" />
                                    <line x1="22" y1="32" x2="22" y2="38" stroke="currentColor" stroke-width="1.5" />
                                    <line x1="23.5" y1="32" x2="23.5" y2="38" stroke="currentColor" stroke-width="1.5" />

                                    <!-- Sendok (di kanan) -->
                                    <path d="M42 32 C44 32, 44 36, 42 36 C40 36, 40 32, 42 32 Z" fill="currentColor" />
                                    <line x1="42" y1="36" x2="42" y2="48" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </div>
                        </div>
                        <h5 class="logo-title mb-0">Serendipity</h5>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <span class="mt-2 navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                        @auth
                        <li class="nav-item dropdown custom-drop">
                            <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->foto)
                                <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" alt="user" class="rounded-circle" width="31">
                                @else
                                <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user" class="rounded-circle" width="31">
                                @endif
                                <div class="caption ms-3 d-none d-md-block">
                                    <h6 class="mb-0 caption-title">{{ Auth::user()->nama }}</h6>
                                    <p class="mb-0 caption-sub-title">
                                        @if (Auth::user()->role == 1)
                                        Super Admin
                                        @elseif (Auth::user()->role == 0)
                                        Admin
                                        @endif
                                    </p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('backend.user.edit', Auth::user()->id) }}">Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <button class="dropdown-item" type="button" onclick="document.getElementById('keluar-app').submit();">
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>

            </div>
        </nav>
        <!-- Nav End -->

        <!-- Main Content Body -->
        <div class="main-body-container py-3">
            @yield('content')
        </div>

        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <ul class="left-panel list-inline mb-0 p-0 text-center text-sm-start">
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none small">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none small">Terms of Use</a></li>
                </ul>
                <div class="right-panel text-muted small text-center text-sm-end">
                    © <script>
                        document.write(new Date().getFullYear())

                    </script> Serendipity Coffee & Resto. All rights reserved.
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>
    <!-- Wrapper End-->

    <!-- sweetalert -->
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- sweetalert End -->
    <!-- konfirmasi success-->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: 'Berhasil!'
            , text: "{{ session('success') }}"
        });

    </script>
    @endif
    <!-- sweetalert -->

    <!-- Script Hapus User-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-confirm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-nama');
                    const form = document.getElementById(`delete-form-${userId}`);

                    Swal.fire({
                        title: 'Apakah Anda yakin?'
                        , text: `Data pengguna "${userName}" akan dihapus!`
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Ya, hapus!'
                        , cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

    </script>
    <!-- Script Hapus user end -->

    <!-- Script Hapus kategori -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.show_confirm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the form submission on click

                    const nama_katagori = this.getAttribute('data-konf-delete'); // Pastikan mengambil data-konf-delete

                    Swal.fire({
                        title: 'Apakah Anda yakin?'
                        , text: `Kategori "${nama_katagori}" akan dihapus!`
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Ya, hapus!'
                        , cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });

    </script>
    <!-- Script Hapus kategori end -->

    <script>
        // previewFoto
        function previewFoto() {
            const foto = document.querySelector('input[name="foto"]');
            const fotoPreview = document.querySelector('.foto-preview');
            fotoPreview.style.display = 'block';
            const fotoReader = new FileReader();
            fotoReader.readAsDataURL(foto.files[0]);
            fotoReader.onload = function(fotoEvent) {
                fotoPreview.src = fotoEvent.target.result;
                fotoPreview.style.width = '100%';
            }
        }

    </script>

    </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <!-- <script
          src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script> -->
    <script>
        ClassicEditor.create(document.querySelector('#ckeditor')).catch(error => {
            console.error(error);
        });

    </script>

    <!-- Library Bundle Script -->
    <script src="{{ asset('template/html/assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('template/html/assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('template/html/assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('template/html/assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('template/html/assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('template/html/assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('template/html/assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('template/html/assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('template/html/assets/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->

    <!-- App Script -->
    <script src="{{ asset('template/html/assets/js/hope-ui.js') }}" defer></script>



</body>

</html>

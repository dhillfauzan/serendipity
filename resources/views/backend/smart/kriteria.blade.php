@extends('backend.layout.app')

@section('content')

<div class="container-fluid">

    <style>
        /* Table Styling Spesifik untuk Kontras Tinggi & Teks Jelas */
        .table-smart thead th {
            background-color: #1e293b !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 13.5px !important;
            text-align: center !important;
            vertical-align: middle !important;
            border: 1px solid #334155 !important;
            padding: 12px 10px !important;
        }
        .table-smart tbody td {
            vertical-align: middle !important;
            font-size: 13px !important;
            color: #0f172a !important;
            border-color: #e2e8f0 !important;
        }
        .table-smart tbody tr:hover {
            background-color: #f8fafc !important;
        }
        .cell-value-dark {
            color: #0f172a !important;
            font-weight: 700 !important;
            font-size: 13.5px;
        }
        @media (max-width: 768px) {
            .table-smart thead th, .table-smart tbody td {
                padding: 8px 6px !important;
                font-size: 12px !important;
            }
            .cell-value-dark {
                font-size: 12px !important;
            }
            .btn-action-edit, .btn-action-delete {
                padding: 4px 7px !important;
                font-size: 11px !important;
            }
        }
    </style>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 py-3">
            <div>
                <h4 class="text-white mb-1 fs-5 fs-md-4"><i class="fas fa-brain me-2"></i>SPK SMART - Data Penjualan Menu Cafe & Resto</h4>
                <p class="mb-0 text-white-50 small">Sistem Penunjang Keputusan metode SMART untuk menentukan menu terbaik berdasarkan data penjualan</p>
            </div>
            <span class="badge bg-light text-primary fs-7 px-3 py-2 text-nowrap align-self-start align-self-md-auto shadow-sm">
                <i class="fas fa-database me-1"></i> Total: {{ count($dataPenjualan) }} Menu Tersimpan
            </span>
        </div>

        <div class="card-body">

            <!-- ACTION BUTTONS & FILTER -->
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-12 col-xl-8 d-flex flex-wrap gap-2">
                    <!-- Tombol Tambah Manual -->
                    <button type="button" class="btn btn-sm btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahManual">
                        <i class="fas fa-plus-circle me-1"></i> + Tambah Data Manual
                    </button>

                    <!-- Tombol Import Excel -->
                    <button type="button" class="btn btn-sm btn-info text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                        <i class="fas fa-file-excel me-1"></i> 📊 Tambah / Import Excel
                    </button>

                    <!-- Tombol Ambil Data dari Laporan Kasir -->
                    <button type="button" class="btn btn-sm btn-primary fw-bold text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAmbilKasir">
                        <i class="fas fa-cash-register me-1"></i> 🛒 Ambil Data Laporan Kasir
                    </button>

                    <!-- Tombol Download Template -->
                    <a href="{{ route('smart.exportTemplate') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download me-1"></i> Template CSV
                    </a>

                    <!-- Tombol Reset / Default -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sync-alt me-1"></i> Kelola Database
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item text-primary" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalAmbilKasir">
                                    <i class="fas fa-cash-register me-2"></i> Sinkronkan Penjualan Kasir
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('smart.resetData') }}" method="POST" onsubmit="return confirm('Kembalikan database ke 50 data menu Excel Serendipity 2025?')">
                                    @csrf
                                    <input type="hidden" name="action" value="default">
                                    <button type="submit" class="dropdown-item text-secondary">
                                        <i class="fas fa-undo me-2"></i> Muat Ulang 50 Data Excel 2025
                                    </button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('smart.resetData') }}" method="POST" onsubmit="return confirm('Yakin ingin mengosongkan semua data dari database?')">
                                    @csrf
                                    <input type="hidden" name="action" value="empty">
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash-alt me-2"></i> Kosongkan Database
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- FILTER KATEGORI -->
                <div class="col-12 col-xl-4 text-start text-xl-end">
                    <div class="d-inline-flex align-items-center gap-2 flex-wrap justify-content-start justify-content-xl-end">
                        <label class="fw-bold text-muted small text-nowrap">Filter Kategori:</label>
                        <select class="form-select form-select-sm" style="width: auto; max-width: 100%;" onchange="location = this.value;">
                            <option value="{{ route('smart.kriteria', ['kategori' => 'all']) }}" {{ $filterKategori == 'all' ? 'selected' : '' }}>
                                Semua Kategori ({{ \App\Models\SmartPenjualan::count() }})
                            </option>
                            <option value="{{ route('smart.kriteria', ['kategori' => 'minuman']) }}" {{ $filterKategori == 'minuman' ? 'selected' : '' }}>
                                Menu Minuman (Coffee, Tea, Mocktail, Choc)
                            </option>
                            <option value="{{ route('smart.kriteria', ['kategori' => 'makanan']) }}" {{ $filterKategori == 'makanan' ? 'selected' : '' }}>
                                Menu Makanan
                            </option>
                            <option value="{{ route('smart.kriteria', ['kategori' => 'snack']) }}" {{ $filterKategori == 'snack' ? 'selected' : '' }}>
                                Menu Snack / Cemilan
                            </option>
                        </select>
                    </div>
                </div>
            </div>
                            <option value="{{ route('smart.kriteria', ['kategori' => 'makanan']) }}" {{ $filterKategori == 'makanan' ? 'selected' : '' }}>
                                Menu Makanan
                            </option>
                            <option value="{{ route('smart.kriteria', ['kategori' => 'snack']) }}" {{ $filterKategori == 'snack' ? 'selected' : '' }}>
                                Menu Snack / Cemilan
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- KETERANGAN SKALA LIKERT INFO BOX -->
            <div class="alert alert-light border mb-4 py-2 px-3 small">
                <div class="d-flex justify-content-between align-items-center cursor-pointer" data-bs-toggle="collapse" data-bs-target="#boxSkala" style="cursor: pointer;">
                    <span class="fw-bold text-dark"><i class="fas fa-info-circle text-primary me-2"></i>Keterangan Skala Likert Kriteria SMART (Klik untuk lihat pedoman penilaian)</span>
                    <i class="fas fa-chevron-down text-muted"></i>
                </div>
                <div class="collapse mt-3" id="boxSkala">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white">
                                <h6 class="fw-bold text-primary mb-1">C1: Kategori (Benefit)</h6>
                                <p class="mb-1 text-muted small">Bobot: <strong>0.20 (20%)</strong></p>
                                <ul class="list-unstyled mb-0 ps-1" style="font-size: 11px;">
                                    <li>1 = Chocolate</li>
                                    <li>2 = Mocktail</li>
                                    <li>3 = Tea</li>
                                    <li>4 = Coffee</li>
                                    <li>5 = Makanan / 6 = Snack</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white">
                                <h6 class="fw-bold text-danger mb-1">C2: Harga (Cost)</h6>
                                <p class="mb-1 text-muted small">Bobot: <strong>0.20 (20%)</strong></p>
                                <ul class="list-unstyled mb-0 ps-1" style="font-size: 11px;">
                                    <li>1 = Sangat Murah (≤ 20.000)</li>
                                    <li>2 = Murah (21.000 - 25.000)</li>
                                    <li>3 = Sedang (26.000 - 28.000)</li>
                                    <li>4 = Mahal (29.000 - 30.000)</li>
                                    <li>5 = Sangat Mahal (&gt; 30.000)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white">
                                <h6 class="fw-bold text-success mb-1">C3: Penjualan (Benefit)</h6>
                                <p class="mb-1 text-muted small">Bobot: <strong>0.35 (35%)</strong></p>
                                <ul class="list-unstyled mb-0 ps-1" style="font-size: 11px;">
                                    <li>1 = Sangat Dikit (&lt; 300)</li>
                                    <li>2 = Sedikit (300 - 399)</li>
                                    <li>3 = Cukup Banyak (400 - 499)</li>
                                    <li>4 = Banyak (500 - 599)</li>
                                    <li>5 = Sangat Banyak (≥ 600)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 border rounded bg-white">
                                <h6 class="fw-bold text-info mb-1">C4: Waktu Penyajian (Benefit)</h6>
                                <p class="mb-1 text-muted small">Bobot: <strong>0.25 (25%)</strong></p>
                                <ul class="list-unstyled mb-0 ps-1" style="font-size: 11px;">
                                    <li>1 = Sangat Lama (≥ 6 Menit)</li>
                                    <li>2 = Lama (5 Menit)</li>
                                    <li>3 = Cepat (4 Menit)</li>
                                    <li>4 = Sangat Cepat (≤ 3 Menit)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM UNTUK LANJUT KE STEP 2 BOBOT -->
            <form action="{{ route('smart.storeKriteria') }}" method="POST">
                @csrf

                <!-- TABEL DATA PENJUALAN & SKALA KRITERIA -->
                <div class="d-md-none text-muted small mb-2 fst-italic">
                    <i class="fas fa-arrows-alt-h me-1 text-primary"></i> Geser tabel ke samping untuk melihat seluruh kolom data
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-smart">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 75px;">Kode</th>
                                <th class="text-start" style="min-width: 170px;">Nama Menu</th>
                                <th style="min-width: 130px;">Kategori (C1)</th>
                                <th style="min-width: 120px;">Harga (C2)</th>
                                <th style="min-width: 120px;">Penjualan (C3)</th>
                                <th style="min-width: 130px;">Waktu Penyajian (C4)</th>
                                <th style="min-width: 130px;">Laba Penjualan</th>
                                <th style="min-width: 165px; width: 170px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="table-body">
                            @forelse($dataPenjualan as $index => $item)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td><span class="badge bg-secondary px-2 py-1">{{ $item->kode_alternatif ?: 'A' . ($index + 1) }}</span></td>
                                <td class="text-start">
                                    <span class="fw-bold text-dark fs-6">{{ $item->nama }}</span>
                                    <input type="hidden" name="produk[{{ $index }}][nama]" value="{{ $item->nama }}">
                                    <input type="hidden" name="produk[{{ $index }}][kode_alternatif]" value="{{ $item->kode_alternatif ?: 'A' . ($index + 1) }}">
                                    <input type="hidden" name="produk[{{ $index }}][kategori_nama]" value="{{ $item->kategori_nama }}">
                                </td>
                                <td>
                                    <span class="badge bg-primary px-2 py-1">{{ $item->kategori_nama ?: 'Kategori' }}</span>
                                    <span class="badge bg-dark text-white border ms-1">Skala: {{ $item->kategori }}</span>
                                    <input type="hidden" name="produk[{{ $index }}][kategori]" value="{{ $item->kategori }}">
                                </td>
                                <td>
                                    <div class="cell-value-dark">{{ $item->harga_asli ? 'Rp ' . number_format($item->harga_asli, 0, ',', '.') : '-' }}</div>
                                    <span class="badge bg-danger mt-1">Skala: {{ $item->harga }}</span>
                                    <input type="hidden" name="produk[{{ $index }}][harga]" value="{{ $item->harga }}">
                                    <input type="hidden" name="produk[{{ $index }}][harga_asli]" value="{{ $item->harga_asli }}">
                                </td>
                                <td>
                                    <div class="cell-value-dark text-success">{{ $item->penjualan_asli ? number_format($item->penjualan_asli, 0, ',', '.') . ' Qty' : '-' }}</div>
                                    <span class="badge bg-success mt-1">Skala: {{ $item->penjualan }}</span>
                                    <input type="hidden" name="produk[{{ $index }}][penjualan]" value="{{ $item->penjualan }}">
                                    <input type="hidden" name="produk[{{ $index }}][penjualan_asli]" value="{{ $item->penjualan_asli }}">
                                </td>
                                <td>
                                    <div class="cell-value-dark">{{ $item->penyajian_asli ?: '-' }}</div>
                                    <span class="badge bg-info text-white mt-1">Skala: {{ $item->estimasi }}</span>
                                    <input type="hidden" name="produk[{{ $index }}][estimasi]" value="{{ $item->estimasi }}">
                                    <input type="hidden" name="produk[{{ $index }}][penyajian_asli]" value="{{ $item->penyajian_asli }}">
                                </td>
                                <td>
                                    <div class="cell-value-dark">
                                        {{ $item->laba_penjualan ? 'Rp ' . number_format($item->laba_penjualan, 0, ',', '.') : '-' }}
                                    </div>
                                    <input type="hidden" name="produk[{{ $index }}][laba_penjualan]" value="{{ $item->laba_penjualan }}">
                                </td>
                                <td>
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <button type="button" class="btn btn-sm btn-warning text-dark fw-bold px-2 py-1 shadow-sm" onclick="openEditModal({{ json_encode($item) }})" title="Edit Data {{ $item->nama }}">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger text-white fw-bold px-2 py-1 shadow-sm" onclick="hapusDatabase({{ $item->id }}, '{{ addslashes($item->nama) }}')" title="Hapus Data {{ $item->nama }}">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                                    Belum ada data penjualan menu di database.<br>
                                    Silakan klik tombol <strong>+ Tambah Data Manual</strong> atau <strong>📊 Tambah / Import Data Excel</strong> di atas!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SUBMIT KE STEP 2 BOBOT -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4 text-center text-md-start">
                    <span class="text-muted small order-2 order-md-1">
                        * Data di atas tersimpan permanen di database dan akan digunakan untuk perhitungan matriks SMART.
                    </span>
                    @if(count($dataPenjualan) > 0)
                    <button type="submit" class="btn btn-primary btn-lg px-4 shadow w-100 w-md-auto order-1 order-md-2">
                        Lanjut ke Pembobotan (Step 2) <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    @endif
                </div>

            </form>

        </div>
    </div>

</div>

<!-- ================= MODAL TAMBAH DATA MANUAL ================= -->
<div class="modal fade" id="modalTambahManual" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('smart.storeManual') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-plus-circle me-2"></i>Input Data Penjualan Menu (Manual)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Menu / Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Caramel Macchiato" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Kategori Menu</label>
                            <select name="kategori_nama" id="manual_kategori_nama" class="form-select" onchange="autoSetKategoriSkala(this.value)">
                                <option value="Coffee">Coffee</option>
                                <option value="Tea">Tea</option>
                                <option value="Mocktail">Mocktail</option>
                                <option value="Chocolate">Chocolate</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Snack">Snack</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C1 (1-6)</label>
                            <input type="number" step="0.1" name="kategori" id="manual_kategori" class="form-control" value="4" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Harga Asli (Rp)</label>
                            <input type="number" name="harga_asli" id="manual_harga_asli" class="form-control" placeholder="32000" oninput="autoSetHargaSkala(this.value)">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C2 Cost (1-5)</label>
                            <input type="number" step="0.1" name="harga" id="manual_harga" class="form-control" value="5" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Total Penjualan (Qty)</label>
                            <input type="number" name="penjualan_asli" id="manual_penjualan_asli" class="form-control" placeholder="518" oninput="autoSetPenjualanSkala(this.value)">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C3 (1-5)</label>
                            <input type="number" step="0.1" name="penjualan" id="manual_penjualan" class="form-control" value="4" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Waktu Penyajian</label>
                            <input type="text" name="penyajian_asli" id="manual_penyajian_asli" class="form-control" placeholder="6 Menit" oninput="autoSetPenyajianSkala(this.value)">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C4 (1-4)</label>
                            <input type="number" step="0.1" name="estimasi" id="manual_estimasi" class="form-control" value="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Laba Penjualan (Rp, Opsional)</label>
                        <input type="number" name="laba_penjualan" class="form-control" placeholder="Contoh: 16576000">
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Simpan ke Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT DATA MANUAL ================= -->
<div class="modal fade" id="modalEditManual" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="formEditManual" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Penjualan Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Menu / Produk</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Kategori Menu</label>
                            <input type="text" name="kategori_nama" id="edit_kategori_nama" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C1</label>
                            <input type="number" step="0.1" name="kategori" id="edit_kategori" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Harga Asli (Rp)</label>
                            <input type="number" name="harga_asli" id="edit_harga_asli" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C2 Cost</label>
                            <input type="number" step="0.1" name="harga" id="edit_harga" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Total Penjualan (Qty)</label>
                            <input type="number" name="penjualan_asli" id="edit_penjualan_asli" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C3</label>
                            <input type="number" step="0.1" name="penjualan" id="edit_penjualan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Waktu Penyajian</label>
                            <input type="text" name="penyajian_asli" id="edit_penyajian_asli" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Skala C4</label>
                            <input type="number" step="0.1" name="estimasi" id="edit_estimasi" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Laba Penjualan (Rp)</label>
                        <input type="number" name="laba_penjualan" id="edit_laba_penjualan" class="form-control">
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-check me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL IMPORT DATA EXCEL / CSV ================= -->
<div class="modal fade" id="modalImportExcel" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('smart.importExcel') }}" method="POST" enctype="multipart/form-data" id="formImportExcel">
                @csrf
                <input type="hidden" name="data_json" id="import_data_json">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-file-excel me-2"></i>Tambah & Import Data Excel / CSV ke Database</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-file" type="button">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Upload File (.xlsx / .csv)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-paste" type="button">
                                <i class="fas fa-paste me-1"></i> Copy-Paste dari Excel
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content border rounded p-3 bg-light">
                        <!-- TAB 1: UPLOAD FILE -->
                        <div class="tab-pane fade show active" id="tab-file">
                            <label class="form-label fw-bold">Pilih File Excel (.xlsx, .xls) atau CSV (.csv):</label>
                            <input type="file" id="file_excel_input" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv, .txt" onchange="handleFileSelect(event)">
                            <div class="form-text mt-2 small">
                                <i class="fas fa-info-circle text-primary"></i> File Excel/CSV Anda akan langsung diproses dan dikonversi otomatis ke skala Likert SMART.
                            </div>
                        </div>

                        <!-- TAB 2: COPY PASTE DARI EXCEL -->
                        <div class="tab-pane fade" id="tab-paste">
                            <label class="form-label fw-bold">Paste Baris Tabel dari Excel / Spreadsheet:</label>
                            <textarea id="paste_excel_area" class="form-control" rows="6" placeholder="Buka file Excel Anda, seleksi tabel kolom: Menu, Kategori, Harga, Penjualan, Penyajian, Laba Penjualan. Lalu tekan Ctrl+C dan Paste di sini..."></textarea>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="form-text small">Mendukung pemisah TAB maupun KOMA (CSV).</span>
                                <button type="button" class="btn btn-sm btn-primary" onclick="processPastedText()">
                                    <i class="fas fa-cogs me-1"></i> Proses Teks Paste
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- PILIHAN MODE SIMPAN -->
                    <div class="row align-items-center mt-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-1">Metode Penyimpanan Database:</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode" id="modeReplace" value="replace" checked>
                                    <label class="form-check-label" for="modeReplace">
                                        Ganti Semua Data (Replace)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode" id="modeAppend" value="append">
                                    <label class="form-check-label" for="modeAppend">
                                        Tambahkan (Append)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-2 mt-md-0">
                            <span id="preview_badge" class="badge bg-secondary p-2 d-none">
                                0 Data Terdeteksi
                            </span>
                        </div>
                    </div>

                    <!-- PREVIEW TABLE -->
                    <div class="mt-3 d-none" id="preview_container">
                        <label class="form-label fw-bold text-success mb-1">
                            <i class="fas fa-eye me-1"></i> Preview Data yang Akan Disimpan ke Database:
                        </label>
                        <div class="table-responsive border rounded" style="max-height: 250px;">
                            <table class="table table-sm table-striped text-center small mb-0">
                                <thead class="table-dark sticky-top">
                                    <tr>
                                        <th>Menu</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Penjualan</th>
                                        <th>Penyajian</th>
                                        <th>Skala Likert (C1,C2,C3,C4)</th>
                                    </tr>
                                </thead>
                                <tbody id="preview_tbody"></tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info text-white px-4" id="btnSubmitImport">
                        <i class="fas fa-database me-1"></i> Simpan ke Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL AMBIL DATA DARI LAPORAN KASIR ================= -->
<div class="modal fade" id="modalAmbilKasir" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('smart.importKasir') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-cash-register me-2"></i>Ambil & Sinkronkan Data Penjualan dari Laporan Kasir
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Ringkasan Statistik Laporan Kasir Saat Ini -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light border rounded text-center">
                                <small class="text-muted d-block fw-bold" style="font-size: 11px;">TOTAL TRANSAKSI KASIR</small>
                                <span class="fs-4 fw-bold text-primary">{{ $kasirStats['total_transaksi'] ?? 0 }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">Struk / Transaksi Selesai</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light border rounded text-center">
                                <small class="text-muted d-block fw-bold" style="font-size: 11px;">TOTAL ITEM TERJUAL</small>
                                <span class="fs-4 fw-bold text-success">{{ $kasirStats['total_item'] ?? 0 }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">Porsi Menu Dipesan</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light border rounded text-center">
                                <small class="text-muted d-block fw-bold" style="font-size: 11px;">TOTAL OMSET KASIR</small>
                                <span class="fs-5 fw-bold text-dark">Rp {{ number_format($kasirStats['total_pendapatan'] ?? 0, 0, ',', '.') }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">Akumulasi Penjualan Kasir</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 px-3 small border-0 mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Sistem akan membaca seluruh riwayat menu yang dipesan pada <strong>Laporan Kasir</strong>, menghitung akumulasi porsi terjual (Qty) dan omset, lalu mengonversinya secara otomatis ke skala Likert SMART.
                    </div>

                    <!-- Filter Rentang Tanggal Kasir -->
                    <div class="card bg-light border mb-3">
                        <div class="card-body p-3">
                            <label class="form-label fw-bold mb-2 text-dark">
                                <i class="fas fa-calendar-alt text-primary me-1"></i> Filter Periode Transaksi Kasir:
                            </label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Tanggal Mulai (Opsional):</label>
                                    <input type="date" name="start_date" id="kasir_start_date" class="form-control form-control-sm" onchange="fetchKasirPreview()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Tanggal Akhir (Opsional):</label>
                                    <input type="date" name="end_date" id="kasir_end_date" class="form-control form-control-sm" onchange="fetchKasirPreview()">
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="setKasirDateFilter('all')">Semua Waktu</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="setKasirDateFilter('month')">Bulan Ini</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="setKasirDateFilter('today')">Hari Ini</button>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Mode Simpan -->
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold mb-1 text-dark">Metode Sinkronisasi Database:</label>
                            <div class="d-flex flex-column gap-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode" id="kasirModeReplace" value="replace" checked>
                                    <label class="form-check-label small" for="kasirModeReplace">
                                        <strong>Ganti Semua Data (Replace)</strong> — Rekomendasi: Mengisi tabel SMART murni dari penjualan kasir.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode" id="kasirModeAppend" value="append">
                                    <label class="form-check-label small" for="kasirModeAppend">
                                        <strong>Gabungkan / Update (Append)</strong> — Menambahkan menu kasir baru atau memperbarui data menu yang sudah ada.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold mb-1 text-dark">Opsi Tambahan:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_orders" id="kasirIncludeOrders" value="1" onchange="fetchKasirPreview()">
                                <label class="form-check-label small" for="kasirIncludeOrders">
                                    Gabungkan juga pesanan online pelanggan (Order Web)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview Box -->
                    <div class="border rounded p-3 bg-white" id="kasir_preview_box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold small text-dark">
                                <i class="fas fa-list text-success me-1"></i> Pratinjau Menu yang Dipesan di Kasir:
                            </span>
                            <span class="badge bg-success" id="kasir_preview_badge">Memuat pratinjau...</span>
                        </div>
                        <div class="table-responsive" style="max-height: 200px;">
                            <table class="table table-sm table-bordered text-center small mb-0 align-middle">
                                <thead style="background-color: #1e293b !important; color: #fff !important;">
                                    <tr>
                                        <th class="text-start">Nama Menu</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Terjual</th>
                                        <th>Total Omset</th>
                                    </tr>
                                </thead>
                                <tbody id="kasir_preview_tbody">
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted">
                                            <div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data menu dari kasir...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-sync me-1"></i> Tarik & Simpan ke SPK SMART
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SheetJS CDN untuk Parsing Excel & CSV secara Cepat & Akurat di Browser -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
// ================= FORM HELPER: AUTO SET SKALA LIKERT =================
function autoSetKategoriSkala(kat) {
    kat = (kat || '').toLowerCase();
    let val = 1;
    if (kat.includes('choc')) val = 1;
    else if (kat.includes('mock')) val = 2;
    else if (kat.includes('tea') || kat.includes('teh')) val = 3;
    else if (kat.includes('coff') || kat.includes('kopi')) val = 4;
    else if (kat.includes('makan')) val = 5;
    else if (kat.includes('snack') || kat.includes('cemil')) val = 6;
    document.getElementById('manual_kategori').value = val;
}

function autoSetHargaSkala(harga) {
    let val = parseFloat((harga || '').toString().replace(/[^0-9.]/g, '')) || 0;
    let skala = 5;
    if (val <= 20000) skala = 1;
    else if (val <= 25000) skala = 2;
    else if (val <= 28000) skala = 3;
    else if (val <= 30000) skala = 4;
    else skala = 5;
    document.getElementById('manual_harga').value = skala;
}

function autoSetPenjualanSkala(qty) {
    let val = parseInt((qty || '').toString().replace(/[^0-9]/g, '')) || 0;
    let skala = 5;
    if (val < 300) skala = 1;
    else if (val < 400) skala = 2;
    else if (val < 500) skala = 3;
    else if (val < 600) skala = 4;
    else skala = 5;
    document.getElementById('manual_penjualan').value = skala;
}

function autoSetPenyajianSkala(menit) {
    let val = parseInt((menit || '').toString().replace(/[^0-9]/g, '')) || 0;
    let skala = 1;
    if (val <= 3 && val > 0) skala = 4; // Sangat Cepat
    else if (val === 4) skala = 3;      // Cepat
    else if (val === 5) skala = 2;      // Lama
    else skala = 1;                     // Sangat Lama (>= 6)
    document.getElementById('manual_estimasi').value = skala;
}

// ================= MODAL EDIT =================
function openEditModal(item) {
    document.getElementById('formEditManual').action = "{{ url('backend/smart/update-manual') }}/" + item.id;
    document.getElementById('edit_nama').value = item.nama || '';
    document.getElementById('edit_kategori_nama').value = item.kategori_nama || '';
    document.getElementById('edit_kategori').value = item.kategori || 1;
    document.getElementById('edit_harga_asli').value = item.harga_asli || '';
    document.getElementById('edit_harga').value = item.harga || 1;
    document.getElementById('edit_penjualan_asli').value = item.penjualan_asli || '';
    document.getElementById('edit_penjualan').value = item.penjualan || 1;
    document.getElementById('edit_penyajian_asli').value = item.penyajian_asli || '';
    document.getElementById('edit_estimasi').value = item.estimasi || 1;
    document.getElementById('edit_laba_penjualan').value = item.laba_penjualan || '';

    let modal = new bootstrap.Modal(document.getElementById('modalEditManual'));
    modal.show();
}

// ================= HAPUS DATABASE =================
function hapusDatabase(id, nama) {
    if (confirm("Yakin ingin menghapus menu '" + nama + "' dari database?")) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ url('backend/smart/destroy-manual') }}/" + id;

        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = "{{ csrf_token() }}";
        form.appendChild(csrf);

        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    }
}

// ================= PARSER EXCEL / CSV MENGGUNAKAN SHEETJS =================
let parsedExcelData = [];

function mapToLikertScores(item) {
    let kat = (item.kategori_nama || '').toLowerCase();
    let c1 = 1;
    if (kat.includes('choc')) c1 = 1;
    else if (kat.includes('mock')) c1 = 2;
    else if (kat.includes('tea') || kat.includes('teh')) c1 = 3;
    else if (kat.includes('coff') || kat.includes('kopi')) c1 = 4;
    else if (kat.includes('makan')) c1 = 5;
    else if (kat.includes('snack') || kat.includes('cemil')) c1 = 6;

    let hrg = parseFloat((item.harga_asli || 0).toString().replace(/[^0-9.]/g, '')) || 0;
    let c2 = 5;
    if (hrg <= 20000) c2 = 1;
    else if (hrg <= 25000) c2 = 2;
    else if (hrg <= 28000) c2 = 3;
    else if (hrg <= 30000) c2 = 4;
    else c2 = 5;

    let qty = parseInt((item.penjualan_asli || 0).toString().replace(/[^0-9]/g, '')) || 0;
    let c3 = 5;
    if (qty < 300) c3 = 1;
    else if (qty < 400) c3 = 2;
    else if (qty < 500) c3 = 3;
    else if (qty < 600) c3 = 4;
    else c3 = 5;

    let mnt = parseInt((item.penyajian_asli || 0).toString().replace(/[^0-9]/g, '')) || 0;
    let c4 = 1;
    if (mnt <= 3 && mnt > 0) c4 = 4;
    else if (mnt === 4) c4 = 3;
    else if (mnt === 5) c4 = 2;
    else c4 = 1;

    return {
        ...item,
        kategori: c1,
        harga: c2,
        penjualan: c3,
        estimasi: c4
    };
}

function handleFileSelect(evt) {
    let files = evt.target.files;
    if (!files.length) return;

    let file = files[0];
    let reader = new FileReader();

    reader.onload = function(e) {
        let data = new Uint8Array(e.target.result);
        let workbook = XLSX.read(data, {type: 'array'});

        let firstSheetName = workbook.SheetNames[0];
        let worksheet = workbook.Sheets[firstSheetName];
        let json = XLSX.utils.sheet_to_json(worksheet, {header: 1});

        processRawSheetRows(json);
    };

    reader.readAsArrayBuffer(file);
}

function processPastedText() {
    let text = document.getElementById('paste_excel_area').value.trim();
    if (!text) {
        alert("Silakan paste data tabel dari Excel terlebih dahulu!");
        return;
    }

    let rows = text.split(/\r?\n/).map(line => {
        if (line.includes('\t')) return line.split('\t');
        return line.split(',');
    });

    processRawSheetRows(rows);
}

function processRawSheetRows(rows) {
    if (!rows || rows.length === 0) return;

    let headerIndex = -1;
    let colMap = { menu: 1, kategori: 2, harga: 3, penjualan: 4, penyajian: 5, laba: 6 };

    for (let i = 0; i < Math.min(rows.length, 10); i++) {
        let r = rows[i].map(c => (c || '').toString().toLowerCase().trim());
        if (r.some(c => c.includes('menu') || c.includes('nama'))) {
            headerIndex = i;
            r.forEach((col, idx) => {
                if (col.includes('menu') || col.includes('nama')) colMap.menu = idx;
                if (col.includes('kategori')) colMap.kategori = idx;
                if (col.includes('harga')) colMap.harga = idx;
                if (col.includes('penjualan') && !col.includes('laba')) colMap.penjualan = idx;
                if (col.includes('penyajian') || col.includes('waktu') || col.includes('estimasi')) colMap.penyajian = idx;
                if (col.includes('laba')) colMap.laba = idx;
            });
            break;
        }
    }

    let startIndex = headerIndex >= 0 ? headerIndex + 1 : 0;
    parsedExcelData = [];

    for (let i = startIndex; i < rows.length; i++) {
        let r = rows[i];
        if (!r || r.length < 2) continue;

        let menuName = (r[colMap.menu] || '').toString().trim();
        if (!menuName || menuName.toLowerCase().includes('total') || menuName.toLowerCase().includes('keterangan')) continue;

        let item = {
            nama: menuName,
            kategori_nama: (r[colMap.kategori] || 'Coffee').toString().trim(),
            harga_asli: parseFloat((r[colMap.harga] || '0').toString().replace(/[^0-9.]/g, '')) || 0,
            penjualan_asli: parseInt((r[colMap.penjualan] || '0').toString().replace(/[^0-9]/g, '')) || 0,
            penyajian_asli: (r[colMap.penyajian] || '').toString().trim(),
            laba_penjualan: parseFloat((r[colMap.laba] || '0').toString().replace(/[^0-9.]/g, '')) || 0,
        };

        parsedExcelData.push(mapToLikertScores(item));
    }

    renderPreview();
}

function renderPreview() {
    let container = document.getElementById('preview_container');
    let tbody = document.getElementById('preview_tbody');
    let badge = document.getElementById('preview_badge');

    if (parsedExcelData.length === 0) {
        container.classList.add('d-none');
        badge.classList.add('d-none');
        return;
    }

    badge.innerText = parsedExcelData.length + " Menu Terdeteksi Siap Masuk Database";
    badge.className = "badge bg-success p-2";
    badge.classList.remove('d-none');

    document.getElementById('import_data_json').value = JSON.stringify(parsedExcelData);

    tbody.innerHTML = '';
    parsedExcelData.slice(0, 10).forEach(it => {
        let tr = `<tr>
            <td class="text-start fw-bold">${it.nama}</td>
            <td>${it.kategori_nama}</td>
            <td>Rp ${(it.harga_asli || 0).toLocaleString('id-ID')}</td>
            <td>${it.penjualan_asli} Qty</td>
            <td>${it.penyajian_asli}</td>
            <td><span class="badge bg-primary">C1:${it.kategori}</span> <span class="badge bg-danger">C2:${it.harga}</span> <span class="badge bg-success">C3:${it.penjualan}</span> <span class="badge bg-info">C4:${it.estimasi}</span></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', tr);
    });

    if (parsedExcelData.length > 10) {
        tbody.insertAdjacentHTML('beforeend', `<tr><td colspan="6" class="text-muted fst-italic">... dan ${parsedExcelData.length - 10} data menu lainnya.</td></tr>`);
    }

    container.classList.remove('d-none');
}

// ================= AMBIL DATA DARI LAPORAN KASIR =================
function setKasirDateFilter(type) {
    let start = document.getElementById('kasir_start_date');
    let end = document.getElementById('kasir_end_date');
    let now = new Date();

    if (type === 'all') {
        start.value = '';
        end.value = '';
    } else if (type === 'today') {
        let todayStr = now.toISOString().split('T')[0];
        start.value = todayStr;
        end.value = todayStr;
    } else if (type === 'month') {
        let y = now.getFullYear();
        let m = String(now.getMonth() + 1).padStart(2, '0');
        let lastDay = new Date(y, now.getMonth() + 1, 0).getDate();
        start.value = `${y}-${m}-01`;
        end.value = `${y}-${m}-${lastDay}`;
    }
    fetchKasirPreview();
}

function fetchKasirPreview() {
    let start = document.getElementById('kasir_start_date').value;
    let end = document.getElementById('kasir_end_date').value;
    let tbody = document.getElementById('kasir_preview_tbody');
    let badge = document.getElementById('kasir_preview_badge');

    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-2 text-muted"><div class="spinner-border spinner-border-sm text-primary me-1"></div> Mengambil data laporan kasir...</td></tr>';

    let url = '{{ route("smart.previewKasir") }}?start_date=' + encodeURIComponent(start) + '&end_date=' + encodeURIComponent(end);
    fetch(url)
        .then(res => res.json())
        .then(data => {
            badge.innerText = data.total_menu + ' Menu Dipesan (' + data.total_transaksi + ' Transaksi)';
            tbody.innerHTML = '';

            if (!data.top_menus || data.top_menus.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">Belum ada transaksi kasir pada periode ini.</td></tr>';
                return;
            }

            data.top_menus.forEach(m => {
                let tr = `<tr>
                    <td class="text-start fw-bold text-dark">${m.nama}</td>
                    <td>Rp ${Number(m.harga).toLocaleString('id-ID')}</td>
                    <td><span class="badge bg-success fw-bold">${m.qty} Qty</span></td>
                    <td class="fw-bold">Rp ${Number(m.subtotal).toLocaleString('id-ID')}</td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', tr);
            });

            if (data.total_menu > data.top_menus.length) {
                tbody.insertAdjacentHTML('beforeend', `<tr><td colspan="4" class="text-muted fst-italic">... dan ${data.total_menu - data.top_menus.length} menu lainnya dari transaksi kasir.</td></tr>`);
            }
        })
        .catch(err => {
            tbody.innerHTML = '<tr><td colspan="4" class="text-danger py-2">Gagal memuat pratinjau data kasir.</td></tr>';
        });
}

document.addEventListener('DOMContentLoaded', function () {
    let modalAmbilKasirEl = document.getElementById('modalAmbilKasir');
    if (modalAmbilKasirEl) {
        modalAmbilKasirEl.addEventListener('show.bs.modal', function () {
            fetchKasirPreview();
        });
    }
});
</script>

@endsection

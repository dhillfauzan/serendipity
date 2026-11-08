@extends('backend.layout.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="text-white mb-1"><i class="fas fa-balance-scale me-2"></i>Input & Normalisasi Bobot Kriteria SMART</h4>
            <p class="mb-0 text-white-50">Tentukan bobot prioritas untuk setiap kriteria penilaian. Total bobot harus berjumlah tepat 1 (atau 100%).</p>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('smart.storeBobot') }}" method="POST" onsubmit="return validasiBobot()">
                @csrf

                <div class="row g-4">

                    <!-- KRITERIA 1: KATEGORI -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold text-dark fs-6 mb-0">
                                    <i class="fas fa-tags text-primary me-2"></i>C1: Kategori Menu
                                </label>
                                <span class="badge bg-primary">Benefit</span>
                            </div>
                            <p class="text-muted small mb-3">Tingkat prioritas menu berdasarkan variasi jenis produk (Coffee, Tea, Mocktail, dll).</p>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="1" id="kategori" name="bobot[kategori]" class="form-control form-control-lg fw-bold text-center" value="0.20" required>
                                <span class="input-group-text">(20%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KRITERIA 2: HARGA -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold text-dark fs-6 mb-0">
                                    <i class="fas fa-money-bill-wave text-danger me-2"></i>C2: Harga Menu
                                </label>
                                <span class="badge bg-danger">Cost</span>
                            </div>
                            <p class="text-muted small mb-3">Kriteria biaya/harga menu (semakin murah/terjangkau maka nilai kepuasan konsumen semakin tinggi).</p>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="1" id="harga" name="bobot[harga]" class="form-control form-control-lg fw-bold text-center" value="0.20" required>
                                <span class="input-group-text">(20%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KRITERIA 3: PENJUALAN -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold text-dark fs-6 mb-0">
                                    <i class="fas fa-chart-line text-success me-2"></i>C3: Volume Penjualan
                                </label>
                                <span class="badge bg-success">Benefit</span>
                            </div>
                            <p class="text-muted small mb-3">Tingkat penjualan produk (semakin laris atau banyak terjual maka nilai kriteria semakin tinggi).</p>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="1" id="penjualan" name="bobot[penjualan]" class="form-control form-control-lg fw-bold text-center" value="0.35" required>
                                <span class="input-group-text">(35%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- KRITERIA 4: ESTIMASI PENYAJIAN -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold text-dark fs-6 mb-0">
                                    <i class="fas fa-clock text-info me-2"></i>C4: Waktu Penyajian
                                </label>
                                <span class="badge bg-info text-white">Benefit</span>
                            </div>
                            <p class="text-muted small mb-3">Kecepatan waktu penyajian pesanan (semakin cepat disajikan, kepuasan pelanggan semakin optimal).</p>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="1" id="estimasi" name="bobot[estimasi]" class="form-control form-control-lg fw-bold text-center" value="0.25" required>
                                <span class="input-group-text">(25%)</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TOTAL BOBOT INDICATOR -->
                <div class="card mt-4 bg-light border">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 py-3 text-center text-md-start">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Total Akumulasi Bobot:</h6>
                            <small class="text-muted">Total nilai bobot harus berjumlah tepat <strong>1.00</strong></small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="total" class="form-control form-control-lg fw-bold text-center text-success" style="width: 120px;" value="1.00" readonly>
                            <span id="badge_status" class="badge bg-success fs-6 py-2 px-3">Sesuai (1.00)</span>
                        </div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 mt-4">
                    <a href="{{ route('smart.kriteria') }}" class="btn btn-secondary px-4 order-2 order-sm-1 w-100 w-sm-auto">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Kriteria
                    </a>

                    <button type="submit" class="btn btn-primary btn-lg px-4 shadow order-1 order-sm-2 w-100 w-sm-auto" id="btnSubmit">
                        Lanjut ke Perhitungan (Step 3) <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
// ================= HITUNG TOTAL =================
function hitungTotal() {
    let kategori = parseFloat(document.getElementById('kategori').value) || 0;
    let harga = parseFloat(document.getElementById('harga').value) || 0;
    let penjualan = parseFloat(document.getElementById('penjualan').value) || 0;
    let estimasi = parseFloat(document.getElementById('estimasi').value) || 0;

    let total = kategori + harga + penjualan + estimasi;
    let totalFormatted = total.toFixed(2);
    let totalInput = document.getElementById('total');
    let badge = document.getElementById('badge_status');
    let btnSubmit = document.getElementById('btnSubmit');

    totalInput.value = totalFormatted;

    if (Math.abs(total - 1.0) < 0.001) {
        totalInput.className = "form-control form-control-lg fw-bold text-center text-success";
        badge.className = "badge bg-success fs-6 py-2 px-3";
        badge.innerText = "Sesuai (1.00)";
        btnSubmit.disabled = false;
    } else {
        totalInput.className = "form-control form-control-lg fw-bold text-center text-danger";
        badge.className = "badge bg-danger fs-6 py-2 px-3";
        badge.innerText = "Harus = 1.00 (Sekarang: " + totalFormatted + ")";
        btnSubmit.disabled = true;
    }
}

// ================= VALIDASI =================
function validasiBobot() {
    let total = parseFloat(document.getElementById('total').value);

    if (Math.abs(total - 1.0) >= 0.001) {
        alert("Total seluruh bobot harus sama dengan 1.00!");
        return false;
    }

    let bobot = {
        kategori: document.getElementById('kategori').value,
        harga: document.getElementById('harga').value,
        penjualan: document.getElementById('penjualan').value,
        estimasi: document.getElementById('estimasi').value
    };

    localStorage.setItem('bobot_smart', JSON.stringify(bobot));
    return true;
}

// ================= EVENT LISTENER =================
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', hitungTotal);
});

window.onload = function() {
    let saved = JSON.parse(localStorage.getItem('bobot_smart'));
    if (saved) {
        document.getElementById('kategori').value = saved.kategori || '0.20';
        document.getElementById('harga').value = saved.harga || '0.20';
        document.getElementById('penjualan').value = saved.penjualan || '0.35';
        document.getElementById('estimasi').value = saved.estimasi || '0.25';
    }
    hitungTotal();
};
</script>

@endsection

@extends('frontend.layout.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Proses Checkout</h5>
            <h1 class="mb-5">Lengkapi Pesanan Anda</h1>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> @endif
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-receipt me-2"></i>Detail Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/img-produk/' . $details['image']) }}" class="img-thumbnail me-3" width="60" height="60" style="object-fit: cover;">
                                                <span>{{ $details['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end align-middle">Rp {{ number_format($details['price'], 0, ',',
                                            '.') }}</td>
                                        <td class="text-center align-middle">{{ $details['quantity'] }}</td>
                                        <td class="text-end align-middle">Rp {{ number_format($details['price'] *
                                            $details['quantity'], 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr>
                                        <th colspan="3" class="text-end">Total Pembayaran</th>
                                        <th class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('place.order') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="table_number" class="form-label">Nomor Meja</label>
                                <input type="number" class="form-control" id="table_number" name="table_number" required min="1">
                            </div>

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan (opsional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>

                            <!-- QRIS Payment Section -->
                            <div class="border rounded p-3 mb-4 text-center bg-light">
                                <img src="{{ asset('storage/qris1.jpg') }}" alt="QRIS Code" class="img-fluid mb-2" style="max-width: 200px;">
                                <h5 class="text-primary">Scan QR Code untuk Pembayaran</h5>
                                <h4 class="text-danger fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                                <small class="text-muted">Gunakan aplikasi bank/e-wallet untuk scan</small>
                            </div>

                            <!-- Payment Proof Upload -->
                            <div class="mb-4">
                                <label for="payment_proof" class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof" required accept="image/*">
                                </div>
                                <div class="form-text">Format: JPG/PNG (maks. 2MB). Pastikan nominal terlihat jelas.
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="{{ route('cart') }}" method="POST" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                                </a>
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-check-circle me-2"></i> Konfirmasi Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show selected file name
    document.getElementById('payment_proof').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        if (nextSibling && nextSibling.classList.contains('input-group-text')) {
            nextSibling.innerText = fileName;
        }
    });

</script>
@endsection

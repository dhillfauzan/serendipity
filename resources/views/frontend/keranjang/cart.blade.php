@extends('frontend.layout.app')

@section('content')
<div class="container py-4 py-md-5 my-auto">
    <div class="container px-2 px-md-3">
        <div class="text-center mb-4">
            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold small mb-2">
                <i class="fas fa-shopping-bag me-1"></i> Keranjang Pemesanan
            </span>
            <h2 class="fw-bold text-dark mb-1">Pesanan Anda</h2>
            <p class="text-muted small">Periksa kembali daftar menu yang ingin Anda pesan sebelum melakukan checkout</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(count((array) session('cart')))
                <div class="card shadow-sm border-0 rounded-3 mb-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="cart-table">
                                <thead class="table-dark" style="background-color: #0F172B !important; color: #fff !important;">
                                    <tr>
                                        <th class="ps-3 py-3" style="min-width: 180px;">Menu</th>
                                        <th class="text-end py-3" style="min-width: 100px;">Harga</th>
                                        <th class="text-center py-3" style="min-width: 110px;">Jumlah</th>
                                        <th class="text-end py-3" style="min-width: 110px;">Subtotal</th>
                                        <th class="text-center py-3 pe-3" style="width: 70px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center py-1">
                                                <img src="{{ asset('storage/img-produk/' . $details['image']) }}" 
                                                     class="rounded-3 me-3 border" 
                                                     width="55" 
                                                     height="55" 
                                                     style="object-fit: cover;"
                                                     onerror="this.onerror=null;this.src='{{ asset('template2/img/menu-1.jpg') }}';"
                                                     alt="{{ $details['name'] }}">
                                                <div>
                                                    <span class="fw-bold text-dark d-block lh-sm">{{ $details['name'] }}</span>
                                                    <small class="text-muted d-block d-sm-none">Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end align-middle price fw-bold text-dark" data-price="{{ $details['price'] }}">
                                            Rp {{ number_format($details['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <input type="number" 
                                                   value="{{ $details['quantity'] }}" 
                                                   class="form-control form-control-sm quantity update-cart text-center fw-bold mx-auto" 
                                                   min="1" 
                                                   style="width: 70px;"
                                                   data-id="{{ $id }}">
                                        </td>
                                        <td class="text-end align-middle subtotal fw-bold text-primary">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center align-middle pe-3">
                                            <button class="btn btn-sm btn-outline-danger remove-from-cart rounded-circle" style="width: 32px; height: 32px; padding: 0;" data-id="{{ $id }}" title="Hapus menu">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="3" class="text-end py-3 fw-bold fs-6 ps-3">Total Pembayaran:</th>
                                        <th class="text-end total-amount text-primary fw-bold fs-5 py-3">Rp {{ number_format($total, 0, ',', '.') }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-5">
                    <a href="{{ route('frontend.beranda') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 order-2 order-sm-1">
                        <i class="fas fa-arrow-left me-2"></i> Tambah Menu Lain
                    </a>
                    <a href="{{ route('checkout') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm order-1 order-sm-2">
                        Lanjut ke Pembayaran <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                @else
                <div class="card shadow-sm border-0 rounded-4 my-3 my-md-5">
                    <div class="card-body text-center py-5 px-3">
                        <div class="mb-3">
                            <span class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px;">
                                <i class="fas fa-shopping-cart fa-3x text-muted opacity-50"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Keranjang Anda Masih Kosong</h4>
                        <p class="text-muted small mb-4 mx-auto" style="max-width: 380px;">Belum ada menu yang dipilih. Silakan jelajahi aneka menu makanan, minuman, dan cemilan lezat kami.</p>
                        <a href="{{ route('frontend.beranda') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                            <i class="fas fa-utensils me-2"></i> Mulai Pesan Menu
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Update quantity - langsung update tanpa alert/konfirmasi
        $(".update-cart").on('change', function(e) {
            e.preventDefault();
            var ele = $(this);
            var produk_id = ele.data("id");
            var quantity = ele.val();
            var row = ele.closest("tr");

            $.ajax({
                url: '{{ route("update.cart") }}',
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    produk_id: produk_id,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Update subtotal untuk baris ini
                        var price = row.find(".price").data("price");
                        var newSubtotal = price * quantity;
                        row.find(".subtotal").text('Rp ' + formatNumber(newSubtotal));
                        
                        // Update total
                        $(".total-amount").text('Rp ' + response.total);
                    }
                },
                error: function(xhr) {
                    // Kembalikan nilai quantity sebelumnya jika error
                    window.location.reload();
                }
            });
        });

        // Remove item - langsung hapus tanpa konfirmasi
        $(".remove-from-cart").on('click', function(e) {
            e.preventDefault();
            var ele = $(this);
            var produk_id = ele.data("id");
            var row = ele.closest("tr");
            
            $.ajax({
                url: '{{ route("remove.from.cart") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    produk_id: produk_id
                },
                success: function(response) {
                    if (response.success) {
                        // Hapus baris dari tabel dengan animasi
                        row.fadeOut(300, function() {
                            $(this).remove();
                            
                            // Update total
                            $(".total-amount").text('Rp ' + response.total);
                            
                            // Jika keranjang kosong, reload halaman
                            if (response.cart_count === 0) {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    // Jika error, reload halaman
                    window.location.reload();
                }
            });
        });

        // Helper function untuk format number
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    });
</script>
@endsection
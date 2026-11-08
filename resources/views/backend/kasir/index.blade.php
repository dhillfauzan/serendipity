@extends('backend.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <h1 class="h3 mb-0">Kasir</h1>
                <div class="btn-group">
                    <button class="btn btn-outline-secondary" id="search-toggle">
                        <i class="fas fa-search"></i> Cari Produk
                    </button>
                    <button class="btn btn-outline-primary" id="category-filter">
                        <i class="fas fa-filter"></i> Filter Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="row mb-3 d-none" id="search-box">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" id="product-search" placeholder="Cari produk...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="row mb-3 d-none" id="category-box">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-sm btn-outline-secondary category-btn active" data-category="all">
                            Semua Kategori
                        </button>
                        @foreach($categories as $category)
                        <button class="btn btn-sm btn-outline-primary category-btn" data-category="{{ $category->id }}">
                            {{ $category->nama_katagori }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Daftar Produk -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <span id="product-count">{{ $produks->count() }} produk tersedia</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($produks->isEmpty())
                    <div class="alert alert-warning text-center">Tidak ada produk tersedia</div>
                    @else
                    <div class="row g-2 g-sm-3" id="product-container">
                        @foreach($produks as $item)
                        <div class="col-6 col-sm-4 col-md-4 col-xl-3 mb-2 mb-sm-3 product-item" data-category="{{ $item->katagori_id }}" data-name="{{ strtolower($item->nama_produk) }}">
                            <div class="card produk-card h-100" data-id="{{ $item->id }}" data-name="{{ $item->nama_produk }}" data-price="{{ $item->harga }}" data-stock="{{ $item->stok }}" data-weight="{{ $item->berat ?? 0 }}" data-description="{{ $item->detail ?? 'Tidak ada deskripsi' }}">

                                <!-- Foto Produk -->
                                <div class="product-image-container">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/img-produk/' . $item->foto) }}" class="card-img-top product-image" alt="{{ $item->nama_produk }}">
                                    @else
                                    <div class="no-image-placeholder text-center py-4 bg-light">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="mt-2 mb-0 text-muted">No Image</p>
                                    </div>
                                    @endif
                                    <div class="product-badge">
                                        <span class="badge bg-success">Rp {{ number_format($item->harga, 0, ',', '.')
                                            }}</span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h6 class="card-title font-weight-bold text-truncate">{{ $item->nama_produk }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-info">{{ $item->katagori->nama_katagori ?? 'No Category'
                                            }}</span>
                                        <small class="text-muted">Stok: {{ $item->stok }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Keranjang Belanja -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Transaksi</h5>
                        <span id="item-count">0 item</span>
                    </div>
                </div>
                <div class="card-body">
                    <form id="transaction-form" action="{{ route('kasir.process') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40%">Produk</th>
                                        <th width="20%">Qty</th>
                                        <th width="30%">Subtotal</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody id="transaction-items">
                                    <!-- Items akan ditambahkan via JavaScript -->
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="2">TOTAL</th>
                                        <th id="total-amount">Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="process-btn" disabled>
                                <i class="fas fa-cash-register me-2"></i>Proses Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Product Detail -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductName"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="modalProductImage" src="" class="img-fluid rounded" style="max-height: 200px;" alt="Product Image">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Kategori:</strong> <span id="modalProductCategory"></span></p>
                        <p><strong>Harga:</strong> <span id="modalProductPrice"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Stok:</strong> <span id="modalProductStock"></span></p>
                        <p><strong>Berat:</strong> <span id="modalProductWeight"></span> gram</p>
                    </div>
                </div>
                <p><strong>Deskripsi:</strong></p>
                <div id="modalProductDescription" class="border p-2 rounded bg-light"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="addToCartFromModal">Tambah ke Keranjang</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const produkCards = document.querySelectorAll('.produk-card');
        const transactionItems = document.getElementById('transaction-items');
        const totalAmount = document.getElementById('total-amount');
        const processBtn = document.getElementById('process-btn');
        const itemCount = document.getElementById('item-count');
        const searchBox = document.getElementById('search-box');
        const searchToggle = document.getElementById('search-toggle');
        const productSearch = document.getElementById('product-search');
        const categoryBox = document.getElementById('category-box');
        const categoryFilter = document.getElementById('category-filter');
        const categoryBtns = document.querySelectorAll('.category-btn');
        const productContainer = document.getElementById('product-container');
        const productCount = document.getElementById('product-count');

        // Modal elements
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));
        const modalProductName = document.getElementById('modalProductName');
        const modalProductImage = document.getElementById('modalProductImage');
        const modalProductCategory = document.getElementById('modalProductCategory');
        const modalProductPrice = document.getElementById('modalProductPrice');
        const modalProductStock = document.getElementById('modalProductStock');
        const modalProductWeight = document.getElementById('modalProductWeight');
        const modalProductDescription = document.getElementById('modalProductDescription');
        const addToCartFromModal = document.getElementById('addToCartFromModal');

        let items = [];
        let total = 0;
        let selectedProduct = null;

        // Toggle search box
        searchToggle.addEventListener('click', function() {
            searchBox.classList.toggle('d-none');
            if (!searchBox.classList.contains('d-none')) {
                categoryBox.classList.add('d-none');
            }
        });

        // Toggle category filter
        categoryFilter.addEventListener('click', function() {
            categoryBox.classList.toggle('d-none');
            if (!categoryBox.classList.contains('d-none')) {
                searchBox.classList.add('d-none');
            }
        });

        // Search functionality
        productSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            let visibleCount = 0;

            productItems.forEach(item => {
                const productName = item.dataset.name;
                if (productName.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            productCount.textContent = `${visibleCount} produk ditemukan`;
        });

        // Category filter
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.dataset.category;

                // Update active button
                categoryBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const productItems = document.querySelectorAll('.product-item');
                let visibleCount = 0;

                if (category === 'all') {
                    productItems.forEach(item => {
                        item.style.display = 'block';
                        visibleCount++;
                    });
                } else {
                    productItems.forEach(item => {
                        if (item.dataset.category === category) {
                            item.style.display = 'block';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                productCount.textContent = `${visibleCount} produk ditemukan`;
            });
        });

        // Product card click - show modal
        productContainer.addEventListener('click', function(e) {
            const card = e.target.closest('.produk-card');
            if (!card) return;

            const produkId = parseInt(card.dataset.id);
            const produk = {
                id: produkId,
                name: card.dataset.name,
                price: parseInt(card.dataset.price),
                stock: parseInt(card.dataset.stock),
                image: card.querySelector('.product-image')?.src || '',
                category: card.querySelector('.badge.bg-info')?.textContent || 'No Category',
                weight: card.dataset.weight || '0',
                description: card.dataset.description || 'Tidak ada deskripsi'
            };

            selectedProduct = produk;

            // Fill modal
            modalProductName.textContent = produk.name;
            modalProductImage.src = produk.image || '{{ asset("assets/img/no-image.png") }}';
            modalProductImage.onerror = function() {
                this.src = '{{ asset("assets/img/no-image.png") }}';
            };
            modalProductCategory.textContent = produk.category;
            modalProductPrice.textContent = 'Rp ' + produk.price.toLocaleString('id-ID');
            modalProductStock.textContent = produk.stock;
            modalProductWeight.textContent = produk.weight;
            modalProductDescription.textContent = produk.description;

            productModal.show();
        });

        // Add to cart from modal
        addToCartFromModal.addEventListener('click', function() {
            if (!selectedProduct) return;

            const existingItem = items.find(item => item.produk_id === selectedProduct.id);

            if (existingItem) {
                if (existingItem.quantity < selectedProduct.stock) {
                    existingItem.quantity += 1;
                } else {
                    alert('Stok tidak mencukupi!');
                    return;
                }
            } else {
                items.push({
                    produk_id: selectedProduct.id
                    , name: selectedProduct.name
                    , price: selectedProduct.price
                    , stock: selectedProduct.stock
                    , quantity: 1
                });
            }

            updateTransactionDisplay();
            productModal.hide();
        });

        // Fungsi untuk update tampilan keranjang
        function updateTransactionDisplay() {
            transactionItems.innerHTML = '';
            total = 0;

            if (items.length === 0) {
                processBtn.disabled = true;
                totalAmount.textContent = 'Rp 0';
                itemCount.textContent = '0 item';
                return;
            }

            processBtn.disabled = false;
            itemCount.textContent = `${items.reduce((sum, item) => sum + item.quantity, 0)} item`;

            items.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const row = document.createElement('tr');
                row.className = 'align-middle';
                row.innerHTML = `
                <td>${item.name}</td>
                <td>
                    <input type="number" 
                           name="items[${index}][quantity]" 
                           value="${item.quantity}" 
                           min="1" 
                           max="${item.stock}"
                           class="form-control form-control-sm quantity-input" 
                           data-index="${index}">
                    <input type="hidden" name="items[${index}][produk_id]" value="${item.produk_id}">
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;

                transactionItems.appendChild(row);
            });

            totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;

            // Tambahkan event listener untuk perubahan quantity
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.dataset.index);
                    const newQuantity = parseInt(this.value);

                    if (newQuantity < 1) {
                        this.value = 1;
                        items[index].quantity = 1;
                    } else if (newQuantity > items[index].stock) {
                        this.value = items[index].stock;
                        items[index].quantity = items[index].stock;
                        alert('Stok tidak mencukupi!');
                    } else {
                        items[index].quantity = newQuantity;
                    }

                    updateTransactionDisplay();
                });
            });

            // Tambahkan event listener untuk tombol hapus
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    items.splice(index, 1);
                    updateTransactionDisplay();
                });
            });
        }
    });

</script>

<style>
    .produk-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .produk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 150px;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .produk-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }

    .no-image-placeholder {
        height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .quantity-input {
        width: 70px;
        display: inline-block;
    }

    #process-btn:disabled {
        cursor: not-allowed;
        opacity: 0.65;
    }

    #transaction-items tr td {
        vertical-align: middle;
    }

    #product-count,
    #item-count {
        font-size: 0.9rem;
        font-weight: normal;
    }

    .category-btn.active {
        background-color: #0d6efd;
        color: white;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #modalProductDescription {
        white-space: pre-line;
        min-height: 100px;
        max-height: 200px;
        overflow-y: auto;
    }

    @media (max-width: 576px) {
        .product-image-container,
        .no-image-placeholder {
            height: 110px;
        }
        .produk-card .card-body {
            padding: 0.6rem;
        }
        .produk-card .card-title {
            font-size: 0.85rem;
        }
        .product-badge {
            bottom: 5px;
            left: 5px;
        }
        .product-badge .badge {
            font-size: 0.72rem;
            padding: 3px 6px;
        }
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
@endsection

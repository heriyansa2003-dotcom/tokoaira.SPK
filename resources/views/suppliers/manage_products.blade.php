@extends('layouts.app')

@section('title', 'Kelola Produk Supplier')

@section('content')

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Produk</h2>
            <p class="text-muted mb-0">Pilih produk yang disediakan oleh supplier: <span class="text-primary fw-bold">{{ $supplier->name }}</span></p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- SEARCH & FILTER CARD -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-search me-2"></i>Cari & Filter Produk</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.suppliers.manage_products', $supplier->id) }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold mb-2">Nama Produk</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box text-muted"></i></span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari nama produk..."
                               value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-2">Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag text-muted"></i></span>
                        <select name="category" class="form-select">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('admin.suppliers.manage_products', $supplier->id) }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN FORM CARD -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-check2-square me-2"></i>Daftar Produk ({{ $products->count() }} ditemukan)</h5>
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Centang produk untuk menghubungkan dengan supplier</small>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.suppliers.update_products', $supplier->id) }}" method="POST">
                @csrf

                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-md-4 col-lg-3">
                            <div class="product-selection-card h-100">
                                <input class="form-check-input d-none" 
                                       type="checkbox" 
                                       name="product_ids[]" 
                                       value="{{ $product->id }}" 
                                       id="product_{{ $product->id }}"
                                       {{ in_array($product->id, $supplierProducts) ? 'checked' : '' }}>
                                
                                <label class="product-label d-block p-3 border rounded-3 h-100 cursor-pointer" for="product_{{ $product->id }}">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="category-badge px-2 py-1 rounded-pill bg-light text-muted small">
                                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                                        </div>
                                        <div class="check-indicator">
                                            <i class="bi bi-check-circle-fill text-primary fs-5 d-none"></i>
                                            <i class="bi bi-circle text-light fs-5"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 bg-light rounded-3">
                                <i class="bi bi-search text-muted display-4"></i>
                                <p class="mt-3 text-muted mb-0">Tidak ada produk yang sesuai dengan pencarian Anda.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .product-selection-card .form-check-input:checked + .product-label {
        border-color: #2563eb !important;
        background-color: rgba(37, 99, 235, 0.05);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }
    .product-selection-card .form-check-input:checked + .product-label .check-indicator .bi-check-circle-fill {
        display: block !important;
    }
    .product-selection-card .form-check-input:checked + .product-label .check-indicator .bi-circle {
        display: none !important;
    }
    .product-label {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb !important;
    }
    .product-label:hover {
        border-color: #2563eb !important;
        transform: translateY(-2px);
    }
    .category-badge {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

@endsection

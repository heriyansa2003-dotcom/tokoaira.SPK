@extends('layouts.app')

@section('title','Edit Produk')

@section('content')

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Produk</h2>
            <p class="text-muted mb-0">Perbarui data produk yang sudah ada</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- CARD FORM -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Produk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold mb-2">Kategori</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold mb-2">Harga Jual (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Stok Saat Ini</label>
                                        <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Stok Minimum</label>
                                        <input type="number" name="min_stock" class="form-control" min="0" value="{{ old('min_stock', $product->min_stock) }}" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Satuan</label>
                                        <select name="unit" class="form-select" required>
                                            @php $units = ['Bungkus', 'Dos', 'Karton', 'Lusin', 'Pack', 'Bal', 'Pcs']; @endphp
                                            @foreach($units as $u)
                                                <option value="{{ $u }}" {{ (old('unit', $product->unit) == $u) ? 'selected' : '' }}>{{ $u }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Volume Penjualan</label>
                                    <input type="number" name="sales_frequency" class="form-control" min="0" value="{{ old('sales_frequency', $product->sales_frequency) }}" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Gambar Produk</label>
                                    <div class="border-2 border-dashed rounded-3 p-3 text-center" style="border-color: #dee2e6; background-color: #f9fafb;">
                                        @if ($product->image)
                                            <div id="currentImage" class="mb-3">
                                                <p class="text-muted small mb-2">Gambar Saat Ini:</p>
                                                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-3" style="max-height: 150px;" alt="Gambar Produk">
                                            </div>
                                        @endif
                                        <div id="imagePreview" class="d-none mb-3">
                                            <p class="text-primary fw-bold small mb-2">Preview Gambar Baru:</p>
                                            <img src="#" class="img-fluid rounded-3" style="max-height: 150px;" alt="Preview">
                                        </div>
                                        <div class="mt-3">
                                            <input type="file" name="image" class="form-control form-control-sm" accept="image/jpeg,image/jpg,image/png,image/webp" id="imageInput">
                                            <small class="text-muted mt-2 d-block">Format: JPG, JPEG, PNG, WebP | Ukuran maksimal: 2MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i>Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        const currentImg = document.getElementById('currentImage');
        const file = e.target.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        if (file) {
            // Validasi ukuran file
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                e.target.value = '';
                preview.classList.add('d-none');
                if(currentImg) currentImg.classList.remove('opacity-50');
                return;
            }
            
            // Validasi tipe file
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                e.target.value = '';
                preview.classList.add('d-none');
                if(currentImg) currentImg.classList.remove('opacity-50');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('d-none');
                if(currentImg) currentImg.classList.add('opacity-50');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
            if(currentImg) currentImg.classList.remove('opacity-50');
        }
    });
    </script>

</div>

@endsection

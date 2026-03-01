@extends('layouts.app')

@section('title','Tambah Produk')

@section('content')

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Produk</h2>
            <p class="text-muted mb-0">Tambahkan data produk baru ke dalam sistem</p>
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
                    <h5 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Formulir Tambah Produk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" placeholder="Contoh: Indomie Goreng" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold mb-2">Kategori</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold mb-2">Harga Jual (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price" class="form-control" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Stok Awal</label>
                                        <input type="number" name="stock" class="form-control" min="0" placeholder="0" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Stok Minimum</label>
                                        <input type="number" name="min_stock" class="form-control" min="0" value="10" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold mb-2">Satuan</label>
                                        <select name="unit" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Bungkus">Bungkus</option>
                                            <option value="Dos">Dos</option>
                                            <option value="Karton">Karton</option>
                                            <option value="Lusin">Lusin</option>
                                            <option value="Pack">Pack</option>
                                            <option value="Bal">Bal</option>
                                            <option value="Pcs">Pcs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Gambar Produk</label>
                                    <div class="border-2 border-dashed rounded-3 d-flex flex-column align-items-center justify-content-center p-4" style="height: 250px; border-color: #dee2e6; background-color: #f9fafb;">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-muted mb-2"></i>
                                        <p class="text-muted small mb-3">Klik atau seret gambar ke sini</p>
                                        <input type="file" name="image" class="form-control form-control-sm" accept="image/jpeg,image/jpg,image/png,image/webp" id="imageInput">
                                        <small class="text-muted mt-2 d-block">Format: JPG, JPEG, PNG, WebP | Ukuran maksimal: 2MB</small>
                                    </div>
                                    <div id="imagePreview" class="mt-3 d-none">
                                        <p class="text-primary fw-bold small mb-2">Preview Gambar:</p>
                                        <img src="#" class="img-fluid rounded-3" style="max-height: 150px;" alt="Preview">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Volume Penjualan Awal</label>
                                    <input type="number" name="sales_frequency" class="form-control" min="0" value="0" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>Simpan Produk
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
        const file = e.target.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        if (file) {
            // Validasi ukuran file
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                e.target.value = '';
                preview.classList.add('d-none');
                return;
            }
            
            // Validasi tipe file
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                e.target.value = '';
                preview.classList.add('d-none');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });
    </script>

</div>

@endsection

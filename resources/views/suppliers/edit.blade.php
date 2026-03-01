@extends('layouts.app')

@section('title','Edit Supplier')

@section('content')

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Supplier</h2>
            <p class="text-muted mb-0">Perbarui data supplier: <span class="text-primary fw-bold">{{ $supplier->name }}</span></p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                
                <!-- CARD HEADER -->
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Formulir Edit Supplier</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- NAMA SUPPLIER -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold mb-2">Nama Supplier</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-building text-muted"></i></span>
                                        <input type="text"
                                               name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Masukkan nama lengkap supplier"
                                               value="{{ old('name', $supplier->name) }}"
                                               required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- TELP/WA -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold mb-2">Nomor TELP/WA</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-whatsapp text-muted"></i></span>
                                        <input type="text"
                                               name="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="Contoh: 081234567890"
                                               pattern="0[0-9]{9,14}"
                                               inputmode="numeric"
                                               maxlength="15"
                                               value="{{ old('phone', $supplier->phone) }}"
                                               required>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="bi bi-info-circle me-1"></i>Masukkan angka saja, harus dimulai dengan 0 (10-15 digit)
                                    </small>
                                    @error('phone')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- ALAMAT -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold mb-2">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text align-items-start pt-2"><i class="bi bi-geo-alt text-muted"></i></span>
                                        <textarea name="address"
                                                  class="form-control @error('address') is-invalid @enderror"
                                                  rows="4"
                                                  placeholder="Masukkan alamat lengkap supplier"
                                                  required>{{ old('address', $supplier->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- ACTION BUTTONS -->
                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Update Supplier
                                    </button>
                                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.querySelector('input[name="phone"]').addEventListener('input', function (e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Ensure it starts with 0
        if (this.value && !this.value.startsWith('0')) {
            this.value = '0' + this.value.replace(/^0+/, '');
        }
    });
</script>

@endsection

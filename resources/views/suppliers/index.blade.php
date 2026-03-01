@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="dashboard-header mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Supplier</h2>
            <p class="text-muted mb-0">
                Kelola data supplier sebagai mitra pengadaan barang
            </p>
        </div>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.suppliers.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Supplier
        </a>
        @endif
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- MAIN CARD -->
    <div class="card">
        <!-- CARD HEADER -->
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Daftar Supplier</h5>
                <span class="badge bg-primary">Total: {{ $suppliers->count() }}</span>
            </div>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">No</th>
                            <th>Informasi Supplier</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th class="text-center" width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($suppliers as $i => $supplier)
                        <tr>
                            <td>
                                <span class="text-muted fw-medium">{{ $i + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-primary-soft text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(79, 109, 230, 0.1);">
                                        <i class="bi bi-building fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $supplier->name }}</h6>
                                        <small class="text-muted">ID: SUP-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-dark">
                                        <i class="bi bi-whatsapp text-success me-1"></i> {{ $supplier->phone }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 text-muted small" style="max-width: 250px; line-height: 1.4;">
                                    {{ Str::limit($supplier->address, 60) }}
                                </p>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.suppliers.manage_products', $supplier->id) }}"
                                       class="btn btn-icon btn-info-soft rounded-3" 
                                       data-bs-toggle="tooltip" 
                                       title="Kelola Produk">
                                        <i class="bi bi-box-seam"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                       class="btn btn-icon btn-warning-soft rounded-3"
                                       data-bs-toggle="tooltip"
                                       title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-icon btn-danger-soft rounded-3"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted display-1"></i>
                                    <p class="mt-3 text-muted">Belum ada data supplier.</p>
                                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary btn-sm mt-2">
                                        Tambah Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- CARD FOOTER -->
        <div class="card-footer">
            <small class="text-muted">Menampilkan {{ $suppliers->count() }} data supplier</small>
        </div>
    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

@endsection

@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Kategori</h2>
            <p class="text-muted mb-0">
                Kelola kategori barang dalam sistem inventaris
            </p>
        </div>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
        </a>
        @endif
    </div>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- MAIN CARD -->
    <div class="card">
        <!-- CARD HEADER -->
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Daftar Kategori</h5>
        </div>


        <!-- CARD BODY -->
        <div class="card-body">
            @if($categories->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <h5 class="fw-semibold">Belum ada kategori</h5>
                    <p class="text-muted mb-3">
                        Tambahkan kategori untuk mulai mengelola data barang.
                    </p>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Buat Kategori Pertama
                    </a>
                    @endif
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kategori</th>
                            @if(auth()->user()->role === 'admin')
                                <th width="140" class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-semibold text-dark">
                                    <i class="bi bi-tag me-2 text-primary"></i>
                                    {{ $category->name }}
                                </span>
                            </td>
                            @if(auth()->user()->role === 'admin')
                            <td class="text-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning-soft me-1"
                                   data-bs-toggle="tooltip"
                                   title="Edit Kategori">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="btn btn-sm btn-danger-soft"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Kategori">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- CARD FOOTER -->
        @if(!$categories->isEmpty())
        <div class="card-footer">
            <small class="text-muted">Total {{ $categories->count() }} kategori</small>
        </div>
        @endif
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection

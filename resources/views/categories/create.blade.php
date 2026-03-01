@extends('layouts.app')

@section('title','Tambah Kategori')

@section('content')

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="dashboard-header">
        <div>
            <h2>Tambah Kategori</h2>
            <p class="text-muted mb-0">
                Tambahkan kategori baru ke dalam sistem inventaris
            </p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label class="fw-semibold">Nama Kategori</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Contoh: Peralatan Kantor"
                           required>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary me-2">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection

@extends('layouts.app')

@section('title','Edit Kategori')

@section('content')

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="dashboard-header">
        <div>
            <h2>Edit Kategori</h2>
            <p class="text-muted mb-0">
                Perbarui nama kategori barang
            </p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label class="fw-semibold">Nama Kategori</label>
                    <input type="text"
                           name="name"
                           value="{{ $category->name }}"
                           class="form-control"
                           required>
                </div>

                <div class="mt-4">
                    <button class="btn btn-warning me-2">
                        <i class="bi bi-pencil-square me-1"></i>Update
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

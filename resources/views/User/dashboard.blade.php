@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

    <p class="text-subtitle text-muted">
        Ringkasan informasi inventaris (akses baca)
    </p>
</div>

<div class="page-content">
    <section class="row">

        {{-- TOTAL BARANG --}}
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                    <h6 class="mt-2">Total Barang</h6>
                    <h3>{{ $totalBarang }}</h3>
                </div>
            </div>
        </div>

        {{-- TOTAL KATEGORI --}}
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-tags fs-1 text-success"></i>
                    <h6 class="mt-2">Total Kategori</h6>
                    <h3>{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>

        {{-- TOTAL SUPPLIER --}}
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-truck fs-1 text-warning"></i>
                    <h6 class="mt-2">Total Supplier</h6>
                    <h3>{{ $totalSupplier }}</h3>
                </div>
            </div>
        </div>

    </section>

    {{-- INFO --}}
    <section class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Informasi</h5>
                    <p class="text-muted mb-0">
                        Halaman ini menyediakan ringkasan data inventaris.
                        Pengguna hanya memiliki akses baca terhadap data kategori,
                        barang, dan supplier.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

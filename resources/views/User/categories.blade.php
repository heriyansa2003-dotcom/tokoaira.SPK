@extends('layouts.app')
@section('title','Kategori Barang')

@section('content')

{{-- HEADER --}}
<div class="page-heading mb-4">
    <h3 class="fw-bold">Kategori Barang</h3>
    <p class="text-muted">
        Daftar kategori inventaris (akses baca)
    </p>
</div>

@if($categories->count() === 0)
    <div class="text-center py-5">
        <i class="bi bi-folder-x fs-1 text-muted"></i>
        <h6 class="mt-3">Belum ada kategori</h6>
    </div>
@else

{{-- GRID CARD --}}
<div class="row g-4">
    @foreach($categories as $category)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card category-user-card h-100">

                <div class="card-body d-flex align-items-center gap-3">
                    {{-- ICON --}}
                    <div class="category-icon">
                        <i class="bi bi-tags"></i>
                    </div>

                    {{-- TEXT --}}
                    <div>
                        <h6 class="mb-1 fw-semibold">
                            {{ $category->name }}
                        </h6>
                        <small class="text-muted">
                            Kategori inventaris
                        </small>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- PAGINATION --}}
<div class="d-flex justify-content-center mt-4">
    {{ $categories->links() }}
</div>

@endif
@endsection

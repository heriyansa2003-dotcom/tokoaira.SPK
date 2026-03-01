@extends('layouts.app')
@section('title','Data Supplier')

@section('content')

<div class="page-heading mb-4">
    <h3 class="fw-bold">Data Supplier</h3>
    <p class="text-muted">Daftar supplier inventaris (akses baca)</p>
</div>

@if($suppliers->count() === 0)
    <div class="text-center py-5">
        <i class="bi bi-truck fs-1 text-muted"></i>
        <h6 class="mt-3">Belum ada data supplier</h6>
    </div>
@else

<div class="row g-4">
    @foreach($suppliers as $supplier)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card supplier-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="supplier-icon mb-3">
                        <i class="bi bi-truck"></i>
                    </div>

                    <h6 class="fw-bold mb-1">
                        {{ $supplier->name }}
                    </h6>

                    <p class="mb-0 text-muted small">
                        <i class="bi bi-geo-alt"></i>
                        {{ $supplier->address ?? '-' }}
                    </p>

                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- PAGINATION --}}
<div class="d-flex justify-content-center mt-4">
    {{ $suppliers->links() }}
</div>

@endif
@endsection

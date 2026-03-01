@extends('layouts.app')
@section('title','Data Produk')

@section('content')

<div class="page-heading mb-4">
    <h3 class="fw-bold">Data Produk</h3>
    <p class="text-muted">Daftar produk inventaris (akses baca)</p>
</div>

@if($products->count() === 0)
    <div class="text-center py-5">
        <i class="bi bi-box fs-1 text-muted"></i>
        <h6 class="mt-3">Belum ada data produk</h6>
    </div>
@else

<div class="row g-4">
    @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card product-card h-100 border-0 shadow-sm">

                {{-- IMAGE --}}
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}">
                    @else
                        <div class="no-image">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <span class="badge category-badge mb-2">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </span>

                    <h6 class="fw-semibold mb-1">
                        {{ $product->name }}
                    </h6>

                    <p class="price mb-2">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </p>

                    <small class="text-muted">
                        Stok: {{ $product->stock }}
                    </small>
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- PAGINATION --}}
<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>

@endif
@endsection

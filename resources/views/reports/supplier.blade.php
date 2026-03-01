@extends('layouts.app')

@section('title', 'Laporan Pemesanan per Supplier')

@section('content')
<div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Laporan Pemesanan</h2>
            <p class="text-muted mb-0">Tentukan barang yang ingin dipesan untuk pengadaan stok</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.supplier') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold mb-2">Pilih Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}" {{ $selectedSupplierId == $sup->id ? 'selected' : '' }}>
                                        {{ $sup->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="low_stock" id="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="low_stock">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Hanya Stok Menipis
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Tampilkan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedSupplier)
    <form id="printForm" action="{{ route('admin.reports.supplier.print') }}" method="GET">
        <input type="hidden" name="supplier_id" value="{{ $selectedSupplierId }}">
        <input type="hidden" name="order_data" id="orderDataInput">
        
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-cart-check me-2"></i>Pemesanan: {{ $selectedSupplier->name }}</h5>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <small class="text-muted d-block">ESTIMASI TOTAL</small>
                        <h6 class="mb-0 text-primary" id="grandTotalDisplay">Rp 0</h6>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" onclick="submitAction('print')" class="btn btn-success">
                            <i class="bi bi-printer me-1"></i>Cetak
                        </button>
                        <button type="button" onclick="submitAction('pdf')" class="btn btn-danger">
                            <i class="bi bi-file-pdf me-1"></i>PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60" class="text-center">
                                <div class="form-check d-flex justify-content-center">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </div>
                            </th>
                            <th class="py-3">PRODUK & PRIORITAS</th>
                            <th class="py-3">KATEGORI</th>
                            <th class="py-3" width="180">HARGA SATUAN</th>
                            <th class="py-3 text-center">STOK</th>
                            <th class="py-3" width="140">QTY PESAN</th>
                            <th class="py-3" width="140">SATUAN</th>
                            <th class="py-3 text-end pe-4" width="180">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ahpService = app(App\Services\AHPService::class);
                            $ahpResults = $ahpService->calculatePriorities()->keyBy('id');
                        @endphp
                        @forelse($products as $product)
                        @php
                            $ahpInfo = $ahpResults->get($product->id);
                            $priority = $ahpInfo['priority'] ?? 'N/A';
                            $badgeClass = 'bg-secondary';
                            if($priority == 'Sangat Tinggi') $badgeClass = 'bg-danger';
                            elseif($priority == 'Tinggi') $badgeClass = 'bg-warning text-dark';
                            elseif($priority == 'Sedang') $badgeClass = 'bg-info text-dark';
                            elseif($priority == 'Rendah') $badgeClass = 'bg-success';
                        @endphp
                        <tr class="product-row" data-id="{{ $product->id }}">
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center">
                                    <input type="checkbox" class="form-check-input product-checkbox" data-id="{{ $product->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1">{{ $product->name }}</div>
                                <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1">
                                    <i class="bi bi-lightning-fill me-1"></i>{{ $priority }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $product->category->name ?? '-' }}</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control order-price" 
                                           value="{{ $product->price }}" data-id="{{ $product->id }}" min="0" disabled>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $product->stock <= 10 ? 'bg-danger' : 'bg-primary' }} rounded-pill px-3 py-2">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm order-qty" 
                                       placeholder="0" data-id="{{ $product->id }}" min="0" disabled>
                            </td>
                            <td>
                                <select class="form-select form-select-sm order-unit" data-id="{{ $product->id }}" disabled>
                                    <option value="Bungkus">Bungkus</option>
                                    <option value="Dos">Dos</option>
                                    <option value="Karton">Karton</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Bal">Bal</option>
                                    <option value="Pcs">Pcs</option>
                                </select>
                            </td>
                            <td class="text-end fw-bold text-primary" id="subtotal-{{ $product->id }}">
                                Rp 0
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada produk ditemukan untuk kriteria ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>Silakan pilih supplier untuk mulai membuat rencana pemesanan barang.
    </div>
    @endif
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const priceInputs = document.querySelectorAll('.order-price');
    const qtyInputs = document.querySelectorAll('.order-qty');

    if(checkAll) {
        checkAll.addEventListener('change', function() {
            productCheckboxes.forEach(cb => {
                cb.checked = this.checked;
                toggleInputs(cb);
            });
            calculateGrandTotal();
        });
    }

    productCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            toggleInputs(this);
            calculateGrandTotal();
        });
    });

    priceInputs.forEach(input => {
        input.addEventListener('input', function() {
            calculateSubtotal(this.getAttribute('data-id'));
            calculateGrandTotal();
        });
    });

    qtyInputs.forEach(input => {
        input.addEventListener('input', function() {
            calculateSubtotal(this.getAttribute('data-id'));
            calculateGrandTotal();
        });
    });

    function toggleInputs(checkbox) {
        const id = checkbox.getAttribute('data-id');
        const priceInput = document.querySelector(`.order-price[data-id="${id}"]`);
        const qtyInput = document.querySelector(`.order-qty[data-id="${id}"]`);
        const unitSelect = document.querySelector(`.order-unit[data-id="${id}"]`);
        
        priceInput.disabled = !checkbox.checked;
        qtyInput.disabled = !checkbox.checked;
        unitSelect.disabled = !checkbox.checked;
        
        if (!checkbox.checked) {
            qtyInput.value = '';
            calculateSubtotal(id);
        } else if (qtyInput.value === '') {
            qtyInput.value = 1;
            calculateSubtotal(id);
        }
    }

    function calculateSubtotal(id) {
        const price = parseFloat(document.querySelector(`.order-price[data-id="${id}"]`).value) || 0;
        const qty = parseFloat(document.querySelector(`.order-qty[data-id="${id}"]`).value) || 0;
        const subtotal = price * qty;
        
        document.getElementById(`subtotal-${id}`).innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        return subtotal;
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        productCheckboxes.forEach(cb => {
            if (cb.checked) {
                const id = cb.getAttribute('data-id');
                const price = parseFloat(document.querySelector(`.order-price[data-id="${id}"]`).value) || 0;
                const qty = parseFloat(document.querySelector(`.order-qty[data-id="${id}"]`).value) || 0;
                grandTotal += price * qty;
            }
        });
        document.getElementById('grandTotalDisplay').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
});

function submitAction(type) {
    const orderData = {};
    const checkedItems = document.querySelectorAll('.product-checkbox:checked');
    
    if (checkedItems.length === 0) {
        alert('Silakan pilih minimal satu barang untuk dipesan.');
        return;
    }

    let hasInvalidQty = false;
    checkedItems.forEach(cb => {
        const id = cb.getAttribute('data-id');
        const price = document.querySelector(`.order-price[data-id="${id}"]`).value;
        const qty = document.querySelector(`.order-qty[data-id="${id}"]`).value;
        const unit = document.querySelector(`.order-unit[data-id="${id}"]`).value;
        
        if (qty <= 0) {
            hasInvalidQty = true;
        }
        orderData[id] = { price, qty, unit };
    });

    if (hasInvalidQty) {
        alert('Jumlah pesanan untuk barang yang dipilih harus lebih dari 0.');
        return;
    }

    const form = document.getElementById('printForm');
    document.getElementById('orderDataInput').value = JSON.stringify(orderData);
    
    if (type === 'pdf') {
        form.action = "{{ route('admin.reports.supplier.pdf') }}";
        form.target = "_self"; // Langsung download di tab yang sama
    } else {
        form.action = "{{ route('admin.reports.supplier.print') }}";
        form.target = "_blank"; // Cetak di tab baru
    }
    
    form.submit();
}
</script>


@endsection

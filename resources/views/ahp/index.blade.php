@extends('layouts.app')

@section('title', 'Sistem Penunjang Keputusan - Prioritas Stok')

@section('content')
<div class="dashboard-container mb-4">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold mb-1">Sistem Penunjang Keputusan (SPK)</h2>
            <p class="text-muted mb-0">Optimasi Pengadaan Stok Barang dengan Metode Analytic Hierarchy Process (AHP)</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.ahp.print', $categoryId ? ['category_id' => $categoryId] : []) }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </a>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <!-- FILTER KATEGORI -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ahp.index') }}" class="d-flex gap-2 align-items-end">
                <div class="flex-grow-1">
                    <label for="category_id" class="form-label fw-bold">Filter Kategori</label>
                    <select name="category_id" id="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-funnel me-2"></i>Terapkan Filter
                </button>
                @if($categoryId)
                    <a href="{{ route('admin.ahp.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle me-2"></i>Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- STATISTIK RINGKAS -->
    <div class="stat-grid mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Total Produk</h6>
                        <small class="text-muted">Teranalisis</small>
                    </div>
                </div>
                <h3 class="fw-bold text-primary mb-0">{{ $statistics['total_products'] }}</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Stok Kritis</h6>
                        <small class="text-muted">Perlu Restock</small>
                    </div>
                </div>
                <h3 class="fw-bold text-danger mb-0">{{ $statistics['critical_stock'] }}</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">
                        <i class="bi bi-arrow-up-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Prioritas Tinggi</h6>
                        <small class="text-muted">Sangat Tinggi + Tinggi</small>
                    </div>
                </div>
                <h3 class="fw-bold text-warning mb-0">{{ $statistics['high_priority'] }}</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">
                        <i class="bi bi-percent fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Skor Rata-rata</h6>
                        <small class="text-muted">AHP Score</small>
                    </div>
                </div>
                <h3 class="fw-bold text-success mb-0">{{ number_format($statistics['avg_score'] * 100, 1) }}%</h3>
            </div>
        </div>
    </div>

    <!-- KRITERIA AHP -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Kriteria dan Bobot AHP</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem; flex-shrink: 0;">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Volume Penjualan</h6>
                            <p class="small text-muted mb-2">Mencari barang fast-moving dengan normalisasi Min-Max Scaling.</p>
                            <span class="badge bg-primary">{{ number_format($weights['sales_frequency'] * 100, 1) }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem; flex-shrink: 0;">
                            <i class="bi bi-layers-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Stok Minimum (Urgency)</h6>
                            <p class="small text-muted mb-2">Prioritas stok mendekati/di bawah ambang batas minimum.</p>
                            <span class="badge bg-purple">{{ number_format($weights['min_stock_ratio'] * 100, 1) }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem; flex-shrink: 0;">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Harga Satuan (Investasi)</h6>
                            <p class="small text-muted mb-2">Optimalisasi perputaran modal dengan high value investment.</p>
                            <span class="badge bg-success">{{ number_format($weights['price'] * 100, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VISUALISASI: TOP 10 BARANG PRIORITAS -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Top 10 Barang Prioritas Pengadaan</h5>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 400px;">
                <canvas id="topPrioritiesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- TABEL LENGKAP PRIORITAS PENGADAAN -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-list-stars me-2"></i>Peringkat Prioritas Pengadaan Lengkap</h5>
                <span class="badge bg-primary">{{ count($priorities) }} Produk</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="prioritiesTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">Rank</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Stok Saat Ini</th>
                            <th class="text-center">Volume Penjualan</th>
                            <th>Harga Satuan</th>
                            <th width="220">Skor Prioritas</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($priorities as $index => $item)
                        <tr>
                            <td class="text-center">
                                @if($index == 0)
                                    <div class="avatar avatar-md bg-warning shadow-sm mx-auto">
                                        <span class="avatar-content text-dark fw-bold"><i class="bi bi-trophy-fill"></i></span>
                                    </div>
                                @elseif($index == 1)
                                    <div class="avatar avatar-md bg-light-secondary mx-auto">
                                        <span class="avatar-content text-dark fw-bold">2</span>
                                    </div>
                                @elseif($index == 2)
                                    <div class="avatar avatar-md bg-light-warning mx-auto">
                                        <span class="avatar-content text-dark fw-bold">3</span>
                                    </div>
                                @else
                                    <span class="fw-bold text-muted">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-0">
                                        <h6 class="mb-0 fw-bold">{{ $item['name'] }}</h6>
                                        <small class="text-muted">ID: #PROD-{{ $item['id'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light-info text-dark">{{ $item['category_name'] }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fw-bold {{ $item['stock'] <= $item['min_stock'] ? 'text-danger' : 'text-dark' }}">
                                        {{ $item['stock'] }} {{ $item['unit'] }}
                                    </span>
                                    <small class="text-muted">Min: {{ $item['min_stock'] }} {{ $item['unit'] }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light-primary text-primary px-3">{{ $item['sales_frequency'] }}x</span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress progress-primary progress-sm w-100 me-3" style="height: 8px;">
                                        <div class="progress-bar shadow-none" role="progressbar" style="width: {{ $item['score'] * 100 }}%" aria-valuenow="{{ $item['score'] }}" aria-valuemin="0" aria-valuemax="1"></div>
                                    </div>
                                    <span class="fw-bold text-primary">{{ number_format($item['score'] * 100, 1) }}%</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item['priority'] == 'Sangat Tinggi')
                                    <span class="badge bg-danger px-3 py-2 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-1"></i>Sangat Tinggi</span>
                                @elseif($item['priority'] == 'Tinggi')
                                    <span class="badge bg-warning text-dark px-3 py-2 shadow-sm"><i class="bi bi-arrow-up-circle-fill me-1"></i>Tinggi</span>
                                @elseif($item['priority'] == 'Sedang')
                                    <span class="badge bg-info px-3 py-2 shadow-sm"><i class="bi bi-dash-circle-fill me-1"></i>Sedang</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i>Rendah</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x display-6 d-block mb-3"></i>
                                Data produk belum tersedia untuk dianalisis.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .bg-purple {
        background-color: #7c3aed !important;
        color: white !important;
    }
    .text-purple { color: #6f42c1 !important; }
    .bg-light-purple { background-color: #f3e5f5 !important; }
    .border-purple { border-color: #6f42c1 !important; }
    .table-lg th, .table-lg td { padding: 1.2rem 1rem; }
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-5px); }
    .stats-icon { width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; border-radius: 0.7rem; }
</style>

<!-- CHART.JS LIBRARY -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk Top 10 Barang Prioritas
    const topPrioritiesData = @json($topPriorities);
    
    if (topPrioritiesData && topPrioritiesData.length > 0) {
        const labels = topPrioritiesData.map(item => item.name);
        const scores = topPrioritiesData.map(item => (item.score * 100).toFixed(1));
        const colors = topPrioritiesData.map(item => {
            if (item.priority === 'Sangat Tinggi') return '#ef4444';
            if (item.priority === 'Tinggi') return '#f59e0b';
            if (item.priority === 'Sedang') return '#06b6d4';
            return '#6b7280';
        });

        const ctx = document.getElementById('topPrioritiesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Prioritas AHP (%)',
                    data: scores,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Skor: ' + context.parsed.x.toFixed(1) + '%';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

@endsection

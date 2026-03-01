<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="dashboard-container">

    <!-- WELCOME SECTION -->
    <div class="welcome-card mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="welcome-icon me-4 d-none d-md-flex">
                    <i class="bi bi-shop-window fs-1 text-primary"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Selamat Datang di <span class="text-primary">Toko Aira SRC</span></h4>
                    <p class="mb-0 text-muted">Ringkasan sistem inventaris barang hari ini. Kelola stok Anda dengan lebih efisien.</p>
                </div>
            </div>
            <div class="text-end d-none d-lg-block">
                <span class="badge bg-primary text-white p-2 px-3 shadow-sm" id="todayDate"></span>
            </div>
        </div>
    </div>

    <!-- STATISTICS GRID -->
    <div class="stat-grid mb-4">
        <div class="stat-box stat-blue">
            <span>Total Kategori</span>
            <h2><?php echo e($totalKategori ?? 0); ?></h2>
            <div class="stat-icon"><i class="bi bi-tags"></i></div>
        </div>

        <div class="stat-box stat-green">
            <span>Total Barang</span>
            <h2><?php echo e($totalBarang ?? 0); ?></h2>
            <div class="stat-icon"><i class="bi bi-box"></i></div>
        </div>

        <div class="stat-box stat-orange">
            <span>Total Supplier</span>
            <h2><?php echo e($totalSupplier ?? 0); ?></h2>
            <div class="stat-icon"><i class="bi bi-truck"></i></div>
        </div>

        <div class="stat-box stat-red">
            <span>Barang Prioritas</span>
            <h2><?php echo e(count($stokRendahAHP) ?? 0); ?></h2>
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
        </div>
    </div>

    <!-- PRIORITY ITEMS TABLE -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="bi bi-graph-up-arrow me-2 text-danger"></i>Daftar Barang Prioritas (AHP)</h5>
                    </div>
                    <a href="<?php echo e(route('admin.ahp.index')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Detail
                    </a>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Menampilkan barang dengan prioritas <strong>Sangat Tinggi</strong> dan <strong>Tinggi</strong> berdasarkan perhitungan real-time AHP.
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Stok / Min</th>
                                    <th>Penjualan</th>
                                    <th>Harga</th>
                                    <th>Skor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $stokRendahAHP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($item['name']); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($item['stock'] <= $item['min_stock'] ? 'bg-danger' : 'bg-warning'); ?>">
                                            <?php echo e($item['stock']); ?> / <?php echo e($item['min_stock']); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($item['sales_frequency']); ?>x</span>
                                    </td>
                                    <td class="fw-semibold">Rp <?php echo e(number_format($item['price'], 0, ',', '.')); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress" style="width: 60px; height: 4px; margin-right: 0.5rem;">
                                                <div class="progress-bar bg-primary" style="width: <?php echo e($item['score'] * 100); ?>%"></div>
                                            </div>
                                            <small class="text-muted"><?php echo e(round($item['score'] * 100, 0)); ?>%</small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($item['priority'] == 'Sangat Tinggi'): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i>Sangat Tinggi
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-arrow-up-circle-fill me-1"></i>Tinggi
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox fs-3 text-muted d-block mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada barang dengan prioritas tinggi saat ini.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const el = document.getElementById("todayDate");
        if (el) {
            el.textContent = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Toko_Aira-FINAL deploy\resources\views/dashboard/index.blade.php ENDPATH**/ ?>
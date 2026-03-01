<?php $__env->startSection('title', 'Data Produk'); ?>

<?php $__env->startSection('content'); ?>

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Produk</h2>
            <p class="text-muted mb-0">
                Kelola data barang dalam sistem inventaris
            </p>
        </div>

        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.products.create')); ?>"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Produk
        </a>
        <?php endif; ?>
    </div>

    <!-- ALERT -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- SEARCH FORM -->
    <div class="card mb-4">
        <div class="card-body">
                <form action="<?php echo e(route('admin.products.index')); ?>" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label fw-bold mb-2">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Ketik nama produk..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="category_id" class="form-label fw-bold mb-2">Filter Kategori</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <?php if(request('search') || request('category_id')): ?>
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    <!-- CARD TABLE -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Daftar Produk</h5>
                <span class="badge bg-primary">Total: <?php echo e($products->count()); ?> Produk</span>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="100">Produk</th>
                            <th>Nama & Kategori</th>
                            <th>Harga Jual</th>
                            <th>Stok Tersedia</th>
                            <th>Penjualan</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($product->image): ?>
                                    <div class="product-img-wrapper shadow-sm rounded-3 overflow-hidden" style="width: 64px; height: 64px;">
                                        <img src="<?php echo e(asset('storage/'.$product->image)); ?>" class="w-100 h-100 object-fit-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 64px; height: 64px;">
                                        <i class="bi bi-image fs-4"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?php echo e($product->name); ?></div>
                                <span class="badge bg-info">
                                    <i class="bi bi-tag me-1"></i><?php echo e($product->category->name ?? 'Tanpa Kategori'); ?>

                                </span>
                            </td>
                            <td class="fw-semibold text-dark">
                                Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php
                                        $isLow = $product->stock <= $product->min_stock;
                                        $percent = $product->stock > 0 ? min(100, ($product->stock / ($product->min_stock * 3)) * 100) : 0;
                                        $barClass = $isLow ? 'bg-danger' : 'bg-success';
                                    ?>
                                    <div class="me-3">
                                        <div class="fw-bold <?php echo e($isLow ? 'text-danger' : 'text-dark'); ?>">
                                            <?php echo e($product->stock); ?> <small class="text-muted fw-normal"><?php echo e($product->unit); ?></small>
                                        </div>
                                        <div class="progress mt-1" style="height: 4px; width: 80px;">
                                            <div class="progress-bar <?php echo e($barClass); ?>" role="progressbar" style="width: <?php echo e($percent); ?>%"></div>
                                        </div>
                                    </div>
                                    <?php if($isLow): ?>
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 x-small">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Stok Tipis
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-graph-up-arrow me-2 text-success"></i>
                                    <span><?php echo e($product->sales_frequency); ?>x terjual</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo e(route('admin.products.edit',$product->id)); ?>"
                                       class="btn btn-icon btn-warning-soft rounded-3" title="Edit Produk">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.products.destroy',$product->id)); ?>"
                                          method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-icon btn-danger-soft rounded-3"
                                            onclick="return confirm('Hapus produk ini?')" title="Hapus Produk">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada produk yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Toko_Aira-FINAL\resources\views/products/index.blade.php ENDPATH**/ ?>
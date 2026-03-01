<?php $__env->startSection('title', 'Data Kategori'); ?>

<?php $__env->startSection('content'); ?>

<div class="dashboard-container">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Kategori</h2>
            <p class="text-muted mb-0">
                Kelola kategori barang dalam sistem inventaris
            </p>
        </div>

        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.categories.create')); ?>"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
        </a>
        <?php endif; ?>
    </div>

    <!-- ALERT SUCCESS -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- MAIN CARD -->
    <div class="card">
        <!-- CARD HEADER -->
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Daftar Kategori</h5>
        </div>


        <!-- CARD BODY -->
        <div class="card-body">
            <?php if($categories->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <h5 class="fw-semibold">Belum ada kategori</h5>
                    <p class="text-muted mb-3">
                        Tambahkan kategori untuk mulai mengelola data barang.
                    </p>
                    <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Buat Kategori Pertama
                    </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kategori</th>
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <th width="140" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?php echo e($index + 1); ?></td>
                            <td>
                                <span class="fw-semibold text-dark">
                                    <i class="bi bi-tag me-2 text-primary"></i>
                                    <?php echo e($category->name); ?>

                                </span>
                            </td>
                            <?php if(auth()->user()->role === 'admin'): ?>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>"
                                   class="btn btn-sm btn-warning-soft me-1"
                                   data-bs-toggle="tooltip"
                                   title="Edit Kategori">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>"
                                      method="POST"
                                      class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button
                                        class="btn btn-sm btn-danger-soft"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Kategori">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- CARD FOOTER -->
        <?php if(!$categories->isEmpty()): ?>
        <div class="card-footer">
            <small class="text-muted">Total <?php echo e($categories->count()); ?> kategori</small>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Toko_Aira-FINAL\resources\views/categories/index.blade.php ENDPATH**/ ?>
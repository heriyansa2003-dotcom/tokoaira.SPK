<div id="sidebar">
    <div class="sidebar-wrapper">

        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <div class="logo-icon me-2">
                    <i class="bi bi-shop-window text-white fs-3"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-0" style="letter-spacing: 1px;">AIRA <span style="color: #ffcc00;">SRC</span></h4>
                    <small class="text-white-50" style="font-size: 0.7rem; text-transform: uppercase;">Inventory System</small>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

             

                <li class="sidebar-title text-white-50">Menu Utama</li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-item <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.categories.index')); ?>">
                        <i class="bi bi-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.products.index')); ?>">
                        <i class="bi bi-box-seam"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.suppliers.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.suppliers.index')); ?>">
                        <i class="bi bi-truck"></i>
                        <span>Supplier</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.ahp.index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.ahp.index')); ?>">
                        <i class="bi bi-cpu"></i>
                        <span>SPK Prioritas (AHP)</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.reports.supplier')); ?>">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Laporan Pemesanan</span>
                    </a>
                </li>

                <li class="sidebar-title text-white-50">Pengaturan</li>

                <li class="sidebar-item <?php echo e(request()->routeIs('admin.management.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.management.index')); ?>">
                        <i class="bi bi-people"></i>
                        <span>Manajemen Admin</span>
                    </a>
                </li>

            </ul>
        </div>

    </div>
</div>
<?php /**PATH C:\laragon\www\Toko_Aira-FINAL\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>
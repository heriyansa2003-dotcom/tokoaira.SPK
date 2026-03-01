<nav class="navbar navbar-expand navbar-light bg-transparent">
    <div class="container-fluid d-flex align-items-center">

        
        <button
            class="btn btn-light d-lg-none me-3"
            id="sidebarToggle"
            aria-label="Toggle Sidebar"
        >
            <i class="bi bi-list fs-4"></i>
        </button>

        
        <span class="navbar-brand mb-0 fw-semibold">
            <?php echo e(auth()->user()->name); ?>

        </span>

        
        <div class="ms-auto d-flex align-items-center">
            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-primary me-2">
                <i class="bi bi-person-circle me-1"></i> Profil
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-logout-danger">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>


    </div>
</nav>
<?php /**PATH C:\laragon\www\Toko_Aira-FINAL\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>
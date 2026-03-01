<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Inventaris'); ?></title>

    
    <link rel="stylesheet" href="<?php echo e(asset('mazer/assets/compiled/css/app.css')); ?>">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    
    <link rel="stylesheet" href="<?php echo e(asset('css/custom-theme.css')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('css/modern-theme.css')); ?>">
    <style>
        /* password visibility toggle for profile and auth forms */
        .password-wrapper { position: relative; }
        .password-wrapper .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
            font-size: 1.05rem;
        }
    </style>
</head>
<body>

<div id="app">
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div id="main">
        <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>


<div id="sidebarOverlay" class="sidebar-overlay"></div>


<script src="<?php echo e(asset('mazer/assets/compiled/js/app.js')); ?>"></script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");

    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("show");
        });
    }

    if (overlay) {
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("active");
            overlay.classList.remove("show");
        });
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function (icon) {
        icon.addEventListener('click', function () {
            var targetId = this.getAttribute('data-target');
            if (!targetId) return;
            var input = document.getElementById(targetId);
            if (!input) return;
            var type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
});
</script>

</body>
</html>
<?php /**PATH C:\laragon\www\Toko_Aira-FINAL deploy\resources\views/layouts/app.blade.php ENDPATH**/ ?>
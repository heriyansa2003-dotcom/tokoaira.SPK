<?php $__env->startSection('title','Login'); ?>

<?php $__env->startSection('form'); ?>
<div class="mb-4">
    <h2>TOKO AIRA <span>SRC</span></h2>
    <small>Inventory Management System</small>
</div>
<p>
    Masukkan Akun Anda Untuk Mengakses Sistem Inventaris
</p>

<?php if($errors->any()): ?>
<div class="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    <?php echo e($errors->first()); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login')); ?>">
<?php echo csrf_field(); ?>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email"
           id="email"
           name="email"
           placeholder="nama@email.com"
           required>
</div>

<div class="form-group password-wrapper">
    <label for="password">Password</label>
    <input type="password"
           id="password"
           name="password"
           placeholder="••••••••"
           required>
    
    <i class="bi bi-eye toggle-password" id="togglePassword"></i>
</div>

<button type="submit" class="btn btn-primary w-100">
    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
</button>
</form>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        if (toggle && password) {
            toggle.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // swap icon styles
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('auth.auth-split', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Toko_Aira-FINAL deploy\resources\views/auth/login.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>

    
    <link rel="stylesheet" href="<?php echo e(asset('mazer/assets/compiled/css/app.css')); ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/modern-theme.css')); ?>">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-wrapper {
            width: 100%;
            padding: 0.75rem;
        }

        .auth-card {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 18.75px 45px rgba(0, 0, 0, 0.3);
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #ffffff;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(22.5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-left {
            padding: 2.625rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-right {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #1e3c72 100%);
            color: #ffffff;
            padding: 2.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-right::before {
            content: '';
            position: absolute;
            top: -37.5%;
            right: -15%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-right::after {
            content: '';
            position: absolute;
            bottom: -22.5%;
            left: -7.5%;
            width: 225px;
            height: 225px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-right-content {
            position: relative;
            z-index: 1;
        }

        .auth-right-icon {
            font-size: 3rem;
            margin-bottom: 1.125rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            width: 75px;
            height: 75px;
            border-radius: 15px;
            backdrop-filter: blur(7.5px);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7.5px); }
        }

        .auth-right h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            letter-spacing: -0.375px;
        }

        .auth-right p {
            font-size: 0.875rem;
            line-height: 1.5;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .auth-left h2 {
            font-size: 1.3125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.375rem;
            letter-spacing: -0.375px;
        }

        .auth-left h2 span {
            color: #2563eb;
            font-weight: 700;
        }

        .auth-left small {
            font-size: 0.6375rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            display: block;
            margin-bottom: 1.125rem;
        }

        .auth-left > p {
            color: #6b7280;
            margin-bottom: 1.5rem;
            font-size: 0.7125rem;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 0.9375rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.375rem;
            font-size: 0.7125rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.65625rem 0.75rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 7.5px;
            font-size: 0.7125rem;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: #ffffff;
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        /* password visibility toggle */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .auth-left form button {
            width: 100%;
            padding: 0.65625rem;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: #ffffff;
            border: none;
            border-radius: 7.5px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 11.25px rgba(37, 99, 235, 0.3);
            margin-top: 0.375rem;
        }

        .auth-left form button:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 6px 18.75px rgba(37, 99, 235, 0.4);
        }

        .auth-left form button:active {
            transform: translateY(0);
        }

        .alert {
            margin-bottom: 1.125rem;
            padding: 0.75rem;
            border-radius: 7.5px;
            border-left: 3px solid #ef4444;
            background: linear-gradient(135deg, #fee2e2 0%, #ffffff 100%);
            color: #991b1b;
            font-weight: 500;
            font-size: 0.7125rem;
        }

        hr {
            margin: 1.5rem 0;
            border: none;
            border-top: 1px solid #e5e7eb;
        }

        .auth-left > div {
            text-align: center;
        }

        .auth-left a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.7125rem;
            transition: all 0.3s ease;
        }

        .auth-left a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
            }
            .auth-right {
                display: none;
            }
            .auth-left {
                padding: 1.5rem;
            }
            .auth-left h2 {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
            }
            .auth-right {
                display: none;
            }
            .auth-left {
                padding: 1.5rem;
            }
            .auth-left h2 {
                font-size: 1.125rem;
            }
            .form-group input {
                padding: 0.65625rem 0.75rem;
                font-size: 0.85rem;
                min-height: 40px;
            }
            .form-group label {
                font-size: 0.8rem;
            }
            .auth-left form button {
                padding: 0.65625rem;
                font-size: 0.9rem;
                min-height: 40px;
            }
        }

        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 0.5rem;
            }
            .auth-card {
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
            .auth-left {
                padding: 1.25rem;
            }
            .auth-left h2 {
                font-size: 1rem;
                margin-bottom: 0.25rem;
            }
            .auth-left small {
                font-size: 0.6rem;
                margin-bottom: 0.75rem;
            }
            .auth-left > p {
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }
            .form-group {
                margin-bottom: 0.75rem;
            }
            .form-group label {
                font-size: 0.75rem;
                margin-bottom: 0.3rem;
            }
            .form-group input {
                padding: 0.6rem 0.65rem;
                font-size: 1rem;
                min-height: 44px;
                border-radius: 6px;
            }
            .password-wrapper .toggle-password {
                right: 0.65rem;
                font-size: 1rem;
            }
            .auth-left form button {
                padding: 0.6rem;
                font-size: 0.85rem;
                min-height: 44px;
                border-radius: 6px;
                margin-top: 0.25rem;
            }
            .alert {
                margin-bottom: 0.875rem;
                padding: 0.65rem;
                border-radius: 6px;
                font-size: 0.75rem;
            }
            hr {
                margin: 1rem 0;
            }
            .auth-left a {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .auth-left {
                padding: 1rem;
            }
            .auth-left h2 {
                font-size: 0.9rem;
            }
            .auth-left small {
                font-size: 0.55rem;
            }
            .auth-left > p {
                font-size: 0.75rem;
                margin-bottom: 0.75rem;
            }
            .form-group {
                margin-bottom: 0.65rem;
            }
            .form-group label {
                font-size: 0.7rem;
                margin-bottom: 0.25rem;
            }
            .form-group input {
                padding: 0.55rem 0.6rem;
                font-size: 0.95rem;
                min-height: 40px;
                border-radius: 6px;
            }
            .auth-left form button {
                padding: 0.55rem;
                font-size: 0.8rem;
                min-height: 40px;
                margin-top: 0.2rem;
            }
            .alert {
                padding: 0.6rem;
                font-size: 0.7rem;
            }
        }

        @media (max-width: 360px) {
            .auth-wrapper {
                padding: 0.35rem;
            }
            .auth-left {
                padding: 0.875rem;
            }
            .auth-left h2 {
                font-size: 0.85rem;
            }
            .form-group input {
                padding: 0.5rem 0.55rem;
                font-size: 0.9rem;
            }
            .auth-left form button {
                padding: 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="auth-left">
            <?php echo $__env->yieldContent('form'); ?>
            <hr>
            <div>
                <a href="<?php echo $__env->yieldContent('switch-url'); ?>" class="text-decoration-none">
                    <?php echo $__env->yieldContent('switch-text'); ?>
                </a>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-right-content">
                <div class="auth-right-icon">
                    <i class="bi bi-shop-window"></i>
                </div>
                <h2>Toko Aira SRC</h2>
                <p>
                    Sistem Manajemen Inventaris Terpadu yang modern dan efisien. Kelola stok, kategori, dan supplier dengan mudah dalam satu platform terintegrasi.
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\laragon\www\Toko_Aira-FINAL deploy\resources\views/auth/auth-split.blade.php ENDPATH**/ ?>
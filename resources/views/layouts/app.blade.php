<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventaris')</title>

    {{-- MAZER CSS --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">

    {{-- BOOTSTRAP ICONS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CUSTOM THEME --}}
    <link rel="stylesheet" href="{{ asset('css/custom-theme.css') }}">

    {{-- MODERN PROFESSIONAL THEME --}}
    <link rel="stylesheet" href="{{ asset('css/modern-theme.css') }}">
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
    @include('layouts.sidebar')

    <div id="main">
        @include('layouts.navbar')

        <div class="page-content">
            @yield('content')
        </div>
    </div>
</div>

{{-- OVERLAY (MOBILE SIDEBAR) --}}
<div id="sidebarOverlay" class="sidebar-overlay"></div>

{{-- MAZER JS --}}
<script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>

{{-- SIDEBAR TOGGLE JS --}}
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

{{-- Password toggle script for any toggle-password icons --}}
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

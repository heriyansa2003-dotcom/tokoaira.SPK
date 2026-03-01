@extends('auth.auth-split')

@section('title','Login')

@section('form')
<div class="mb-4">
    <h2>TOKO AIRA <span>SRC</span></h2>
    <small>Inventory Management System</small>
</div>
<p>
    Masukkan Akun Anda Untuk Mengakses Sistem Inventaris
</p>

@if($errors->any())
<div class="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('login') }}">
@csrf

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
    {{-- eye icon to toggle visibility --}}
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

@endsection

{{-- @section('switch-url', route('register')) --}}
{{-- @section('switch-text', 'Create new account') --}}

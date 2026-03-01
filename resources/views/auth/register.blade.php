@extends('auth.auth-split')

@section('title','Register')

@section('form')
<h2 class="mb-2">Create Account ✨</h2>
<p class="mb-4 text-muted">
    Lengkapi data untuk mulai menggunakan sistem inventaris
</p>

@if($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="mb-3">
    <label>Nama Lengkap</label>
    <input type="text"
           name="name"
           class="form-control"
           placeholder="Nama lengkap"
           value="{{ old('name') }}"
           required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email"
           name="email"
           class="form-control"
           placeholder="email@email.com"
           value="{{ old('email') }}"
           required>
</div>

<div class="mb-3">
    <label>Password</label>
    <input type="password"
           name="password"
           class="form-control"
           placeholder="********"
           required>
</div>

<div class="mb-4">
    <label>Konfirmasi Password</label>
    <input type="password"
           name="password_confirmation"
           class="form-control"
           placeholder="********"
           required>
</div>

<button class="btn btn-primary w-100">
    Register
</button>
</form>
@endsection

@section('switch-url', route('login'))
@section('switch-text', 'Already have an account?')

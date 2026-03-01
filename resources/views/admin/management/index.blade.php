@extends('layouts.app')

@section('title', 'Manajemen Admin')

@section('content')
<div class="dashboard-container mb-4">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Admin</h2>
            <p class="text-muted mb-0">Kelola akun administrator sistem.</p>
        </div>
        <a href="{{ route('admin.management.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Admin
        </a>
    </div>
</div>

<div class="dashboard-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Admin</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td class="fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 0.75rem; font-weight: bold;">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <span class="fw-semibold">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($admin->role) }}</span></td>
                            <td>
                                @if(auth()->id() !== $admin->id)
                                    <form action="{{ route('admin.management.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-0">Belum ada admin terdaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
</div>
@endsection

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\UserSupplierController;
/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
| Saat aplikasi dibuka pertama kali, user diarahkan ke halaman login
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, Logout)
|--------------------------------------------------------------------------
| Route bawaan Laravel Breeze
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes (Full CRUD)
|--------------------------------------------------------------------------
| Hanya dapat diakses oleh Admin
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // CRUD Data Master
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::get('products/print', [ProductController::class, 'print'])->name('admin.products.print');
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::get('suppliers/{supplier}/products', [SupplierController::class, 'manageProducts'])->name('admin.suppliers.manage_products');
    Route::post('suppliers/{supplier}/products', [SupplierController::class, 'updateProducts'])->name('admin.suppliers.update_products');
    Route::resource('suppliers', SupplierController::class)->names('admin.suppliers');

    // Prioritas Stok AHP
    Route::get('ahp-priority', [\App\Http\Controllers\AHPController::class, 'index'])->name('admin.ahp.index');
    Route::get('ahp-priority/print', [\App\Http\Controllers\AHPController::class, 'print'])->name('admin.ahp.print');
    Route::get('api/ahp-data', [\App\Http\Controllers\AHPController::class, 'getAHPData'])->name('admin.ahp.api');

    // Laporan Supplier
    Route::get('reports/supplier', [ReportController::class, 'supplierReport'])->name('admin.reports.supplier');
    Route::get('reports/supplier/print', [ReportController::class, 'printSupplierReport'])->name('admin.reports.supplier.print');
    Route::get('reports/supplier/pdf', [ReportController::class, 'downloadSupplierPDF'])->name('admin.reports.supplier.pdf');

    // Profile Admin
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Admin
    Route::get('/management', [\App\Http\Controllers\AdminManagementController::class, 'index'])->name('admin.management.index');
    Route::get('/management/create', [\App\Http\Controllers\AdminManagementController::class, 'create'])->name('admin.management.create');
    Route::post('/management', [\App\Http\Controllers\AdminManagementController::class, 'store'])->name('admin.management.store');
    Route::delete('/management/{user}', [\App\Http\Controllers\AdminManagementController::class, 'destroy'])->name('admin.management.destroy');
});


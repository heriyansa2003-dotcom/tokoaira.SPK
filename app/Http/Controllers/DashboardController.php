<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\AHPService;

class DashboardController extends Controller
{
    protected $ahpService;

    public function __construct(AHPService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    public function index()
    {
        $priorities = $this->ahpService->calculatePriorities();
        
        // Ambil barang dengan prioritas Sangat Tinggi dan Tinggi untuk dashboard
        $stokRendahAHP = $priorities->filter(function($item) {
            return in_array($item['priority'], ['Sangat Tinggi', 'Tinggi']);
        });

        return view('dashboard.index', [
            'totalKategori' => Category::count(),
            'totalBarang'   => Product::count(),
            'totalSupplier' => Supplier::count(),
            'stokRendah'    => Product::where('stock', '<=', 5)->count(),
            'stokRendahAHP' => $stokRendahAHP,
        ]);
    }
}

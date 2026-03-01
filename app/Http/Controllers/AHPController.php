<?php

namespace App\Http\Controllers;

use App\Services\AHPService;
use Illuminate\Http\Request;

class AHPController extends Controller
{
    protected $ahpService;

    public function __construct(AHPService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    /**
     * Tampilkan halaman SPK dengan filter kategori
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id', null);
        $categories = $this->ahpService->getCategories();
        $priorities = $this->ahpService->calculatePriorities($categoryId);
        $topPriorities = $this->ahpService->getTopPriorities(10, $categoryId);
        $statistics = $this->ahpService->getStatistics($categoryId);
        $weights = $this->ahpService->getWeights();
        
        return view('ahp.index', compact(
            'priorities',
            'topPriorities',
            'categories',
            'categoryId',
            'statistics',
            'weights'
        ));
    }

    /**
     * Cetak laporan SPK
     */
    public function print(Request $request)
    {
        $categoryId = $request->get('category_id', null);
        $categories = $this->ahpService->getCategories();
        $priorities = $this->ahpService->calculatePriorities($categoryId);
        $statistics = $this->ahpService->getStatistics($categoryId);
        $weights = $this->ahpService->getWeights();
        
        return view('ahp.print', compact(
            'priorities',
            'categories',
            'categoryId',
            'statistics',
            'weights'
        ));
    }

    /**
     * API endpoint untuk mendapatkan data AHP dalam format JSON
     */
    public function getAHPData(Request $request)
    {
        $categoryId = $request->get('category_id', null);
        $limit = $request->get('limit', 10);
        
        $topPriorities = $this->ahpService->getTopPriorities($limit, $categoryId);
        $statistics = $this->ahpService->getStatistics($categoryId);
        
        return response()->json([
            'success' => true,
            'data' => $topPriorities,
            'statistics' => $statistics
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use App\Services\AHPService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $ahpService;

    public function __construct(AHPService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    public function supplierReport(Request $request)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $selectedSupplierId = $request->get('supplier_id');
        $lowStockFilter = $request->has('low_stock');

        $products = collect();
        $selectedSupplier = null;

        if ($selectedSupplierId) {
            $selectedSupplier = Supplier::find($selectedSupplierId);
            $query = Product::where('supplier_id', $selectedSupplierId);
            
            $allProductsOfSupplier = $query->with('category')->get();
            
            // Filter produk berdasarkan stok menipis jika checkbox dicentang
            if ($lowStockFilter) {
                $products = $allProductsOfSupplier->filter(function($product) {
                    return $product->stock <= $product->min_stock;
                });
            } else {
                $products = $allProductsOfSupplier;
            }
        }

        return view('reports.supplier', compact('suppliers', 'products', 'selectedSupplier', 'selectedSupplierId', 'lowStockFilter'));
    }

    public function printSupplierReport(Request $request)
    {
        $data = $this->prepareReportData($request);
        $data['isPdf'] = false;
        return view('reports.print_supplier', $data);
    }

    public function downloadSupplierPDF(Request $request)
    {
        $data = $this->prepareReportData($request);
        $data['isPdf'] = true;
        
        $pdf = Pdf::loadView('reports.print_supplier', $data);
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'Nota_Pemesanan_' . ($data['supplier']->name ?? 'Supplier') . '_' . date('Ymd') . '.pdf';
        
        return $pdf->download($filename);
    }

    private function prepareReportData(Request $request)
    {
        $supplierId = $request->get('supplier_id');
        $orderData = json_decode($request->get('order_data', '{}'), true);
        
        $selectedProductIds = array_keys($orderData);
        $supplier = Supplier::findOrFail($supplierId);
        
        if (empty($selectedProductIds)) {
            $products = collect();
        } else {
            $products = Product::whereIn('id', $selectedProductIds)
                ->with('category')
                ->get();

            foreach ($products as $product) {
                if (isset($orderData[$product->id])) {
                    $product->order_price = $orderData[$product->id]['price'];
                    $product->order_qty = $orderData[$product->id]['qty'];
                    $product->order_unit = $orderData[$product->id]['unit'];
                    $product->subtotal = $product->order_price * $product->order_qty;
                }
            }
        }

        $totalPrice = $products->sum('subtotal');

        return compact('supplier', 'products', 'totalPrice');
    }
}

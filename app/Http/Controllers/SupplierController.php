<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|digits_between:10,15|numeric|regex:/^0/',
            'address' => 'required',
        ]);

        Supplier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|digits_between:10,15|numeric|regex:/^0/',
            'address' => 'required',
        ]);

        $supplier->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus');
    }

    public function manageProducts(Request $request, Supplier $supplier)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        
        $query = \App\Models\Product::with('category');
        
        // Filter by product name
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        // Filter by category
        if ($category) {
            $query->where('category_id', $category);
        }
        
        $products = $query->orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        $supplierProducts = $supplier->products()->pluck('id')->toArray();
        
        return view('suppliers.manage_products', compact('supplier', 'products', 'categories', 'supplierProducts', 'search', 'category'));
    }

    public function updateProducts(Request $request, Supplier $supplier)
    {
        $productIds = $request->input('product_ids', []);
        
        // Reset supplier_id for products previously owned by this supplier
        \App\Models\Product::where('supplier_id', $supplier->id)->update(['supplier_id' => null]);
        
        // Set supplier_id for selected products
        if (!empty($productIds)) {
            \App\Models\Product::whereIn('id', $productIds)->update(['supplier_id' => $supplier->id]);
        }

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Produk supplier berhasil diperbarui');
    }
}

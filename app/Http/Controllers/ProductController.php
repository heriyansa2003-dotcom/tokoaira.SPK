<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category_id');
        $supplier_id = $request->input('supplier_id');

        $query = Product::with(['category', 'supplier']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($supplier_id) {
            $query->where('supplier_id', $supplier_id);
        }

        $products = $query->latest()->get();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',

            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:20',
            'sales_frequency' => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,

            'price'       => $request->price,
            'stock'       => $request->stock,
            'min_stock'   => $request->min_stock,
            'unit'        => $request->unit,
            'sales_frequency' => $request->sales_frequency,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',

            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => 'required|string|max:20',
            'sales_frequency' => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'category_id' => $request->category_id,

            'price'       => $request->price,
            'stock'       => $request->stock,
            'min_stock'   => $request->min_stock,
            'unit'        => $request->unit,
            'sales_frequency' => $request->sales_frequency,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function print(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category_id');
        $supplier_id = $request->input('supplier_id');

        $query = Product::with(['category', 'supplier']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($supplier_id) {
            $query->where('supplier_id', $supplier_id);
        }

        $products = $query->latest()->get();

        return view('products.print', compact('products'));
    }
}

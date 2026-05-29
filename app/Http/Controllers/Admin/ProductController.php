<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $products = Product::with(['brand', 'category', 'variants'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->checkAdmin();
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shade_name.*' => 'required|string',
            'hex_color.*' => 'required|string',
            'price.*' => 'required|numeric',
            'stock.*' => 'required|integer',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
        ]);

        foreach ($request->shade_name as $i => $shade) {
            ProductVariant::create([
                'product_id' => $product->id,
                'shade_name' => $shade,
                'hex_color' => $request->hex_color[$i],
                'price' => $request->price[$i],
                'stock' => $request->stock[$i],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
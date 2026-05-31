<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
                          ->with(['brand', 'category', 'variants', 'reviews.user'])
                          ->firstOrFail();

        // Ambil produk related (kategori sama, kecuali produk ini)
        $related = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->with(['brand', 'variants'])
                          ->take(4)
                          ->get();

        return view('products.show', compact('product', 'related'));
    }
}
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

        return view('products.show', compact('product'));
    }
}
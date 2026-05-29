<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Brand
        $theOrdinary = Brand::create(['name' => 'The Ordinary', 'slug' => 'the-ordinary']);
        $judydoll = Brand::create(['name' => 'Judydoll', 'slug' => 'judydoll']);
        $nacific = Brand::create(['name' => 'Nacific', 'slug' => 'nacific']);

        // Buat Category
        $skincare = Category::create(['name' => 'Skincare', 'slug' => 'skincare']);
        $makeup = Category::create(['name' => 'Makeup', 'slug' => 'makeup']);
        $lip = Category::create(['name' => 'Lip', 'slug' => 'lip']);

        // Produk 1
        $product1 = Product::create([
            'brand_id' => $theOrdinary->id,
            'category_id' => $skincare->id,
            'name' => 'Buffet Serum',
            'slug' => 'buffet-serum',
            'description' => 'Multi-technology peptide serum untuk kulit lebih muda dan cerah.',
            'thumbnail' => null,
        ]);
        ProductVariant::create(['product_id' => $product1->id, 'shade_name' => 'Original', 'hex_color' => '#F5E6D3', 'price' => 185000, 'stock' => 50]);

        // Produk 2
        $product2 = Product::create([
            'brand_id' => $judydoll->id,
            'category_id' => $makeup->id,
            'name' => 'Eye Palette',
            'slug' => 'eye-palette',
            'description' => 'Eyeshadow palette dengan 9 warna pigmented untuk tampilan sehari-hari.',
            'thumbnail' => null,
        ]);
        ProductVariant::create(['product_id' => $product2->id, 'shade_name' => 'Rose Nude', 'hex_color' => '#E8B4A0', 'price' => 220000, 'stock' => 30]);
        ProductVariant::create(['product_id' => $product2->id, 'shade_name' => 'Brown Smoky', 'hex_color' => '#8B6355', 'price' => 220000, 'stock' => 25]);

        // Produk 3
        $product3 = Product::create([
            'brand_id' => $nacific->id,
            'category_id' => $lip->id,
            'name' => 'Lip Concealer',
            'slug' => 'lip-concealer',
            'description' => 'Lip concealer dengan formula ringan dan tahan lama.',
            'thumbnail' => null,
        ]);
        ProductVariant::create(['product_id' => $product3->id, 'shade_name' => 'Cherry Red', 'hex_color' => '#C0392B', 'price' => 95000, 'stock' => 40]);
        ProductVariant::create(['product_id' => $product3->id, 'shade_name' => 'Nude Pink', 'hex_color' => '#E8A598', 'price' => 95000, 'stock' => 35]);
        ProductVariant::create(['product_id' => $product3->id, 'shade_name' => 'Berry Plum', 'hex_color' => '#8E3A59', 'price' => 95000, 'stock' => 20]);
    }
}
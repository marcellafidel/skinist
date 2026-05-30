<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CouponController;

Route::get('/', function () {
    $products = \App\Models\Product::with(['brand', 'variants'])->get();
    return view('welcome', compact('products'));
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Product
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

//Cart&Checkout
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/upload', [OrderController::class, 'uploadPayment'])->name('orders.upload');
    Route::post('/products/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/profile/show', function() {
        return view('profile.show');
    })->name('profile.show');
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
});

// Admin
Route::middleware('auth')->group(function () {
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/orders/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('admin.confirm');
    Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.status');
    Route::get('/admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/admin/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::post('/admin/brands', [AdminController::class, 'storeBrand'])->name('admin.brands.store');
    Route::delete('/admin/brands/{id}', [AdminController::class, 'destroyBrand'])->name('admin.brands.destroy');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::post('/admin/coupons', [AdminController::class, 'storeCoupon'])->name('admin.coupons.store');
    Route::delete('/admin/coupons/{id}', [AdminController::class, 'destroyCoupon'])->name('admin.coupons.destroy');
});

// Search
Route::get('/search', function () {
    $query = request('q');
    $products = \App\Models\Product::with(['brand', 'variants'])
                ->where('name', 'like', "%{$query}%")
                ->orWhereHas('brand', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->get();
    return view('search', compact('products', 'query'));
})->name('search');

// New Arrival & Best Seller
Route::get('/new-arrival', function () {
    $products = \App\Models\Product::with(['brand', 'variants'])
                ->latest()
                ->take(8)
                ->get();
    $query = 'New Arrival';
    return view('search', compact('products', 'query'));
})->name('new.arrival');

Route::get('/best-seller', function () {
    $products = \App\Models\Product::with(['brand', 'variants'])
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->take(8)
                ->get();
    $query = 'Best Seller';
    return view('search', compact('products', 'query'));
})->name('best.seller');

// Filter by Kategori
Route::get('/kategori/{slug}', function ($slug) {
    $category = \App\Models\Category::where('slug', $slug)->firstOrFail();
    $products = \App\Models\Product::with(['brand', 'variants'])
                ->where('category_id', $category->id)
                ->get();
    $query = $category->name;
    return view('search', compact('products', 'query'));
})->name('category.show');

require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak!');
        }
    }

    public function orders()
    {
        $this->checkAdmin();
        $orders = Order::with(['user', 'details.variant.product'])
                       ->latest()
                       ->get();
        return view('admin.orders', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $this->checkAdmin();
        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid']);
        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
        ]);
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diupdate!');
    }

    public function brands()
    {
        $this->checkAdmin();
        $brands = \App\Models\Brand::all();
        return view('admin.brands', compact('brands'));
    }

    public function storeBrand(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|unique:brands,name',
        ]);
        \App\Models\Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Brand berhasil ditambahkan!');
    }

    public function destroyBrand($id)
    {
        $this->checkAdmin();
        \App\Models\Brand::findOrFail($id)->delete();
        return back()->with('success', 'Brand berhasil dihapus!');
    }

    public function categories()
    {
        $this->checkAdmin();
        $categories = \App\Models\Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);
        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroyCategory($id)
    {
        $this->checkAdmin();
        \App\Models\Category::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function coupons()
    {
        $this->checkAdmin();
        $coupons = \App\Models\Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function storeCoupon(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        \App\Models\Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'max_uses' => $request->max_uses ?? 100,
            'expires_at' => $request->expires_at,
            'is_active' => true,
        ]);

        return back()->with('success', 'Kupon berhasil dibuat!');
    }

    public function destroyCoupon($id)
    {
        $this->checkAdmin();
        \App\Models\Coupon::findOrFail($id)->delete();
        return back()->with('success', 'Kupon berhasil dihapus!');
    }
}
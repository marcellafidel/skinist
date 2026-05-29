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
}
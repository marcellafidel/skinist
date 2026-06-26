<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan — Admin Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders') }}" class="text-sm text-sky-500 hover:underline">Pesanan</a>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-sky-500 hover:underline">Produk</a>
            <a href="{{ route('admin.brands') }}" class="text-sm text-sky-500 hover:underline">Brand</a>
            <a href="{{ route('admin.categories') }}" class="text-sm text-sky-500 hover:underline">Kategori</a>
            <a href="{{ route('admin.coupons') }}" class="text-sm text-sky-500 hover:underline">Kupon</a>
            <a href="{{ route('admin.laporan') }}" class="text-sm text-sky-500 hover:underline">Laporan Keuangan</a>
            <a href="{{ route('admin.stok') }}" class="text-sm text-sky-500 hover:underline">Histori Stok</a>
            <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
            </form>
        </div>
    </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('admin.orders') }}" class="text-xs text-sky-500 hover:underline">← Kembali ke Daftar Pesanan</a>
                <h1 class="text-2xl font-bold text-gray-700 mt-2">Detail Pesanan</h1>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $order->status === 'paid' ? 'bg-green-100 text-green-600' :
                   ($order->status === 'shipped' ? 'bg-blue-100 text-blue-600' :
                   ($order->status === 'delivered' ? 'bg-teal-100 text-teal-600' :
                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-600' :
                   'bg-yellow-100 text-yellow-600'))) }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-6">{{ session('error') }}</div>
        @endif

        {{-- INFO PESANAN --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <p class="text-xs text-gray-400 mb-3 font-semibold uppercase tracking-wide">Informasi Pesanan</p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Invoice</p>
                    <p class="font-semibold text-gray-700">{{ $order->invoice_number }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Tanggal</p>
                    <p class="font-semibold text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Customer</p>
                    <p class="font-semibold text-gray-700">{{ $order->user->name }}</p>
                    <p class="text-xs text-sky-400">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Total</p>
                    <p class="font-bold text-sky-500">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-400 text-xs">Alamat Pengiriman</p>
                    <p class="font-semibold text-gray-700">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Kurir</p>
                    <p class="font-semibold text-gray-700">{{ $order->courier_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Ongkos Kirim</p>
                    <p class="font-semibold text-gray-700">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                </div>
                @if($order->tracking_number)
                <div>
                    <p class="text-gray-400 text-xs">No. Resi</p>
                    <p class="font-semibold text-gray-700">{{ $order->tracking_number }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- PRODUK --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <p class="text-xs text-gray-400 mb-3 font-semibold uppercase tracking-wide">Produk Dipesan</p>
            @foreach($order->details as $detail)
            <div class="flex items-center gap-4 py-2 border-b border-sky-50 last:border-0">
                <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center">
                    <span class="text-lg">🧴</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">{{ $detail->variant->product->name }}</p>
                    <p class="text-xs text-gray-400">{{ $detail->variant->shade_name }} x{{ $detail->quantity }}</p>
                </div>
                <p class="text-sm font-bold text-sky-500">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        {{-- RIWAYAT STATUS --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <p class="text-xs text-gray-400 mb-3 font-semibold uppercase tracking-wide">Riwayat Status</p>
            @forelse($order->statusHistories as $history)
            <div class="flex items-start gap-3 py-3 border-b border-sky-50 last:border-0">
                <span class="w-2.5 h-2.5 rounded-full mt-1.5" style="background:{{ $history->status_color }};"></span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">{{ $history->status_label }}</p>
                    @if($history->note)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $history->note }}</p>
                    @endif
                    @if($history->changedBy)
                    <p class="text-xs text-sky-400 mt-0.5">oleh {{ $history->changedBy->name }}</p>
                    @endif
                </div>
                <p class="text-xs text-gray-400 whitespace-nowrap">{{ $history->created_at->format('d M Y, H:i') }}</p>
            </div>
            @empty
            <p class="text-sm text-gray-400">Belum ada riwayat status.</p>
            @endforelse
        </div>

        {{-- UPDATE STATUS --}}
        <div class="bg-white rounded-3xl shadow-sm p-6">
            <p class="text-xs text-gray-400 mb-3 font-semibold uppercase tracking-wide">Update Status</p>
            @if(in_array($order->status, ['delivered', 'cancelled']))
                <p class="text-xs text-gray-400 italic">Status pesanan sudah final dan tidak bisa diubah lagi.</p>
            @else
            <form action="{{ route('admin.status', $order->id) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div class="flex items-center gap-3">
                    <select name="status" class="border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-sky-300 hover:bg-sky-400 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all">
                        Update Status
                    </button>
                </div>
                <input type="text" name="note" placeholder="Catatan (opsional, contoh: nomor resi, alasan, dll)"
                    class="border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300 w-full">
            </form>
            @endif
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist Admin Panel
    </footer>

</body>
</html>
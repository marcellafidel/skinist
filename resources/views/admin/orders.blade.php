<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
        <div class="flex items-center gap-4">
            <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
            </form>
        </div>
    </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">🛠️ Admin — Kelola Pesanan</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        @forelse($orders as $order)
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-gray-400">Invoice</p>
                    <p class="font-bold text-gray-700">{{ $order->invoice_number }}</p>
                    <p class="text-xs text-sky-400 mt-1">{{ $order->user->name }} — {{ $order->user->email }}</p>
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

            {{-- Produk --}}
            @foreach($order->details as $detail)
            <div class="flex items-center gap-4 mb-2">
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

            <div class="flex justify-between items-center mt-4 pt-4 border-t border-sky-50">
                <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                <p class="font-bold text-sky-500">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>

            {{-- Bukti Pembayaran --}}
            @if($order->payment_proof)
            <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 font-semibold mb-2">Bukti Pembayaran:</p>
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="h-32 rounded-lg object-cover mb-3">

                @if($order->status === 'pending')
                <form action="{{ route('admin.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-400 hover:bg-green-500 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
                @endif
            </div>
            @endif

            {{-- Update Status --}}
            <div class="mt-4">
                <form action="{{ route('admin.status', $order->id) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <select name="status" class="border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit"
                        class="bg-sky-300 hover:bg-sky-400 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all">
                        Update Status
                    </button>
                </form>
            </div>

        </div>
        @empty
        <div class="text-center py-20">
            <p class="text-gray-400 text-lg">Belum ada pesanan.</p>
        </div>
        @endforelse

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist Admin Panel
    </footer>

</body>
</html>
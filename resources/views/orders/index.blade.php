<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                <a href="{{ route('cart.index') }}" class="text-sky-400 hover:text-sky-500">🛒 Cart</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">📦 Pesanan Saya</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
                🎉 {{ session('success') }}
            </div>
        @endif

        @forelse($orders as $order)
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-gray-400">Invoice</p>
                    <p class="font-bold text-gray-700">{{ $order->invoice_number }}</p>
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

            @foreach($order->details as $detail)
            <div class="flex items-center gap-4 mb-3 pb-3 border-b border-sky-50 last:border-0 last:mb-0 last:pb-0">
                <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center">
                    <span class="text-xl">🧴</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">{{ $detail->variant->product->name }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="w-3 h-3 rounded-full inline-block" style="background-color: {{ $detail->variant->hex_color }}"></span>
                        <span class="text-xs text-gray-400">{{ $detail->variant->shade_name }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-sky-500">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">x{{ $detail->quantity }}</p>
                </div>
            </div>
            @endforeach

            <div class="flex justify-between items-center mt-4 pt-4 border-t border-sky-50">
                <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                <p class="font-bold text-sky-500">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📭</div>
            <p class="text-gray-400 text-lg">Belum ada pesanan.</p>
            <a href="/" class="mt-4 inline-block bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">
                Mulai Belanja
            </a>
        </div>
        @endforelse

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
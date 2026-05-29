<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex-1 mx-8">
                <input type="text" placeholder="Search products..." class="w-full border border-sky-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300 bg-sky-50">
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                <a href="{{ route('cart.index') }}" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-sky-400 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $carts->count() }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">🛒 Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
        @endif

        @if($carts->isEmpty())
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🛍️</div>
                <p class="text-gray-400 text-lg">Keranjangmu masih kosong.</p>
                <a href="/" class="mt-4 inline-block bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm overflow-hidden mb-6">
                @foreach($carts as $cart)
                <div class="flex items-center gap-6 p-6 border-b border-sky-50 last:border-0">

                    {{-- Gambar --}}
                    <div class="w-20 h-20 bg-sky-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl">🧴</span>
                    </div>

                    {{-- Info Produk --}}
                    <div class="flex-1">
                        <p class="text-xs text-sky-400 font-semibold">{{ $cart->variant->product->brand->name }}</p>
                        <p class="font-semibold text-gray-700">{{ $cart->variant->product->name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-4 h-4 rounded-full border border-gray-200 inline-block" style="background-color: {{ $cart->variant->hex_color }}"></span>
                            <span class="text-sm text-gray-400">{{ $cart->variant->shade_name }}</span>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="text-right">
                        <p class="text-sky-500 font-bold">Rp {{ number_format($cart->variant->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-400">x{{ $cart->quantity }}</p>
                        <p class="text-sky-600 font-bold text-sm">Rp {{ number_format($cart->variant->price * $cart->quantity, 0, ',', '.') }}</p>
                    </div>

                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('cart.remove', $cart->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-300 hover:text-red-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                </div>
                @endforeach
            </div>

            {{-- TOTAL & CHECKOUT --}}
            <div class="bg-white rounded-3xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500">Total ({{ $carts->count() }} item)</span>
                    <span class="text-2xl font-bold text-sky-500">
                        Rp {{ number_format($carts->sum(fn($c) => $c->variant->price * $c->quantity), 0, ',', '.') }}
                    </span>
                </div>
                <a href="{{ route('checkout.index') }}"
                    class="block w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-2xl text-center text-lg transition-all duration-200">
                    Checkout Sekarang →
                </a>
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
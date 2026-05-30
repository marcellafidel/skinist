<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian "{{ $query }}" — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex-1 mx-8">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Search products..."
                        class="w-full border border-sky-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300 bg-sky-50">
                </form>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-sky-500 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm bg-sky-300 text-white px-4 py-2 rounded-full hover:bg-sky-400">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        <h1 class="text-xl font-bold text-gray-700 mb-2">
            Hasil pencarian untuk: <span class="text-sky-400">"{{ $query }}"</span>
        </h1>
        <p class="text-sm text-gray-400 mb-8">{{ $products->count() }} produk ditemukan</p>

        @if($products->isEmpty())
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-gray-400 text-lg">Produk tidak ditemukan.</p>
                <a href="/" class="mt-4 inline-block bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                        <div class="text-4xl">🧴</div>
                    </div>
                    <p class="text-xs text-sky-400 font-semibold">{{ $product->brand->name }}</p>
                    <p class="text-sm font-semibold text-gray-700 mt-1">{{ $product->name }}</p>
                    <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                </a>
                @endforeach
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
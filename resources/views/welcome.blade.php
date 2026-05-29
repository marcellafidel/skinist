<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinist — Beauty Store</title>
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
        <div class="border-t border-sky-100">
            <div class="max-w-7xl mx-auto px-4 py-2 flex gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-sky-500">Categories</a>
                <a href="#" class="hover:text-sky-500">Brands</a>
                <a href="#" class="hover:text-sky-500">Best Seller</a>
                <a href="#" class="hover:text-sky-500">New Arrival</a>
                <a href="#" class="hover:text-sky-500">Best Deals</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        {{-- HERO --}}
        <div class="rounded-3xl overflow-hidden mb-12 bg-sky-100 px-12 py-16 flex items-center justify-between">
            <div>
                <p class="text-sky-400 text-sm font-semibold tracking-widest uppercase mb-2">New Arrival</p>
                <h1 class="text-4xl font-bold text-gray-700 mb-4">keep the barrier safe<br>let your flawless<br>skin speak</h1>
                <a href="#" class="bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">Shop Now</a>
            </div>
            <div class="text-8xl font-bold text-sky-200 opacity-50 select-none">Skinist</div>
        </div>

        {{-- CHOOSE YOUR FAVS --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-700">CHOOSE YOUR FAVS</h2>
            <div class="flex justify-center gap-4 mt-2">
                <a href="#" class="text-sky-400 font-semibold border-b-2 border-sky-400 pb-1">best seller</a>
                <a href="#" class="text-gray-400 hover:text-sky-400">new arrival</a>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            @forelse($products ?? [] as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group">
                <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                    <div class="text-4xl">🧴</div>
                </div>
                <p class="text-xs text-sky-400 font-semibold">{{ $product->brand->name }}</p>
                <p class="text-sm font-semibold text-gray-700 mt-1">{{ $product->name }}</p>
                <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-12">Belum ada produk.</div>
            @endforelse
        </div>

        {{-- SHOP BY CATEGORIES --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-700">SHOP BY CATEGORIES</h2>
        </div>
        <div class="grid grid-cols-3 gap-6 mb-16">
            <a href="#" class="rounded-2xl h-48 bg-sky-200 flex items-end p-4 hover:shadow-md transition-all">
                <span class="text-white font-bold text-lg drop-shadow">skincare</span>
            </a>
            <a href="#" class="rounded-2xl h-48 bg-pink-200 flex items-end p-4 hover:shadow-md transition-all">
                <span class="text-white font-bold text-lg drop-shadow">makeup</span>
            </a>
            <a href="#" class="rounded-2xl h-48 bg-rose-200 flex items-end p-4 hover:shadow-md transition-all">
                <span class="text-white font-bold text-lg drop-shadow">lip</span>
            </a>
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
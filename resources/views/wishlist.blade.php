<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya — Skinist</title>
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
                <a href="{{ route('wishlist.index') }}" class="text-sky-400">❤️</a>
                <a href="{{ route('cart.index') }}" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        {{-- TOMBOL KEMBALI KE BERANDA --}}
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2 bg-white border border-sky-200 text-sky-500 hover:bg-sky-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali Belanja
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-700 mb-8">❤️ Wishlist Saya</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
        @endif

        {{-- CEK APAKAH WISHLIST KOSONG --}}
        @if(!isset($wishlists) || $wishlists->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-sky-100 p-8 shadow-sm">
                <div class="text-6xl mb-4">🤍</div>
                <p class="text-gray-400 text-lg font-medium">Wishlist kamu masih kosong.</p>
                <p class="text-gray-400 text-sm mt-1">Yuk, cari produk skincare favoritmu dulu!</p>
                <a href="/" class="mt-6 inline-block bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Mulai Jelajah Produk
                </a>
            </div>
        @else
            {{-- GRID PRODUK WISHLIST --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                @foreach($wishlists as $wishlist)
                    @if($wishlist->product)
                    <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group relative">
                        <a href="{{ route('products.show', $wishlist->product->slug) }}">
                            <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                                <div class="text-4xl">🧴</div>
                            </div>
                            <p class="text-xs text-sky-400 font-semibold">{{ $wishlist->product->brand->name ?? '' }}</p>
                            <p class="text-sm font-semibold text-gray-700 mt-1">{{ $wishlist->product->name }}</p>
                            <p class="text-sky-500 font-bold mt-1">
                                Rp {{ number_format($wishlist->product->variants->first()->price ?? 0, 0, ',', '.') }}
                            </p>
                        </a>

                        {{-- TOMBOL HAPUS DARI WISHLIST --}}
                        <form action="{{ route('wishlist.toggle', $wishlist->product->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full border border-red-300 text-red-400 hover:bg-red-50 text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                                ❤️ Hapus Favorit
                            </button>
                        </form>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
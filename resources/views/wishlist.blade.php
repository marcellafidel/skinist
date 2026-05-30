<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                <a href="{{ route('wishlist.index') }}" class="text-sky-400 hover:text-sky-500">❤️ Wishlist</a>
                <a href="{{ route('cart.index') }}" class="text-sky-400 hover:text-sky-500">🛒 Cart</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">❤️ Wishlist Saya</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
        @endif

        @if($wishlists->isEmpty())
            <div class="text-center py-20">
                <div class="text-6xl mb-4">💔</div>
                <p class="text-gray-400 text-lg">Wishlist kamu masih kosong.</p>
                <a href="/" class="mt-4 inline-block bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($wishlists as $wishlist)
                <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200">
                    <a href="{{ route('products.show', $wishlist->product->slug) }}">
                        <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                            <div class="text-4xl">🧴</div>
                        </div>
                        <p class="text-xs text-sky-400 font-semibold">{{ $wishlist->product->brand->name }}</p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">{{ $wishlist->product->name }}</p>
                        <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($wishlist->product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                    </a>
                    <form action="{{ route('wishlist.toggle', $wishlist->product->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-red-400 hover:text-red-600 text-sm font-semibold border border-red-200 hover:border-red-400 rounded-xl py-2 transition-all">
                            ❤️ Hapus dari Wishlist
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        @endif

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
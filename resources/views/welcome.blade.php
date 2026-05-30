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
                <form action="{{ route('search') }}" method="GET" class="w-full">
                    <input type="text" name="q" placeholder="Search products..."
                        class="w-full border border-sky-200 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300 bg-sky-50">
                </form>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                    <a href="{{ route('wishlist.index') }}" class="text-sky-400">❤️</a>
                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('notifications.index') }}" class="relative">
                        🔔
                        @php
                            $unread = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                        @endphp
                        @if($unread > 0)
                            <span class="absolute -top-2 -right-2 bg-red-400 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $unread }}
                            </span>
                        @endif
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
                <div class="relative group">
                    <a href="#" class="hover:text-sky-500">Categories</a>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-xl py-2 z-50 min-w-32">
                    @foreach(\App\Models\Category::all() as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="block px-4 py-2 hover:bg-sky-50 hover:text-sky-500">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="relative group">
                <a href="#" class="hover:text-sky-500">Brands</a>
                <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-xl py-2 z-50 min-w-32">
                    @foreach(\App\Models\Brand::all() as $brand)
                    <a href="{{ route('brand.show', $brand->slug) }}" class="block px-4 py-2 hover:bg-sky-50 hover:text-sky-500">{{ $brand->name }}</a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('best.seller') }}" class="hover:text-sky-500">Best Seller</a>
            <a href="{{ route('new.arrival') }}" class="hover:text-sky-500">New Arrival</a>
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
        <div class="mb-8">
            <div class="text-center mb-2">
                <h2 class="text-2xl font-bold text-gray-700">CHOOSE YOUR FAVS</h2>
                <div class="flex justify-center gap-4 mt-2">
                    <a href="{{ route('best.seller') }}" class="text-sky-400 font-semibold border-b-2 border-sky-400 pb-1">best seller</a>
                    <a href="{{ route('new.arrival') }}" class="text-gray-400 hover:text-sky-400">new arrival</a>
                </div>
            </div>
            {{-- SORTING --}}
            <div class="flex justify-end items-center gap-2 mt-2">
                <span class="text-sm text-gray-400">Urutkan:</span>
                <select onchange="window.location.href='/?sort='+this.value"
                    class="border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300 bg-white">
                    <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ ($sort ?? '') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_high" {{ ($sort ?? '') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="name" {{ ($sort ?? '') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                </select>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            @forelse($products ?? [] as $product)
            <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group relative">
                <a href="{{ route('products.show', $product->slug) }}">
                    <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                        <div class="text-4xl">🧴</div>
                    </div>
                    <p class="text-xs text-sky-400 font-semibold">{{ $product->brand->name }}</p>
                    <p class="text-sm font-semibold text-gray-700 mt-1">{{ $product->name }}</p>
                    <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                </a>
                {{-- Tombol Add to Cart --}}
                @auth
                <button onclick="openShadePopup({{ $product->id }}, {{ $product->variants->toJson() }})"
                    class="w-full mt-3 bg-sky-100 hover:bg-sky-300 hover:text-white text-sky-500 text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                    + Add to Cart
                </button>
                @endauth
                </div>
                @empty
                <div class="col-span-4 text-center text-gray-400 py-12">Belum ada produk.</div>
                @endforelse
            </div>

            {{-- POPUP SHADE PICKER --}}
            <div id="shade-popup" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden flex items-center justify-center">
                <div class="bg-white rounded-3xl p-6 shadow-xl w-80">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-700">Pilih Shade</h3>
                        <button onclick="closeShadePopup()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                    </div>
                    <div id="popup-shades" class="flex flex-wrap gap-3 mb-4"></div>
                    <p id="popup-shade-name" class="text-sm text-sky-400 font-medium mb-4"></p>
                    <form id="popup-cart-form" action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_variant_id" id="popup-variant-id">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                            class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-3 rounded-2xl transition-all">
                            🛒 Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <script>
            function openShadePopup(productId, variants) {
                const popup = document.getElementById('shade-popup');
                const shadesContainer = document.getElementById('popup-shades');
                const shadeName = document.getElementById('popup-shade-name');
                const variantId = document.getElementById('popup-variant-id');

                 shadesContainer.innerHTML = '';

                variants.forEach((variant, index) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'w-10 h-10 rounded-full border-4 border-white shadow-md hover:scale-110 transition-transform duration-200';
                    btn.style.backgroundColor = variant.hex_color;
                    btn.title = variant.shade_name;
                    btn.onclick = function() {
                        variantId.value = variant.id;
                        shadeName.textContent = variant.shade_name;
                        document.querySelectorAll('#popup-shades button').forEach(b => {
                            b.classList.remove('ring-4', 'ring-sky-300', 'ring-offset-2');
                        });
                        btn.classList.add('ring-4', 'ring-sky-300', 'ring-offset-2');
                    };
                    if (index === 0) {
                        variantId.value = variant.id;
                        shadeName.textContent = variant.shade_name;
                        setTimeout(() => btn.classList.add('ring-4', 'ring-sky-300', 'ring-offset-2'), 10);
                    }
                    shadesContainer.appendChild(btn);
                });

                popup.classList.remove('hidden');
            }

            function closeShadePopup() {
                document.getElementById('shade-popup').classList.add('hidden');
            }

            // Tutup popup kalau klik di luar
            document.getElementById('shade-popup').addEventListener('click', function(e) {
                if (e.target === this) closeShadePopup();
            });
            </script>

        {{-- SHOP BY CATEGORIES --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-700">SHOP BY CATEGORIES</h2>
        </div>
        <div class="grid grid-cols-3 gap-6 mb-16">
            @php $categoryColors = ['bg-sky-200', 'bg-pink-200', 'bg-rose-200', 'bg-purple-200', 'bg-green-200', 'bg-yellow-200']; @endphp
            @foreach(\App\Models\Category::all() as $index => $cat)
        <a href="{{ route('category.show', $cat->slug) }}" class="rounded-2xl h-48 {{ $categoryColors[$index % count($categoryColors)] }} flex items-end p-4 hover:shadow-md transition-all">
            <span class="text-white font-bold text-lg drop-shadow">{{ $cat->name }}</span>
        </a>
        @endforeach
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
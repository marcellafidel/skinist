<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinist — Beauty Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                    <a href="{{ route('profile.show') }}" class="text-sm text-sky-500 hover:underline">Hi, {{ auth()->user()->name }}</a>
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
                    <a href="#" class="hover:text-sky-500 flex items-center gap-1">Categories
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="absolute hidden group-hover:block top-full left-0 mt-1 bg-white border border-sky-100 rounded-2xl shadow-xl py-2 z-50 min-w-44 transition-all">
                        @foreach(\App\Models\Category::all() as $cat)
                        @php
                            $catIcons = ['Skincare' => '🧴', 'Makeup' => '💄', 'Brush' => '🖌️', 'Lip' => '💋'];
                        @endphp
                        <a href="{{ route('category.show', $cat->slug) }}"
                            class="flex items-center gap-3 px-4 py-2 hover:bg-sky-50 hover:text-sky-500 transition-all rounded-xl mx-1">
                            <span class="text-base">{{ $catIcons[$cat->name] ?? '✨' }}</span>
                            <span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="relative group">
                    <a href="#" class="hover:text-sky-500 flex items-center gap-1">Brands
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="absolute hidden group-hover:block top-full left-0 mt-1 bg-white border border-sky-100 rounded-2xl shadow-xl py-3 z-50 min-w-64 transition-all">
                        <div class="grid grid-cols-2 gap-1 px-2">
                            @foreach(\App\Models\Brand::all() as $brand)
                            <a href="{{ route('brand.show', $brand->slug) }}"
                                class="flex items-center gap-3 px-3 py-2 hover:bg-sky-50 hover:text-sky-500 transition-all rounded-xl">
                                <span class="text-base">🏷️</span>
                                <span>{{ $brand->name }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <a href="{{ route('best.seller') }}" class="hover:text-sky-500">Best Seller</a>
                <a href="{{ route('new.arrival') }}" class="hover:text-sky-500">New Arrival</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        {{-- HERO --}}
        <div data-aos="fade-up" data-aos-duration="800"
            class="rounded-3xl overflow-hidden mb-12 bg-gradient-to-r from-sky-100 to-sky-50 flex items-center justify-between min-h-72 relative">
            <div class="w-1/2 h-72 flex items-end justify-center overflow-hidden">
                @if($featuredProduct && $featuredProduct->thumbnail)
                    <img src="{{ asset('storage/' . $featuredProduct->thumbnail) }}"
                        class="h-72 object-cover object-top">
                @else
                    <div class="text-9xl pb-4">🧴</div>
                @endif
            </div>
            <div class="w-1/2 px-10 py-12">
                <p class="text-sky-400 text-xs font-semibold tracking-widest uppercase mb-2">New Arrival</p>
                <h1 class="text-3xl font-bold text-gray-700 mb-2">{{ $featuredProduct->name ?? 'Skinist' }}</h1>
                <p class="text-sky-400 text-sm font-semibold mb-3">{{ $featuredProduct->brand->name ?? '' }}</p>
                <p class="text-gray-500 text-sm mb-6 leading-relaxed">{{ Str::limit($featuredProduct->description ?? 'keep the barrier safe, let your flawless skin speak', 100) }}</p>
                @if($featuredProduct)
                <a href="{{ route('products.show', $featuredProduct->slug) }}"
                    class="bg-sky-300 hover:bg-sky-400 text-white px-8 py-3 rounded-full font-semibold transition-all inline-block">
                    Shop Now →
                </a>
                @endif
            </div>
        </div>

        {{-- CHOOSE YOUR FAVS --}}
        <div class="mb-8">
            <div class="text-center mb-2" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-gray-700">CHOOSE YOUR FAVS</h2>
                <div class="flex justify-center gap-4 mt-2">
                    <button id="tab-bestseller" onclick="switchTab('bestseller')"
                        class="text-sky-400 font-semibold border-b-2 border-sky-400 pb-1">best seller</button>
                    <button id="tab-newarrival" onclick="switchTab('newarrival')"
                        class="text-gray-400 hover:text-sky-400 pb-1">new arrival</button>
                </div>
            </div>
            {{-- SORTING --}}
            <div class="flex justify-end items-center gap-2 mt-2" data-aos="fade-left">
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

        {{-- PRODUCT GRID BEST SELLER --}}
        <div id="grid-bestseller" class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            @forelse($products ?? [] as $product)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}"
                class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group relative">
                <a href="{{ route('products.show', $product->slug) }}">
                    <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="h-full object-contain">
                        @else
                            <div class="text-4xl">🧴</div>
                        @endif
                    </div>
                    <p class="text-xs text-sky-400 font-semibold">{{ $product->brand->name }}</p>
                    <p class="text-sm font-semibold text-gray-700 mt-1">{{ $product->name }}</p>
                    <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                </a>
                @auth
                <button onclick="openShadePopup({{ $product->id }}, {{ $product->variants->toJson() }})"
                    class="w-full mt-3 bg-sky-100 hover:bg-sky-300 hover:text-white text-sky-500 text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                    + Add to Cart
                </button>
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="mt-2">
                    @csrf
                    @php
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="submit"
                        class="w-full border {{ $inWishlist ? 'border-red-300 text-red-400 hover:bg-red-50' : 'border-sky-200 text-sky-400 hover:bg-sky-50' }} text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                        {{ $inWishlist ? '❤️ Wishlisted' : '🤍 Wishlist' }}
                    </button>
                </form>
                @endauth
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-12">Belum ada produk.</div>
            @endforelse
        </div>

        {{-- PRODUCT GRID NEW ARRIVAL --}}
        <div id="grid-newarrival" class="grid-cols-2 md:grid-cols-4 gap-6 mb-16" style="display:none;">
            @forelse($newArrivals ?? [] as $product)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}"
                class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group relative">
                <a href="{{ route('products.show', $product->slug) }}">
                    <div class="bg-sky-50 rounded-xl p-4 mb-3 flex items-center justify-center h-40">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="h-full object-contain">
                        @else
                            <div class="text-4xl">🧴</div>
                        @endif
                    </div>
                    <p class="text-xs text-sky-400 font-semibold">{{ $product->brand->name }}</p>
                    <p class="text-sm font-semibold text-gray-700 mt-1">{{ $product->name }}</p>
                    <p class="text-sky-500 font-bold mt-1">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                </a>
                @auth
                <button onclick="openShadePopup({{ $product->id }}, {{ $product->variants->toJson() }})"
                    class="w-full mt-3 bg-sky-100 hover:bg-sky-300 hover:text-white text-sky-500 text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                    + Add to Cart
                </button>
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="mt-2">
                    @csrf
                    @php
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="submit"
                        class="w-full border {{ $inWishlist ? 'border-red-300 text-red-400 hover:bg-red-50' : 'border-sky-200 text-sky-400 hover:bg-sky-50' }} text-sm font-semibold py-2 rounded-xl transition-all duration-200">
                        {{ $inWishlist ? '❤️ Wishlisted' : '🤍 Wishlist' }}
                    </button>
                </form>
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

        {{-- SHOP BY CATEGORIES --}}
    <div class="text-center mb-8" data-aos="fade-up">
        <h2 class="text-2xl font-bold text-gray-700">SHOP BY CATEGORIES</h2>
    </div>
    <div class="grid grid-cols-3 gap-6 mb-16">
        @foreach(\App\Models\Category::whereNotIn('name', ['Lip'])->get() as $index => $cat)
        @php
            $categoryImages = [
                'Skincare' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&q=80',
                'Makeup'   => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&q=80',
                'Brush' => 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388?w=600&q=80',
            ];
            $key = $cat->name;
            $img = $categoryImages[$key] ?? null;
            $categoryColors = ['bg-sky-200', 'bg-pink-200', 'bg-rose-200', 'bg-purple-200', 'bg-green-200', 'bg-yellow-200'];
        @endphp
        <a data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
            href="{{ route('category.show', $cat->slug) }}"
            class="rounded-2xl h-48 overflow-hidden relative flex items-end p-4 hover:shadow-md transition-all {{ !$img ? $categoryColors[$loop->index % count($categoryColors)] : '' }}">
            @if($img)
                <img src="{{ $img }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 rounded-2xl"></div>
            @endif
            <span class="relative text-white font-bold text-lg drop-shadow">{{ $cat->name }}</span>
        </a>
        @endforeach
    </div>

    </main>

    <footer class="bg-white border-t border-sky-100 pt-12 pb-6 text-sm text-gray-500">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-3 gap-24 mb-10">

        {{-- Brand --}}
        <div data-aos="fade-up">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <p class="mt-3 text-gray-400 text-sm leading-relaxed">keep the barrier safe,<br>let your flawless skin speak.</p>
        </div>

        {{-- Contact --}}
        <div data-aos="fade-up" data-aos-delay="100">
            <h4 class="font-bold text-gray-600 mb-4 text-base">Contact Us</h4>
            <ul class="space-y-2 text-gray-400">
                <li class="flex items-center gap-2">
                    <span>📱</span>
                    <a href="https://wa.me/087646787534245" target="_blank" class="hover:text-sky-400 transition">087646787534245</a>
                </li>
                <li class="flex items-center gap-2">
                    <span>✉️</span>
                    <a href="mailto:cs.skinist@gmail.com" class="hover:text-sky-400 transition">cs.skinist@gmail.com</a>
                </li>
                <li class="flex items-center gap-2">
                    <span>📍</span>
                    <span>Jl. Apalo</span>
                </li>
            </ul>
        </div>

        {{-- Sosmed --}}
        <div data-aos="fade-up" data-aos-delay="200">
            <h4 class="font-bold text-gray-600 mb-4 text-base">Follow Us</h4>
            <ul class="space-y-2 text-gray-400">
                <li class="flex items-center gap-2">
                    <span>📸</span>
                    <a href="https://instagram.com/skinist" target="_blank" class="hover:text-sky-400 transition">@skinist</a>
                </li>
                <li class="flex items-center gap-2">
                    <span>🎵</span>
                    <a href="https://tiktok.com/@skinist" target="_blank" class="hover:text-sky-400 transition">@skinist</a>
                </li>
                <li class="flex items-center gap-2">
                    <span>🐦</span>
                    <a href="https://twitter.com/skinist" target="_blank" class="hover:text-sky-400 transition">@skinist</a>
                </li>
            </ul>
        </div>

    </div>

    <div class="border-t border-sky-100 pt-6 text-center text-gray-400 text-xs">
        © 2025 Skinist — All rights reserved.
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 700,
        once: true,
        offset: 80,
    });
</script>

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

document.getElementById('shade-popup').addEventListener('click', function(e) {
    if (e.target === this) closeShadePopup();
});

function switchTab(tab) {
    const bsGrid = document.getElementById('grid-bestseller');
    const naGrid = document.getElementById('grid-newarrival');
    const bsTab = document.getElementById('tab-bestseller');
    const naTab = document.getElementById('tab-newarrival');

    if (tab === 'bestseller') {
        bsGrid.style.display = 'grid';
        naGrid.style.display = 'none';
        bsTab.classList.add('text-sky-400', 'font-semibold', 'border-b-2', 'border-sky-400');
        bsTab.classList.remove('text-gray-400');
        naTab.classList.remove('text-sky-400', 'font-semibold', 'border-b-2', 'border-sky-400');
        naTab.classList.add('text-gray-400');
    } else {
        naGrid.style.display = 'grid';
        bsGrid.style.display = 'none';
        naTab.classList.add('text-sky-400', 'font-semibold', 'border-b-2', 'border-sky-400');
        naTab.classList.remove('text-gray-400');
        bsTab.classList.remove('text-sky-400', 'font-semibold', 'border-b-2', 'border-sky-400');
        bsTab.classList.add('text-gray-400');
    }
}
</script>

</body>
</html>
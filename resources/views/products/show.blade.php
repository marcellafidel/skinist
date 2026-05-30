<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — Skinist</title>
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
                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-sky-500 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm bg-sky-300 text-white px-4 py-2 rounded-full hover:bg-sky-400">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- GAMBAR PRODUK --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm flex items-center justify-center h-96">
                <div class="text-8xl">🧴</div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="flex flex-col gap-4">

                <p class="text-sky-400 text-sm font-semibold tracking-widest uppercase">
                    {{ $product->brand->name }}
                </p>

                <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>

                {{-- Rating --}}
                <div class="flex items-center gap-2">
                    @php
                        $avg = round($product->reviews->avg('rating') ?? 0);
                        $total = $product->reviews->count();
                    @endphp
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $avg ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-400">({{ $total }} ulasan)</span>
                </div>

                <p id="product-price" class="text-2xl font-bold text-sky-500">
                    Rp {{ number_format($product->variants->first()->price, 0, ',', '.') }}
                </p>

                <p class="text-gray-500 text-sm leading-relaxed">{{ $product->description }}</p>

                {{-- SHADE PICKER --}}
                <div>
                    <p class="text-sm font-semibold text-gray-600 mb-3">Pilih Shade:</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->variants as $variant)
                        <button type="button"
                            onclick="selectVariant({{ $variant->id }}, {{ $variant->price }}, '{{ $variant->shade_name }}')"
                            class="shade-btn w-10 h-10 rounded-full border-4 border-white shadow-md hover:scale-110 transition-transform duration-200 focus:outline-none"
                            style="background-color: {{ $variant->hex_color }}"
                            title="{{ $variant->shade_name }}">
                        </button>
                        @endforeach
                    </div>
                    <p id="shade-name" class="text-sm text-sky-400 mt-2 font-medium">
                        {{ $product->variants->first()->shade_name }}
                    </p>
                </div>

                {{-- ADD TO CART --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_variant_id" id="selected-variant" value="{{ $product->variants->first()->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 text-lg mt-2">
                        🛒 Add to Cart
                    </button>
                </form>

                <p id="stock-info" class="text-xs text-gray-400 text-center">
                    Stok: {{ $product->variants->first()->stock }} pcs
                </p>

            </div>
        </div>

        {{-- ULASAN --}}
<div class="mt-16">
    <h2 class="text-xl font-bold text-gray-700 mb-6">Ulasan Pembeli</h2>

    @if(session('success'))
        <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
    @endif

    {{-- FORM REVIEW --}}
    @auth
    <div class="bg-white rounded-2xl p-5 shadow-sm mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Tulis Ulasan</h3>
        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf
            {{-- RATING BINTANG --}}
            <div class="flex items-center gap-2 mb-4">
                <p class="text-sm text-gray-500">Rating:</p>
                <div class="flex gap-1" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})"
                        class="star text-3xl text-gray-300 hover:text-yellow-400 transition-colors cursor-pointer"
                        data-value="{{ $i }}">★</button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="0">
            </div>
            <div class="mb-4">
                <textarea name="comment" rows="3" placeholder="Tulis ulasanmu di sini..."
                    class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300"></textarea>
            </div>
            <button type="submit"
                class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-2 rounded-xl font-semibold transition-all">
                Kirim Ulasan
            </button>
        </form>
    </div>
    @else
    <div class="bg-sky-50 rounded-2xl p-4 mb-6 text-center">
        <p class="text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-sky-400 hover:underline font-semibold">Login</a> untuk memberikan ulasan.
        </p>
    </div>
    @endauth

    {{-- DAFTAR ULASAN --}}
    @forelse($product->reviews as $review)
    <div class="bg-white rounded-2xl p-5 shadow-sm mb-4">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-sky-200 flex items-center justify-center text-sky-600 font-bold text-sm">
                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700">{{ $review->user->name }}</p>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                        @endfor
                    </div>
                </div>
            </div>
            @if(auth()->check() && auth()->id() === $review->user_id)
            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-300 hover:text-red-500 text-xs">Hapus</button>
            </form>
            @endif
        </div>
        <p class="text-sm text-gray-500 mt-2">{{ $review->comment }}</p>
        <p class="text-xs text-gray-300 mt-1">{{ $review->created_at->format('d M Y') }}</p>
    </div>
    @empty
    <p class="text-gray-400 text-sm">Belum ada ulasan.</p>
    @endforelse
    </div>

    <script>
    function setRating(value) 
    {
        document.getElementById('rating-input').value = value;
        document.querySelectorAll('.star').forEach(star => 
        {
            if (parseInt(star.dataset.value) <= value) 
            {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } 
            else 
            {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
            }
        });
    }
    </script>

        </main>

        <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400">
            © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
        </footer>

    <script>
        const variants = @json($product->variants);

        function selectVariant(id, price, shadeName) {
            document.getElementById('selected-variant').value = id;
            const formatted = new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('product-price').textContent = 'Rp ' + formatted;
            document.getElementById('shade-name').textContent = shadeName;
            const variant = variants.find(v => v.id === id);
            if (variant) 
            {
                document.getElementById('stock-info').textContent = 'Stok: ' + variant.stock + ' pcs';
            }
            document.querySelectorAll('.shade-btn').forEach(btn => {
                btn.classList.remove('ring-4', 'ring-sky-300', 'ring-offset-2');
            });
            event.currentTarget.classList.add('ring-4', 'ring-sky-300', 'ring-offset-2');
    }
    </script>

</body>
</html>
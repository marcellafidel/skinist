<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $query }} — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #F0F7FF; color: #1A3A5C; margin: 0; }
        .font-display { font-family: 'Cormorant Garamond', serif; }

        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(91,184,245,0.15);
            position: sticky; top: 0; z-index: 100;
        }

        .search-input {
            background: #E3F2FD; border: 1.5px solid transparent;
            border-radius: 50px; padding: 9px 20px 9px 40px;
            font-size: 0.85rem; width: 100%;
            font-family: 'DM Sans', sans-serif; color: #1A3A5C;
            transition: all 0.3s ease;
        }
        .search-input:focus { outline: none; border-color: #5BB8F5; background: white; box-shadow: 0 0 0 4px rgba(91,184,245,0.1); }
        .search-input::placeholder { color: #5A7FA0; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #5A7FA0; text-decoration: none;
            padding: 7px 16px; border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.25); background: white;
            transition: all 0.2s ease;
        }
        .btn-back:hover { color: #5BB8F5; border-color: #5BB8F5; background: #E3F2FD; }

        /* PRODUCT CARD */
        .product-card {
            background: white; border-radius: 20px; overflow: hidden;
            border: 1px solid rgba(91,184,245,0.08);
            transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none; display: block;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(26,58,92,0.1);
            border-color: rgba(91,184,245,0.2);
        }

        .product-img {
            background: #E3F2FD; height: 180px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .product-img img {
            height: 100%; object-fit: contain;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-img img { transform: scale(1.06); }

        .product-brand {
            font-size: 0.68rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5BB8F5; font-weight: 500;
        }
        .product-name {
            font-size: 0.9rem; font-weight: 500; color: #1A3A5C;
            line-height: 1.4; margin: 4px 0;
        }
        .product-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem; font-weight: 600; color: #5BB8F5;
        }

        /* QUERY BADGE */
        .query-badge {
            display: inline-block;
            background: rgba(91,184,245,0.12); color: #1A3A5C;
            border: 1px solid rgba(91,184,245,0.25);
            padding: 4px 14px; border-radius: 50px;
            font-size: 0.88rem; font-style: italic;
            font-family: 'Cormorant Garamond', serif;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center; padding: 80px 24px;
            background: white; border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.08);
        }
        .btn-home {
            display: inline-block; margin-top: 20px;
            background: #1A3A5C; color: white; text-decoration: none;
            padding: 13px 32px; border-radius: 50px;
            font-size: 0.85rem; font-weight: 500;
            transition: all 0.25s ease;
        }
        .btn-home:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,184,245,0.3); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease both; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:32px; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em; white-space:nowrap;">Skinist</a>
                <form action="{{ route('search') }}" method="GET" style="flex:1;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#5A7FA0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" value="{{ $query }}" placeholder="Cari produk, brand, kategori..." class="search-input">
                    </div>
                </form>
                <div style="display:flex; align-items:center; gap:20px; flex-shrink:0;">
                    @auth
                        <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
                        <a href="{{ route('cart.index') }}" style="color:#5A7FA0; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button style="font-size:0.78rem; color:#5A7FA0; background:none; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:color 0.2s;" onmouseover="this.style.color='#e05c5c'" onmouseout="this.style.color='#5A7FA0'">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="font-size:0.82rem; color:#5A7FA0; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">Masuk</a>
                        <a href="{{ route('register') }}" style="font-size:0.82rem; background:#1A3A5C; color:white; padding:9px 20px; border-radius:50px; text-decoration:none; transition:background 0.25s;" onmouseover="this.style.background='#5BB8F5'" onmouseout="this.style.background='#1A3A5C'">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:1280px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                    <h1 class="font-display" style="font-size:1.8rem; font-weight:300; color:#1A3A5C; margin:0;">
                        Hasil untuk
                    </h1>
                    <span class="query-badge">{{ $query }}</span>
                </div>
                <p style="font-size:0.82rem; color:#5A7FA0;">
                    {{ $products->count() }} produk ditemukan
                </p>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        @if($products->isEmpty())
            <div class="empty-state animate-in">
                <div style="font-size:3.5rem; margin-bottom:16px; opacity:0.2;">🔍</div>
                <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Produk tidak ditemukan</h3>
                <p style="font-size:0.85rem; color:#5A7FA0;">Coba cari dengan kata kunci lain atau jelajahi semua produk kami.</p>
                <a href="/" class="btn-home">Kembali ke Beranda</a>
            </div>
        @else
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px;">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card animate-in" style="animation-delay:{{ $loop->index * 50 }}ms;">
                    <div class="product-img">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                        @else
                            <div style="font-size:3.5rem; filter:drop-shadow(0 8px 16px rgba(91,184,245,0.2));">🧴</div>
                        @endif
                    </div>
                    <div style="padding:16px;">
                        <p class="product-brand">{{ $product->brand->name }}</p>
                        <p class="product-name">{{ $product->name }}</p>
                        <p class="product-price">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        @if($product->variants->count() > 0)
                        <div style="display:flex; gap:4px; margin-top:8px;">
                            @foreach($product->variants->take(5) as $v)
                            <span style="width:12px; height:12px; border-radius:50%; background:{{ $v->hex_color }}; border:2px solid white; box-shadow:0 1px 4px rgba(26,58,92,0.15); display:inline-block;"></span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        @endif

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
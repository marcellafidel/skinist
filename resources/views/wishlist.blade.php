<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya — Skinist</title>
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
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(26,58,92,0.1);
            border-color: rgba(91,184,245,0.2);
        }

        .product-img {
            background: #E3F2FD; height: 180px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
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

        .btn-remove {
            width: 100%; background: none;
            border: 1.5px solid rgba(224,92,92,0.25);
            color: rgba(224,92,92,0.7); padding: 9px;
            border-radius: 12px; font-size: 0.8rem;
            font-weight: 400; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.25s ease; margin-top: 8px;
        }
        .btn-remove:hover {
            background: rgba(224,92,92,0.06);
            border-color: #e05c5c; color: #e05c5c;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center; padding: 80px 24px;
            background: white; border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.08);
        }
        .btn-shop {
            display: inline-block; margin-top: 20px;
            background: #1A3A5C; color: white; text-decoration: none;
            padding: 13px 32px; border-radius: 50px;
            font-size: 0.85rem; font-weight: 500; letter-spacing: 0.05em;
            transition: all 0.25s ease;
        }
        .btn-shop:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,184,245,0.3); }

        .alert-success {
            background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.3);
            color: #1A3A5C; padding: 12px 16px; border-radius: 12px;
            margin-bottom: 16px; font-size: 0.85rem;
        }

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
                        <input type="text" name="q" placeholder="Cari produk..." class="search-input">
                    </div>
                </form>
                <div style="display:flex; align-items:center; gap:20px; flex-shrink:0;">
                    <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
                    @include('partials.order-notif-icons')
                    <a href="{{ route('wishlist.index') }}" style="color:#5BB8F5; line-height:1;">
                        <svg style="width:20px;height:20px;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </a>
                    <a href="{{ route('cart.index') }}" style="color:#5A7FA0; line-height:1; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:1280px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Wishlist Saya</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">
                    @if(isset($wishlists) && !$wishlists->isEmpty())
                        {{ $wishlists->count() }} produk tersimpan
                    @else
                        Produk favoritmu tersimpan di sini
                    @endif
                </p>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali Belanja
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in">✓ {{ session('success') }}</div>
        @endif

        @if(!isset($wishlists) || $wishlists->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="empty-state animate-in">
                <div style="font-size:4rem; margin-bottom:16px; opacity:0.25;">🤍</div>
                <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Wishlist masih kosong</h3>
                <p style="font-size:0.85rem; color:#5A7FA0;">Simpan produk favoritmu dengan menekan tombol ❤️ di halaman produk.</p>
                <a href="/" class="btn-shop">Jelajah Produk</a>
            </div>

        @else
            {{-- PRODUCT GRID --}}
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px;">
                @foreach($wishlists as $wishlist)
                    @if($wishlist->product)
                    <div class="product-card animate-in">
                        <a href="{{ route('products.show', $wishlist->product->slug) }}" style="text-decoration:none; display:block;">
                            <div class="product-img">
                                @if($wishlist->product->thumbnail)
                                    <img src="{{ asset('storage/' . $wishlist->product->thumbnail) }}" alt="{{ $wishlist->product->name }}">
                                @else
                                    <div style="font-size:3.5rem; filter:drop-shadow(0 8px 16px rgba(91,184,245,0.2));">🧴</div>
                                @endif
                            </div>
                        </a>
                        <div style="padding:16px;">
                            <a href="{{ route('products.show', $wishlist->product->slug) }}" style="text-decoration:none; display:block;">
                                <p class="product-brand">{{ $wishlist->product->brand->name ?? '' }}</p>
                                <p class="product-name">{{ $wishlist->product->name }}</p>
                                <p class="product-price">Rp {{ number_format($wishlist->product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                                {{-- Shade colors --}}
                                @if($wishlist->product->variants->count() > 0)
                                <div style="display:flex; gap:4px; margin-top:8px;">
                                    @foreach($wishlist->product->variants->take(5) as $v)
                                    <span style="width:12px; height:12px; border-radius:50%; background:{{ $v->hex_color }}; border:2px solid white; box-shadow:0 1px 4px rgba(26,58,92,0.15); display:inline-block;"></span>
                                    @endforeach
                                </div>
                                @endif
                            </a>
                            <form action="{{ route('wishlist.toggle', $wishlist->product->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-remove">
                                    ❤️ Hapus dari Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
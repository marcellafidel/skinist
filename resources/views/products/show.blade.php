<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #F0F7FF;
            --blush: #BFDFFF;
            --blue: #5BB8F5;
            --deep: #1A3A5C;
            --mid: #5A7FA0;
            --light: #E3F2FD;
            --white: #FFFFFF;
        }

        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--cream); color: var(--deep); margin: 0; }
        .font-display { font-family: 'Cormorant Garamond', serif; }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(91,184,245,0.15);
            position: sticky; top: 0; z-index: 100;
        }

        .search-input {
            background: var(--light);
            border: 1.5px solid transparent;
            border-radius: 50px;
            padding: 9px 20px 9px 40px;
            font-size: 0.85rem;
            width: 100%;
            transition: all 0.3s ease;
            font-family: 'DM Sans', sans-serif;
            color: var(--deep);
        }
        .search-input:focus { outline: none; border-color: var(--blue); background: white; box-shadow: 0 0 0 4px rgba(91,184,245,0.12); }
        .search-input::placeholder { color: var(--mid); }

        /* BREADCRUMB */
        .breadcrumb { font-size: 0.78rem; color: var(--mid); display: flex; align-items: center; gap: 8px; margin-bottom: 28px; }
        .breadcrumb a { color: var(--mid); text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: var(--blue); }

        /* PRODUCT IMAGE */
        .product-img-card {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.1);
            display: flex; align-items: center; justify-content: center;
            height: 440px; overflow: hidden; position: relative;
        }
        .product-img-card img {
            height: 85%; object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .product-img-card:hover img { transform: scale(1.05); }

        /* BADGE */
        .badge {
            display: inline-block;
            font-size: 0.68rem; letter-spacing: 0.18em; text-transform: uppercase;
            padding: 4px 12px; border-radius: 50px;
            background: rgba(91,184,245,0.12); color: var(--blue);
            border: 1px solid rgba(91,184,245,0.25);
            font-weight: 500;
        }

        /* PRICE */
        .product-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem; font-weight: 600; color: var(--blue);
        }

        /* SHADE BTN */
        .shade-btn {
            width: 36px; height: 36px; border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(26,58,92,0.15);
            cursor: pointer; transition: all 0.2s ease;
        }
        .shade-btn:hover { transform: scale(1.15); }
        .shade-btn.active { outline: 2.5px solid var(--blue); outline-offset: 3px; }

        /* SIZE BTN */
        .size-btn {
            padding: 8px 18px; border-radius: 10px;
            border: 1.5px solid rgba(91,184,245,0.3);
            font-size: 0.82rem; color: var(--mid);
            background: white; cursor: pointer;
            transition: all 0.2s ease; font-family: 'DM Sans', sans-serif;
        }
        .size-btn:hover, .size-btn.active {
            border-color: var(--blue); color: var(--deep);
            background: var(--light);
        }

        /* BUTTONS */
        .btn-primary {
            width: 100%; background: var(--deep); color: white;
            border: none; padding: 15px; border-radius: 14px;
            font-size: 0.88rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; letter-spacing: 0.05em;
            transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover { background: var(--blue); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,184,245,0.3); }

        .btn-secondary {
            width: 100%; background: none; color: var(--mid);
            border: 1.5px solid rgba(91,184,245,0.3); padding: 13px; border-radius: 14px;
            font-size: 0.85rem; font-weight: 400; cursor: pointer;
            font-family: 'DM Sans', sans-serif; transition: all 0.25s ease;
        }
        .btn-secondary:hover { border-color: var(--blue); color: var(--blue); background: rgba(91,184,245,0.06); }
        .btn-secondary.wishlisted { border-color: #e05c5c; color: #e05c5c; }

        /* DIVIDER */
        .divider { border: none; border-top: 1px solid rgba(91,184,245,0.12); margin: 4px 0; }

        /* REVIEW SECTION */
        .review-card {
            background: white; border-radius: 16px;
            padding: 20px; margin-bottom: 12px;
            border: 1px solid rgba(91,184,245,0.08);
            transition: box-shadow 0.2s ease;
        }
        .review-card:hover { box-shadow: 0 4px 16px rgba(26,58,92,0.06); }

        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--light); color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.85rem; flex-shrink: 0;
        }

        /* RELATED CARD */
        .related-card {
            background: white; border-radius: 18px; overflow: hidden;
            border: 1px solid rgba(91,184,245,0.08);
            transition: all 0.3s ease; text-decoration: none; display: block;
        }
        .related-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(26,58,92,0.1); border-color: rgba(91,184,245,0.2); }
        .related-img { background: var(--light); height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .related-img img { height: 100%; object-fit: contain; transition: transform 0.4s ease; }
        .related-card:hover .related-img img { transform: scale(1.06); }

        /* STAR */
        .star-display { color: #FBBF24; }
        .star-empty { color: #E5E7EB; }

        /* TEXTAREA */
        .review-textarea {
            width: 100%; background: var(--light); border: 1.5px solid transparent;
            border-radius: 12px; padding: 12px 16px;
            font-size: 0.85rem; color: var(--deep); resize: none;
            font-family: 'DM Sans', sans-serif; transition: all 0.2s ease;
        }
        .review-textarea:focus { outline: none; border-color: var(--blue); background: white; }
        .review-textarea::placeholder { color: var(--mid); }

        /* BACK BTN */
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: var(--mid); text-decoration: none;
            padding: 7px 14px; border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.25);
            transition: all 0.2s ease; background: white;
        }
        .btn-back:hover { color: var(--blue); border-color: var(--blue); background: var(--light); }

        /* RATING STARS INTERACTIVE */
        .star-btn { font-size: 1.8rem; color: #E5E7EB; cursor: pointer; background: none; border: none; padding: 0 2px; transition: color 0.15s, transform 0.15s; line-height: 1; }
        .star-btn:hover, .star-btn.active { color: #FBBF24; transform: scale(1.15); }

        /* STOCK BADGE */
        .stock-info { font-size: 0.75rem; color: var(--mid); text-align: center; margin-top: 8px; }

        /* ANIMATION */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:32px; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:var(--deep); text-decoration:none; letter-spacing:0.15em; white-space:nowrap;">Skinist</a>
                <form action="{{ route('search') }}" method="GET" style="flex:1;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--mid);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" placeholder="Cari produk, brand, kategori..." class="search-input">
                    </div>
                </form>
                <div style="display:flex; align-items:center; gap:20px; flex-shrink:0;">
                    @auth
                        <a href="{{ route('profile.show') }}" style="font-size:0.82rem; color:var(--mid); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--mid)'">Hi, {{ auth()->user()->name }}</a>
                        @include('partials.order-notif-icons')
                        <a href="{{ route('wishlist.index') }}" style="color:var(--mid); transition:color 0.2s;" onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--mid)'">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </a>
                        <a href="{{ route('cart.index') }}" style="color:var(--mid); transition:color 0.2s;" onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--mid)'">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button style="font-size:0.78rem; color:var(--mid); background:none; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:color 0.2s;" onmouseover="this.style.color='#e05c5c'" onmouseout="this.style.color='var(--mid)'">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="font-size:0.82rem; color:var(--mid); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--mid)'">Masuk</a>
                        <a href="{{ route('register') }}" style="font-size:0.82rem; background:var(--deep); color:white; padding:9px 20px; border-radius:50px; text-decoration:none; transition:background 0.25s;" onmouseover="this.style.background='var(--blue)'" onmouseout="this.style.background='var(--deep)'">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:1280px; margin:0 auto; padding:32px 24px;">

        {{-- BREADCRUMB + BACK --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
            <div class="breadcrumb">
                <a href="/">Home</a>
                <span style="color:rgba(91,184,245,0.4);">›</span>
                <a href="/">Produk</a>
                <span style="color:rgba(91,184,245,0.4);">›</span>
                <span style="color:var(--deep);">{{ $product->name }}</span>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        {{-- PRODUCT DETAIL --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; margin-bottom:64px;">

            {{-- IMAGE --}}
            <div class="product-img-card animate-in">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                @else
                    <div style="font-size:8rem; filter:drop-shadow(0 16px 32px rgba(91,184,245,0.3));">🧴</div>
                @endif
            </div>

            {{-- INFO --}}
            <div style="display:flex; flex-direction:column; gap:20px;" class="animate-in delay-1">

                <div>
                    <span class="badge">{{ $product->brand->name }}</span>
                    <h1 class="font-display" style="font-size:2.2rem; font-weight:300; line-height:1.2; margin:12px 0 0; color:var(--deep);">{{ $product->name }}</h1>
                </div>

                {{-- RATING --}}
                @php
                    $avg = round($product->reviews->avg('rating') ?? 0);
                    $total = $product->reviews->count();
                @endphp
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="display:flex; gap:2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg style="width:18px;height:18px;" class="{{ $i <= $avg ? 'star-display' : 'star-empty' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span style="font-size:0.82rem; color:var(--mid);">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }} ({{ $total }} ulasan)</span>
                    <a href="#ulasan" style="font-size:0.78rem; color:var(--blue); text-decoration:none; margin-left:4px;">Lihat semua →</a>
                </div>

                <hr class="divider">

                <p id="product-price" class="product-price">
                    Rp {{ number_format($product->variants->first()->price, 0, ',', '.') }}
                </p>

                <p style="font-size:0.875rem; color:var(--mid); line-height:1.75;">{{ $product->description }}</p>

                <hr class="divider">

                {{-- SHADE PICKER --}}
                @if($product->variants->first()->shade_name)
                <div>
                    <p style="font-size:0.78rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:12px; font-weight:500;">Pilih Variant</p>
                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:8px;">
                        @foreach($product->variants as $variant)
                        <button type="button"
                            onclick="selectVariant({{ $variant->id }}, {{ $variant->price }}, '{{ $variant->shade_name }}', '{{ $variant->size }}')"
                            class="shade-btn {{ $loop->first ? 'active' : '' }}"
                            style="background-color:{{ $variant->hex_color }}"
                            title="{{ $variant->shade_name }}">
                        </button>
                        @endforeach
                    </div>
                    <p id="shade-name" style="font-size:0.82rem; color:var(--blue); font-weight:500;">{{ $product->variants->first()->shade_name }}</p>
                </div>
                @endif

                {{-- SIZE PICKER --}}
                @if($product->variants->first()->size)
                <div>
                    <p style="font-size:0.78rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:12px; font-weight:500;">Pilih Size</p>
                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                        @foreach($product->variants as $variant)
                        <button type="button"
                            onclick="selectVariant({{ $variant->id }}, {{ $variant->price }}, '{{ $variant->shade_name }}', '{{ $variant->size }}')"
                            class="size-btn {{ $loop->first ? 'active' : '' }}">
                            {{ $variant->size }}
                        </button>
                        @endforeach
                    </div>
                    <p id="size-name" style="font-size:0.82rem; color:var(--blue); font-weight:500;">{{ $product->variants->first()->size }}</p>
                </div>
                @endif

                {{-- ACTIONS --}}
                <div style="display:flex; flex-direction:column; gap:10px;" class="animate-in delay-2">

                    {{-- ADD TO CART --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_variant_id" id="selected-variant" value="{{ $product->variants->first()->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-primary">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>

                    {{-- WISHLIST --}}
                    @auth
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                        @csrf
                        @php $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
                        <button type="submit" class="btn-secondary {{ $inWishlist ? 'wishlisted' : '' }}">
                            {{ $inWishlist ? '❤️ Hapus dari Wishlist' : '🤍 Tambah ke Wishlist' }}
                        </button>
                    </form>
                    @endauth

                </div>

                <p id="stock-info" class="stock-info">
                    Stok tersedia: {{ $product->variants->first()->stock }} pcs
                </p>

            </div>
        </div>

        {{-- RELATED PRODUCTS --}}
        @if($related->count() > 0)
        <div style="margin-bottom:64px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                <h2 class="font-display" style="font-size:1.7rem; font-weight:300; color:var(--deep);">Produk Serupa</h2>
                <a href="/" style="font-size:0.8rem; color:var(--blue); text-decoration:none; letter-spacing:0.05em;">Lihat semua →</a>
            </div>
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">
                @foreach($related as $item)
                <a href="{{ route('products.show', $item->slug) }}" class="related-card">
                    <div class="related-img">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}">
                        @else
                            <div style="font-size:3rem;">🧴</div>
                        @endif
                    </div>
                    <div style="padding:14px;">
                        <p style="font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--blue); font-weight:500;">{{ $item->brand->name }}</p>
                        <p style="font-size:0.88rem; font-weight:500; color:var(--deep); margin:4px 0;">{{ $item->name }}</p>
                        <p class="font-display" style="font-size:1rem; font-weight:600; color:var(--blue);">Rp {{ number_format($item->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        <div style="display:flex; gap:4px; margin-top:8px;">
                            @foreach($item->variants->take(5) as $v)
                            <span style="width:14px; height:14px; border-radius:50%; border:2px solid white; box-shadow:0 1px 4px rgba(26,58,92,0.15); display:inline-block; background-color:{{ $v->hex_color }};"></span>
                            @endforeach
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ULASAN --}}
        <div id="ulasan" style="margin-bottom:64px;">
            <h2 class="font-display" style="font-size:1.7rem; font-weight:300; color:var(--deep); margin-bottom:24px;">Ulasan Pembeli</h2>

            @if(session('success'))
                <div style="background:rgba(91,184,245,0.1); border:1px solid rgba(91,184,245,0.3); color:var(--deep); padding:12px 16px; border-radius:12px; margin-bottom:16px; font-size:0.85rem;">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="background:rgba(224,92,92,0.08); border:1px solid rgba(224,92,92,0.25); color:#c0392b; padding:12px 16px; border-radius:12px; margin-bottom:16px; font-size:0.85rem;">{{ session('error') }}</div>
            @endif

            {{-- FORM REVIEW --}}
            @auth
            <div style="background:white; border-radius:20px; padding:24px; margin-bottom:24px; border:1px solid rgba(91,184,245,0.1);">
                <h3 style="font-size:0.95rem; font-weight:500; color:var(--deep); margin:0 0 16px;">Tulis Ulasanmu</h3>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                        <span style="font-size:0.78rem; color:var(--mid); letter-spacing:0.05em; text-transform:uppercase;">Rating</span>
                        <div style="display:flex; gap:2px;" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="star-btn" data-value="{{ $i }}">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="0">
                    </div>
                    <textarea name="comment" rows="3" placeholder="Ceritakan pengalamanmu pakai produk ini..." class="review-textarea" style="margin-bottom:12px;"></textarea>
                    <button type="submit"
                        style="background:var(--deep); color:white; border:none; padding:11px 24px; border-radius:12px; font-size:0.82rem; font-weight:500; cursor:pointer; font-family:'DM Sans',sans-serif; letter-spacing:0.04em; transition:all 0.25s;"
                        onmouseover="this.style.background='var(--blue)'" onmouseout="this.style.background='var(--deep)'">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
            @else
            <div style="background:var(--light); border-radius:16px; padding:20px; text-align:center; margin-bottom:24px;">
                <p style="font-size:0.85rem; color:var(--mid);">
                    <a href="{{ route('login') }}" style="color:var(--blue); font-weight:500; text-decoration:none;">Login</a> untuk menulis ulasan.
                </p>
            </div>
            @endauth

            {{-- DAFTAR ULASAN --}}
            @forelse($product->reviews->sortByDesc('created_at') as $review)
            <div class="review-card">
                <div style="display:flex; align-items:flex-start; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="avatar">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                        <div>
                            <p style="font-size:0.88rem; font-weight:500; color:var(--deep); margin:0 0 4px;">{{ $review->user->name }}</p>
                            <div style="display:flex; gap:2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size:0.9rem;" class="{{ $i <= $review->rating ? 'star-display' : 'star-empty' }}">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <span style="font-size:0.75rem; color:rgba(90,127,160,0.6);">{{ $review->created_at->format('d M Y') }}</span>
                        @if(auth()->check() && auth()->id() === $review->user_id)
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:0.75rem; color:rgba(224,92,92,0.6); background:none; border:none; cursor:pointer; transition:color 0.2s; font-family:'DM Sans',sans-serif;" onmouseover="this.style.color='#e05c5c'" onmouseout="this.style.color='rgba(224,92,92,0.6)'">Hapus</button>
                        </form>
                        @endif
                    </div>
                </div>
                @if($review->comment)
                <p style="font-size:0.85rem; color:var(--mid); margin:12px 0 0; line-height:1.7; padding-left:48px;">{{ $review->comment }}</p>
                @endif
            </div>
            @empty
            <div style="text-align:center; padding:48px; color:var(--mid);">
                <div style="font-size:2.5rem; margin-bottom:12px; opacity:0.3;">💬</div>
                <p style="font-size:0.85rem;">Belum ada ulasan. Jadilah yang pertama!</p>
            </div>
            @endforelse
        </div>

    </main>

    {{-- FOOTER --}}
    <footer style="background:var(--deep); padding:24px; text-align:center;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

<script>
    const variants = @json($product->variants);

    function selectVariant(id, price, shadeName, sizeName) {
        document.getElementById('selected-variant').value = id;
        const formatted = new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('product-price').textContent = 'Rp ' + formatted;

        if (shadeName && document.getElementById('shade-name')) {
            document.getElementById('shade-name').textContent = shadeName;
        }
        if (sizeName && document.getElementById('size-name')) {
            document.getElementById('size-name').textContent = sizeName;
        }

        const variant = variants.find(v => v.id === id);
        if (variant) {
            document.getElementById('stock-info').textContent = 'Stok tersedia: ' + variant.stock + ' pcs';
        }

        document.querySelectorAll('.shade-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));

        if (event.currentTarget.classList.contains('shade-btn')) {
            event.currentTarget.classList.add('active');
        } else {
            event.currentTarget.classList.add('active');
        }
    }

    function setRating(value) {
        document.getElementById('rating-input').value = value;
        document.querySelectorAll('.star-btn').forEach(star => {
            const v = parseInt(star.dataset.value);
            star.classList.toggle('active', v <= value);
        });
    }

    // Hover effect stars
    document.querySelectorAll('.star-btn').forEach((star, idx, arr) => {
        star.addEventListener('mouseenter', () => {
            const current = parseInt(document.getElementById('rating-input').value) || 0;
            arr.forEach((s, i) => {
                s.style.color = i <= idx ? '#FBBF24' : '#E5E7EB';
            });
        });
        star.addEventListener('mouseleave', () => {
            const current = parseInt(document.getElementById('rating-input').value) || 0;
            arr.forEach((s, i) => {
                s.style.color = i < current ? '#FBBF24' : '#E5E7EB';
            });
        });
    });
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skinist — Beauty Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #F0F7FF;
            --blush: #BFDFFF;
            --rose: #5BB8F5;
            --deep: #1A3A5C;
            --mid: #5A7FA0;
            --light: #E3F2FD;
            --white: #FFFFFF;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--deep);
        }

        .font-display { font-family: 'Cormorant Garamond', serif; }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(91,184,245,0.12);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* ANNOUNCEMENT BAR */
        .announcement-bar {
            background: var(--deep);
            color: var(--blush);
            font-size: 0.72rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 8px 0;
            text-align: center;
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-100%); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* SEARCH */
        .search-input {
            background: var(--light);
            border: 1.5px solid transparent;
            border-radius: 50px;
            padding: 9px 20px;
            font-size: 0.85rem;
            width: 100%;
            transition: all 0.3s ease;
            font-family: 'DM Sans', sans-serif;
            color: var(--deep);
        }
        .search-input:focus {
            outline: none;
            border-color: var(--rose);
            background: white;
            box-shadow: 0 0 0 4px rgba(91,184,245,0.12);
        }
        .search-input::placeholder { color: var(--mid); }

        /* HERO */
        .hero-section {
            background: linear-gradient(135deg, #EBF5FF 0%, #D6EEFF 40%, #BFDFFF 100%);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            min-height: 440px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(91,184,245,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(91,184,245,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(91,184,245,0.2);
            color: var(--rose);
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.3);
            margin-bottom: 16px;
            animation: fadeInUp 0.8s ease both;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.2rem;
            font-weight: 300;
            line-height: 1.15;
            color: var(--deep);
            animation: fadeInUp 0.9s ease 0.1s both;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--deep);
            color: white;
            padding: 13px 28px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: fadeInUp 1s ease 0.3s both;
        }
        .hero-cta:hover {
            background: var(--rose);
            transform: translateX(4px);
        }
        .hero-cta-arrow {
            transition: transform 0.3s ease;
        }
        .hero-cta:hover .hero-cta-arrow {
            transform: translateX(4px);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* HERO IMAGE FLOAT */
        .hero-img-wrap {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        /* MARQUEE */
        .marquee-wrap {
            overflow: hidden;
            background: var(--deep);
            padding: 14px 0;
        }
        .marquee-track {
            display: flex;
            gap: 0;
            animation: marquee 25s linear infinite;
            white-space: nowrap;
        }
        .marquee-item {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-style: italic;
            color: var(--blush);
            padding: 0 40px;
            opacity: 0.8;
            flex-shrink: 0;
        }
        .marquee-dot {
            color: var(--rose);
            padding: 0 4px;
            flex-shrink: 0;
            line-height: 1.5rem;
            font-size: 1rem;
        }
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        /* SECTION TITLE */
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 300;
            color: var(--deep);
            letter-spacing: 0.02em;
        }

        /* TABS */
        .tab-btn {
            font-size: 0.82rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            color: var(--mid);
            background: none;
            border-left: none;
            border-right: none;
            border-top: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }
        .tab-btn.active {
            color: var(--deep);
            border-bottom-color: var(--rose);
        }

        /* PRODUCT CARD */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid rgba(91,184,245,0.08);
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(26,58,92,0.1);
            border-color: rgba(91,184,245,0.2);
        }

        .product-img-wrap {
            background: var(--light);
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .product-img-wrap img {
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.06);
        }

        .product-brand {
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--rose);
            font-weight: 500;
        }

        .product-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--deep);
            line-height: 1.4;
            margin: 4px 0;
        }

        .product-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--rose);
        }

        .btn-cart {
            width: 100%;
            background: var(--light);
            color: var(--deep);
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.03em;
            margin-top: 10px;
        }
        .btn-cart:hover {
            background: var(--deep);
            color: white;
        }

        .btn-wishlist {
            width: 100%;
            background: none;
            border: 1.5px solid rgba(91,184,245,0.3);
            color: var(--mid);
            padding: 9px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: 'DM Sans', sans-serif;
            margin-top: 6px;
        }
        .btn-wishlist:hover {
            border-color: var(--rose);
            color: var(--rose);
            background: rgba(91,184,245,0.06);
        }
        .btn-wishlist.wishlisted {
            border-color: #e05c5c;
            color: #e05c5c;
            background: rgba(224,92,92,0.05);
        }

        /* CATEGORY CARD */
        .category-card {
            border-radius: 20px;
            height: 220px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 20px;
            transition: all 0.35s ease;
        }
        .category-card:hover {
            transform: scale(1.02);
            box-shadow: 0 16px 32px rgba(26,58,92,0.15);
        }
        .category-card img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .category-card:hover img {
            transform: scale(1.08);
        }
        .category-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26,58,92,0.65) 0%, transparent 60%);
        }
        .category-card-label {
            position: relative;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: white;
            letter-spacing: 0.05em;
        }

        /* POPUP */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26,58,92,0.5);
            backdrop-filter: blur(4px);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .popup-overlay.active {
            opacity: 1;
            pointer-events: all;
        }
        .popup-box {
            background: white;
            border-radius: 24px;
            padding: 28px;
            width: 340px;
            transform: translateY(20px) scale(0.97);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .popup-overlay.active .popup-box {
            transform: translateY(0) scale(1);
        }

        /* NAV DROPDOWN */
        .nav-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: white;
            border: 1px solid rgba(91,184,245,0.15);
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(26,58,92,0.1);
            padding: 8px;
            min-width: 180px;
            z-index: 200;
        }
        .nav-item:hover .nav-dropdown {
            display: block;
            animation: dropIn 0.2s ease;
        }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .nav-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            color: var(--mid);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nav-dropdown a:hover {
            background: var(--light);
            color: var(--deep);
        }

        /* FOOTER */
        .footer {
            background: var(--deep);
            color: rgba(255,255,255,0.6);
        }

        /* SCROLL ANIMATION */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* SORT SELECT */
        .sort-select {
            border: 1.5px solid rgba(91,184,245,0.3);
            border-radius: 50px;
            padding: 7px 16px;
            font-size: 0.82rem;
            color: var(--mid);
            background: white;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.2s ease;
        }
        .sort-select:focus {
            outline: none;
            border-color: var(--rose);
        }
    </style>
</head>
<body>

    {{-- ANNOUNCEMENT BAR --}}
    <div class="announcement-bar">
        ✦ Free Ongkir Pembelian di atas Rp 150.000 &nbsp;·&nbsp; ✦ New Arrivals Every Week &nbsp;·&nbsp; ✦ 100% Original Products
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:32px; padding:14px 0;">
                {{-- LOGO --}}
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; color:var(--deep); text-decoration:none; letter-spacing:0.15em; white-space:nowrap; font-style:italic;">
                    Skinist
                </a>

                {{-- SEARCH --}}
                <form action="{{ route('search') }}" method="GET" style="flex:1;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--mid);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" placeholder="Cari produk, brand, kategori..."
                            class="search-input" style="padding-left:40px;">
                    </div>
                </form>

                {{-- AUTH AREA --}}
                <div style="display:flex; align-items:center; gap:20px; flex-shrink:0;">
                    @auth
                        <a href="{{ route('profile.show') }}" style="font-size:0.82rem; color:var(--mid); text-decoration:none; white-space:nowrap; transition:color 0.2s;" onmouseover="this.style.color='var(--rose)'" onmouseout="this.style.color='var(--mid)'">
                            Hi, {{ auth()->user()->name }}
                        </a>
                        <a href="{{ route('wishlist.index') }}" style="color:var(--mid); line-height:1; transition:color 0.2s;" onmouseover="this.style.color='var(--rose)'" onmouseout="this.style.color='var(--mid)'">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </a>
                        <a href="{{ route('cart.index') }}" style="color:var(--mid); line-height:1; transition:color 0.2s;" onmouseover="this.style.color='var(--rose)'" onmouseout="this.style.color='var(--mid)'">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button style="font-size:0.78rem; color:var(--mid); background:none; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:color 0.2s;" onmouseover="this.style.color='#e05c5c'" onmouseout="this.style.color='var(--mid)'">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="font-size:0.82rem; color:var(--mid); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--rose)'" onmouseout="this.style.color='var(--mid)'">Masuk</a>
                        <a href="{{ route('register') }}" style="font-size:0.82rem; background:var(--deep); color:white; padding:9px 20px; border-radius:50px; text-decoration:none; transition:all 0.25s; letter-spacing:0.04em;" onmouseover="this.style.background='var(--rose)'" onmouseout="this.style.background='var(--deep)'">Daftar</a>
                    @endauth
                </div>
            </div>

            {{-- SUB NAV --}}
            <div style="border-top:1px solid rgba(91,184,245,0.1); display:flex; gap:32px; padding:10px 0; font-size:0.8rem; letter-spacing:0.08em; text-transform:uppercase;">
                <div class="nav-item" style="position:relative;">
                    <a href="#" style="color:var(--mid); text-decoration:none; display:flex; align-items:center; gap:4px; transition:color 0.2s;" onmouseover="this.style.color='var(--deep)'" onmouseout="this.style.color='var(--mid)'">
                        Kategori
                        <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="nav-dropdown">
                        @foreach(\App\Models\Category::all() as $cat)
                        @php $catIcons = ['Skincare'=>'🧴','Makeup'=>'💄','Brush'=>'🖌️','Lip'=>'💋']; @endphp
                        <a href="{{ route('category.show', $cat->slug) }}">
                            <span>{{ $catIcons[$cat->name] ?? '✨' }}</span>
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="nav-item" style="position:relative;">
                    <a href="#" style="color:var(--mid); text-decoration:none; display:flex; align-items:center; gap:4px; transition:color 0.2s;" onmouseover="this.style.color='var(--deep)'" onmouseout="this.style.color='var(--mid)'">
                        Brand
                        <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="nav-dropdown" style="min-width:220px;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2px;">
                            @foreach(\App\Models\Brand::all() as $brand)
                            <a href="{{ route('brand.show', $brand->slug) }}">
                                <span>🏷️</span> {{ $brand->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <a href="{{ route('best.seller') }}" style="color:var(--mid); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--deep)'" onmouseout="this.style.color='var(--mid)'">Best Seller</a>
                <a href="{{ route('new.arrival') }}" style="color:var(--mid); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--deep)'" onmouseout="this.style.color='var(--mid)'">New Arrival</a>
            </div>
        </div>
    </nav>

    <main style="max-width:1280px; margin:0 auto; padding:32px 24px;">

        {{-- HERO --}}
        <div class="hero-section" style="display:flex; align-items:center; margin-bottom:48px;">
            <div style="flex:1; padding:56px 56px; position:relative; z-index:1;">
                <div class="hero-badge">✦ New Arrival</div>
                <h1 class="hero-title">
                    {{ $featuredProduct->name ?? 'Your Skin,<br>Your Story.' }}
                </h1>
                @if($featuredProduct)
                <p style="color:var(--rose); font-size:0.82rem; letter-spacing:0.12em; text-transform:uppercase; margin:12px 0 8px; font-weight:500; animation: fadeInUp 0.95s ease 0.2s both;">
                    {{ $featuredProduct->brand->name }}
                </p>
                <p style="color:var(--mid); font-size:0.88rem; line-height:1.7; margin-bottom:28px; max-width:360px; animation: fadeInUp 1s ease 0.25s both;">
                    {{ Str::limit($featuredProduct->description ?? '', 100) }}
                </p>
                <a href="{{ route('products.show', $featuredProduct->slug) }}" class="hero-cta">
                    Shop Now
                    <svg class="hero-cta-arrow" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                @endif
            </div>
            <div style="flex:1; display:flex; align-items:flex-end; justify-content:center; height:440px; overflow:hidden; position:relative; z-index:1;">
                <div class="hero-img-wrap" style="height:100%; display:flex; align-items:flex-end;">
                    @if($featuredProduct && $featuredProduct->thumbnail)
                        <img src="{{ asset('storage/' . $featuredProduct->thumbnail) }}" style="height:90%; object-fit:contain;">
                    @else
                        <div style="font-size:9rem; padding-bottom:20px; filter:drop-shadow(0 20px 40px rgba(91,184,245,0.3));">🧴</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- MARQUEE --}}
        <div class="marquee-wrap" style="border-radius:16px; margin-bottom:48px;">
            <div class="marquee-track">
                @foreach(range(1, 2) as $r)
                <span class="marquee-item">Skincare</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">Makeup</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">Original Products</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">Best Seller</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">New Arrivals</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">Free Ongkir</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">100% Authentic</span><span class="marquee-dot">✦</span>
                <span class="marquee-item">Cruelty Free</span><span class="marquee-dot">✦</span>
                @endforeach
            </div>
        </div>

        {{-- CHOOSE YOUR FAV --}}
        <div data-aos="fade-up" style="margin-bottom:64px;">

            {{-- HEADER TENGAH --}}
            <div style="text-align:center; margin-bottom:32px;">
                <p style="font-size:0.72rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--rose); font-weight:500; margin-bottom:8px;">Produk Pilihan</p>
                <h2 class="section-title" style="font-size:2.4rem;">Choose Your Fav</h2>
                <p style="font-size:0.85rem; color:var(--mid); margin-top:8px;">Temukan produk yang cocok untukmu</p>

                {{-- TABS --}}
                <div style="display:flex; justify-content:center; gap:32px; margin-top:20px; border-bottom:1px solid rgba(91,184,245,0.12); padding-bottom:0;">
                    <button id="tab-bestseller" onclick="switchTab('bestseller')" class="tab-btn active">Best Seller</button>
                    <button id="tab-newarrival" onclick="switchTab('newarrival')" class="tab-btn">New Arrival</button>
                </div>
            </div>

            {{-- GRID BEST SELLER — 4 produk saja --}}
            <div id="grid-bestseller" style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px;">
                @forelse(($products ?? collect())->take(4) as $product)
                <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}" style="padding:0;">
                    <div class="product-img-wrap">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                        @else
                            <div style="font-size:3.5rem; filter:drop-shadow(0 8px 16px rgba(91,184,245,0.2));">🧴</div>
                        @endif
                    </div>
                    <div style="padding:16px;">
                        <a href="{{ route('products.show', $product->slug) }}" style="text-decoration:none; display:block;">
                            <p class="product-brand">{{ $product->brand->name }}</p>
                            <p class="product-name">{{ $product->name }}</p>
                            <p class="product-price">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        </a>
                        @auth
                        <button onclick="openShadePopup({{ $product->id }}, {{ $product->variants->toJson() }})" class="btn-cart">
                            + Tambah ke Keranjang
                        </button>
                        @php $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
                        <button onclick="toggleWishlist(this, {{ $product->id }})"
                            data-wishlisted="{{ $inWishlist ? 'true' : 'false' }}"
                            class="btn-wishlist {{ $inWishlist ? 'wishlisted' : '' }}">
                            {{ $inWishlist ? '❤️ Wishlisted' : '🤍 Wishlist' }}
                        </button>
                        @endauth
                    </div>
                </div>
                @empty
                <div style="grid-column:span 4; text-align:center; padding:48px; color:var(--mid);">Belum ada produk.</div>
                @endforelse
            </div>

            {{-- GRID NEW ARRIVAL — 4 produk saja --}}
            <div id="grid-newarrival" style="display:none; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px;">
                @forelse(($newArrivals ?? collect())->take(4) as $product)
                <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}" style="padding:0;">
                    <div class="product-img-wrap">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                        @else
                            <div style="font-size:3.5rem; filter:drop-shadow(0 8px 16px rgba(91,184,245,0.2));">🧴</div>
                        @endif
                    </div>
                    <div style="padding:16px;">
                        <a href="{{ route('products.show', $product->slug) }}" style="text-decoration:none; display:block;">
                            <p class="product-brand">{{ $product->brand->name }}</p>
                            <p class="product-name">{{ $product->name }}</p>
                            <p class="product-price">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        </a>
                        @auth
                        <button onclick="openShadePopup({{ $product->id }}, {{ $product->variants->toJson() }})" class="btn-cart">
                            + Tambah ke Keranjang
                        </button>
                        @php $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
                        <button onclick="toggleWishlist(this, {{ $product->id }})"
                            data-wishlisted="{{ $inWishlist ? 'true' : 'false' }}"
                            class="btn-wishlist {{ $inWishlist ? 'wishlisted' : '' }}">
                            {{ $inWishlist ? '❤️ Wishlisted' : '🤍 Wishlist' }}
                        </button>
                        @endauth
                    </div>
                </div>
                @empty
                <div style="grid-column:span 4; text-align:center; padding:48px; color:var(--mid);">Belum ada produk.</div>
                @endforelse
            </div>

            {{-- TOMBOL LIHAT SEMUA --}}
            <div style="text-align:center;">
                <a href="{{ route('best.seller') }}" id="btn-lihat-semua"
                    style="display:inline-flex; align-items:center; gap:8px; border:1.5px solid rgba(91,184,245,0.3); color:var(--mid); padding:11px 28px; border-radius:50px; font-size:0.82rem; text-decoration:none; transition:all 0.25s ease; letter-spacing:0.04em;"
                    onmouseover="this.style.borderColor='var(--rose)'; this.style.color='var(--deep)'; this.style.background='var(--light)';"
                    onmouseout="this.style.borderColor='rgba(91,184,245,0.3)'; this.style.color='var(--mid)'; this.style.background='none';">
                    Lihat Semua Produk
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- SHOP BY BRAND — 5 brand terlaris --}}
        @php
            $topBrands = \App\Models\Brand::query()
                ->withCount(['products as order_count' => function($q) {
                    $q->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
                      ->selectRaw('SUM(order_details.quantity)');
                }])
                ->orderByDesc('order_count')
                ->take(5)
                ->get();

            // fallback: kalau belum ada order, ambil brand pertama
            if ($topBrands->isEmpty()) {
                $topBrands = \App\Models\Brand::take(5)->get();
            }

            $brandEmojis = ['💄','🧴','✨','💋','🌸','🫧','💅','🪷','🌷','👄'];
        @endphp

        @php
            $brandBg = [
                'linear-gradient(135deg, #BFDFFF 0%, #E3F2FD 100%)',
                'linear-gradient(135deg, #D6EEFF 0%, #BFDFFF 100%)',
                'linear-gradient(135deg, #E3F2FD 0%, #C8E6FF 100%)',
                'linear-gradient(135deg, #C8E6FF 0%, #D6EEFF 100%)',
                'linear-gradient(135deg, #BFDFFF 0%, #C8E6FF 100%)',
            ];
        @endphp

        <div data-aos="fade-up" style="margin-bottom:64px;">
            <div style="text-align:center; margin-bottom:32px;">
                <p style="font-size:0.72rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--rose); font-weight:500; margin-bottom:8px;">Brand Favorit</p>
                <h2 class="section-title" style="font-size:2.4rem;">Shop by Brand</h2>
                <p style="font-size:0.85rem; color:var(--mid); margin-top:8px;">Brand paling banyak dibeli oleh pelanggan kami</p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px;">
                @foreach($topBrands as $i => $brand)
                <a href="{{ route('brand.show', $brand->slug) }}"
                    data-aos="fade-up" data-aos-delay="{{ $i * 80 }}"
                    style="border-radius:20px; overflow:hidden; text-decoration:none; transition:all 0.35s cubic-bezier(0.25,0.46,0.45,0.94); border:1.5px solid rgba(91,184,245,0.1); background:white;"
                    onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 36px rgba(91,184,245,0.2)'; this.style.borderColor='var(--rose)';"
                    onmouseout="this.style.transform='none'; this.style.boxShadow='none'; this.style.borderColor='rgba(91,184,245,0.1)';">

                    {{-- "Foto" brand — background gradient + emoji besar --}}
                    <div style="height:140px; background:{{ $brandBg[$i] ?? $brandBg[0] }}; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;">
                        {{-- Lingkaran dekorasi --}}
                        <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(255,255,255,0.3); border-radius:50%;"></div>
                        <div style="position:absolute; bottom:-15px; left:-15px; width:60px; height:60px; background:rgba(255,255,255,0.2); border-radius:50%;"></div>
                        {{-- Emoji --}}
                        <span style="font-size:3.5rem; filter:drop-shadow(0 4px 12px rgba(91,184,245,0.2)); position:relative; z-index:1;">{{ $brandEmojis[$i] ?? '🏷️' }}</span>
                    </div>

                    {{-- Info brand --}}
                    <div style="padding:14px 16px;">
                        <p style="font-size:0.9rem; font-weight:600; color:var(--deep); margin:0 0 4px; letter-spacing:0.02em;">{{ $brand->name }}</p>
                        @if($brand->order_count > 0)
                        <p style="font-size:0.72rem; color:var(--mid);">{{ number_format($brand->order_count) }} terjual</p>
                        @else
                        <p style="font-size:0.72rem; color:var(--mid);">Jelajahi koleksi →</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- SHOP BY CATEGORIES --}}
        <div data-aos="fade-up" style="margin-bottom:64px;">
            <h2 class="section-title" style="margin-bottom:24px;">Shop by Category</h2>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
                @foreach(\App\Models\Category::whereNotIn('name', ['Lip'])->get() as $index => $cat)
                @php
                    $categoryImages = [
                        'Skincare' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&q=80',
                        'Makeup'   => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&q=80',
                        'Brush'    => 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388?w=600&q=80',
                    ];
                    $img = $categoryImages[$cat->name] ?? null;
                @endphp
                <a href="{{ route('category.show', $cat->slug) }}" class="category-card"
                   data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                   style="{{ !$img ? 'background:var(--blush);' : '' }} text-decoration:none;">
                    @if($img)
                        <img src="{{ $img }}" alt="{{ $cat->name }}">
                        <div class="category-card-overlay"></div>
                    @endif
                    <span class="category-card-label">{{ $cat->name }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </main>

    {{-- SHADE PICKER POPUP --}}
    <div id="shade-popup" class="popup-overlay" onclick="if(event.target===this)closeShadePopup()">
        <div class="popup-box">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 class="font-display" style="font-size:1.3rem; font-weight:400; color:var(--deep);">Pilih Shade</h3>
                <button onclick="closeShadePopup()" style="width:32px; height:32px; border-radius:50%; background:var(--light); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:var(--mid); font-size:1rem; transition:all 0.2s;" onmouseover="this.style.background='var(--blush)'" onmouseout="this.style.background='var(--light)'">✕</button>
            </div>
            <div id="popup-shades" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px;"></div>
            <p id="popup-shade-name" style="font-size:0.82rem; color:var(--rose); margin-bottom:20px; font-weight:500;"></p>
            <input type="hidden" id="popup-variant-id">
            <button type="button" onclick="submitCart(this)"
                style="width:100%; background:var(--deep); color:white; border:none; padding:14px; border-radius:14px; font-size:0.85rem; font-weight:500; cursor:pointer; font-family:'DM Sans',sans-serif; letter-spacing:0.05em; transition:all 0.25s;"
                onmouseover="this.style.background='var(--rose)'" onmouseout="this.style.background='var(--deep)'">
                Tambah ke Keranjang
            </button>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="footer">
        <div style="max-width:1280px; margin:0 auto; padding:56px 24px 32px;">
            <div style="display:grid; grid-template-columns:1.5fr 1fr 1fr; gap:64px; margin-bottom:48px;">
                <div data-aos="fade-up">
                    <a href="/" class="font-display" style="font-size:2rem; font-weight:300; font-style:italic; color:white; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                    <p style="margin-top:16px; font-size:0.85rem; line-height:1.8; color:rgba(255,255,255,0.45);">
                        keep the barrier safe,<br>let your flawless skin speak.
                    </p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100">
                    <h4 style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:20px;">Hubungi Kami</h4>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <li style="margin-bottom:12px;"><a href="https://wa.me/087646787534245" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">📱 087646787534245</a></li>
                        <li style="margin-bottom:12px;"><a href="mailto:cs.skinist@gmail.com" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">✉️ cs.skinist@gmail.com</a></li>
                        <li style="margin-bottom:12px;"><span style="font-size:0.85rem; color:rgba(255,255,255,0.55);">📍 Jl. Apalo</span></li>
                        <li style="margin-bottom:8px;"><a href="https://instagram.com/skinist" target="_blank" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s; display:flex; align-items:center; gap:8px;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">📸 @skinist</a></li>
                        <li><a href="https://tiktok.com/@skinist" target="_blank" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s; display:flex; align-items:center; gap:8px;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">🎵 @skinist</a></li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <h4 style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.4); margin-bottom:20px;">Navigasi</h4>
                    <ul style="list-style:none; padding:0; margin:0;">
                        <li style="margin-bottom:10px;"><a href="{{ route('best.seller') }}" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">Best Seller</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('new.arrival') }}" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">New Arrival</a></li>
                        <li style="margin-bottom:10px;"><a href="{{ route('login') }}" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">Login</a></li>
                        <li><a href="{{ route('register') }}" style="font-size:0.85rem; color:rgba(255,255,255,0.55); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--blush)'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">Daftar</a></li>
                    </ul>
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:24px; text-align:center; font-size:0.75rem; color:rgba(255,255,255,0.25); letter-spacing:0.08em;">
                © 2025 Skinist — All rights reserved.
            </div>
        </div>
    </footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true, offset: 60 });

    function switchTab(tab) {
        const bsGrid = document.getElementById('grid-bestseller');
        const naGrid = document.getElementById('grid-newarrival');
        const bsTab = document.getElementById('tab-bestseller');
        const naTab = document.getElementById('tab-newarrival');
        const btnLihat = document.getElementById('btn-lihat-semua');
        if (tab === 'bestseller') {
            bsGrid.style.display = 'grid';
            naGrid.style.display = 'none';
            bsTab.classList.add('active');
            naTab.classList.remove('active');
            if (btnLihat) btnLihat.href = '{{ route("best.seller") }}';
        } else {
            naGrid.style.display = 'grid';
            bsGrid.style.display = 'none';
            naTab.classList.add('active');
            bsTab.classList.remove('active');
            if (btnLihat) btnLihat.href = '{{ route("new.arrival") }}';
        }
    }

    function openShadePopup(productId, variants) {
        const popup = document.getElementById('shade-popup');
        const shadesContainer = document.getElementById('popup-shades');
        const shadeName = document.getElementById('popup-shade-name');
        const variantId = document.getElementById('popup-variant-id');
        shadesContainer.innerHTML = '';
        variants.forEach((variant, index) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.style.cssText = `width:36px; height:36px; border-radius:50%; border:3px solid white; box-shadow:0 2px 8px rgba(26,58,92,0.15); cursor:pointer; transition:all 0.2s; background-color:${variant.hex_color};`;
            btn.title = variant.shade_name;
            btn.onclick = function() {
                variantId.value = variant.id;
                shadeName.textContent = variant.shade_name;
                document.querySelectorAll('#popup-shades button').forEach(b => b.style.outline = 'none');
                btn.style.outline = '2px solid var(--rose)';
                btn.style.outlineOffset = '3px';
            };
            if (index === 0) {
                variantId.value = variant.id;
                shadeName.textContent = variant.shade_name;
                setTimeout(() => { btn.style.outline = '2px solid var(--rose)'; btn.style.outlineOffset = '3px'; }, 10);
            }
            shadesContainer.appendChild(btn);
        });
        popup.classList.add('active');
    }

    function closeShadePopup() {
        document.getElementById('shade-popup').classList.remove('active');
    }

    function toggleWishlist(btn, productId) {
        fetch(`/wishlist/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        }).then(res => res.json()).then(() => {
            const wishlisted = btn.dataset.wishlisted === 'true';
            if (wishlisted) {
                btn.dataset.wishlisted = 'false';
                btn.textContent = '🤍 Wishlist';
                btn.classList.remove('wishlisted');
            } else {
                btn.dataset.wishlisted = 'true';
                btn.textContent = '❤️ Wishlisted';
                btn.classList.add('wishlisted');
            }
        });
    }

    function submitCart(btn) {
        const variantId = document.getElementById('popup-variant-id').value;
        const original = btn.textContent;
        btn.textContent = 'Menambahkan...';
        btn.disabled = true;
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_variant_id: variantId, quantity: 1 })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                btn.textContent = '✓ Ditambahkan!';
                btn.style.background = '#38b2ac';
                setTimeout(() => {
                    closeShadePopup();
                    btn.textContent = original;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 1200);
            } else {
                btn.textContent = data.error ?? 'Gagal!';
                btn.disabled = false;
            }
        }).catch(() => {
            btn.textContent = 'Gagal!';
            btn.disabled = false;
        });
    }
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang — Skinist</title>
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
            border-radius: 50px; padding: 9px 20px;
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

        .cart-card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            overflow: hidden; margin-bottom: 12px;
        }

        .cart-item {
            display: flex; align-items: center; gap: 20px;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(91,184,245,0.07);
            transition: background 0.2s ease;
        }
        .cart-item:last-child { border-bottom: none; }
        .cart-item:hover { background: #F8FBFF; }

        .cart-img {
            width: 72px; height: 72px;
            background: #E3F2FD; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .cart-img img { width: 100%; height: 100%; object-fit: contain; }

        .brand-label {
            font-size: 0.68rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5BB8F5; font-weight: 500;
        }

        .product-name {
            font-size: 0.92rem; font-weight: 500; color: #1A3A5C; margin: 3px 0;
        }

        .shade-dot {
            width: 14px; height: 14px; border-radius: 50%;
            border: 2px solid white; box-shadow: 0 1px 4px rgba(26,58,92,0.15);
            display: inline-block; flex-shrink: 0;
        }

        .price-main {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem; font-weight: 600; color: #5BB8F5;
        }

        .price-sub {
            font-size: 0.75rem; color: #5A7FA0; margin: 2px 0;
        }

        .price-total {
            font-size: 0.82rem; font-weight: 600; color: #1A3A5C;
        }

        .btn-delete {
            width: 34px; height: 34px; border-radius: 10px;
            background: none; border: 1px solid rgba(224,92,92,0.2);
            color: rgba(224,92,92,0.5); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s ease; flex-shrink: 0;
        }
        .btn-delete:hover { background: rgba(224,92,92,0.08); border-color: #e05c5c; color: #e05c5c; }

        .summary-card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 24px;
            position: sticky; top: 88px;
        }

        .summary-title {
            font-size: 0.72rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5A7FA0;
            margin-bottom: 20px; font-weight: 500;
        }

        .summary-row {
            display: flex; justify-content: space-between;
            align-items: center; padding: 10px 0;
            border-bottom: 1px solid rgba(91,184,245,0.08);
            font-size: 0.85rem; color: #5A7FA0;
        }
        .summary-row:last-of-type { border-bottom: none; }

        .summary-total {
            display: flex; justify-content: space-between;
            align-items: center; padding: 16px 0 20px;
        }
        .summary-total-label { font-size: 0.88rem; color: #1A3A5C; font-weight: 500; }
        .summary-total-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 600; color: #5BB8F5;
        }

        .btn-checkout {
            display: block; width: 100%;
            background: #1A3A5C; color: white;
            text-align: center; text-decoration: none;
            padding: 15px; border-radius: 14px;
            font-size: 0.88rem; font-weight: 500;
            letter-spacing: 0.05em;
            transition: all 0.25s ease;
        }
        .btn-checkout:hover {
            background: #5BB8F5;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(91,184,245,0.3);
        }

        .empty-state {
            text-align: center; padding: 80px 24px;
            background: white; border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.08);
        }

        .btn-shop {
            display: inline-block; margin-top: 20px;
            background: #1A3A5C; color: white;
            text-decoration: none; padding: 13px 32px;
            border-radius: 50px; font-size: 0.85rem;
            font-weight: 500; letter-spacing: 0.05em;
            transition: all 0.25s ease;
        }
        .btn-shop:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,184,245,0.3); }

        .alert-success {
            background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.3);
            color: #1A3A5C; padding: 12px 16px; border-radius: 12px;
            margin-bottom: 16px; font-size: 0.85rem;
        }
        .alert-error {
            background: rgba(224,92,92,0.08); border: 1px solid rgba(224,92,92,0.25);
            color: #c0392b; padding: 12px 16px; border-radius: 12px;
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
                <div style="flex:1; position:relative;">
                    <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#5A7FA0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Cari produk..." class="search-input" style="padding-left:40px;">
                </div>
                <div style="display:flex; align-items:center; gap:20px; flex-shrink:0;">
                    <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
                    @include('partials.order-notif-icons')
                    <a href="{{ route('cart.index') }}" style="color:#5A7FA0; position:relative; line-height:1;">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if($carts->count() > 0)
                        <span style="position:absolute; top:-8px; right:-8px; background:#5BB8F5; color:white; font-size:0.65rem; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600;">{{ $carts->count() }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:1280px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Keranjang Belanja</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">{{ $carts->count() }} item dalam keranjangmu</p>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Lanjut Belanja
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error animate-in">{{ session('error') }}</div>
        @endif

        @if($carts->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="empty-state animate-in">
                <div style="font-size:4rem; margin-bottom:16px; opacity:0.3;">🛍️</div>
                <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Keranjangmu masih kosong</h3>
                <p style="font-size:0.85rem; color:#5A7FA0;">Yuk mulai belanja dan temukan produk favoritmu!</p>
                <a href="/" class="btn-shop">Mulai Belanja</a>
            </div>

        @else
            <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

                {{-- CART ITEMS --}}
                <div class="animate-in">
                    <div class="cart-card">
                        @foreach($carts as $cart)
                        <div class="cart-item">

                            {{-- Gambar --}}
                            <div class="cart-img">
                                @if($cart->variant->product->thumbnail)
                                    <img src="{{ asset('storage/' . $cart->variant->product->thumbnail) }}" alt="">
                                @else
                                    <span style="font-size:2rem;">🧴</span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div style="flex:1; min-width:0;">
                                <p class="brand-label">{{ $cart->variant->product->brand->name }}</p>
                                <p class="product-name">{{ $cart->variant->product->name }}</p>
                                <div style="display:flex; align-items:center; gap:6px; margin-top:6px;">
                                    @if($cart->variant->hex_color)
                                    <span class="shade-dot" style="background-color:{{ $cart->variant->hex_color }};"></span>
                                    @endif
                                    @if($cart->variant->shade_name)
                                    <span style="font-size:0.78rem; color:#5A7FA0;">{{ $cart->variant->shade_name }}</span>
                                    @endif
                                    @if($cart->variant->size)
                                    <span style="font-size:0.78rem; color:#5A7FA0; background:#E3F2FD; padding:2px 8px; border-radius:6px;">{{ $cart->variant->size }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div style="text-align:right; flex-shrink:0;">
                                <p class="price-main">Rp {{ number_format($cart->variant->price, 0, ',', '.') }}</p>
                                <p class="price-sub">× {{ $cart->quantity }}</p>
                                <p class="price-total">Rp {{ number_format($cart->variant->price * $cart->quantity, 0, ',', '.') }}</p>
                            </div>

                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('cart.remove', $cart->id) }}" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus">
                                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- SUMMARY --}}
                <div class="animate-in" style="animation-delay:0.1s;">
                    <div class="summary-card">
                        <p class="summary-title">Ringkasan Pesanan</p>

                        @foreach($carts as $cart)
                        <div class="summary-row">
                            <span style="max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $cart->variant->product->name }}</span>
                            <span style="color:#1A3A5C; font-weight:500; flex-shrink:0;">Rp {{ number_format($cart->variant->price * $cart->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach

                        <div style="border-top:1px solid rgba(91,184,245,0.15); margin-top:4px;">
                            <div class="summary-total">
                                <span class="summary-total-label">Total</span>
                                <span class="summary-total-value">Rp {{ number_format($carts->sum(fn($c) => $c->variant->price * $c->quantity), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn-checkout">
                            Checkout Sekarang →
                        </a>

                        <a href="/" style="display:block; text-align:center; margin-top:12px; font-size:0.78rem; color:#5A7FA0; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                            ← Lanjut Belanja
                        </a>
                    </div>
                </div>

            </div>
        @endif

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
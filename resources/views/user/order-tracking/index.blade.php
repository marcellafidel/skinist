<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan — Skinist</title>
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

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #5A7FA0; text-decoration: none;
            padding: 7px 16px; border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.25); background: white;
            transition: all 0.2s ease;
        }
        .btn-back:hover { color: #5BB8F5; border-color: #5BB8F5; background: #E3F2FD; }

        .order-card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 22px 24px;
            margin-bottom: 14px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 20px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .order-card:hover { box-shadow: 0 8px 24px rgba(91,184,245,0.12); transform: translateY(-1px); }

        .invoice-label {
            font-size: 0.68rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5BB8F5; font-weight: 500;
        }
        .order-date { font-size: 0.78rem; color: #5A7FA0; margin: 3px 0; }
        .order-total {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem; font-weight: 600; color: #1A3A5C;
        }

        .status-badge {
            font-size: 0.72rem; font-weight: 600; padding: 6px 16px;
            border-radius: 50px; white-space: nowrap;
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

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease both; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:32px; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                <div style="flex:1;"></div>
                <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </nav>

    <main style="max-width:900px; margin:0 auto; padding:32px 24px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Lacak Pesanan</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">{{ $orders->count() }} pesanan ditemukan</p>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Lanjut Belanja
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.3); color: #1A3A5C; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 0.85rem;">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background: rgba(224,92,92,0.08); border: 1px solid rgba(224,92,92,0.25); color: #c0392b; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 0.85rem;">{{ session('error') }}</div>
        @endif

        @if($orders->isEmpty())
            <div class="empty-state animate-in">
                <div style="font-size:4rem; margin-bottom:16px; opacity:0.3;">📦</div>
                <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Belum ada pesanan</h3>
                <p style="font-size:0.85rem; color:#5A7FA0;">Pesananmu akan muncul di sini setelah checkout.</p>
                <a href="/" class="btn-shop">Mulai Belanja</a>
            </div>
        @else
            <div class="animate-in">
                @foreach($orders as $order)
                <a href="{{ route('orders.tracking.show', $order->invoice_number) }}" class="order-card">
                    <div>
                        <p class="invoice-label">{{ $order->invoice_number }}</p>
                        <p class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="order-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <span class="status-badge" style="background: {{ $order->status_color }}1A; color: {{ $order->status_color }};">
                        {{ $order->status_label }}
                    </span>
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
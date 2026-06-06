<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — Skinist</title>
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

        .btn-dashboard {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: white; text-decoration: none;
            padding: 9px 20px; border-radius: 50px;
            background: #1A3A5C; border: none;
            transition: all 0.25s ease; font-weight: 500;
        }
        .btn-dashboard:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,184,245,0.3); }

        /* INFO CARD */
        .info-card {
            background: linear-gradient(135deg, #1A3A5C 0%, #2563a8 100%);
            border-radius: 20px; padding: 20px 24px;
            margin-bottom: 24px; color: white;
            display: flex; align-items: center; gap: 20px;
        }
        .info-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }
        .info-bank { font-size: 1rem; font-weight: 600; color: white; margin: 4px 0; }
        .info-note { font-size: 0.75rem; color: rgba(255,255,255,0.55); }

        /* ORDER CARD */
        .order-card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            margin-bottom: 16px; overflow: hidden;
            transition: box-shadow 0.2s ease;
        }
        .order-card:hover { box-shadow: 0 4px 20px rgba(26,58,92,0.08); }

        .order-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 24px 16px;
            border-bottom: 1px solid rgba(91,184,245,0.08);
        }

        .invoice-label { font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #5A7FA0; margin-bottom: 4px; }
        .invoice-number { font-size: 0.95rem; font-weight: 600; color: #1A3A5C; }

        /* STATUS BADGE */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 500; letter-spacing: 0.05em;
        }
        .badge-pending { background: rgba(251,191,36,0.12); color: #b45309; border: 1px solid rgba(251,191,36,0.3); }
        .badge-paid { background: rgba(52,211,153,0.12); color: #065f46; border: 1px solid rgba(52,211,153,0.3); }
        .badge-shipped { background: rgba(91,184,245,0.12); color: #1A3A5C; border: 1px solid rgba(91,184,245,0.3); }
        .badge-delivered { background: rgba(16,185,129,0.12); color: #064e3b; border: 1px solid rgba(16,185,129,0.3); }
        .badge-cancelled { background: rgba(224,92,92,0.1); color: #c0392b; border: 1px solid rgba(224,92,92,0.25); }

        /* ORDER ITEM */
        .order-items { padding: 0 24px; }
        .order-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(91,184,245,0.07);
        }
        .order-item:last-child { border-bottom: none; }

        .item-img {
            width: 52px; height: 52px; background: #E3F2FD;
            border-radius: 12px; display: flex;
            align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .item-img img { width: 100%; height: 100%; object-fit: contain; }

        /* ORDER FOOTER */
        .order-footer {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 24px;
            border-top: 1px solid rgba(91,184,245,0.08);
            background: #F8FBFF;
        }

        .order-date { font-size: 0.78rem; color: #5A7FA0; }
        .order-total {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; font-weight: 600; color: #5BB8F5;
        }

        /* UPLOAD SECTION */
        .upload-section { padding: 16px 24px 20px; }

        .upload-pending {
            background: rgba(251,191,36,0.06); border: 1px solid rgba(251,191,36,0.2);
            border-radius: 14px; padding: 16px;
        }
        .upload-pending-label { font-size: 0.8rem; color: #92400e; font-weight: 500; margin-bottom: 12px; }

        .file-input-wrap {
            display: flex; align-items: center; gap: 10px;
        }
        .file-label {
            display: inline-flex; align-items: center; gap: 6px;
            background: #E3F2FD; color: #1A3A5C; padding: 9px 16px;
            border-radius: 10px; font-size: 0.8rem; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease;
        }
        .file-label:hover { background: #BFDFFF; }
        .file-input { display: none; }

        .btn-upload {
            background: #1A3A5C; color: white; border: none;
            padding: 9px 20px; border-radius: 10px;
            font-size: 0.8rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; transition: all 0.2s ease;
        }
        .btn-upload:hover { background: #5BB8F5; }

        .uploaded-proof {
            background: rgba(91,184,245,0.06); border: 1px solid rgba(91,184,245,0.2);
            border-radius: 14px; padding: 14px 16px;
        }
        .uploaded-label { font-size: 0.78rem; color: #5A7FA0; margin-bottom: 8px; font-weight: 500; }
        .proof-thumb { height: 80px; border-radius: 10px; object-fit: cover; }

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
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                <div style="display:flex; align-items:center; gap:16px;">
                    <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
                    <a href="{{ route('cart.index') }}" style="color:#5A7FA0; text-decoration:none; font-size:0.82rem; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:860px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Pesanan Saya</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">Pantau status pesanan & upload bukti pembayaran</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="/" class="btn-back">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali Belanja
                </a>
                {{-- TOMBOL KEMBALI KE DASHBOARD --}}
                <a href="/" class="btn-dashboard">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in">🎉 {{ session('success') }}</div>
        @endif

        {{-- INFO REKENING --}}
        <div class="info-card animate-in">
            <div class="info-icon">🏦</div>
            <div>
                <p style="font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.5); margin-bottom:4px;">Info Pembayaran</p>
                <p class="info-bank">BCA — 1234567890 a/n Skinist Store</p>
                <p class="info-note">Transfer sesuai total pesanan, lalu upload bukti di bawah.</p>
            </div>
        </div>

        @forelse($orders as $order)
        <div class="order-card animate-in">

            {{-- HEADER --}}
            <div class="order-header">
                <div>
                    <p class="invoice-label">Invoice</p>
                    <p class="invoice-number">{{ $order->invoice_number }}</p>
                </div>
                @php
                    $badgeClass = match($order->status) {
                        'paid' => 'badge-paid',
                        'shipped' => 'badge-shipped',
                        'delivered' => 'badge-delivered',
                        'cancelled' => 'badge-cancelled',
                        default => 'badge-pending',
                    };
                    $statusIcon = match($order->status) {
                        'paid' => '✓',
                        'shipped' => '🚚',
                        'delivered' => '✅',
                        'cancelled' => '✕',
                        default => '⏳',
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">
                    {{ $statusIcon }} {{ ucfirst($order->status) }}
                </span>
            </div>

            {{-- ITEMS --}}
            <div class="order-items">
                @foreach($order->details as $detail)
                <div class="order-item">
                    <div class="item-img">
                        @if($detail->variant->product->thumbnail)
                            <img src="{{ asset('storage/' . $detail->variant->product->thumbnail) }}" alt="">
                        @else
                            <span style="font-size:1.5rem;">🧴</span>
                        @endif
                    </div>
                    <div style="flex:1; min-width:0;">
                        <p style="font-size:0.88rem; font-weight:500; color:#1A3A5C;">{{ $detail->variant->product->name }}</p>
                        <div style="display:flex; align-items:center; gap:5px; margin-top:3px;">
                            @if($detail->variant->hex_color)
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $detail->variant->hex_color }};border:1px solid rgba(0,0,0,0.1);display:inline-block;"></span>
                            @endif
                            <span style="font-size:0.75rem; color:#5A7FA0;">{{ $detail->variant->shade_name }} @if($detail->variant->size) · {{ $detail->variant->size }} @endif</span>
                        </div>
                    </div>
                    <div style="text-align:right; flex-shrink:0;">
                        <p style="font-size:0.88rem; font-weight:600; color:#5BB8F5;">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                        <p style="font-size:0.72rem; color:#5A7FA0;">×{{ $detail->quantity }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FOOTER --}}
            <div class="order-footer">
                <span class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</span>
                <div style="text-align:right;">
                    <p style="font-size:0.7rem; color:#5A7FA0; margin-bottom:2px;">Total Pembayaran</p>
                    <p class="order-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- UPLOAD BUKTI --}}
            @if($order->status === 'pending')
            <div class="upload-section">
                @if($order->payment_proof)
                    <div class="uploaded-proof">
                        <p class="uploaded-label">✓ Bukti pembayaran sudah diupload — menunggu konfirmasi admin</p>
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="proof-thumb" alt="Bukti Pembayaran">
                    </div>
                @else
                    <div class="upload-pending">
                        <p class="upload-pending-label">⏳ Belum ada bukti pembayaran — upload sekarang untuk konfirmasi</p>
                        <form action="{{ route('orders.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="file-input-wrap">
                                <label class="file-label" for="file-{{ $order->id }}">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Pilih Gambar
                                </label>
                                <input type="file" id="file-{{ $order->id }}" name="payment_proof" accept="image/*" required class="file-input" onchange="showFileName(this, {{ $order->id }})">
                                <span id="filename-{{ $order->id }}" style="font-size:0.75rem; color:#5A7FA0; flex:1;"></span>
                                <button type="submit" class="btn-upload">Upload</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            @endif

            {{-- TOMBOL KEMBALI KE DASHBOARD setelah paid/delivered --}}
            @if(in_array($order->status, ['paid', 'shipped', 'delivered']))
            <div style="padding:0 24px 20px; display:flex; justify-content:flex-end;">
                <a href="/" class="btn-dashboard" style="font-size:0.78rem; padding:8px 18px;">
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
            @endif

        </div>
        @empty
        <div class="empty-state animate-in">
            <div style="font-size:4rem; margin-bottom:16px; opacity:0.3;">📭</div>
            <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Belum ada pesanan</h3>
            <p style="font-size:0.85rem; color:#5A7FA0;">Yuk mulai belanja dan temukan produk favoritmu!</p>
            <a href="/" class="btn-shop">Mulai Belanja</a>
        </div>
        @endforelse

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

<script>
function showFileName(input, orderId) {
    const span = document.getElementById('filename-' + orderId);
    if (input.files && input.files[0]) {
        span.textContent = input.files[0].name;
    }
}
</script>

</body>
</html>
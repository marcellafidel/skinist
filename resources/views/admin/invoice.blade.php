<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice_number }} — Admin Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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

        .btn-print {
            display: inline-flex; align-items: center; gap: 8px;
            background: #1A3A5C; color: white; border: none;
            padding: 12px 24px; border-radius: 50px;
            font-size: 0.85rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; letter-spacing: 0.04em;
            transition: all 0.25s ease; text-decoration: none;
        }
        .btn-print:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,184,245,0.3); }

        /* INVOICE CARD */
        .invoice-wrap {
            background: white; border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.1);
            max-width: 760px; margin: 0 auto;
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #1A3A5C 0%, #2563a8 100%);
            padding: 36px 40px;
            display: flex; justify-content: space-between; align-items: flex-start;
        }

        .invoice-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem; font-weight: 300; font-style: italic;
            color: white; letter-spacing: 0.15em;
        }
        .invoice-tagline { font-size: 0.72rem; color: rgba(255,255,255,0.45); letter-spacing: 0.1em; margin-top: 4px; }

        .invoice-number-wrap { text-align: right; }
        .invoice-label { font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; color: rgba(255,255,255,0.45); margin-bottom: 4px; }
        .invoice-number { font-size: 1rem; font-weight: 600; color: white; letter-spacing: 0.05em; }
        .invoice-date { font-size: 0.75rem; color: rgba(255,255,255,0.55); margin-top: 6px; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 50px;
            font-size: 0.7rem; font-weight: 500; margin-top: 8px;
        }
        .status-pending { background: rgba(251,191,36,0.2); color: #fbbf24; border: 1px solid rgba(251,191,36,0.4); }
        .status-paid { background: rgba(52,211,153,0.2); color: #34d399; border: 1px solid rgba(52,211,153,0.4); }
        .status-shipped { background: rgba(91,184,245,0.2); color: #5BB8F5; border: 1px solid rgba(91,184,245,0.4); }
        .status-delivered { background: rgba(16,185,129,0.2); color: #10b981; border: 1px solid rgba(16,185,129,0.4); }
        .status-cancelled { background: rgba(224,92,92,0.2); color: #e05c5c; border: 1px solid rgba(224,92,92,0.4); }

        .invoice-body { padding: 36px 40px; }

        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 24px; margin-bottom: 32px;
            padding-bottom: 28px;
            border-bottom: 1px solid rgba(91,184,245,0.1);
        }

        .info-section-label {
            font-size: 0.65rem; letter-spacing: 0.2em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; margin-bottom: 10px;
        }
        .info-value { font-size: 0.88rem; color: #1A3A5C; line-height: 1.7; }

        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .items-table th {
            font-size: 0.65rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; padding: 10px 0;
            border-bottom: 1px solid rgba(91,184,245,0.15);
            text-align: left;
        }
        .items-table th:last-child { text-align: right; }
        .items-table td {
            padding: 16px 0;
            border-bottom: 1px solid rgba(91,184,245,0.07);
            vertical-align: middle;
        }

        .item-img {
            width: 44px; height: 44px; border-radius: 10px;
            background: #E3F2FD; display: flex;
            align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .item-img img { width: 100%; height: 100%; object-fit: contain; }
        .item-brand { font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase; color: #5BB8F5; font-weight: 500; }
        .item-name { font-size: 0.88rem; font-weight: 500; color: #1A3A5C; }
        .item-variant { font-size: 0.75rem; color: #5A7FA0; margin-top: 2px; }
        .item-qty { font-size: 0.85rem; color: #5A7FA0; text-align: center; }
        .item-price { font-size: 0.85rem; color: #5A7FA0; }
        .item-total { font-size: 0.9rem; font-weight: 600; color: #1A3A5C; text-align: right; font-family: 'Cormorant Garamond', serif; }

        .total-section { margin-left: auto; width: 280px; }
        .total-row {
            display: flex; justify-content: space-between;
            align-items: center; padding: 8px 0;
            font-size: 0.85rem; color: #5A7FA0;
            border-bottom: 1px solid rgba(91,184,245,0.08);
        }
        .total-final {
            display: flex; justify-content: space-between;
            align-items: center; padding: 16px 0 0;
            border-top: 2px solid #1A3A5C; margin-top: 4px;
        }
        .total-final-label { font-size: 0.85rem; font-weight: 600; color: #1A3A5C; }
        .total-final-value { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: #5BB8F5; }

        /* ADMIN BADGE */
        .admin-badge {
            background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.2);
            border-radius: 14px; padding: 12px 16px; margin-top: 24px;
            display: flex; align-items: center; gap: 10px;
        }
        .admin-badge-label { font-size: 0.72rem; color: #5A7FA0; }
        .admin-badge-value { font-size: 0.85rem; font-weight: 500; color: #1A3A5C; }

        /* PAYMENT PROOF */
        .proof-section {
            background: #F0F7FF; border-radius: 14px;
            padding: 18px 20px; margin-top: 20px;
            border: 1px solid rgba(91,184,245,0.15);
        }
        .proof-label { font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase; color: #5A7FA0; font-weight: 500; margin-bottom: 10px; }
        .proof-img { height: 120px; border-radius: 10px; object-fit: cover; }

        .invoice-footer {
            padding: 20px 40px;
            background: #F8FBFF;
            border-top: 1px solid rgba(91,184,245,0.1);
            display: flex; justify-content: space-between; align-items: center;
        }
        .footer-note { font-size: 0.75rem; color: #5A7FA0; font-style: italic; }
        .footer-brand { font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-style: italic; color: #1A3A5C; opacity: 0.4; }

        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .invoice-wrap { box-shadow: none; border: none; max-width: 100%; }
            .navbar { display: none; }
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
    <nav class="navbar no-print">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0;">
                <div style="display:flex; align-items:center; gap:16px;">
                    <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                    <span style="font-size:0.72rem; background:#E3F2FD; color:#5BB8F5; padding:4px 12px; border-radius:50px; font-weight:500; letter-spacing:0.08em;">Admin Panel</span>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <a href="{{ route('admin.orders') }}" class="btn-back">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Pesanan
                    </a>
                    <button onclick="window.print()" class="btn-print">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print / Simpan PDF
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:860px; margin:0 auto; padding:32px 24px;">

        <div class="invoice-wrap animate-in">

            {{-- HEADER --}}
            <div class="invoice-header">
                <div>
                    <div class="invoice-logo">Skinist</div>
                    <div class="invoice-tagline">keep the barrier safe, let your flawless skin speak</div>
                </div>
                <div class="invoice-number-wrap">
                    <div class="invoice-label">Invoice</div>
                    <div class="invoice-number">{{ $order->invoice_number }}</div>
                    <div class="invoice-date">{{ $order->created_at->format('d F Y, H:i') }} WIB</div>
                    @php
                        $statusClass = match($order->status) {
                            'paid' => 'status-paid',
                            'shipped' => 'status-shipped',
                            'delivered' => 'status-delivered',
                            'cancelled' => 'status-cancelled',
                            default => 'status-pending',
                        };
                        $statusIcon = match($order->status) {
                            'paid' => '✓',
                            'shipped' => '🚚',
                            'delivered' => '✅',
                            'cancelled' => '✕',
                            default => '⏳',
                        };
                    @endphp
                    <div class="status-badge {{ $statusClass }}">
                        {{ $statusIcon }} {{ ucfirst($order->status) }}
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            <div class="invoice-body">

                {{-- INFO --}}
                <div class="info-grid">
                    <div>
                        <p class="info-section-label">Dari</p>
                        <p class="info-value">
                            <strong>Skinist Store</strong><br>
                            Jl. Apalo<br>
                            cs.skinist@gmail.com<br>
                            087646787534245
                        </p>
                    </div>
                    <div>
                        <p class="info-section-label">Kepada</p>
                        <p class="info-value">
                            <strong>{{ $order->user->name }}</strong><br>
                            {{ $order->user->email }}<br>
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>

                {{-- ITEMS --}}
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width:40%;">Produk</th>
                            <th style="text-align:center;">Qty</th>
                            <th>Harga Satuan</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div class="item-img">
                                        @if($detail->variant->product->thumbnail)
                                            <img src="{{ asset('storage/' . $detail->variant->product->thumbnail) }}" alt="">
                                        @else
                                            <span style="font-size:1.2rem;">🧴</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="item-brand">{{ $detail->variant->product->brand->name }}</p>
                                        <p class="item-name">{{ $detail->variant->product->name }}</p>
                                        <p class="item-variant">
                                            @if($detail->variant->shade_name) {{ $detail->variant->shade_name }} @endif
                                            @if($detail->variant->size) · {{ $detail->variant->size }} @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="item-qty">{{ $detail->quantity }}</td>
                            <td class="item-price">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="item-total">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- TOTAL --}}
                <div style="display:flex; justify-content:flex-end;">
                    <div class="total-section">
                        @php
                            $subtotal = $order->details->sum(fn($d) => $d->price * $d->quantity);
                            $discount = $subtotal - $order->total_price;
                        @endphp
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="total-row">
                            <span>Diskon</span>
                            <span style="color:#5BB8F5;">− Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="total-row">
                            <span>Ongkos Kirim</span>
                            <span style="color:#34d399;">Gratis</span>
                        </div>
                        <div class="total-final">
                            <span class="total-final-label">Total</span>
                            <span class="total-final-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- BUKTI PEMBAYARAN --}}
                @if($order->payment_proof)
                <div class="proof-section">
                    <p class="proof-label">Bukti Pembayaran</p>
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="proof-img" alt="Bukti Pembayaran">
                </div>
                @endif

                {{-- INFO ADMIN --}}
                <div class="admin-badge no-print">
                    <span style="font-size:1rem;">🛠️</span>
                    <div>
                        <p class="admin-badge-label">Dilihat sebagai Admin</p>
                        <p class="admin-badge-value">Invoice ini milik {{ $order->user->name }} ({{ $order->user->email }})</p>
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="invoice-footer">
                <p class="footer-note">Terima kasih telah berbelanja di Skinist ✨</p>
                <p class="footer-brand">Skinist</p>
            </div>

        </div>

    </main>

</body>
</html>
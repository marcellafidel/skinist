<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $order->invoice_number }} — Skinist</title>
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

        .card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 28px; margin-bottom: 20px;
        }

        .card-title {
            font-size: 0.72rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5A7FA0;
            margin-bottom: 20px; font-weight: 500;
        }

        .status-badge {
            font-size: 0.72rem; font-weight: 600; padding: 6px 16px;
            border-radius: 50px; white-space: nowrap;
        }

        /* STEPPER */
        .stepper {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding: 10px 0 6px;
        }
        .step {
            display: flex; flex-direction: column; align-items: center;
            flex: 1; position: relative;
        }
        .step-circle {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; font-weight: 600;
            background: #E3F2FD; color: #5A7FA0;
            border: 2px solid #E3F2FD;
            z-index: 2; transition: all 0.3s ease;
        }
        .step.done .step-circle { background: #5BB8F5; color: white; border-color: #5BB8F5; }
        .step.current .step-circle { background: #1A3A5C; color: white; border-color: #1A3A5C; box-shadow: 0 0 0 4px rgba(26,58,92,0.12); }
        .step.cancelled .step-circle { background: #e05c5c; color: white; border-color: #e05c5c; }

        .step-line {
            position: absolute; top: 18px; left: -50%; width: 100%;
            height: 2px; background: #E3F2FD; z-index: 1;
        }
        .step:first-child .step-line { display: none; }
        .step.done .step-line, .step.current .step-line { background: #5BB8F5; }

        .step-label {
            font-size: 0.72rem; color: #5A7FA0; margin-top: 10px;
            text-align: center; max-width: 90px;
        }
        .step.done .step-label, .step.current .step-label { color: #1A3A5C; font-weight: 500; }

        /* HISTORY TABLE */
        .history-row {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 14px 0; border-bottom: 1px solid rgba(91,184,245,0.07);
        }
        .history-row:last-child { border-bottom: none; }
        .history-dot {
            width: 10px; height: 10px; border-radius: 50%;
            margin-top: 4px; flex-shrink: 0;
        }
        .history-status { font-size: 0.85rem; font-weight: 500; color: #1A3A5C; }
        .history-note { font-size: 0.78rem; color: #5A7FA0; margin-top: 2px; }
        .history-date { font-size: 0.72rem; color: #5A7FA0; margin-left: auto; white-space: nowrap; flex-shrink: 0; }

        /* PRODUCT ITEM */
        .item-row {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 0; border-bottom: 1px solid rgba(91,184,245,0.07);
        }
        .item-row:last-child { border-bottom: none; }
        .item-img {
            width: 56px; height: 56px; background: #E3F2FD;
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; overflow: hidden; flex-shrink: 0;
        }
        .item-img img { width: 100%; height: 100%; object-fit: contain; }
        .item-name { font-size: 0.85rem; font-weight: 500; color: #1A3A5C; }
        .item-meta { font-size: 0.75rem; color: #5A7FA0; margin-top: 2px; }

        .btn-cancel {
            background: white; color: #e05c5c;
            border: 1px solid rgba(224,92,92,0.3);
            padding: 11px 24px; border-radius: 50px;
            font-size: 0.82rem; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease;
        }
        .btn-cancel:hover { background: rgba(224,92,92,0.06); border-color: #e05c5c; }

        .info-row {
            display: flex; justify-content: space-between;
            font-size: 0.85rem; padding: 8px 0;
            border-bottom: 1px solid rgba(91,184,245,0.07);
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #5A7FA0; }
        .info-value { color: #1A3A5C; font-weight: 500; text-align: right; }

        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(26,58,92,0.4); z-index: 200;
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: white; border-radius: 20px; padding: 28px;
            width: 90%; max-width: 380px;
        }
        .modal-textarea {
            width: 100%; border: 1.5px solid rgba(91,184,245,0.2);
            border-radius: 12px; padding: 12px; font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem; resize: vertical; min-height: 80px;
            margin: 12px 0 16px;
        }
        .modal-textarea:focus { outline: none; border-color: #5BB8F5; }

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

    <main style="max-width:760px; margin:0 auto; padding:32px 24px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;" class="animate-in">
            <div>
                <p class="font-display" style="font-size:0.95rem; color:#5BB8F5; letter-spacing:0.05em; margin:0 0 4px;">{{ $order->invoice_number }}</p>
                <h1 class="font-display" style="font-size:1.8rem; font-weight:300; color:#1A3A5C; margin:0;">Detail Pesanan</h1>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('orders.invoice', $order->id) }}" class="btn-back">
                    🧾 Lihat Invoice
                </a>
                <a href="{{ route('orders.tracking.index') }}" class="btn-back">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Semua Pesanan
                </a>
            </div>
        </div>
        </div>

        @if(session('success'))
            <div style="background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.3); color: #1A3A5C; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 0.85rem;">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background: rgba(224,92,92,0.08); border: 1px solid rgba(224,92,92,0.25); color: #c0392b; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 0.85rem;">{{ session('error') }}</div>
        @endif

        {{-- STEPPER --}}
        <div class="card animate-in">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <p class="card-title" style="margin-bottom:0;">Status Pesanan</p>
                <span class="status-badge" style="background: {{ $order->status_color }}1A; color: {{ $order->status_color }};">
                    {{ $order->status_label }}
                </span>
            </div>

            @if($order->status === 'cancelled')
                <div style="text-align:center; padding:30px 0 10px;">
                    <div style="width:48px; height:48px; border-radius:50%; background:rgba(224,92,92,0.1); color:#e05c5c; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-size:1.3rem;">✕</div>
                    <p style="font-size:0.88rem; color:#1A3A5C; font-weight:500;">Pesanan ini telah dibatalkan</p>
                </div>
            @else
                @php
                    $steps = [
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Dibayar',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Diterima',
                    ];
                    $statusOrder = array_keys($steps);
                    $currentIndex = array_search($order->status, $statusOrder);
                @endphp
                <div class="stepper" style="margin-top:16px;">
                    @foreach($steps as $key => $label)
                        @php
                            $stepIndex = array_search($key, $statusOrder);
                            $stateClass = $stepIndex < $currentIndex ? 'done' : ($stepIndex === $currentIndex ? 'current' : '');
                        @endphp
                        <div class="step {{ $stateClass }}">
                            <div class="step-line"></div>
                            <div class="step-circle">
                                @if($stateClass === 'done')
                                    ✓
                                @else
                                    {{ $stepIndex + 1 }}
                                @endif
                            </div>
                            <p class="step-label">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($order->isCancellable())
                <div style="text-align:center; margin-top:20px;">
                    <button class="btn-cancel" onclick="document.getElementById('cancelModal').classList.add('open')">Batalkan Pesanan</button>
                </div>
            @endif
        </div>

        {{-- UPLOAD BUKTI PEMBAYARAN --}}
        @if($order->status === 'pending')
        <div class="card animate-in">
            <p class="card-title">Bukti Pembayaran</p>
            <div style="background: linear-gradient(135deg, #1A3A5C 0%, #2563a8 100%); border-radius:14px; padding:16px 18px; color:white; margin-bottom:16px; display:flex; align-items:center; gap:14px;">
                <div style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0;">🏦</div>
                <div>
                    <p style="font-size:0.85rem; font-weight:600; margin:0 0 2px;">BCA — 1234567890 a/n Skinist Store</p>
                    <p style="font-size:0.72rem; color:rgba(255,255,255,0.6); margin:0;">Transfer sesuai total pesanan, lalu upload bukti di bawah.</p>
                </div>
            </div>

            @if($order->payment_proof)
                <div style="background: rgba(91,184,245,0.06); border: 1px solid rgba(91,184,245,0.2); border-radius: 14px; padding: 14px 16px;">
                    <p style="font-size:0.78rem; color:#5A7FA0; margin-bottom:8px; font-weight:500;">✓ Bukti pembayaran sudah diupload — menunggu konfirmasi admin</p>
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" style="height:80px; border-radius:10px; object-fit:cover;" alt="Bukti Pembayaran">
                </div>
            @else
                <div style="background: rgba(251,191,36,0.06); border: 1px solid rgba(251,191,36,0.2); border-radius: 14px; padding: 16px;">
                    <p style="font-size:0.8rem; color:#92400e; font-weight:500; margin-bottom:12px;">⏳ Belum ada bukti pembayaran — upload sekarang untuk konfirmasi</p>
                    <form action="{{ route('orders.tracking.upload', $order->invoice_number) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="display:flex; align-items:center; gap:10px;">
                            <label for="payment-proof-file" style="display:inline-flex; align-items:center; gap:6px; background:#E3F2FD; color:#1A3A5C; padding:9px 16px; border-radius:10px; font-size:0.8rem; font-weight:500; cursor:pointer; transition:all 0.2s ease;">
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Pilih Gambar
                            </label>
                            <input type="file" id="payment-proof-file" name="payment_proof" accept="image/*" required style="display:none;" onchange="document.getElementById('payment-proof-filename').textContent = this.files[0]?.name ?? ''">
                            <span id="payment-proof-filename" style="font-size:0.75rem; color:#5A7FA0; flex:1;"></span>
                            <button type="submit" style="background:#1A3A5C; color:white; border:none; padding:9px 20px; border-radius:10px; font-size:0.8rem; font-weight:500; cursor:pointer;">Upload</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        @endif

        {{-- INFO PESANAN --}}
        <div class="card animate-in">
            <p class="card-title">Informasi Pesanan</p>
            <div class="info-row">
                <span class="info-label">Tanggal Pesan</span>
                <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat Pengiriman</span>
                <span class="info-value">{{ $order->shipping_address }}</span>
            </div>
            @if($order->tracking_number)
            <div class="info-row">
                <span class="info-label">No. Resi</span>
                <span class="info-value">{{ $order->tracking_number }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Total Pembayaran</span>
                <span class="info-value" style="color:#5BB8F5; font-family:'Cormorant Garamond',serif; font-size:1.1rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- PRODUK --}}
        <div class="card animate-in">
            <p class="card-title">Produk Dipesan</p>
            @foreach($order->details as $detail)
            <div class="item-row">
                <div class="item-img">
                    @if($detail->variant->product->thumbnail)
                        <img src="{{ asset('storage/' . $detail->variant->product->thumbnail) }}" alt="">
                    @else
                        <span style="font-size:1.5rem;">🧴</span>
                    @endif
                </div>
                <div style="flex:1;">
                    <p class="item-name">{{ $detail->variant->product->name ?? 'Produk' }}</p>
                    @if($detail->variant->shade_name || $detail->variant->size)
                    <p class="item-meta" style="margin-bottom:2px;">
                        {{ $detail->variant->shade_name }}
                        @if($detail->variant->shade_name && $detail->variant->size) — @endif
                        {{ $detail->variant->size }}
                    </p>
                    @endif
                    <p class="item-meta">{{ $detail->quantity }}x — Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- RIWAYAT STATUS --}}
        <div class="card animate-in">
            <p class="card-title">Riwayat Status</p>
            @forelse($order->statusHistories as $history)
            <div class="history-row">
                <span class="history-dot" style="background:{{ $history->status_color }};"></span>
                <div style="flex:1;">
                    <p class="history-status">{{ $history->status_label }}</p>
                    @if($history->note)
                    <p class="history-note">{{ $history->note }}</p>
                    @endif
                </div>
                <span class="history-date">{{ $history->created_at->format('d M Y, H:i') }}</span>
            </div>
            @empty
            <p style="font-size:0.82rem; color:#5A7FA0;">Belum ada riwayat status.</p>
            @endforelse
        </div>

    </main>

    {{-- MODAL CANCEL --}}
    @if($order->isCancellable())
    <div class="modal-overlay" id="cancelModal">
        <div class="modal-box">
            <h3 class="font-display" style="font-size:1.3rem; font-weight:400; color:#1A3A5C; margin:0 0 4px;">Batalkan Pesanan?</h3>
            <p style="font-size:0.82rem; color:#5A7FA0; margin:0;">Beri tahu kami alasan pembatalan.</p>
            <form method="POST" action="{{ route('orders.tracking.cancel', $order->invoice_number) }}">
                @csrf
                <textarea name="cancel_reason" class="modal-textarea" placeholder="Contoh: Salah pilih produk, ingin ganti alamat, dll." required></textarea>
                <div style="display:flex; gap:10px;">
                    <button type="button" onclick="document.getElementById('cancelModal').classList.remove('open')" style="flex:1; background:white; border:1px solid rgba(91,184,245,0.25); color:#5A7FA0; padding:11px; border-radius:50px; font-size:0.82rem; cursor:pointer;">Batal</button>
                    <button type="submit" style="flex:1; background:#e05c5c; border:none; color:white; padding:11px; border-radius:50px; font-size:0.82rem; cursor:pointer;">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Skinist</title>
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

        /* STEPS */
        .steps {
            display: flex; align-items: center; gap: 0;
            font-size: 0.75rem; letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .step {
            display: flex; align-items: center; gap: 8px;
            color: #BFDFFF; font-weight: 400;
        }
        .step.active { color: #1A3A5C; font-weight: 500; }
        .step.done { color: #5BB8F5; }
        .step-num {
            width: 24px; height: 24px; border-radius: 50%;
            background: #E3F2FD; color: #5A7FA0;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 600;
        }
        .step.active .step-num { background: #1A3A5C; color: white; }
        .step.done .step-num { background: #5BB8F5; color: white; }
        .step-arrow { color: #BFDFFF; margin: 0 12px; font-size: 0.9rem; }

        /* CARD */
        .card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 28px;
        }

        .card-title {
            font-size: 0.72rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; margin-bottom: 20px;
        }

        /* INPUT */
        .input-group { margin-bottom: 16px; }
        .input-label {
            font-size: 0.72rem; letter-spacing: 0.1em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; margin-bottom: 7px; display: block;
        }
        .input-field {
            width: 100%; background: #F0F7FF;
            border: 1.5px solid transparent; border-radius: 12px;
            padding: 12px 16px; font-size: 0.88rem;
            color: #1A3A5C; font-family: 'DM Sans', sans-serif;
            transition: all 0.25s ease;
        }
        .input-field:focus { outline: none; border-color: #5BB8F5; background: white; box-shadow: 0 0 0 4px rgba(91,184,245,0.1); }
        .input-field:disabled { color: #5A7FA0; cursor: not-allowed; }
        .input-field::placeholder { color: #5A7FA0; opacity: 0.6; }

        textarea.input-field { resize: none; }

        .error-msg { font-size: 0.75rem; color: #e05c5c; margin-top: 6px; }

        /* COUPON */
        .coupon-active {
            background: rgba(91,184,245,0.08); border: 1px solid rgba(91,184,245,0.25);
            border-radius: 12px; padding: 12px 16px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .coupon-active-label { font-size: 0.82rem; color: #1A3A5C; font-weight: 500; }
        .coupon-remove { font-size: 0.75rem; color: #e05c5c; text-decoration: none; transition: opacity 0.2s; }
        .coupon-remove:hover { opacity: 0.7; }

        .coupon-input-wrap { display: flex; gap: 10px; }
        .btn-coupon {
            background: #E3F2FD; color: #1A3A5C; border: none;
            padding: 12px 20px; border-radius: 12px;
            font-size: 0.82rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; white-space: nowrap;
            transition: all 0.2s ease;
        }
        .btn-coupon:hover { background: #5BB8F5; color: white; }

        /* COURIER OPTIONS */
        .courier-option {
            display: flex; align-items: center; justify-content: space-between;
            border: 1.5px solid rgba(91,184,245,0.15); border-radius: 12px;
            padding: 12px 16px; margin-bottom: 10px; cursor: pointer;
            transition: all 0.2s ease; background: #F0F7FF;
        }
        .courier-option:hover { border-color: #5BB8F5; }
        .courier-option.selected { border-color: #5BB8F5; background: rgba(91,184,245,0.08); }
        .courier-option input[type="radio"] { accent-color: #1A3A5C; margin-right: 12px; }
        .courier-info { display: flex; align-items: center; }
        .courier-name { font-size: 0.85rem; font-weight: 500; color: #1A3A5C; }
        .courier-eta { font-size: 0.72rem; color: #5A7FA0; margin-top: 2px; }
        .courier-cost { font-size: 0.85rem; font-weight: 600; color: #5BB8F5; }

        /* BTN SUBMIT */
        .btn-submit {
            width: 100%; background: #1A3A5C; color: white;
            border: none; padding: 15px; border-radius: 14px;
            font-size: 0.88rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; letter-spacing: 0.05em;
            transition: all 0.25s ease; margin-top: 8px;
        }
        .btn-submit:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,184,245,0.3); }

        /* BACK BTN */
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #5A7FA0; text-decoration: none;
            padding: 7px 16px; border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.25); background: white;
            transition: all 0.2s ease;
        }
        .btn-back:hover { color: #5BB8F5; border-color: #5BB8F5; background: #E3F2FD; }

        /* ORDER SUMMARY */
        .order-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(91,184,245,0.08);
        }
        .order-item:last-child { border-bottom: none; }

        .order-img {
            width: 52px; height: 52px; background: #E3F2FD;
            border-radius: 12px; display: flex;
            align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .order-img img { width: 100%; height: 100%; object-fit: contain; }

        /* TOTAL CARD */
        .total-card {
            background: linear-gradient(135deg, #1A3A5C 0%, #2563a8 100%);
            border-radius: 20px; padding: 24px; color: white;
            margin-top: 16px;
        }
        .total-row {
            display: flex; justify-content: space-between;
            align-items: center; padding: 8px 0;
            font-size: 0.85rem; color: rgba(255,255,255,0.65);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .total-row:last-of-type { border-bottom: none; }
        .total-final {
            display: flex; justify-content: space-between;
            align-items: center; padding: 16px 0 0;
            border-top: 1px solid rgba(255,255,255,0.12);
            margin-top: 4px;
        }
        .total-final-label { font-size: 0.88rem; color: rgba(255,255,255,0.8); font-weight: 500; }
        .total-final-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem; font-weight: 600; color: white;
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
        .delay-1 { animation-delay: 0.1s; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>

                {{-- STEPS --}}
                <div class="steps">
                    <div class="step done">
                        <div class="step-num">✓</div>
                        <span>Keranjang</span>
                    </div>
                    <span class="step-arrow">›</span>
                    <div class="step active">
                        <div class="step-num">2</div>
                        <span>Checkout</span>
                    </div>
                    <span class="step-arrow">›</span>
                    <div class="step">
                        <div class="step-num">3</div>
                        <span>Pembayaran</span>
                    </div>
                </div>

                <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </nav>

    <main style="max-width:1100px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Checkout</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">Lengkapi informasi pengirimanmu</p>
            </div>
            <a href="{{ route('cart.index') }}" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        @if(session('error'))
            <div class="alert-error animate-in">{{ session('error') }}</div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 380px; gap:24px; align-items:start;">

            {{-- FORM --}}
            <div class="animate-in">
                <div class="card" style="margin-bottom:16px;">
                    <p class="card-title">Informasi Pengiriman</p>

                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf

                        <div class="input-group">
                            <label class="input-label">Nama Lengkap</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled class="input-field">
                        </div>

                        <div class="input-group">
                            <label class="input-label">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="input-field">
                        </div>

                        <div class="input-group">
                            <label class="input-label">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="4" required
                                placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Kode Pos..."
                                class="input-field">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label class="input-label">Pilih Kurir</label>
                            @foreach($couriers as $key => $courier)
                            <label class="courier-option {{ $loop->first ? 'selected' : '' }}" id="courier-label-{{ $key }}">
                                <div class="courier-info">
                                    <input type="radio" name="shipping_courier" value="{{ $key }}"
                                        data-cost="{{ $courier['cost'] }}"
                                        {{ $loop->first ? 'checked' : '' }}
                                        onchange="updateShipping(this)">
                                    <div>
                                        <p class="courier-name">{{ $courier['name'] }}</p>
                                        <p class="courier-eta">Estimasi {{ $courier['eta'] }}</p>
                                    </div>
                                </div>
                                <span class="courier-cost">Rp {{ number_format($courier['cost'], 0, ',', '.') }}</span>
                            </label>
                            @endforeach
                            @error('shipping_courier')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            Buat Pesanan →
                        </button>
                    </form>
                </div>

                {{-- KUPON --}}
                <div class="card">
                    <p class="card-title">Kode Kupon</p>
                    @if(session('coupon_code'))
                        <div class="coupon-active">
                            <span class="coupon-active-label">✓ Kupon <strong>{{ session('coupon_code') }}</strong> aktif</span>
                            <a href="{{ route('coupon.remove') }}" class="coupon-remove">Hapus</a>
                        </div>
                    @else
                        @if(session('coupon_error'))
                            <p style="font-size:0.78rem; color:#e05c5c; margin-bottom:10px;">{{ session('coupon_error') }}</p>
                        @endif
                        @if(session('coupon_success'))
                            <p style="font-size:0.78rem; color:#5BB8F5; margin-bottom:10px;">{{ session('coupon_success') }}</p>
                        @endif
                        <div class="coupon-input-wrap">
                            <input type="text" id="coupon_input" placeholder="Masukkan kode kupon..." class="input-field" style="margin:0;">
                            <button type="button" onclick="applyCoupon()" class="btn-coupon">Pakai</button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="animate-in delay-1">
                <div class="card">
                    <p class="card-title">Ringkasan Pesanan</p>
                    @foreach($carts as $cart)
                    <div class="order-item">
                        <div class="order-img">
                            @if($cart->variant->product->thumbnail)
                                <img src="{{ asset('storage/' . $cart->variant->product->thumbnail) }}" alt="">
                            @else
                                <span style="font-size:1.5rem;">🧴</span>
                            @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <p style="font-size:0.85rem; font-weight:500; color:#1A3A5C; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $cart->variant->product->name }}</p>
                            <div style="display:flex; align-items:center; gap:5px; margin-top:3px;">
                                @if($cart->variant->hex_color)
                                <span style="width:10px; height:10px; border-radius:50%; background:{{ $cart->variant->hex_color }}; border:1px solid rgba(0,0,0,0.1); display:inline-block;"></span>
                                @endif
                                <span style="font-size:0.75rem; color:#5A7FA0;">{{ $cart->variant->shade_name }} @if($cart->variant->size) · {{ $cart->variant->size }} @endif</span>
                            </div>
                        </div>
                        <div style="text-align:right; flex-shrink:0;">
                            <p style="font-size:0.85rem; font-weight:600; color:#5BB8F5;">Rp {{ number_format($cart->variant->price * $cart->quantity, 0, ',', '.') }}</p>
                            <p style="font-size:0.72rem; color:#5A7FA0;">×{{ $cart->quantity }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- TOTAL --}}
                @php
                    $subtotal = $carts->sum(fn($c) => $c->variant->price * $c->quantity);
                    $discount = 0;
                    if(session('coupon_id')) {
                        $coupon = \App\Models\Coupon::find(session('coupon_id'));
                        if($coupon) $discount = $coupon->calculateDiscount($subtotal);
                    }
                    $defaultShippingCost = array_values($couriers)[0]['cost'] ?? 0;
                    $finalTotal = $subtotal - $discount + $defaultShippingCost;
                @endphp
                <div class="total-card">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span style="color:rgba(255,255,255,0.85);">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="total-row">
                        <span>Diskon Kupon</span>
                        <span style="color:#BFDFFF;">− Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="total-row">
                        <span>Ongkos Kirim</span>
                        <span id="ongkir-value" style="color:#BFDFFF;">Rp {{ number_format($defaultShippingCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="total-final">
                        <span class="total-final-label">Total Pembayaran</span>
                        <span class="total-final-value" id="total-final-value">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>
    
<script>
const subtotalValue = {{ $subtotal }};
const discountValue = {{ $discount }};

function formatRupiah(num) {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function updateShipping(radio) {
    document.querySelectorAll('.courier-option').forEach(el => el.classList.remove('selected'));
    radio.closest('.courier-option').classList.add('selected');

    const shippingCost = parseFloat(radio.dataset.cost);
    document.getElementById('ongkir-value').textContent = formatRupiah(shippingCost);
    document.getElementById('total-final-value').textContent = formatRupiah(subtotalValue - discountValue + shippingCost);
}

function applyCoupon() {
    const code = document.getElementById('coupon_input').value;
    if (!code) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route('coupon.apply') }}';
    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
    const input = document.createElement('input');
    input.type = 'hidden'; input.name = 'coupon_code'; input.value = code;
    form.appendChild(csrf); form.appendChild(input);
    document.body.appendChild(form); form.submit();
}
</script>

</body>
</html>
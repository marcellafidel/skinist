<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">💳 Checkout</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- FORM ALAMAT --}}
            <div class="bg-white rounded-3xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Alamat Pengiriman</h2>

                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="mb-4">
                        <label class="text-sm text-gray-500 mb-1 block">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled
                            class="w-full bg-sky-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600">
                    </div>
                    <div class="mb-4">
                        <label class="text-sm text-gray-500 mb-1 block">Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled
                            class="w-full bg-sky-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600">
                    </div>
                    <div class="mb-6">
                        <label class="text-sm text-gray-500 mb-1 block">Alamat Lengkap</label>
                        <textarea name="shipping_address" rows="4" required
                            placeholder="Masukkan alamat lengkap kamu..."
                            class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-2xl text-lg transition-all duration-200">
                        Buat Pesanan ✨
                    </button>
                </form>
            </div>

            {{-- RINGKASAN PESANAN --}}
            <div>
                <div class="bg-white rounded-3xl shadow-sm p-6 mb-4">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Ringkasan Pesanan</h2>
                    @foreach($carts as $cart)
                    <div class="flex items-center gap-4 mb-4 pb-4 border-b border-sky-50 last:border-0 last:mb-0 last:pb-0">
                        <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">🧴</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-700">{{ $cart->variant->product->name }}</p>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="w-3 h-3 rounded-full inline-block" style="background-color: {{ $cart->variant->hex_color }}"></span>
                                <span class="text-xs text-gray-400">{{ $cart->variant->shade_name }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-sky-500">Rp {{ number_format($cart->variant->price * $cart->quantity, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">x{{ $cart->quantity }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="bg-sky-300 rounded-3xl shadow-sm p-6 text-white">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">Total Pembayaran</span>
                        <span class="text-2xl font-bold">
                            Rp {{ number_format($carts->sum(fn($c) => $c->variant->price * $c->quantity), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
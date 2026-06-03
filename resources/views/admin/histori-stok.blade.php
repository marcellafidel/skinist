<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Stok — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders') }}" class="text-sm text-sky-500 hover:underline">Pesanan</a>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-sky-500 hover:underline">Produk</a>
                <a href="{{ route('admin.brands') }}" class="text-sm text-sky-500 hover:underline">Brand</a>
                <a href="{{ route('admin.categories') }}" class="text-sm text-sky-500 hover:underline">Kategori</a>
                <a href="{{ route('admin.coupons') }}" class="text-sm text-sky-500 hover:underline">Kupon</a>
                <a href="{{ route('admin.laporan') }}" class="text-sm text-sky-500 hover:underline">Laporan Keuangan</a>
                <a href="{{ route('admin.stok') }}" class="text-sm text-sky-500 hover:underline font-semibold">Histori Stok</a>
                <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">📦 Histori Stok Produk</h1>

        @if(session('success'))
        <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
        @endif

        {{-- Form Tambah/Kurang Stok --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-700 mb-4">➕ Update Stok</h2>
            <form action="{{ route('admin.stok.tambah') }}" method="POST" class="grid grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="text-xs text-gray-400 mb-1 block">Pilih Variant</label>
                    <select name="product_variant_id" required
                        class="w-full border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        @foreach($variants as $variant)
                        <option value="{{ $variant->id }}">{{ $variant->product->name }} — {{ $variant->shade_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-400 mb-1 block">Tipe</label>
                    <select name="tipe" required
                        class="w-full border border-sky-200 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        <option value="masuk">Stok Masuk</option>
                        <option value="keluar">Stok Keluar</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-400 mb-1 block">Jumlah</label>
                    <input type="number" name="jumlah" min="1" required
                        class="w-full border border-sky-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300"
                        placeholder="Masukkan jumlah">
                </div>
                <div>
                    <label class="text-xs text-gray-400 mb-1 block">Keterangan</label>
                    <input type="text" name="keterangan"
                        class="w-full border border-sky-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-300"
                        placeholder="Contoh: Restock dari supplier">
                </div>
                <div class="col-span-2">
                    <button type="submit"
                        class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-2 rounded-full text-sm font-semibold transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Stok Saat Ini --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-700 mb-4">📊 Stok Saat Ini</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-sky-50">
                        <th class="pb-3">Produk</th>
                        <th class="pb-3">Brand</th>
                        <th class="pb-3">Variant / Shade</th>
                        <th class="pb-3 text-center">Stok</th>
                        <th class="pb-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        @foreach($product->variants as $variant)
                        <tr class="border-b border-sky-50">
                            <td class="py-3 font-semibold text-gray-700">{{ $product->name }}</td>
                            <td class="py-3 text-gray-400">{{ $product->brand->name }}</td>
                            <td class="py-3 text-gray-500">
                                <div class="flex items-center gap-2">
                                    @if($variant->hex_color)
                                    <span class="w-4 h-4 rounded-full inline-block border border-gray-200" style="background:{{ $variant->hex_color }}"></span>
                                    @endif
                                    {{ $variant->shade_name }}
                                </div>
                            </td>
                            <td class="py-3 text-center font-bold {{ $variant->stock <= 5 ? 'text-red-400' : 'text-gray-700' }}">
                                {{ $variant->stock }}
                            </td>
                            <td class="py-3 text-center">
                                @if($variant->stock == 0)
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-500">Habis</span>
                                @elseif($variant->stock <= 5)
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">Hampir Habis</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Tersedia</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Histori Perubahan Stok --}}
        <div class="bg-white rounded-3xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">🕒 Histori Perubahan Stok</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-sky-50">
                        <th class="pb-3">Tanggal</th>
                        <th class="pb-3">Produk</th>
                        <th class="pb-3">Variant</th>
                        <th class="pb-3 text-center">Jumlah</th>
                        <th class="pb-3 text-center">Tipe</th>
                        <th class="pb-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $histories = \App\Models\StockHistory::with(['variant.product'])->latest()->get();
                    @endphp
                    @forelse($histories as $history)
                    <tr class="border-b border-sky-50">
                        <td class="py-3 text-gray-400">{{ $history->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 font-semibold text-gray-700">{{ $history->variant->product->name }}</td>
                        <td class="py-3 text-gray-500">{{ $history->variant->shade_name }}</td>
                        <td class="py-3 text-center font-bold {{ $history->tipe === 'masuk' ? 'text-green-500' : 'text-red-400' }}">
                            {{ $history->tipe === 'masuk' ? '+' : '-' }}{{ $history->jumlah }}
                        </td>
                        <td class="py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $history->tipe === 'masuk' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-500' }}">
                                {{ ucfirst($history->tipe) }}
                            </span>
                        </td>
                        <td class="py-3 text-gray-400">{{ $history->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-gray-400">Belum ada histori stok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist Admin Panel
    </footer>

</body>
</html>
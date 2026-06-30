<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            main { max-width: 100% !important; padding: 0 !important; }
            .print-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
    </style>
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50 no-print">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders') }}" class="text-sm text-sky-500 hover:underline">Pesanan</a>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-sky-500 hover:underline">Produk</a>
                <a href="{{ route('admin.brands') }}" class="text-sm text-sky-500 hover:underline">Brand</a>
                <a href="{{ route('admin.categories') }}" class="text-sm text-sky-500 hover:underline">Kategori</a>
                <a href="{{ route('admin.coupons') }}" class="text-sm text-sky-500 hover:underline">Kupon</a>
                <a href="{{ route('admin.laporan') }}" class="text-sm text-sky-500 hover:underline font-semibold">Laporan Keuangan</a>
                <a href="{{ route('admin.stok') }}" class="text-sm text-sky-500 hover:underline">Histori Stok</a>
                <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <div class="flex items-center justify-between mb-8 no-print">
            <h1 class="text-2xl font-bold text-gray-700">💰 Laporan Keuangan</h1>
            <a href="{{ route('admin.laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" style="display:flex; align-items:center; gap:8px; background:#0ea5e9; color:#ffffff; font-size:0.85rem; font-weight:600; padding:10px 20px; border-radius:9999px; text-decoration:none;">
                ⬇️ Download Laporan (PDF)
            </a>
        </div>

        {{-- Title shown only when printing --}}
        <h1 class="hidden print:block text-2xl font-bold text-gray-700 mb-2">Laporan Keuangan — Skinist</h1>
        @if($startDate || $endDate)
        <p class="hidden print:block text-sm text-gray-500 mb-6">
            Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }}
            s/d
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
        </p>
        @endif

        {{-- Filter Tanggal --}}
        <form method="GET" action="{{ route('admin.laporan') }}" class="bg-white rounded-3xl shadow-sm p-6 mb-6 flex flex-wrap items-end gap-4 no-print">
            <div>
                <label class="block text-xs text-gray-400 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="border border-sky-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-sky-300">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="border border-sky-100 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-sky-300">
            </div>
            <button type="submit" style="background:#0ea5e9; color:#ffffff; font-size:0.85rem; font-weight:600; padding:10px 20px; border-radius:9999px; border:none; cursor:pointer;">
                Terapkan
            </button>
            @if($startDate || $endDate)
            <a href="{{ route('admin.laporan') }}" class="text-sm text-gray-400 hover:text-red-400 px-2 py-2.5">
                Reset
            </a>
            @endif
        </form>

        {{-- Indikator hasil filter --}}
        <div class="no-print" style="margin-bottom: 24px;">
            @if($startDate || $endDate)
                <p style="font-size:0.85rem; color:#1A3A5C;">
                    📋 Menampilkan hasil laporan periode
                    <strong>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }}</strong>
                    s/d
                    <strong>{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}</strong>
                </p>
            @else
                <p style="font-size:0.85rem; color:#6b7280;">
                    📋 Menampilkan semua data. Pilih rentang tanggal di atas untuk memfilter.
                </p>
            @endif
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-3xl shadow-sm p-6 print-card">
                <p class="text-xs text-gray-400 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold text-sky-500">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-6 print-card">
                <p class="text-xs text-gray-400 mb-1">Total Order Selesai</p>
                <p class="text-2xl font-bold text-green-500">{{ $totalOrder }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow-sm p-6 print-card">
                <p class="text-xs text-gray-400 mb-1">Rata-rata per Order</p>
                <p class="text-2xl font-bold text-purple-400">Rp {{ $totalOrder > 0 ? number_format($totalPendapatan / $totalOrder, 0, ',', '.') : 0 }}</p>
            </div>
        </div>

        {{-- Pendapatan per Bulan --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 print-card">
            <h2 class="text-lg font-bold text-gray-700 mb-4">📅 Pendapatan per Bulan</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-sky-50">
                        <th class="pb-3">Bulan</th>
                        <th class="pb-3 text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendapatanPerBulan as $bulan => $total)
                    <tr class="border-b border-sky-50">
                        <td class="py-3 text-gray-600">{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</td>
                        <td class="py-3 text-right font-bold text-sky-500">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="py-6 text-center text-gray-400">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Detail Order --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 print-card">
            <h2 class="text-lg font-bold text-gray-700 mb-4">🧾 Detail Transaksi</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-sky-50">
                        <th class="pb-3">Invoice</th>
                        <th class="pb-3">Pelanggan</th>
                        <th class="pb-3">Tanggal</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b border-sky-50">
                        <td class="py-3 font-semibold text-gray-700">{{ $order->invoice_number }}</td>
                        <td class="py-3 text-gray-500">{{ $order->user->name }}</td>
                        <td class="py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->status === 'paid' ? 'bg-green-100 text-green-600' :
                                   ($order->status === 'shipped' ? 'bg-blue-100 text-blue-600' :
                                   'bg-teal-100 text-teal-600') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3 text-right font-bold text-sky-500">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16 no-print">
        © 2025 Skinist Admin Panel
    </footer>

</body>
</html>
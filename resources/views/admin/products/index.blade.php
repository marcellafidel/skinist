<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk — Skinist</title>
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
            <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
            </form>
        </div>
    </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-700">🧴 Kelola Produk</h1>
            <a href="{{ route('admin.products.create') }}"
                class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-3 rounded-2xl font-semibold transition-all">
                + Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-sky-50 border-b border-sky-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Produk</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Brand</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Kategori</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Varian</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b border-sky-50 hover:bg-sky-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center">
                                    <span class="text-lg">🧴</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->brand->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1">
                                @foreach($product->variants as $variant)
                                <span class="w-5 h-5 rounded-full border border-gray-200 inline-block" style="background-color: {{ $variant->hex_color }}" title="{{ $variant->shade_name }}"></span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-400">Belum ada produk.</td>
                    </tr>
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
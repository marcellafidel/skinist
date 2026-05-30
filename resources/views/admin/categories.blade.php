<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kategori — Skinist</title>
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
                <a href="{{ route('admin.categories') }}" class="text-sm text-sky-500 hover:underline font-bold">Kategori</a>
                <a href="{{ route('admin.coupons') }}" class="text-sm text-sky-500 hover:underline">Kupon</a>
                <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">📂 Kelola Kategori</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- FORM TAMBAH KATEGORI --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Tambah Kategori Baru</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="name" placeholder="Nama kategori..." required
                    class="flex-1 bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                <button type="submit"
                    class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    Tambah
                </button>
            </form>
            @error('name')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- DAFTAR KATEGORI --}}
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-sky-50 border-b border-sky-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Nama Kategori</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Slug</th>
                        <th class="text-left px-6 py-4 text-sm text-gray-500 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-sky-50 hover:bg-sky-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-700">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $category->slug }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kategori ini?')">
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
                        <td colspan="3" class="text-center py-12 text-gray-400">Belum ada kategori.</td>
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
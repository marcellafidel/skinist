<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk — Skinist</title>
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
            <span class="text-sm bg-sky-100 text-sky-600 px-3 py-1 rounded-full font-semibold">Admin Panel</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
            </form>
        </div>
    </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">➕ Tambah Produk Baru</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Info Produk</h2>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Brand</label>
                        <select name="brand_id" required
                            class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            <option value="">Pilih Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Kategori</label>
                        <select name="category_id" required
                            class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Foto Produk (opsional)</label>
                    <input type="file" name="thumbnail" accept="image/*"
                        class="text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-sky-100 file:text-sky-600 hover:file:bg-sky-200">
                </div>
            </div>

            {{-- VARIAN --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-700">🎨 Varian Shade</h2>
                    <button type="button" onclick="addVariant()"
                        class="bg-sky-100 hover:bg-sky-200 text-sky-600 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                        + Tambah Shade
                    </button>
                </div>

                <div id="variants">
                    <div class="variant-row grid grid-cols-4 gap-3 mb-3">
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Nama Shade</label>
                            <input type="text" name="shade_name[]" placeholder="Cherry Red" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Warna (Hex)</label>
                            <input type="color" name="hex_color[]" value="#C0392B"
                                class="w-full h-10 bg-gray-50 border border-sky-100 rounded-xl px-2 cursor-pointer">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Harga</label>
                            <input type="number" name="price[]" placeholder="150000" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Stok</label>
                            <input type="number" name="stock[]" placeholder="50" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-2xl text-lg transition-all duration-200">
                Simpan Produk
            </button>
        </form>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist Admin Panel
    </footer>

<script>
function addVariant() {
    const container = document.getElementById('variants');
    const row = document.createElement('div');
    row.className = 'variant-row grid grid-cols-4 gap-3 mb-3';
    row.innerHTML = `
        <div>
            <label class="text-xs text-gray-400 mb-1 block">Nama Shade</label>
            <input type="text" name="shade_name[]" placeholder="Nude Pink" required
                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">Warna (Hex)</label>
            <input type="color" name="hex_color[]" value="#E8A598"
                class="w-full h-10 bg-gray-50 border border-sky-100 rounded-xl px-2 cursor-pointer">
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">Harga</label>
            <input type="number" name="price[]" placeholder="150000" required
                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">Stok</label>
            <input type="number" name="stock[]" placeholder="50" required
                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
        </div>
    `;
    container.appendChild(row);
}
</script>

</body>
</html>
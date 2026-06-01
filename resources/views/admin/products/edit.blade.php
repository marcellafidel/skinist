<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk — Skinist</title>
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

        <h1 class="text-2xl font-bold text-gray-700 mb-8">✏️ Edit Produk</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">✅ {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM UPDATE INFO PRODUK --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Info Produk</h2>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Nama Produk</label>
                    <input type="text" name="name" value="{{ $product->name }}" required
                        class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Brand</label>
                        <select name="brand_id" required
                            class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Kategori</label>
                        <select name="category_id" required
                            class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">{{ $product->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-500 mb-1 block">Foto Produk (opsional)</label>
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="h-20 rounded-xl mb-2 object-cover">
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-sky-100 file:text-sky-600 hover:file:bg-sky-200">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-2xl text-lg transition-all duration-200 mb-6">
                Simpan Perubahan Info
            </button>
        </form>

        {{-- FORM UPDATE VARIAN --}}
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">🎨 Edit Varian</h2>

            @foreach($product->variants as $variant)
            <form action="{{ route('admin.variants.update', $variant->id) }}" method="POST" class="mb-4 p-4 bg-sky-50 rounded-2xl">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-5 gap-3">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Shade</label>
                        <input type="text" name="shade_name" value="{{ $variant->shade_name }}"
                            class="w-full bg-white border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Size</label>
                        <input type="text" name="size" value="{{ $variant->size }}"
                            class="w-full bg-white border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Warna</label>
                        <input type="color" name="hex_color" value="{{ $variant->hex_color ?? '#000000' }}"
                            class="w-full h-10 bg-white border border-sky-100 rounded-xl px-2 cursor-pointer">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Harga</label>
                        <input type="number" name="price" value="{{ $variant->price }}" required
                            class="w-full bg-white border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Stok</label>
                        <input type="number" name="stock" value="{{ $variant->stock }}" required
                            class="w-full bg-white border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                    </div>
                </div>
                <button type="submit"
                    class="mt-3 bg-sky-200 hover:bg-sky-300 text-sky-700 px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                    Update Varian
                </button>
            </form>
            @endforeach

            {{-- TAMBAH VARIAN BARU --}}
            <div class="mt-4 pt-4 border-t border-sky-100">
                <h3 class="text-sm font-bold text-gray-600 mb-3">+ Tambah Varian Baru</h3>
                <form action="{{ route('admin.variants.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-5 gap-3 mb-3">
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Shade</label>
                            <input type="text" name="shade_name" placeholder="Cherry Red"
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Size</label>
                            <input type="text" name="size" placeholder="30ml"
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Warna</label>
                            <input type="color" name="hex_color" value="#C0392B"
                                class="w-full h-10 bg-gray-50 border border-sky-100 rounded-xl px-2 cursor-pointer">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Harga</label>
                            <input type="number" name="price" placeholder="150000" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Stok</label>
                            <input type="number" name="stock" placeholder="50" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-3 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-sky-300 hover:bg-sky-400 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all">
                        + Tambah Varian
                    </button>
                </form>
            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist Admin Panel
    </footer>

</body>
</html>
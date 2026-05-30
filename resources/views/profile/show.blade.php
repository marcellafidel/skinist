<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil — Skinist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-sky-400 tracking-widest">Skinist</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-sky-500">Hi, {{ auth()->user()->name }}</span>
                <a href="{{ route('wishlist.index') }}" class="text-sky-400">❤️</a>
                <a href="{{ route('cart.index') }}" class="text-sky-400">🛒</a>
                <a href="{{ route('notifications.index') }}" class="relative">
                    🔔
                    @php
                        $unread = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                    @endphp
                    @if($unread > 0)
                        <span class="absolute -top-2 -right-2 bg-red-400 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unread }}</span>
                    @endif
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">👤 Profil Saya</h1>

        @if(session('status') === 'profile-updated')
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">
                ✅ Profil berhasil diupdate!
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- SIDEBAR --}}
            <div class="bg-white rounded-3xl shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-full bg-sky-200 flex items-center justify-center text-sky-600 font-bold text-3xl mx-auto mb-4">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <p class="font-bold text-gray-700">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('orders.index') }}" class="block text-sm text-sky-500 hover:underline">📦 Pesanan Saya</a>
                    <a href="{{ route('wishlist.index') }}" class="block text-sm text-sky-500 hover:underline">❤️ Wishlist</a>
                    <a href="{{ route('notifications.index') }}" class="block text-sm text-sky-500 hover:underline">🔔 Notifikasi</a>
                </div>
            </div>

            {{-- FORM UPDATE PROFIL --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Update Info --}}
                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Update Informasi</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="text-sm text-gray-500 mb-1 block">Nama</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-500 mb-1 block">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Update Password --}}
                <div class="bg-white rounded-3xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Ubah Password</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="text-sm text-gray-500 mb-1 block">Password Lama</label>
                            <input type="password" name="current_password" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @error('current_password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-500 mb-1 block">Password Baru</label>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-500 mb-1 block">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-gray-50 border border-sky-100 rounded-xl px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-sky-300">
                        </div>

                        <button type="submit"
                            class="bg-sky-300 hover:bg-sky-400 text-white px-6 py-3 rounded-xl font-semibold transition-all">
                            Update Password
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi — Skinist</title>
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
                <a href="{{ route('notifications.index') }}" class="text-sky-400 font-bold">🔔</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-gray-400 hover:text-red-400">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-8">🔔 Notifikasi</h1>

        @if(session('success'))
            <div class="bg-sky-100 text-sky-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $notification)
        <div class="bg-white rounded-2xl p-5 shadow-sm mb-4 border-l-4
            {{ $notification->type === 'success' ? 'border-green-400' :
               ($notification->type === 'warning' ? 'border-yellow-400' : 'border-sky-400') }}">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-gray-700">{{ $notification->title }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $notification->message }}</p>
                    <p class="text-xs text-gray-300 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-300 hover:text-red-400 transition-colors ml-4">✕</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🔔</div>
            <p class="text-gray-400 text-lg">Belum ada notifikasi.</p>
        </div>
        @endforelse

    </main>

    <footer class="bg-white border-t border-sky-100 py-8 text-center text-sm text-gray-400 mt-16">
        © 2025 Skinist — keep the barrier safe, let your flawless skin speak.
    </footer>

</body>
</html>
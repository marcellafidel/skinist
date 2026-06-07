<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi — Skinist</title>
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

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #5A7FA0; text-decoration: none;
            padding: 7px 16px; border-radius: 50px;
            border: 1px solid rgba(91,184,245,0.25); background: white;
            transition: all 0.2s ease;
        }
        .btn-back:hover { color: #5BB8F5; border-color: #5BB8F5; background: #E3F2FD; }

        /* NOTIFICATION CARD */
        .notif-card {
            background: white; border-radius: 16px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 20px; margin-bottom: 10px;
            display: flex; align-items: flex-start; gap: 16px;
            transition: all 0.2s ease; position: relative;
            overflow: hidden;
        }
        .notif-card:hover { box-shadow: 0 4px 16px rgba(26,58,92,0.07); }

        .notif-card::before {
            content: ''; position: absolute;
            left: 0; top: 0; bottom: 0; width: 3px;
        }
        .notif-card.type-success::before { background: #34d399; }
        .notif-card.type-warning::before { background: #fbbf24; }
        .notif-card.type-info::before { background: #5BB8F5; }

        .notif-icon {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .notif-icon.type-success { background: rgba(52,211,153,0.1); }
        .notif-icon.type-warning { background: rgba(251,191,36,0.1); }
        .notif-icon.type-info { background: rgba(91,184,245,0.1); }

        .notif-title {
            font-size: 0.9rem; font-weight: 500; color: #1A3A5C; margin-bottom: 4px;
        }
        .notif-message {
            font-size: 0.82rem; color: #5A7FA0; line-height: 1.6;
        }
        .notif-time {
            font-size: 0.72rem; color: rgba(90,127,160,0.5); margin-top: 6px;
        }

        .btn-dismiss {
            width: 28px; height: 28px; border-radius: 8px;
            background: none; border: none; cursor: pointer;
            color: rgba(90,127,160,0.4); flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s ease; margin-left: auto;
        }
        .btn-dismiss:hover { background: rgba(224,92,92,0.08); color: #e05c5c; }

        /* EMPTY STATE */
        .empty-state {
            text-align: center; padding: 80px 24px;
            background: white; border-radius: 24px;
            border: 1px solid rgba(91,184,245,0.08);
        }

        .alert-success {
            background: rgba(91,184,245,0.1); border: 1px solid rgba(91,184,245,0.3);
            color: #1A3A5C; padding: 12px 16px; border-radius: 12px;
            margin-bottom: 16px; font-size: 0.85rem;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease both; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                <div style="display:flex; align-items:center; gap:20px;">
                    <span style="font-size:0.82rem; color:#5A7FA0;">Hi, {{ auth()->user()->name }}</span>
                    <a href="{{ route('wishlist.index') }}" style="color:#5A7FA0; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </a>
                    <a href="{{ route('cart.index') }}" style="color:#5A7FA0; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </a>
                    <a href="{{ route('notifications.index') }}" style="color:#5BB8F5;">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button style="font-size:0.78rem; color:#5A7FA0; background:none; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:color 0.2s;" onmouseover="this.style.color='#e05c5c'" onmouseout="this.style.color='#5A7FA0'">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:680px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;" class="animate-in">
            <div>
                <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Notifikasi</h1>
                <p style="font-size:0.82rem; color:#5A7FA0;">
                    {{ $notifications->count() }} notifikasi
                </p>
            </div>
            <a href="/" class="btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success animate-in">✓ {{ session('success') }}</div>
        @endif

        @forelse($notifications as $notification)
        @php
            $type = $notification->type ?? 'info';
            $icon = match($type) {
                'success' => '✅',
                'warning' => '⚠️',
                default   => '📢',
            };
        @endphp
        <div class="notif-card type-{{ $type }} animate-in">
            <div class="notif-icon type-{{ $type }}">{{ $icon }}</div>
            <div style="flex:1; min-width:0;">
                <p class="notif-title">{{ $notification->title }}</p>
                <p class="notif-message">{{ $notification->message }}</p>
                <p class="notif-time">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-dismiss" title="Hapus">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
        @empty
        <div class="empty-state animate-in">
            <div style="font-size:3.5rem; margin-bottom:16px; opacity:0.2;">🔔</div>
            <h3 class="font-display" style="font-size:1.6rem; font-weight:300; color:#1A3A5C; margin:0 0 8px;">Semua bersih!</h3>
            <p style="font-size:0.85rem; color:#5A7FA0;">Belum ada notifikasi untukmu saat ini.</p>
        </div>
        @endforelse

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
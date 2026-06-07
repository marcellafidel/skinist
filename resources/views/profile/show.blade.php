<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil — Skinist</title>
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

        /* SIDEBAR */
        .sidebar {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            overflow: hidden; position: sticky; top: 88px;
        }

        .avatar-wrap {
            background: linear-gradient(135deg, #1A3A5C 0%, #2563a8 100%);
            padding: 32px 24px; text-align: center;
        }

        .avatar {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 3px solid rgba(255,255,255,0.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; font-weight: 600; color: white;
            margin: 0 auto 14px;
        }

        .avatar-name {
            font-size: 1rem; font-weight: 500; color: white; margin-bottom: 4px;
        }

        .avatar-email {
            font-size: 0.75rem; color: rgba(255,255,255,0.55);
        }

        .nav-menu { padding: 12px 8px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; border-radius: 12px;
            text-decoration: none; font-size: 0.85rem;
            color: #5A7FA0; transition: all 0.2s ease;
            margin-bottom: 2px;
        }
        .nav-item:hover { background: #E3F2FD; color: #1A3A5C; }
        .nav-item.active { background: #E3F2FD; color: #1A3A5C; font-weight: 500; }

        .nav-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: #F0F7FF; display: flex;
            align-items: center; justify-content: center;
            font-size: 0.9rem; flex-shrink: 0;
            transition: background 0.2s;
        }
        .nav-item:hover .nav-icon, .nav-item.active .nav-icon {
            background: #BFDFFF;
        }

        .nav-divider {
            border: none; border-top: 1px solid rgba(91,184,245,0.1);
            margin: 8px 16px;
        }

        .btn-logout {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; border-radius: 12px;
            font-size: 0.85rem; color: rgba(224,92,92,0.6);
            width: 100%; background: none; border: none;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            transition: all 0.2s ease; text-align: left;
        }
        .btn-logout:hover { background: rgba(224,92,92,0.06); color: #e05c5c; }

        /* FORM CARD */
        .form-card {
            background: white; border-radius: 20px;
            border: 1px solid rgba(91,184,245,0.08);
            padding: 28px; margin-bottom: 16px;
        }

        .form-section-title {
            font-size: 0.72rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; margin-bottom: 20px;
        }

        .input-group { margin-bottom: 16px; }

        .input-label {
            font-size: 0.72rem; letter-spacing: 0.1em;
            text-transform: uppercase; color: #5A7FA0;
            font-weight: 500; margin-bottom: 7px; display: block;
        }

        .input-field {
            width: 100%; background: #F0F7FF;
            border: 1.5px solid transparent; border-radius: 12px;
            padding: 12px 16px; font-size: 0.88rem;
            color: #1A3A5C; font-family: 'DM Sans', sans-serif;
            transition: all 0.25s ease;
        }
        .input-field:focus { outline: none; border-color: #5BB8F5; background: white; box-shadow: 0 0 0 4px rgba(91,184,245,0.1); }
        .input-field::placeholder { color: #5A7FA0; opacity: 0.6; }

        .error-msg { font-size: 0.75rem; color: #e05c5c; margin-top: 6px; }

        .btn-submit {
            background: #1A3A5C; color: white;
            border: none; padding: 12px 24px; border-radius: 12px;
            font-size: 0.85rem; font-weight: 500; cursor: pointer;
            font-family: 'DM Sans', sans-serif; letter-spacing: 0.04em;
            transition: all 0.25s ease;
        }
        .btn-submit:hover { background: #5BB8F5; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,184,245,0.3); }

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
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 0;">
                <a href="/" class="font-display" style="font-size:1.6rem; font-weight:300; font-style:italic; color:#1A3A5C; text-decoration:none; letter-spacing:0.15em;">Skinist</a>
                <div style="display:flex; align-items:center; gap:20px;">
                    <a href="{{ route('wishlist.index') }}" style="color:#5A7FA0; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </a>
                    <a href="{{ route('cart.index') }}" style="color:#5A7FA0; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </a>
                    <a href="{{ route('notifications.index') }}" style="color:#5A7FA0; position:relative; transition:color 0.2s;" onmouseover="this.style.color='#5BB8F5'" onmouseout="this.style.color='#5A7FA0'">
                        <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @php $unread = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                        @if($unread > 0)
                        <span style="position:absolute; top:-6px; right:-6px; background:#e05c5c; color:white; font-size:0.6rem; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600;">{{ $unread }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main style="max-width:1000px; margin:0 auto; padding:32px 24px;">

        {{-- HEADER --}}
        <div style="margin-bottom:28px;" class="animate-in">
            <h1 class="font-display" style="font-size:2rem; font-weight:300; color:#1A3A5C; margin:0 0 4px;">Profil Saya</h1>
            <p style="font-size:0.82rem; color:#5A7FA0;">Kelola informasi akun kamu</p>
        </div>

        @if(session('status') === 'profile-updated')
            <div class="alert-success animate-in">✓ Profil berhasil diperbarui!</div>
        @endif
        @if(session('status') === 'password-updated')
            <div class="alert-success animate-in">✓ Password berhasil diperbarui!</div>
        @endif

        <div style="display:grid; grid-template-columns:260px 1fr; gap:24px; align-items:start;">

            {{-- SIDEBAR --}}
            <div class="sidebar animate-in">
                <div class="avatar-wrap">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <p class="avatar-name">{{ auth()->user()->name }}</p>
                    <p class="avatar-email">{{ auth()->user()->email }}</p>
                </div>
                <div class="nav-menu">
                    <a href="{{ route('profile.show') }}" class="nav-item active">
                        <div class="nav-icon">👤</div>
                        Profil Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="nav-item">
                        <div class="nav-icon">📦</div>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="nav-item">
                        <div class="nav-icon">❤️</div>
                        Wishlist
                    </a>
                    <a href="{{ route('notifications.index') }}" class="nav-item">
                        <div class="nav-icon">🔔</div>
                        Notifikasi
                        @if($unread > 0)
                        <span style="margin-left:auto; background:#e05c5c; color:white; font-size:0.65rem; padding:2px 7px; border-radius:50px; font-weight:600;">{{ $unread }}</span>
                        @endif
                    </a>
                    <hr class="nav-divider">
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <div class="nav-icon" style="background:rgba(224,92,92,0.08);">🚪</div>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            {{-- FORM AREA --}}
            <div>

                {{-- UPDATE INFO --}}
                <div class="form-card animate-in delay-1">
                    <p class="form-section-title">Informasi Akun</p>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="input-group">
                            <label class="input-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="input-field">
                            @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>

                        <div class="input-group">
                            <label class="input-label">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required class="input-field">
                            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    </form>
                </div>

                {{-- UPDATE PASSWORD --}}
                <div class="form-card animate-in delay-2">
                    <p class="form-section-title">Ubah Password</p>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                            <label class="input-label">Password Lama</label>
                            <input type="password" name="current_password" required class="input-field" placeholder="••••••••">
                            @error('current_password') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>

                        <div class="input-group">
                            <label class="input-label">Password Baru</label>
                            <input type="password" name="password" required class="input-field" placeholder="••••••••">
                            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>

                        <div class="input-group">
                            <label class="input-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required class="input-field" placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn-submit">Update Password</button>
                    </form>
                </div>

                {{-- DANGER ZONE --}}
                <div class="form-card" style="border-color:rgba(224,92,92,0.15);">
                    <p class="form-section-title" style="color:rgba(224,92,92,0.6);">Danger Zone</p>
                    <p style="font-size:0.82rem; color:#5A7FA0; margin-bottom:16px;">Setelah akun dihapus, semua data akan hilang permanen.</p>
                    <a href="{{ route('profile.edit') }}"
                        style="display:inline-flex; align-items:center; gap:6px; font-size:0.82rem; color:rgba(224,92,92,0.7); border:1px solid rgba(224,92,92,0.25); padding:9px 18px; border-radius:10px; text-decoration:none; transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(224,92,92,0.06)'; this.style.color='#e05c5c';"
                        onmouseout="this.style.background='none'; this.style.color='rgba(224,92,92,0.7)';">
                        Hapus Akun
                    </a>
                </div>

            </div>
        </div>

    </main>

    <footer style="background:#1A3A5C; padding:24px; text-align:center; margin-top:64px;">
        <p style="font-size:0.75rem; color:rgba(255,255,255,0.3); letter-spacing:0.08em;">© 2025 Skinist — keep the barrier safe, let your flawless skin speak.</p>
    </footer>

</body>
</html>
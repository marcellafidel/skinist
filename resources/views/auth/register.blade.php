<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinist — Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #F0F7FF;
        }

        /* LEFT PANEL */
        .left-panel {
            background: linear-gradient(160deg, #1A3A5C 0%, #2563a8 60%, #5BB8F5 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 320px; height: 320px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 240px; height: 240px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .brand-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 300;
            font-style: italic;
            color: white;
            letter-spacing: 0.2em;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.7s ease both;
        }

        .brand-tagline {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease 0.1s both;
            line-height: 1.8;
        }

        .left-steps {
            position: relative;
            z-index: 1;
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            animation: fadeInUp 0.9s ease 0.2s both;
        }

        .left-step {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .step-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            letter-spacing: 0.04em;
        }

        .left-deco {
            position: absolute;
            bottom: 60px;
            font-size: 7rem;
            opacity: 0.06;
            filter: blur(2px);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-16px) rotate(5deg); }
        }

        /* RIGHT PANEL */
        .right-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            background: white;
            overflow-y: auto;
        }

        .form-wrap {
            width: 100%;
            max-width: 380px;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 300;
            color: #1A3A5C;
            margin-bottom: 6px;
        }

        .form-subtitle {
            font-size: 0.82rem;
            color: #5A7FA0;
            margin-bottom: 32px;
        }

        .input-group { margin-bottom: 14px; }

        .input-label {
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #5A7FA0;
            font-weight: 500;
            margin-bottom: 7px;
            display: block;
        }

        .input-field {
            width: 100%;
            background: #F0F7FF;
            border: 1.5px solid transparent;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 0.88rem;
            color: #1A3A5C;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.25s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #5BB8F5;
            background: white;
            box-shadow: 0 0 0 4px rgba(91,184,245,0.1);
        }
        .input-field::placeholder { color: #5A7FA0; opacity: 0.6; }

        .input-password-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-password-wrap .input-field { padding-right: 48px; }

        .eye-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #5A7FA0;
            padding: 4px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }
        .eye-btn:hover { color: #5BB8F5; }

        .error-msg {
            font-size: 0.75rem;
            color: #e05c5c;
            margin-top: 6px;
        }

        .btn-submit {
            width: 100%;
            background: #1A3A5C;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.06em;
            transition: all 0.25s ease;
            margin-top: 8px;
        }
        .btn-submit:hover {
            background: #5BB8F5;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(91,184,245,0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #5A7FA0;
        }
        .login-link a {
            color: #5BB8F5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .login-link a:hover { color: #1A3A5C; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="brand-logo">Skinist</div>
        <div class="brand-tagline">keep the barrier safe<br>let your flawless skin speak</div>

        <div class="left-steps">
            <div class="left-step">
                <div class="step-icon">✨</div>
                <span class="step-text">Akses ribuan produk kecantikan original</span>
            </div>
            <div class="left-step">
                <div class="step-icon">❤️</div>
                <span class="step-text">Simpan favorit di wishlist kamu</span>
            </div>
            <div class="left-step">
                <div class="step-icon">🚚</div>
                <span class="step-text">Pengiriman Cepat</span>
            </div>
            <div class="left-step">
                <div class="step-icon">🔒</div>
                <span class="step-text">Transaksi aman & terpercaya</span>
            </div>
        </div>

        <div class="left-deco">🧴</div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="form-wrap">

            <h2 class="form-title">Buat akun baru</h2>
            <p class="form-subtitle">Bergabung dengan komunitas Skinist</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label class="input-label">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama kamu"
                        class="input-field" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" placeholder="email@gmail.com"
                        class="input-field" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div class="input-password-wrap">
                        <input type="password" name="password" id="password"
                            placeholder="••••••••" class="input-field" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password', 'eye1')">
                            <svg id="eye1" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Konfirmasi Password</label>
                    <div class="input-password-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="••••••••" class="input-field" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation', 'eye2')">
                            <svg id="eye2" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Buat Akun</button>

                <p class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </p>

            </form>
        </div>
    </div>

<script>
function togglePassword(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
</script>

</body>
</html>